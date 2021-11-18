<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Profiler\Profiler;
use Symfony\Component\Security\Core\Security;

class MainPageController extends AbstractController
{
    #[Route('/', name: 'main_page')]
    public function index(?Profiler $profiler, Security $security): Response
    {
        $user = $security->getUser();
        if (isset($user) or $user != null){
            $loggedin = true;
        } else {
            $loggedin = false;
        }

        return $this->render('main_page/index.html.twig', [
            'logged' => $loggedin
        ]);
    }
}
