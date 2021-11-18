<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RequestUserController extends AbstractController
{
    #[Route('/request/user', name: 'request_user')]
    public function index(): Response
    {
        return $this->render('request_user/index.html.twig', [
        ]);
    }
}
