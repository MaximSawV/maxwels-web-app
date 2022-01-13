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
use Symfony\Component\Security\Core\Security;
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
}