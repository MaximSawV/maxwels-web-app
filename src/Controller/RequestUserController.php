<?php

namespace App\Controller;

use App\Form\CreateRequestsType;
use App\Form\EditRequestType;
use App\myPHPClasses\MaxwelsUserManager;
use App\Repository\ProgrammerRepository;
use App\Repository\SubscriberRepository;
use App\Session\SessionManager;
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
use App\myPHPClasses\MaxwelsRequestManager;
use function Webmozart\Assert\Tests\StaticAnalysis\null;

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
                                MaxwelsRequestManager $requestManager)
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
        ]);
    }

    #[Route('/request/all_open_requests/{page}', name: 'all_open_requests')]
    public function getAllOpenRequests(int $page)
    {
        $tableContent = ['Created by', 'Context', 'Created on', 'Deadline'];
        $allOpenRequests = $this->requestManager->getRequestedRequests($page);
        $numberOfRequests = $this->requestManager->getNumberOfRequestedRequests($page);


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
            'takeable' => true
        ]);
    }

//------------------------------------------------------}

//User Options------------------------------------------{

    #[Route('/user/status_update/{status}', name: 'user_status_update')]
    public function updateUserStatus(string $status, MaxwelsUserManager $userManager): Response
    {
        $userManager->updateStatus($status);
        return $this->redirectToRoute('request_page');
    }

    #[Route('/user/logout', name: 'user_logout')]
    public function logout(MaxwelsUserManager $userManager): Response
    {
        $userManager->updateStatus('offline');
        return $this->redirect('/logout');
    }

//------------------------------------------------------}

//Request Options---------------------------------------{

    #[Route('/request/createRequest', name: 'create_request')]
    public function createRequest(Request $request)
    {

        $form =$this->createForm(CreateRequestsType::class, null,  [
            'action' => $this->generateUrl('create_request')
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $context = $form->get('Context')->getData();
            $deadline = $form->get('Deadline')->getData();

            $this->requestManager->createRequest(null, null,'requested',null, $deadline, $context, false);
            return $this->redirect('all_requests/1');
        }

        return $this->render('request_page/create_request_form.html.twig', [
            'req_form' => $form->createView(),
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
    public function doneRequest(int $id ,RequestRepository $requestRepository, ProgrammerRepository $programmerRepository, SessionManager $manager): Response
    {
        $request = $requestRepository->find($id);
        $request->setStatus('Done');
        $request->setWorkingOn($manager->getUser());

        $this->entityManager->persist($request);
        $this->entityManager->flush();

        $programmer = $programmerRepository->findOneBy(['user' => $manager->getUser()->getId()]);
        $programmer->setDoneRequests($programmer->getDoneRequests() + 1);

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

            $customerRequest->setStatus($_POST['status']);
            $customerRequest->setContext($_POST['Context']);
            $customerRequest->setDeadline($_POST['Deadline']);

            $this->entityManager->persist($customerRequest);
            $this->entityManager->flush();

            return $this->redirect('/request/all_requests/1');
        }

        return $this->render('request_page/table_requests.html.twig', [
            'requests' => $myRequests,
            'tableContent' => $tableContent,
            'req_form' => $form->createView(),
            ]);
    }

//------------------------------------------------------}


//Profile Data------------------------------------------{

    #[Route('user/profile/data/', name: 'profile_data')]
    public function openProfileData(SubscriberRepository $subscriberRepository, ProgrammerRepository $programmerRepository, SessionManager $sessionManager)
    {

        $userID = $sessionManager->getUser()->getId();
        $userMail = $sessionManager->getUser()->getEmail();

        $sub = $subscriberRepository->findOneBy(['email' => $userMail]);
        $programmer = $programmerRepository->findOneBy(['user' => $userID]);

        if ($sub != null)
        {
            $firstName = $sub->getFirstname();
            $lastName = $sub->getLastname();
        } else {
            $firstName = null;
            $lastName = null;
        }

        if ($programmer != null)
        {
            $rating = $programmer->getRating();
            $doneRequests = $programmer->getDoneRequests();
        } else {
            $rating = null;
            $doneRequests = null;
        }


        return $this->render('profile_option/contactOption.html.twig', [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'rating' => $rating,
            'done_requests' => $doneRequests,
        ]);
    }

}