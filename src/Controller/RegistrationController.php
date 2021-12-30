<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\ProfileOptions;
use App\Entity\Programmer;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use Doctrine\DBAL\Driver\PDO\Exception;
use Doctrine\ORM\EntityManagerInterface;
use function Sodium\add;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

class RegistrationController extends AbstractController
{
    /** @EmailVerifier $emailVerifier */
    private $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
            $userPasswordHasherInterface->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setSubscribed(false);
            $user->setStatus('Offline');

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);

            try {
                $entityManager->flush();
            } catch (\PDOException $e){

            }

            $profileOptions = new ProfileOptions();
            $profileOptions->setUser($user);
            $profileOptions->setPublicContact(true);
            $profileOptions->setShowStatus(true);
            $profileOptions->setHidden(false);
            $profileOptions->setDarkmode(false);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($profileOptions);


            if ($form->get('customer_or_programmer')->getData() == 'customer' or $form->get('customer_or_programmer')->getData() == 'both')
            {
                $customer = new Customer();
                $customer->setUserId($user);
                $customer->setStatus('OFFLINE');
                $customer->setNumberOfRequests(0);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($customer);

                try {
                    $entityManager->flush();
                } catch (\PDOException $e){

                }

                $user->setRoles(["ROLE_MANAGE_OWN_REQUESTS"]);
                $entityManager->persist($user);
                $entityManager->flush();
            }

            if ($form->get('customer_or_programmer')->getData() == 'programmer' or $form->get('customer_or_programmer')->getData() == 'both')
            {
                $programmer = new Programmer();
                $programmer->setUser($user);
                $programmer->setStatus('OFFLINE');
                $programmer->setDoneRequests(0);
                $programmer->setRating(null);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($programmer);

                try {
                    $entityManager->flush();
                } catch (\PDOException $e){

                }

                $user->setRoles(["ROLE_TAKE_REQUESTS"]);
                $entityManager->persist($user);
                $entityManager->flush();
            }
            // generate a signed url and email it to the user

            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('maxwels.contacts@gmail.com', 'Maxwels MailBot'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
            // do anything else you need here, like send an email

            return $this->redirectToRoute('main_page');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $id = $request->get('id');

        if (null === $id) {
            return $this->redirectToRoute('app_register');
        }

        $user = $userRepository->find($id);

        if (null === $user) {
            return $this->redirectToRoute('app_register');
        }

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('app_register');
        }
        $newRoles = $user->getRoles();
        array_push($newRoles, 'IS_VERIFIED');
        $user->setRoles($newRoles);

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('main_page');
    }
}
