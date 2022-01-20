<?php
/**
 * Created by PhpStorm.
 * User: maxim
 * Date: 1/20/22
 * Time: 2:56 PM
 */

namespace App\myPHPClasses;


use App\Entity\Chat;
use App\Entity\ChatMessage;
use App\Session\SessionManager;

class MaxwelsMessageManager
{
    private $sessionManager;
    private $participantManager;

    public function __construct(SessionManager $sessionManager,
                                MaxwelsChatParticipantManager $participantManager)
    {
        $this->sessionManager = $sessionManager;
        $this->participantManager = $participantManager;
    }

    public function getUnseenMessages(Chat $chat)
    {
        /**
         * @var ChatMessage[] $messages
         */
        $messages = $chat->getChatMessages()->toArray();
        $currentParticipant = $this->participantManager->getCurrentParticipant($chat);
        $unseenMessages = [];

        foreach ($messages as $message)
        {
            if ($message->getCreatedOn() < $currentParticipant->getLastTimeInChat())
            {
               array_push($unseenMessages, $message);
            }
        }
        return $unseenMessages;
    }
}