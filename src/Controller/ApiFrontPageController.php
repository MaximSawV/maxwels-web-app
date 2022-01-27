<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Router;

class ApiFrontPageController extends AbstractController
{
    public function index(): Response
    {
        $apiEntityList = ['User', 'Customer', 'Programmer', 'Subscriber', 'Request', 'Profile Options', 'Relationship', 'Chat', 'Groupchat', 'Participant', 'Message'];
        return $this->render('api/index.html.twig', [
            'entityList' => $apiEntityList,
        ]);
    }

    #[Route('/api/v1/front-page/search', name: 'api_front-page_search')]
    public function searchEntity(Request $request)
    {
        $entity = $request->get('entities');

        if (empty($entity))
        {
            return $this->redirect('/api/v1/front-page');
        }

        return $this->redirect('/api/v1/front-page/#'.$entity);
    }
}
