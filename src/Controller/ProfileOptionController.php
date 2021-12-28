<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class ProfileOptionController extends AbstractController
{
    #[Route('user/{user}/profile/option', name: 'profile_option')]
    public function index(Security $security): Response
    {
        
        return $this->render('profile_option/index.html.twig', [
            'publicContact' => $publicContact,
            'showStatus' => $showStatus,
            'hidden' => $hidden,
            'darkmode' => $darkmode
        ]);
    }
}
