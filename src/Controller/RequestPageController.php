<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RequestPageController extends AbstractController
{
    #[Route('/request', name: 'request_page')]
    public function index(): Response
    {
        return $this->render('request_page/index.html.twig', [
            'controller_name' => 'RequestPageController',
        ]);
    }
}
