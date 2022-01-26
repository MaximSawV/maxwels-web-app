<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\CreateUserType;
use App\myPHPClasses\MaxwelsCustomerManager;
use App\myPHPClasses\MaxwelsProgrammerManager;
use App\myPHPClasses\MaxwelsUserManager;
use App\myPHPClasses\MaxwelsProfileOptionManager;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ApiUserController extends AbstractController
{
    private $userRepository;

    private $userManager;
    private $entityManager;
    private $programmerManager;
    private $customerManager;
    private $optionManager;

    private $passwordHasher;

    public function __construct(UserRepository $userRepository,
                                EntityManagerInterface $entityManager,
                                MaxwelsUserManager $userManager,
                                MaxwelsProgrammerManager $programmerManager,
                                MaxwelsCustomerManager $customerManager,
                                MaxwelsProfileOptionManager $optionManager,
                                UserPasswordHasherInterface $passwordHasher)
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->userManager = $userManager;
        $this->programmerManager = $programmerManager;
        $this->customerManager = $customerManager;
        $this->optionManager = $optionManager;
        $this->passwordHasher = $passwordHasher;
    }

    public function createUser(Request $request): Response
    {
        $user = new User();

        $form = $this->createForm(CreateUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $this->passwordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->addFlash(
                'success',
                'Entity created'
            );

            $this->optionManager->createProfileOptions($user);
            $what = $form->get('customer_or_programmer')->getData();

            if ($what == 'programmer' or $what == 'both')
            {
                $this->programmerManager->createProgrammer($user);
            }

            if ($what == 'customer' or $what == 'both' )
            {
                $this->customerManager->createCustomer($user);
            }
            
            return $this->redirectToRoute('api_page');
        }

        return $this->renderForm('api/api_form.html.twig', [
            'form' => $form
        ]);
    }
    
    public function deleteUser(User $user)
    {
        if (!$user)
        {
            $this->addFlash(
                'fail',
                'Entity not found'
            );
        } else {
            $this->userManager->deleteUser($user);
            $this->addFlash(
                'success',
                'Entity deleted'
            );
        }

        return $this->redirectToRoute('api_page');
    }
}
