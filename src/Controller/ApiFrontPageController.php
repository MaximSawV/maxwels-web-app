<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Router;

class ApiFrontPageController extends AbstractController
{
    public function index(Router $router): Response
    {
        $apiEntityList = ['User', 'Customer', 'Programmer', 'Request', 'Profile Options', 'Subscriber', 'Relationship'];
        return $this->render('api/index.html.twig', [
            'entityList' => $apiEntityList,
        ]);
    }
}
