<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use App\Entity\User;
use App\Entity\Programmer;
use App\Repository\ProgrammerRepository;
use App\Entity\Request;
use App\Repository\RequestRepository;
use App\Repository\UserRepository;

class RequestUserController extends AbstractController
{
    private $userRepository;
    private $requestRepository;

    private $security;

    public function __construct(UserRepository $userRepository,
                                RequestRepository $requestRepository,
                                Security $security)
    {
        $this->userRepository = $userRepository;
        $this->requestRepository = $requestRepository;
        $this->security = $security;
    }

    #[Route('/request/user', name: 'request_user')]
    public function index(): Response
    {

        return $this->render('request_user/index.html.twig', [
            'showMyRequests' => false,
            'showDoneRequests' => false,
            'showAddRequests' => false,
            'routing' => '../'
        ]);
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


    #[Route('/request/user/all_requests', name: 'user_all_requests')]
    public function getMyRequests()
    {
        $cuID = $this->getCurrentUser();

        $query = $this
            ->requestRepository
            ->createQueryBuilder('r')
            ->join('r.Created_by', 'u')
            ->where('u.id = :currentUser')
            ->andWhere('r.Status != \'Done\'')
            ->setParameter('currentUser', $cuID->getId());


        /** @var Request[] $myRequests */
        $myRequests = $query->getQuery()->getResult();

        return $this->render('request_user/index.html.twig', [
            'showMyRequests' => true,
            'showDoneRequests' => false,
            'showAddRequests' => false,
            'routing' => '../../',
            'myRequests' => $myRequests,
        ]);
    }


    #[Route('/request/user/done_requests', name: 'user_done_requests')]
    public function getDoneRequests()
    {
        $cuID = $this->getCurrentUser();

        $query = $this
            ->requestRepository
            ->createQueryBuilder('r')
            ->join('r.Created_by', 'u')
            ->where('u.id = :currentUser')
            ->andWhere('r.Status = \'DONE\'')
            ->setParameter('currentUser', $cuID);

        /** @var @var Request[] $doneRequests */
        $doneRequests = $query->getQuery()->getResult();

        return $this->render('request_user/index.html.twig', [
            'showDoneRequests' => true,
            'showMyRequests' => false,
            'showAddRequests' => false,
            'routing' => '../../',
            'doneRequests' => $doneRequests,
        ]);
    }

    #[Route('/request/user/add_requests', name: 'add_requests')]
    public function openAddRequest()
    {
        return $this->render('request_user/index.html.twig', [
            'showDoneRequests' => false,
            'showMyRequests' => false,
            'showAddRequests' => true,
            'routing' => '../../',
        ]);
    }
}
