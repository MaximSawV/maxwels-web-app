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
use App\Repository\ChatParticipantRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TwigExtension extends AbstractExtension
{
    private $participantRepository;

    public function __construct(ChatParticipantRepository $participantRepository)
    {
        $this->participantRepository = $participantRepository;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('getChatContact', [$this, 'getChatContact']),
            new TwigFunction('getMessageSender', [$this, 'getMessageSender'])
        ];
    }

    public function getChatContact(Chat $chat, User $user)
    {
        $allChatParticipants = $chat->getChatParticipants();


        foreach ($allChatParticipants as $chatP)
        {
            if($chatP->getUser()->getId() != $user->getId())
            {
                return $chatP->getUser()->getUserIdentifier();
            }
        }
    }

    public function getMessageSender(ChatParticipant $participant)
    {
        return $participant->getUser()->getUserIdentifier();
    }
}