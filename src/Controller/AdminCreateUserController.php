<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\ProfileOptions;
use App\Entity\Programmer;
use App\Entity\Subscriber;
use App\Entity\User;
use App\Entity\UserRelationship;
use App\Form\AdminCreateCustomerType;
use App\Form\AdminCreateProfileOptionsType;
use App\Form\AdminCreateProgrammerType;
use App\Form\AdminCreateRelationshipType;
use App\Form\AdminCreateRequestType;
use App\Form\AdminCreateSubscriberType;
use App\Form\AdminCreateUserType;
use App\myPHPClasses\ProfileOptionManager;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCreateUserController extends AbstractController
{
    #[Route('/admin/create/{entity}', name: 'admin_create_entity')]
    public function index(string $entity, Request $request, ProfileOptionManager $optionManager, UserRepository $userRepository): Response
    {
        if ($entity == 'User')
        {
            $user = new User();
            $form = $this->createForm(AdminCreateUserType::class, $user, [
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
            $form = $this->createForm(AdminCreateCustomerType::class, $customer, [
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
            $form = $this->createForm(AdminCreateProgrammerType::class, $programmer, [
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
            $form = $this->createForm(AdminCreateRequestType::class, $requestEntity, [
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
            $form = $this->createForm(AdminCreateProfileOptionsType::class, $pOptions, [
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
            $form = $this->createForm(AdminCreateSubscriberType::class, $sub, [
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
            $form = $this->createForm(AdminCreateRelationshipType::class, $relation, [
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
