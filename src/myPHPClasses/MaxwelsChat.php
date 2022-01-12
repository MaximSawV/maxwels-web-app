<?php
/**
 * Created by PhpStorm.
 * User: maxim
 * Date: 1/7/22
 * Time: 12:44 PM
 */

namespace App\myPHPClasses;


use App\Entity\Chat;
use App\Entity\ChatMessage;
use App\Entity\ChatParticipant;
use App\Entity\User;
use App\Repository\ChatParticipantRepository;
use App\Repository\ChatRepository;
use App\Session\SessionManager;
use Doctrine\ORM\EntityManagerInterface;

class MaxwelsChat
{
    private $chatRepository;
    private $participantRepository;

    private $entityManager;
    private $sessionManager;

    public function __construct(ChatRepository $chatRepository,
                                EntityManagerInterface $entityManager, SessionManager $sessionManager,
                                ChatParticipantRepository $participantRepository)
    {
        $this->chatRepository = $chatRepository;
        $this->entityManager = $entityManager;
        $this->sessionManager = $sessionManager;
        $this->participantRepository = $participantRepository;
    }

    private function createChat(string $name)
    {
        $chat = new Chat();
        $chat->setIsGroup(false);
        $chat->setGroupName($name);
        $this->entityManager->persist($chat);
        $this->entityManager->flush();

        return $chat;
    }

    private function createParticipant(User $user, Chat $chat)
    {
        $now = new \DateTimeImmutable('now');
        $participant = new ChatParticipant();
        $participant->setUser($user);
        $participant->setInChat($chat);
        $participant->setLoggedInSince($now);
        $participant->setLoggedOutSince($now);


        $this->entityManager->persist($participant);
        $this->entityManager->flush();

        return $participant;
    }

    private function createMessage(ChatParticipant $participant, Chat $chat, string $content, \DateTimeInterface $date)
    {
        $message = new ChatMessage();
        $message->setSource($participant);
        $message->setContent($content);
        $message->setInChat($chat);
        $message->setCreatedOn($date);
        $this->entityManager->persist($message);
        $this->entityManager->flush();

        return $message;
    }

    public function initiateChat(User $user, string $secondUsers)
    {
        $chat = $this->createChat($secondUsers);
        $this->createParticipant($user, $chat);
    }
}