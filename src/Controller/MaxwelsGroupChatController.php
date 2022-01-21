<?php
/**
 * Created by PhpStorm.
 * User: maxim
 * Date: 1/21/22
 * Time: 9:51 AM
 */

namespace App\Controller;


use App\Entity\Chat;
use App\Form\CreateGroupType;
use App\myPHPClasses\MaxwelsChat;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;

class MaxwelsGroupChatController extends AbstractController
{
    private $maxwelsChat;
    private $request;

    public function __construct(MaxwelsChat $maxwelsChat,
                                RequestStack $request)
    {
        $this->maxwelsChat = $maxwelsChat;
        $this->request = $request;
    }

    #[Route('/request/user/chat/new/group', name: 'chat_new_group')]
    public function createGroup()
    {
        $form = $this->createForm(CreateGroupType::class);
        $form->handleRequest($this->request->getCurrentRequest());

        if($form->isSubmitted() && $form->isValid())
        {
            $newGroup = $this->maxwelsChat->createGroup($form->get('group_members')->getData()->toArray(),
                $form->get('group_name')->getData());
        }

        return $this->render('request_page/create_group.html.twig', [
            'groupForm' => $form->createView()
        ]);
    }
}