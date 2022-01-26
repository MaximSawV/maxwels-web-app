<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\ProfileOptions;
use App\Entity\Programmer;
use App\Entity\Subscriber;
use App\Entity\User;
use App\Entity\UserRelationship;
use App\Form\CreateCustomerType;
use App\Form\CreateProfileOptionsType;
use App\Form\CreateProgrammerType;
use App\Form\CreateRelationshipType;
use App\Form\CreateRequestType;
use App\Form\CreateSubscriberType;
use App\Form\CreateUserType;
use App\myPHPClasses\MaxwelsProfileOptionManager;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCreateUserController extends AbstractController
{
    #[Route('/admin/create/{entity}', name: 'admin_create_entity')]
    public function index(string $entity, Request $request, MaxwelsProfileOptionManager $optionManager, UserRepository $userRepository): Response
    {
        if ($entity == 'User')
        {
            $user = new User();
            $form = $this->createForm(CreateUserType::class, $user, [
                'action' => $this->generateUrl('admin_create_entity', ['entity' => $entity])
            ]);

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
                $this->addFlash(
                    'success',
                    'Entity created'
                );

                $optionManager->createProfileOptions($user);
                return $this->redirectToRoute('admin_page');
            }
        }

        if ($entity == 'Customer')
        {
            $customer = new Customer();
            $form = $this->createForm(CreateCustomerType::class, $customer, [
                'action' => $this->generateUrl('admin_create_entity', ['entity' => $entity])
            ]);

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($customer);
                $entityManager->flush();
                $this->addFlash(
                    'success',
                    'Entity created'
                );

                return $this->redirectToRoute('admin_page');
            }
        }

        if ($entity == 'Programmer')
        {
            $programmer = new Programmer();
            $form = $this->createForm(CreateProgrammerType::class, $programmer, [
                'action' => $this->generateUrl('admin_create_entity', ['entity' => $entity])
            ]);

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($programmer);
                $entityManager->flush();
                $this->addFlash(
                    'success',
                    'Entity created'
                );

                return $this->redirectToRoute('admin_page');
            }
        }

        if ($entity == 'Request')
        {
            $requestEntity = new \App\Entity\Request();
            $form = $this->createForm(CreateRequestType::class, $requestEntity, [
                'action' => $this->generateUrl('admin_create_entity', ['entity' => $entity])
            ]);

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($requestEntity);
                $entityManager->flush();
                $this->addFlash(
                    'success',
                    'Entity created'
                );

                return $this->redirectToRoute('admin_page');
            }
        }

        if ($entity == 'Profile Options')
        {
            $pOptions = new ProfileOptions();
            $form = $this->createForm(CreateProfileOptionsType::class, $pOptions, [
                'action' => $this->generateUrl('admin_create_entity', ['entity' => $entity])
            ]);

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($pOptions);
                $entityManager->flush();
                $this->addFlash(
                    'success',
                    'Entity created'
                );

                return $this->redirectToRoute('admin_page');
            }
        }

        if ($entity == 'Subscriber')
        {
            $sub = new Subscriber();
            $form = $this->createForm(CreateSubscriberType::class, $sub, [
                'action' => $this->generateUrl('admin_create_entity', ['entity' => $entity])
            ]);

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($sub);
                $entityManager->flush();
                $this->addFlash(
                    'success',
                    'Entity created'
                );

                return $this->redirectToRoute('admin_page');
            }
        }

        if ($entity == 'Relationship')
        {
            $relation = new UserRelationship();
            $form = $this->createForm(CreateRelationshipType::class, $relation, [
                'action' => $this->generateUrl('admin_create_entity', ['entity' => $entity])
            ]);

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($relation);
                $entityManager->flush();
                $this->addFlash(
                    'success',
                    'Entity created'
                );
                return $this->redirectToRoute('admin_page');
            }
        }
        return $this->renderForm('admin_pages/AdminCreatePage.html.twig', [
            'form' => $form
        ]);
    }
}
