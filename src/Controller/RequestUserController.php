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

        return $this->render('request_page/index.html.twig', [
            'showMyRequests' => false,
            'showDoneRequests' => false,
            'showAddRequests' => false,
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

        /** @var @var User $cuID */
        $cuID = $query1->getQuery()->getOneOrNullResult();

        return $cuID;
    }


    #[Route('/request/user/all_requests/{page}', name: 'user_all_requests')]
    public function getMyRequests(int $page)
    {
        $cuID = $this->getCurrentUser();

        $firstResult = (5*($page-1));

        $query = $this
            ->requestRepository
            ->createQueryBuilder('r')
            ->join('r.Created_by', 'u')
            ->where('u.id = :currentUser')
            ->andWhere('r.Status != \'Done\'')
            ->setFirstResult($firstResult)
            ->setMaxResults(5)
            ->setParameter('currentUser', $cuID->getId());

        /** @var @var Request[] $myRequests */
        $myRequests = $query->getQuery()->getResult();

        $query2 = $this
            ->requestRepository
            ->createQueryBuilder('r')
            ->join('r.Created_by', 'u')
            ->where('u.id = :currentUser')
            ->andWhere('r.Status != \'Done\'')
            ->setFirstResult($firstResult)
            ->setParameter('currentUser', $cuID->getId());

        /** @var @var Request[] $myRequests */
        $myRequestsTotal = $query2->getQuery()->getResult();

        $numberOfRequests = count($myRequestsTotal);

        if ($numberOfRequests > 5)
        {
            $nextPage = $page + 1;

            if ($page > 1)
            {
                $lastPage = $page - 1;
            } else {
                $lastPage = null;
            }
        } else {
            $nextPage = null;
            if ($page > 1)
            {
                $lastPage = $page - 1;
            } else {
                $lastPage = null;
            }
        }

        return $this->render('request_page/index.html.twig', [
            'showMyRequests' => true,
            'showDoneRequests' => false,
            'showAddRequests' => false,
            'myRequests' => $myRequests,
            'nextPage' => $nextPage,
            'currentPage' => $page,
            'lastPage' => $lastPage,
            'test' => $numberOfRequests,
        ]);
    }


    #[Route('/request/user/done_requests/{page}', name: 'user_done_requests')]
    public function getDoneRequests(int $page)
    {
        $cuID = $this->getCurrentUser();
        $firstResult = (5*($page-1));

        $query = $this
            ->requestRepository
            ->createQueryBuilder('r')
            ->join('r.Created_by', 'u')
            ->where('u.id = :currentUser')
            ->andWhere('r.Status = \'DONE\'')
            ->setFirstResult($firstResult)
            ->setMaxResults(5)
            ->setParameter('currentUser', $cuID);

        /** @var @var Request[] $doneRequests */
        $doneRequests = $query->getQuery()->getResult();


        $query2 = $this
            ->requestRepository
            ->createQueryBuilder('r')
            ->join('r.Created_by', 'u')
            ->where('u.id = :currentUser')
            ->andWhere('r.Status = \'DONE\'')
            ->setFirstResult($firstResult)
            ->setMaxResults(5)
            ->setParameter('currentUser', $cuID);

        /** @var @var Request[] $myRequests */
        $myRequestsTotal = $query2->getQuery()->getResult();

        $numberOfRequests = count($myRequestsTotal);

        if ($numberOfRequests > 5)
        {
            $nextPage = $page + 1;

            if ($page > 1)
            {
                $lastPage = $page - 1;
            } else {
                $lastPage = null;
            }
        } else {
            $nextPage = null;
            if ($page > 1)
            {
                $lastPage = $page - 1;
            } else {
                $lastPage = null;
            }
        }

        return $this->render('request_page/index.html.twig', [
            'showDoneRequests' => true,
            'showMyRequests' => false,
            'showAddRequests' => false,
            'nextPage' => $nextPage,
            'currentPage' => $page,
            'lastPage' => $lastPage,
            'test' => $numberOfRequests,
            'doneRequests' => $doneRequests,
        ]);
    }

    #[Route('/request/user/add_requests', name: 'add_requests')]
    public function openAddRequest()
    {
        return $this->render('request_page/index.html.twig', [
            'showDoneRequests' => false,
            'showMyRequests' => false,
            'showAddRequests' => true,
            'nextPage' => null,
            'currentPage' => null,
            'lastPage' => null,
            'test' => null,
        ]);
    }
}
