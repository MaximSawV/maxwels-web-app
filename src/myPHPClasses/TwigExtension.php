<?php
/**
 * Created by PhpStorm.
 * User: maxim
 * Date: 1/13/22
 * Time: 9:42 AM
 */

namespace App\myPHPClasses;

use App\Entity\Chat;
use App\Entity\User;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TwigExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('getChatContact', [$this, 'getChatContact']),
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
}