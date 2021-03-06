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

    private function createChat()
    {
        $chat = new Chat();
        $chat->setIsGroup(false);
        $this->entityManager->persist($chat);
        $this->entityManager->flush();

        return $chat;
    }

    private function createParticipant(User $user, Chat $chat)
    {
        $now = new \DateTime('now');
        $participant = new ChatParticipant();
        $participant->setUser($user);
        $participant->setInChat($chat);
        $participant->setLastTimeInChat($now);
        $chat->addChatParticipant($participant);

        $this->entityManager->persist($participant);
        $this->entityManager->flush();

        return $participant;
    }

    private function createMessage(ChatParticipant $participant, Chat $chat, string $content)
    {
        $date = new \DateTime('now');
        $message = new ChatMessage();
        $message->setSource($participant);
        $message->setContent($content);
        $message->setInChat($chat);
        $message->setCreatedOn($date);
        $this->entityManager->persist($message);
        $this->entityManager->flush();

        return $message;
    }

    public function initiateChat(User $user, User $user2)
    {
        $chat = $this->createChat();
        $this->createParticipant($user, $chat);
        $this->createParticipant($user2, $chat);
    }

    public function writeMessage(ChatParticipant $participant, Chat $chat, $content)
    {
        $message = $this->createMessage($participant, $chat, $content);

        return $message;
    }

    /**
     * @param User[] $users
     * @param string $groupName
     * @return Chat $group
     */
    public function createGroup(array $users, string $groupName)
    {
        $group = new Chat();
        $group->setIsGroup(true);
        $group->setGroupName($groupName);
        $group->setGroupImage($groupName."Image.png");
        $this->entityManager->persist($group);
        $this->entityManager->flush();

        /**
         * @var User $user
         */
        foreach ($users as $user)
        {
            $this->createParticipant($user, $group);
        }

        return $group;
    }

    public function getMyChats()
    {
        $chatParticipants = $this->sessionManager->getUser()->getChatParticipants();
        $chats = [];
        foreach ($chatParticipants as $participant)
        {
            $chat = $this->chatRepository->find($participant->getInChat()->getId());
            array_push($chats, $chat);
        }

        return $chats;
    }

    public function deleteChat(Chat $chat)
    {
        $messages = $chat->getChatMessages();
        $participants = $chat->getChatParticipants();

        if($participants)
        {
            foreach ($participants as $participant)
            {
                $this->entityManager->remove($participant);
                $this->entityManager->flush();
            }
        }

        if($messages)
        {
            foreach ($messages as $message)
            {
                $this->entityManager->remove($message);
                $this->entityManager->flush();
            }
        }

        $this->entityManager->remove($chat);
        $this->entityManager->flush();
    }
}
