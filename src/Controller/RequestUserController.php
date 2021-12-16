<?php

namespace App\Controller;

use App\Form\CreateRequestsType;
use Doctrine\ORM\EntityManagerInterface;
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

    private $security;

    public function __construct(UserRepository $userRepository,
                                RequestRepository $requestRepository,
                                Security $security)
    {
        $this->userRepository = $userRepository;
        $this->requestRepository = $requestRepository;
        $this->security = $security;
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


    #[Route('/request/customer/all_requests/{page}', name: 'customer_all_requests')]
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

        return $this->render('request_page/table_requests.html.twig', [
            'requests' => $myRequests,
            'nextPage' => $nextPage,
            'nextPageUrl' => '/request/customer/all_requests/'.(string)$nextPage,
            'currentPage' => $page,
            'lastPageUrl' => '/request/customer/all_requests/'.(string)$lastPage,
            'lastPage' => $lastPage,
            'username' => $this->getCurrentUsername()
        ]);
    }


    #[Route('/request/customer/done_requests/{page}', name: 'customer_done_requests')]
    public function getDoneRequests(int $page)
    {
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
            'nextPageUrl' => '/request/customer/done_requests/'.(string)$nextPage,
            'currentPage' => $page,
            'lastPageUrl' => '/request/customer/done_requests/'.(string)$lastPage,
            'lastPage' => $lastPage,
            'username' => $this->getCurrentUsername()
        ]);
    }


    #[Route('/request/customer/createRequest', name: 'customer_create_request')]
    public function createRequest(Request $request, EntityManagerInterface $entityManager)
    {
        $customerRequest = new \App\Entity\Request();
        $customerRequest->setCreatedBy($this->getCurrentUser());
        $customerRequest->setStatus('Requested');
        $customerRequest->setCreatedOn(new \DateTime());
        $customerRequest->setWorkingOn(null);
        $customerRequest->setVote(0);

        $form =$this->createForm(CreateRequestsType::class, $customerRequest, [
            'action' => $this->generateUrl('customer_create_request')
        ]);



        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            $entityManager->persist($customerRequest);
            $entityManager->flush();

            return $this->redirect('all_requests/1');
        }

        return $this->render('request_page/create_request_form.html.twig', [
            'req_form' => $form->createView(),
            'username' => $this->getCurrentUserName()
        ]);
    }
}
