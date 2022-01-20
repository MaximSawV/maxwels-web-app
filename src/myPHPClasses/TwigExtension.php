<?php
/**
 * Created by PhpStorm.
 * User: maxim
 * Date: 1/13/22
 * Time: 9:42 AM
 */

namespace App\myPHPClasses;

use App\Entity\Chat;
use App\Entity\ChatMessage;
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

    public function getLastMessage(Chat $chat)
    {
        $chatParticipants = $chat->getChatParticipants();
        $messageCol = $chat->getChatMessages();
        /**
         * @var ChatMessage[] $messages
         */
        $messages = $chat->getChatMessages()->toArray();
        /**
         * @var ChatMessage $lastMessage
         */
        $lastMessage = $messageCol->first();
        $userParticipants = $this->sessionManager->getUser()->getChatParticipants();

        foreach ($userParticipants as $uP)
        {
            foreach ($chatParticipants as $cP)
            {
                if ($uP->getId() == $cP->getId())
                {
                    $currentParticipant = $cP;
                }

            }
        }

        foreach ($messages as $message)
        {
            if ($message->getCreatedOn() < $currentParticipant->getLastTimeInChat())
            {
                if($lastMessage->getCreatedOn() < $message->getCreatedOn())
                {
                    $lastMessage = $message;
                }
            }
        }
        return $lastMessage;
    }


}