<?php

namespace App\Controller;

use App\Entity\Chat;
use App\Entity\ChatParticipant;
use App\Entity\User;
use App\myPHPClasses\MaxwelsChat;
use App\Repository\ChatMessageRepository;
use App\Repository\ChatParticipantRepository;
use App\Repository\ChatRepository;
use App\Repository\UserRepository;
use App\Session\SessionManager;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use function Webmozart\Assert\Tests\StaticAnalysis\true;

class ChatController extends AbstractController
{
    private $userRepository;
    private $sessionManager;
    private $participantRepository;
    private $chatRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(UserRepository $userRepository,
                                SessionManager $sessionManager,
                                EntityManagerInterface $entityManager,
                                ChatParticipantRepository $participantRepository,
                                ChatRepository $chatRepository)
    {
        $this->userRepository = $userRepository;
        $this->sessionManager = $sessionManager;
        $this->entityManager = $entityManager;
        $this->participantRepository = $participantRepository;
        $this->chatRepository = $chatRepository;
    }

    private function getYourChats()
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

    private function getAllOtherUsers ()
    {
        $query = $this->userRepository->createQueryBuilder('u')
        ->where('u.username != :username')
        ->setParameter('username',$this->sessionManager->getUser()->getUserIdentifier())
        ->getQuery();

        return $query->getResult();
    }

    #[Route('/request/user/chat', name: 'chat')]
    public function index(): Response
    {
        $chats = $this->getYourChats();
        $chatParticipants = $this->sessionManager->getUser()->getChatParticipants();
        return $this->render('request_page/chatbox.html.twig', [
            'chat_participants' => $chatParticipants,
            'user_list' => $this->getAllOtherUsers(),
            'chats' => $chats,
        ]);
    }

    #[Route('/request/user/chat/{id}', name: 'chat_messages')]
    public function getMessages(int $id,ChatMessageRepository $messageRepository, ChatRepository $chatRepository): Response
    {
        $chats = $this->getYourChats();
        $messages = $messageRepository->findBy(['source' => $id]);
        $chatParticipants = $this->sessionManager->getUser()->getChatParticipants();
        return $this->render('request_page/chatbox.html.twig', [
            'messages' => $messages,
            'chat_participants' => $chatParticipants,
            'user_list' => $this->getAllOtherUsers(),
            'chats' => $chats,
            'currentChat' => $id
        ]);
    }

    #[Route('/chat/newchat', name: 'chat_new_chat')]
    public function createChat(EntityManagerInterface $em, SessionManager $sessionManager, MaxwelsChat $maxwelsChat): Response
    {
        $user1 = $sessionManager->getUser();
        $user2Id = $_GET['user'];
        $user2 = $this->userRepository->find($user2Id);

        $query = 'SELECT c.id FROM chat c
                    JOIN chat_participant cp ON c.id = cp.in_chat_id AND cp.user_id = :user1
                    JOIN chat_participant cp2 ON c.id = cp2.in_chat_id AND cp2.user_id = :user2';

        $chat = $em->getConnection()->prepare($query)->executeQuery(['user1' => $user1->getId(), 'user2' => $user2Id])->fetchOne();

        if (!$chat)
        {

            $maxwelsChat->initiateChat($user1, $user2);
        }

        return $this->redirectToRoute('chat');
    }

    #[Route('/request/user/chat/send/{chat}/{id}', name: 'chat_new_message')]
    public function newMessage(MaxwelsChat $maxwelsChat,$chat,$id)
    {
        $content = $_GET['message'];
        $user = $this->userRepository->find($id);
        $userParticipants = $user->getChatParticipants();
        $currentChat = $this->chatRepository->find($chat);
        $chatParticipants = $currentChat->getChatParticipants();

        foreach ($userParticipants as $uP)
        {
            foreach ($chatParticipants as $cP)
            {
                if($uP->getId() == $cP->getId())
                {
                    $parti = $cP;
                }
            }
        }

        $maxwelsChat->writeMessage($parti, $currentChat, $content);

        return $this->redirect('/request/user/chat/'.$chat);
    }
}