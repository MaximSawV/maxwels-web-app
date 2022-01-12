<?php

namespace App\Controller;

use App\Entity\User;
use App\myPHPClasses\MaxwelsChat;
use App\Repository\ChatMessageRepository;
use App\Repository\ChatParticipantRepository;
use App\Repository\ChatRepository;
use App\Repository\UserRepository;
use App\Session\SessionManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Webmozart\Assert\Tests\StaticAnalysis\true;

class ChatController extends AbstractController
{
    private $userRepository;
    private $sessionManager;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(UserRepository $userRepository, SessionManager $sessionManager, EntityManagerInterface $entityManager)
    {
        $this->userRepository = $userRepository;
        $this->sessionManager = $sessionManager;
        $this->entityManager = $entityManager;
    }

    private function getAllOtherUsers ()
    {
        $query = $this->userRepository->createQueryBuilder('u')
        ->where('u.username != :username')
        ->setParameter('username',$this->sessionManager->getUser()->getUserIdentifier())
        ->getQuery();

        return $query->getResult();
    }

    #[Route('/request/user/chat', name: 'chat')]
    public function index(ChatRepository $chatRepository): Response
    {
        $chatParticipants = $this->sessionManager->getUser()->getChatParticipants();

        $chats = [];
        foreach ($chatParticipants as $participant)
        {
            $chat = $chatRepository->find($participant->getInChat()->getId());
            array_push($chats, $chat);
        }
        return $this->render('request_page/chatbox.html.twig', [
            'chat_participants' => $chatParticipants,
            'user_list' => $this->getAllOtherUsers(),
            'chats' => $chats,
        ]);
    }

    #[Route('/request/user/chat/{id}', name: 'chat_messages')]
    public function getMessages(int $id,ChatMessageRepository $messageRepository): Response
    {
        $messages = $messageRepository->findBy(['source_id' => $id]);
        $chatParticipants = $this->sessionManager->getUser()->getChatParticipants();
        return $this->render('request_page/chatbox.html.twig', [
            'messages' => $messages,
            'chat_participants' => $chatParticipants,
            'user_list' => $this->getAllOtherUsers()
        ]);
    }

    #[Route('/chat/newchat', name: 'chat_new_chat')]
    public function createChat(MaxwelsChat $maxwelsChat, ChatRepository $chatRepository, ChatParticipantRepository $participantRepository): Response
    {
        $chatExists = false;
        $user = $this->userRepository->find($_GET['user'])->getUserIdentifier();
        $chats = $chatRepository->findAll();

        foreach ($chats as $chat)
        {
            if ($chat->getGroupName() == $user)
            {
                $chatExists = true;
            }
        }

        if ($chatExists == false)
        {
            $user1 = $this->sessionManager->getUser();

            //$this->entityManager->persist($user1);

            $maxwelsChat->initiateChat($user1,$user);
        }

        return $this->redirectToRoute('chat');
    }
}