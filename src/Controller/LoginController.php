<?php

namespace App\Controller;

use App\Repository\ChatParticipantRepository;
use App\Session\SessionManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'login')]

    public function index(AuthenticationUtils $authenticationUtils): Response
    {

        $error = $authenticationUtils->getLastAuthenticationError();
        if ($error != null)
        {
            $loggedin = false;
        } else {
            $loggedin = 0;
        }

        return $this->render('main_page/index.html.twig', [
            'error' => $error,
            'logged' => $loggedin
        ]);

        //return $this->redirectToRoute('main_page');
    }
}
