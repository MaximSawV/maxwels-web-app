<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UserRepository;
use App\Repository\RequestRepository;
use App\Entity\Request;
use DateTimeInterface;
use Symfony\Component\Validator\Constraints\DateTime;

class CreateRequestController extends AbstractController
{
    private $security;
    private $userRepository;
    private $dateTime;

    public function __construct(UserRepository $userRepository,
                                Security $security)
    {
        $this->userRepository = $userRepository;
        $this->security = $security;
    }

    private function getCurrentUser()
    {
        $currentUser = $this->security->getUser()->getUserIdentifier();
        $query1 = $this
            ->userRepository
            ->createQueryBuilder('u')
            ->andWhere('u.username = :currentUser')
            ->setParameter('currentUser', $currentUser);

        /** @var User $cuID */
        $cuID = $query1->getQuery()->getOneOrNullResult();

        return $cuID;
    }

    #[Route('/request/user/add_request/create_request', name: 'create_request')]
    public function createRequest()
    {
        $cuID = $this->getCurrentUser();
        $currentDate = new \DateTime();
        if ($_GET["deadline"] == "")
        {
            $deadline = null;
        }else {
            $sampleDate = $_GET["deadline"];
            $deadline = new \DateTime($sampleDate);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $request = new Request();
        $request->setCreatedBy($cuID);
        $request->setWorkingOn(null);
        $request->setStatus("Requested");
        $request->setCreatedOn($currentDate);
        $request->setDeadline($deadline);
        $request->setContext($_GET["context"]);
        $request->setVote(0);

        $entityManager->persist($request);
        $entityManager->flush();

        return $this->redirectToRoute("request_user");


    }
}