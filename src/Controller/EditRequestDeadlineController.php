<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\RequestRepository;
use App\Entity\Request;
use DateTimeInterface;
use Symfony\Component\Validator\Constraints\DateTime;

class EditRequestDeadlineController extends AbstractController
{
    private $security;

    private $requestRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(RequestRepository $requestRepository, EntityManagerInterface $entityManager)
    {
        $this->requestRepository = $requestRepository;
        $this->entityManager = $entityManager;
    }

    //TODO[maxim] Change to only PHP
    #[Route('/request/user/all_requests/edit_deadline', name: 'edit_deadline')]
    public function editDeadline(\Symfony\Component\HttpFoundation\Request $request)
    {
        $deadline = new \DateTime($request->get('newDeadline'));
        $requestID = $request->get('request_id');

        var_dump($requestID);
        die();

        $requestEntity = $this->requestRepository->find($requestID);

        $requestEntity
            ->setDeadline($deadline);

        $this->entityManager->flush();


        return $this->redirectToRoute("request_user");


    }
}