<?php
/**
 * Created by PhpStorm.
 * User: maxim
 * Date: 1/7/22
 * Time: 3:16 PM
 */

namespace App\myPHPClasses;


use App\Repository\ChatParticipantRepository;
use App\Repository\ChatRepository;
use App\Session\SessionManager;
use Doctrine\ORM\EntityManagerInterface;

class MaxwelChatParticipantManager
{
    private $chatRepository;
    private $participantRepository;

    private $entityManager;
    private $sessionManager;

    public function __construct(ChatRepository $chatRepository,
                                EntityManagerInterface $entityManager,
                                SessionManager $sessionManager,
                                ChatParticipantRepository $participantRepository)
    {
        $this->chatRepository = $chatRepository;
        $this->entityManager = $entityManager;
        $this->sessionManager = $sessionManager;
        $this->participantRepository = $participantRepository;
    }

    public function participantOffline()
    {
        $participant = $this->participantRepository->findBy(['user' => $this->sessionManager->getUser()]);
        foreach ($participant as $user)
        {
            $now = new \DateTimeImmutable('now');
            $user->setLoggedOutSince($now);
        }
    }

    public function participantOnline()
    {
        $participant = $this->participantRepository->findBy(['user' => $this->sessionManager->getUser()]);
        foreach ($participant as $user)
        {
            $now = new \DateTimeImmutable('now');
            $user->setLoggedInSince($now);
        }
    }
}