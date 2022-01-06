<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdmninFrontPageController extends AbstractController
{
    #[Route('/admin', name: 'admin_page')]
    public function index(): Response
    {
        return $this->render('admin_pages/EntityList.html.twig', [
        ]);
    }
}
