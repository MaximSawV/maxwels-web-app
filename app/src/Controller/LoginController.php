<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'login')]

    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        /*
        $error = $authenticationUtils->getLastAuthenticationError();
        return $this->render('main_page/index.html.twig', [
            'error' => $error,
            'logged' => $loggedin
        ]);*/
        return $this->redirectToRoute('main_page');
    }
}
