<?php
/**
 * Created by PhpStorm.
 * User: maxim
 * Date: 1/20/22
 * Time: 1:24 PM
 */

namespace App\myPHPClasses;


use App\Entity\ChatParticipant;
use App\Repository\ChatParticipantRepository;
use App\Session\SessionManager;

class MaxwelsChatParticipantManager
{
    private $participant;
    private $participantRepository;
    private $sessionManager;
    public function __construct(ChatParticipant $participant,
                                ChatParticipantRepository $participantRepository,
                                SessionManager $sessionManager)
    {
        $this->participant = $participant;
        $this->participantRepository = $participantRepository;
        $this->sessionManager = $sessionManager;
    }

    public function getChatParticipants()
    {
        $chatParticipants = $this->sessionManager->getUser()->getChatParticipants();

        return $chatParticipants;
    }
}