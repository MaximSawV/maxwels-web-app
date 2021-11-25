<?php

namespace App\Controller;

use App\Entity\Subscriber;
use App\Form\SubscriberType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\LazyProxy\Instantiator\RealServiceInstantiator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class FormTutorialController extends AbstractController
{
    #[Route('/form/tutorial', name: 'form_tutorial')]
    public function show(Environment $twig, Request $request, EntityManagerInterface $entityManager)
    {
        $subscriber = new Subscriber();

        $form = $this->createForm(SubscriberType::class, $subscriber);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($subscriber);
            $entityManager->flush();
            return new Response('Subscirber number ' . $subscriber->getId(). ' creatded...');
        }

        return $this->render('form_tutorial/index.html.twig', [
            'subscriber_form' => $form->createView()
        ]);
    }
}
