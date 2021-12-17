<?php

namespace App\Controller;

use App\Form\CreateRequestsType;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use App\Repository\RequestRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RequestUserController extends AbstractController
{
    private $userRepository;
    private $requestRepository;
    private $entityManager;
    private $security;

    public function __construct(UserRepository $userRepository,
                                RequestRepository $requestRepository,
                                Security $security,
                                EntityManagerInterface $entityManager)
    {
        $this->userRepository = $userRepository;
        $this->requestRepository = $requestRepository;
        $this->security = $security;
        $this->entityManager = $entityManager;
    }

    private function getCurrentUserName()
    {
        return $this->security->getUser()->getUserIdentifier();
    }

    private function getCurrentUser()
    {
        $currentUser = $this->getCurrentUsername();
        $query1 = $this
            ->userRepository
            ->createQueryBuilder('u')
            ->andWhere('u.username = :currentUser')
            ->setParameter('currentUser', $currentUser);

        /** @var @var User $cuID */
        $cuID = $query1->getQuery()->getOneOrNullResult();

        return $cuID;
    }


    #[Route('/request/all_requests/{page}', name: 'all_requests')]
    public function getMyRequests(int $page)
    {
        $tableContent = ['Working on', 'Status', 'Context', 'Created on', 'Deadline'];
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

        return $this->render('request_page/table_requests.html.twig', [
            'requests' => $myRequests,
            'nextPage' => $nextPage,
            'nextPageUrl' => '/request/all_requests/'.(string)$nextPage,
            'currentPage' => $page,
            'lastPageUrl' => '/request/all_requests/'.(string)$lastPage,
            'lastPage' => $lastPage,
            'tableContent' => $tableContent,
            'username' => $this->getCurrentUsername()
        ]);
    }


    #[Route('/request/done_requests/{page}', name: 'done_requests')]
    public function getDoneRequests(int $page)
    {
        $tableContent = ['Working on', 'Context', 'Created on', 'Deadline'];
        $cuID = $this->getCurrentUser()->getId();
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

        return $this->render('request_page/table_requests.html.twig', [
            'requests' => $doneRequests,
            'nextPage' => $nextPage,
            'nextPageUrl' => '/request/done_requests/'.(string)$nextPage,
            'currentPage' => $page,
            'lastPageUrl' => '/request/done_requests/'.(string)$lastPage,
            'lastPage' => $lastPage,
            'tableContent' => $tableContent,
            'username' => $this->getCurrentUsername()
        ]);
    }

    #[Route('/request/createRequest', name: 'create_request')]
    public function createRequest(Request $request)
    {
        $customerRequest = new \App\Entity\Request();
        $customerRequest->setCreatedBy($this->getCurrentUser());
        $customerRequest->setStatus('Requested');
        $customerRequest->setCreatedOn(new \DateTime());
        $customerRequest->setWorkingOn(null);
        $customerRequest->setVote(0);

        $form =$this->createForm(CreateRequestsType::class, $customerRequest, [
            'action' => $this->generateUrl('create_request')
        ]);



        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            $this->entityManager->persist($customerRequest);
            $this->entityManager->flush();

            return $this->redirect('all_requests/1');
        }

        return $this->render('request_page/create_request_form.html.twig', [
            'req_form' => $form->createView(),
            'username' => $this->getCurrentUserName()
        ]);
    }

    #[Route('/request/all_open_requests/{page}', name: 'all_open_requests')]
    public function getAllOpenRequests(int $page)
    {
        $tableContent = ['Created by', 'Context', 'Created on', 'Deadline'];
        $firstResult = (5*($page-1));

        $query = $this
            ->requestRepository
            ->createQueryBuilder('r')
            ->where('r.Created_by != :currentUser')
            ->andWhere('r.Status = \'Requested\'')
            ->setParameter('currentUser', $this->getCurrentUser())
            ->setFirstResult($firstResult)
            ->setMaxResults(5);

        /** @var @var Request[] $myRequests */
        $allOpenRequests = $query->getQuery()->getResult();

        $query = $this
            ->requestRepository
            ->createQueryBuilder('r')
            ->where('r.Created_by != :currentUser')
            ->andWhere('r.Status = \'Requested\'')
            ->setParameter('currentUser', $this->getCurrentUser())
            ->setFirstResult($firstResult);

        /** @var @var Request[] $myRequests */
        $leftResults = $query->getQuery()->getResult();


        $numberOfRequests = count($leftResults);

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

        return $this->render('request_page/table_requests.html.twig', [
            'requests' => $allOpenRequests,
            'nextPage' => $nextPage,
            'nextPageUrl' => '/request/all_open_requests/'.(string)$nextPage,
            'currentPage' => $page,
            'lastPageUrl' => '/request/all_open_requests/'.(string)$lastPage,
            'lastPage' => $lastPage,
            'tableContent' => $tableContent,
            'username' => $this->getCurrentUsername()
        ]);
    }

    #[Route('/user/status_update/{status}', name: 'user_status_update')]

    public function updateUserStatus(string $status): Response
    {
        $user = $this->userRepository->find($this->getCurrentUser());
        $user->setStatus($status);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->redirectToRoute('request_page');
    }
}

