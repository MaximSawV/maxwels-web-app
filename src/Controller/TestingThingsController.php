<?php

namespace App\Controller;

use App\myPHPClasses\MaxwelsCustomerManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestingThingsController extends AbstractController
{
    #[Route('/testing/things', name: 'testing_things')]
    public function index(MaxwelsCustomerManager $manager): Response
    {

        return $this->render('testing_things/index.html.twig', [
            'controller_name' => $manager->getAllNotCustomerUser()[0],
        ]);
    }
}
