<?php
/**
 * Created by PhpStorm.
 * User: maxim
 * Date: 1/20/22
 * Time: 1:24 PM
 */

namespace App\myPHPClasses;


use App\Entity\Chat;
use App\Repository\ChatParticipantRepository;
use App\Session\SessionManager;

class MaxwelsChatParticipantManager
{
    private $participantRepository;
    private $sessionManager;
    public function __construct(ChatParticipantRepository $participantRepository,
                                SessionManager $sessionManager)
    {
        $this->participantRepository = $participantRepository;
        $this->sessionManager = $sessionManager;
    }

    public function getChatParticipants()
    {
        $userParticipants = $this->sessionManager->getUser()->getChatParticipants();

        return $userParticipants;
    }

    public function getCurrentParticipant(Chat $chat)
    {
        $userParticipants = $this->getChatParticipants();
        $chatParticipants = $chat->getChatParticipants();

        foreach ($userParticipants as $uP)
        {
            foreach ($chatParticipants as $cP)
            {
                if ($uP->getId() == $cP->getId())
                {
                    return $cP;
                } else {
                    return 'error';
                }
            }
        }
    }
}