<?php

namespace App\Controller;

use App\Form\ForgotPasswordType;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Security;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;
 class ForgotPasswordController extends AbstractController
{
    private $entityManager;
    private $userRepository;
    private $security;
    private $emailVerifier;

    public function __construct(EntityManagerInterface $entityManager, UserRepository $userRepository, Security $security, EmailVerifier $emailVerifier)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
        $this->security = $security;
        $this->emailVerifier = $emailVerifier;
    }


    #[Route('/forgot_password', name: 'forgot_password')]
    public function index(Request $request): Response
    {
        $forgotPassword = true;
        $userExists = null;
        $form = $this->createForm(ForgotPasswordType::class, [
            'action' => $this->generateUrl('forgot_password')
        ]);

        $form->handleRequest($request);
        $userError = 0;

        if ($form->isSubmitted() && $form->isValid())
        {

            $username = $form->get('Username')->getData();

            $query = $this
                ->userRepository
                ->createQueryBuilder('u')
                ->select('u.id')
                ->where('u.username = :currentUser')
                ->setParameter('currentUser', $username);

            $userData = $query->getQuery()->getOneOrNullResult();
            if ($userData == null)
            {
                $userExists = false;
                $userEntity = null;
            }else {
                $userEntity = $this->userRepository->find($userData);
            }


            if ($userEntity != null)
            {
                $this->emailVerifier->sendEmailConfirmation('verify_password', $userEntity,
                    (new TemplatedEmail())
                        ->from(new Address('maxwels.contacts@gmail.com', 'Maxwels MailBot'))
                        ->to($userEntity->getEmail())
                        ->subject('Please Confirm change of password')
                        ->htmlTemplate('MailTemplates/passwordConformation_mail.html.twig')
                );
                return $this->redirectToRoute('main_page');
            } else {
                $userError = "This User does not exist.Maybe you made a typo?";
            }

        }

        return $this->render('main_page/index.html.twig', [
            'newPw_form' => $form->createView(),
            'userError' => $userError,
            'userExists' => $userExists,
            'fromEmail' => false,
            'forgotPw' => $forgotPassword,
            'logged' => false,
        ]);
    }



    #[Route('/verify/password', name: 'verify_password')]
    public function verifyUserEmail(UserPasswordHasherInterface $userPasswordHasherInterface,  Request $request, VerifyEmailHelperInterface $helper): Response
    {
        $id = $request->get('id');

        if (null === $id) {
            return $this->redirectToRoute('main_page');
        }

        $user = $this->userRepository->find($id);

        if (null === $user) {
            return $this->redirectToRoute('main_page');
        }

        $form = $this->createForm(ForgotPasswordType::class, [
            'action' => $this->generateUrl('forgot_password')
        ]);

        $form->handleRequest($request);

        if ($form->get('New_Password')->getData() == $form->get('Confirm_new_Password')->getData())
        {
            $pwerror = false;
            if ($form->get('New_Password')->getData() != null and $form->get('Confirm_new_Password')->getData() != null)
            {
                $helper->validateEmailConfirmation($request->getUri(), $user->getId(), $user->getEmail());

                $user->setPassword($userPasswordHasherInterface->hashPassword(
                    $user,
                    $form->get('New_Password')->getData()
                ));

                $this->entityManager->persist($user);
                $this->entityManager->flush();
            }
        } else {
            $pwerror = true;
        }
        return $this->render('main_page/index.html.twig', [
            'newPw_form' => $form->createView(),
            'userError' => true,
            'userExists' => true,
            'pwerror' => $pwerror,
            'forgotPw' => true,
            'fromEmail' => false,
            'logged' => false,
        ]);
    }
}
