<?php
/**
 * Created by PhpStorm.
 * User: maxim
 * Date: 1/13/22
 * Time: 9:42 AM
 */

namespace App\myPHPClasses;

use App\Entity\Chat;
use App\Entity\ChatParticipant;
use App\Entity\User;
use App\Repository\ChatMessageRepository;
use App\Repository\ChatParticipantRepository;
use App\Repository\ChatRepository;
use App\Session\SessionManager;
use Doctrine\ORM\Mapping\OrderBy;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TwigExtension extends AbstractExtension
{
    private $messageRepository;
    private $chatRepository;
    private $sessionManager;

    public function __construct(ChatMessageRepository $messageRepository,
                                ChatRepository $chatRepository,
                                SessionManager $sessionManager)
    {
        $this->messageRepository = $messageRepository;
        $this->chatRepository = $chatRepository;
        $this->sessionManager = $sessionManager;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('getChatContact', [$this, 'getChatContact']),
            new TwigFunction('getLastMessage', [$this, 'getLastMessage'])
        ];
    }

    public function getChatContact(Chat $chat, User $user)
    {
        $allChatParticipants = $chat->getChatParticipants();


        foreach ($allChatParticipants as $chatP)
        {
            if($chatP->getUser()->getId() != $user->getId())
            {
                return $chatP->getUser();
            }
        }
    }

    public function getLastMessage(int $id)
    {
        $lastMessage = $this->messageRepository->createQueryBuilder('m')
            ->where('m.created_on < :loggedIn')
            ->andWhere('m.in_chat = :chat')
            ->setParameter('loggedIn', $this->sessionManager->getUser()->getLoggedInTime())
            ->setParameter('chat', $id)
            ->orderBy('m.created_on', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        return $lastMessage;
    }


}