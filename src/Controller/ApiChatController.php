<?php
/**
 * Created by PhpStorm.
 * User: maxim
 * Date: 1/26/22
 * Time: 11:39 AM
 */

namespace App\Controller;


use App\Entity\Chat;
use App\Entity\User;
use App\myPHPClasses\MaxwelsChat;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiChatController extends AbstractController
{
    private $maxwelsChat;

    public function __construct(MaxwelsChat $maxwelsChat)
    {
        $this->maxwelsChat = $maxwelsChat;
    }

    public function createChat(User $user1, User $user2)
    {
        return $this->redirectToRoute('api_page');
    }

    public function deleteChat(Chat $chat)
    {
        if(!$chat)
        {
            $this->addFlash(
                'fail',
                'Entity not found'
            );
        } else {
            $this->maxwelsChat->deleteChat($chat);
            $this->addFlash(
                'success',
                'Entity deleted'
            );

            return $this->redirectToRoute('api_page');
        }
    }
}