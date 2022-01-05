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
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCreateUserController extends AbstractController
{
    #[Route('/admin/create/{entity}', name: 'admin_create_entity')]
    public function index(string $entity, Request $request, ProfileOptionManager $optionManager): Response
    {
        $form = null;

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

                try {
                    $entityManager->flush();
                    $e = null;
                } catch (\PDOException $e) {
                    $this->addFlash(
                        'warning',
                        'A PDO exception occurred: ' . $e->getMessage()
                    );
                } finally {
                    if ($e == null) {
                        $this->addFlash(
                            'success',
                            'Entity was succesfully created!'
                        );
                    }
                }

                $optionManager->createProfileOptions($user);
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

                try {
                    $entityManager->flush();
                    $e = null;
                } catch (\PDOException $e) {
                    $this->addFlash(
                        'warning',
                        'A PDO exception occurred: ' . $e->getMessage()
                    );
                } finally {
                    if ($e == null) {
                        $this->addFlash(
                            'success',
                            'Entity was succesfully created!'
                        );
                    }
                }
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

                try {
                    $entityManager->flush();
                    $e = null;
                } catch (\PDOException $e) {
                    $this->addFlash(
                        'warning',
                        'A PDO exception occurred: ' . $e->getMessage()
                    );
                } finally {
                    if ($e == null) {
                        $this->addFlash(
                            'success',
                            'Entity was succesfully created!'
                        );
                    }
                }
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

                try {
                    $entityManager->flush();
                    $e = null;
                } catch (\PDOException $e) {
                    $this->addFlash(
                        'warning',
                        'A PDO exception occurred: ' . $e->getMessage()
                    );
                } finally {
                    if ($e == null) {
                        $this->addFlash(
                            'success',
                            'Entity was succesfully created!'
                        );
                    }
                }
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

                try {
                    $entityManager->flush();
                    $e = null;
                } catch (\PDOException $e) {
                    $this->addFlash(
                        'warning',
                        'A PDO exception occurred: ' . $e->getMessage()
                    );
                } finally {
                    if ($e == null) {
                        $this->addFlash(
                            'success',
                            'Entity was succesfully created!'
                        );
                    }
                }
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

                try {
                    $entityManager->flush();
                    $e = null;
                } catch (\PDOException $e) {
                    $this->addFlash(
                        'warning',
                        'A PDO exception occurred: ' . $e->getMessage()
                    );
                } finally {
                    if ($e == null) {
                        $this->addFlash(
                            'success',
                            'Entity was succesfully created!'
                        );
                    }
                }
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

                try {
                    $entityManager->flush();
                    $e = null;
                } catch (\PDOException $e) {
                    $this->addFlash(
                        'warning',
                        'A PDO exception occurred: ' . $e->getMessage()
                    );
                } finally {
                    if ($e == null) {
                        $this->addFlash(
                            'success',
                            'Entity was succesfully created!'
                        );
                    }
                }
            }
        }

        return $this->renderForm('admin_pages/AdminCreatePage.html.twig', [
            'form' => $form
        ]);
    }
}
