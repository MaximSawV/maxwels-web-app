<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RequestProgrammerController extends AbstractController
{
    #[Route('/request/programmer', name: 'request_programmer')]
    public function index(): Response
    {
        return $this->render('request_programmer/index.html.twig', [
            'controller_name' => 'RequestProgrammerController',
        ]);
    }
}
