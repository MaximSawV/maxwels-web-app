<?php

namespace App\Controller;

use App\Form\CreateRequestsType;
use App\Form\EditRequestType;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use App\Repository\RequestRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\myPHPClasses\CustomerRequestManager;

class RequestUserController extends AbstractController
{
    private $userRepository;
    private $requestRepository;
    private $entityManager;
    private $security;
    private $requestManager;

    public function __construct(UserRepository $userRepository,
                                RequestRepository $requestRepository,
                                Security $security,
                                EntityManagerInterface $entityManager,
                                CustomerRequestManager $requestManager)
    {
        $this->userRepository = $userRepository;
        $this->requestRepository = $requestRepository;
        $this->security = $security;
        $this->entityManager = $entityManager;
        $this->requestManager = $requestManager;
    }


//Funktions---------------------------------------------{

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

//------------------------------------------------------}

//Show Request Tables-----------------------------------{

    #[Route('/request/all_requests/{page}', name: 'all_requests')]
    public function getMyRequests(int $page)
    {
        $tableContent = ['Working on', 'Status', 'Context', 'Created on', 'Deadline'];

        $myRequests = $this->requestManager->getMyRequestsPerPage($page);
        $numberOfRequests = $this->requestManager->getNumberOfRequests($page);

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

        if (in_array('ROLE_TAKE_REQUESTS',($this->getUser()->getRoles())) or in_array('ROLE_ADMIN',($this->getUser()->getRoles())))
        {
            return $this->render('request_page/table_requests.html.twig', [
                'requests' => $myRequests,
                'nextPage' => $nextPage,
                'nextPageUrl' => '/request/all_requests/'.(string)$nextPage,
                'currentPage' => $page,
                'lastPageUrl' => '/request/all_requests/'.(string)$lastPage,
                'lastPage' => $lastPage,
                'tableContent' => $tableContent,
                'username' => $this->getCurrentUsername(),
                'doneable' => true,
            ]);
        } else {
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
    }

    #[Route('/request/done_requests/{page}', name: 'done_requests')]
    public function getDoneRequests(int $page)
    {
        $tableContent = ['Working on', 'Context', 'Created on', 'Deadline'];
        if(in_array('ROLE_TAKE_REQUESTS',($this->getUser()->getRoles())) or in_array('ROLE_ADMIN',($this->getUser()->getRoles())))
        {
            $tableContent = ['Working on', 'Created by', 'Context', 'Created on', 'Deadline'];
        }

        $doneRequests = $this->requestManager->getDoneRequests($page);
        $numberOfRequests = $this->requestManager->getNumberOfDoneRequests($page);

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
            'username' => $this->getCurrentUsername(),
            'takeable' => true
        ]);
    }

//------------------------------------------------------}

//User Options------------------------------------------{

    #[Route('/user/status_update/{status}', name: 'user_status_update')]
    public function updateUserStatus(string $status): Response
    {
        $user = $this->userRepository->find($this->getCurrentUser());
        $user->setStatus($status);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->redirectToRoute('request_page');
    }

    #[Route('/user/logout', name: 'user_logout')]
    public function logout(): Response
    {
        $user = $this->userRepository->find($this->getCurrentUser());
        $user->setStatus('Offline');
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return $this->redirect('/logout');
    }

//------------------------------------------------------}

//Request Options---------------------------------------{

    #[Route('/request/createRequest', name: 'create_request')]
    public function createRequest(Request $request)
    {

        $form =$this->createForm(CreateRequestsType::class,  [
            'action' => $this->generateUrl('create_request')
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $context = $request->request->get('Context');
            $deadline = $request->request->get('Deadline');
            $this->requestManager->createRequest(null,'offline',null, $deadline, $context, false);
            return $this->redirect('all_requests/1');
        }

        return $this->render('request_page/create_request_form.html.twig', [
            'req_form' => $form->createView(),
            'username' => $this->getCurrentUserName()
        ]);
    }

    #[Route('/request/take_request/{id}', name: 'take_request')]
    public function takeRequest(int $id ,RequestRepository $requestRepository): Response
    {
        $request = $requestRepository->find($id);
        $request->setStatus('In Progress');
        $request->setWorkingOn($this->getCurrentUser());

        $this->entityManager->persist($request);
        $this->entityManager->flush();
        return $this->redirect('/request/all_open_requests/1');
    }

    #[Route('/request/done_request/{id}', name: 'done_request')]
    public function doneRequest(int $id ,RequestRepository $requestRepository): Response
    {
        $request = $requestRepository->find($id);
        $request->setStatus('Done');
        $request->setWorkingOn($this->getCurrentUser());

        $this->entityManager->persist($request);
        $this->entityManager->flush();
        return $this->redirect('/request/all_requests/1');
    }

    #[Route('/request/edit_request/{id}', name: 'edit_request')]
    public function editRequest(int $id, RequestRepository $requestRepository, Request $request): Response
    {
        $tableContent = ['Working on', 'Status', 'Context', 'Created on', 'Deadline'];

        $query = $this
            ->requestRepository
            ->createQueryBuilder('r')
            ->where('r.id = :currentRequest')
            ->setParameter('currentRequest', $id);

        /** @var @var Request[] $myRequests */
        $myRequests = $query->getQuery()->getResult();

        $customerRequest=$requestRepository->find($id);

        $form =$this->createForm(EditRequestType::class,$customerRequest, [
            'action' => $this->generateUrl('create_request')
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            $customerRequest->setStatus($form->getData()['Status']);
            $customerRequest->setContext($form->getData()['Context']);
            $customerRequest->setDeadline($form->getData()['Deadline']);

            $this->entityManager->persist($customerRequest);
            $this->entityManager->flush();

            return $this->redirect('all_requests/1');
        }

        return $this->render('request_page/table_requests.html.twig', [
            'requests' => $myRequests,
            'tableContent' => $tableContent,
            'username' => $this->getCurrentUsername(),
            'req_form' => $form->createView(),
            ]);
    }

//------------------------------------------------------}

}

//TODO[maxim] Optionsmenü erstellen
//TODO[maxim] Kontaktmenü erstellen
//TODO[maxim] Funktion EditRequest erstellen
//TODO[maxim] Mailfunktion von Usern untereinander Erstellen
//TODO[maxim] sql, generelle funktionen auslagern, sodass der Controller nur kominikation ist