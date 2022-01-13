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

class LoggingOutController extends AbstractController
{
    #[Route('/logging/out', name: 'logging_out')]

    public function index(SessionManager $sessionManager, EntityManagerInterface $entityManager): Response
    {


        $chats = $sessionManager->getUser()->getChatParticipants();
        $user = $sessionManager->getUser();
        $user->setStatus('offline');
        $entityManager->persist($user);
        $entityManager->flush();


        $now = $now = new \DateTimeImmutable('now');
        foreach ($chats as $participant)
        {
            $participant->setLoggedOutSince($now);
            $entityManager->persist($participant);
            $entityManager->flush();
        }

        return $this->redirect('/user/logout');

    }
}
