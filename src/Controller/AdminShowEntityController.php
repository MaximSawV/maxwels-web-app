<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\ProfileOptions;
use App\Entity\Programmer;
use App\Entity\Request;
use App\Entity\Subscriber;
use App\Entity\User;
use App\Entity\UserRelationship;
use App\Repository\CustomerRepository;
use App\Repository\ProfileOptionsRepository;
use App\Repository\ProgrammerRepository;
use App\Repository\RequestRepository;
use App\Repository\SubscriberRepository;
use App\Repository\UserRelationshipRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PropertyInfo\PropertyInfoExtractorInterface;

class AdminShowEntityController extends AbstractController
{
    private $userRepository;
    private $customerRepository;
    private $programmerRepository;
    private $requestRepository;
    private $optionsRepository;
    private $subscriberRepository;
    private $relationshipRepository;
    private $infoExtractor;

    public function __construct(UserRepository $userRepository,
                                CustomerRepository $customerRepository,
                                ProgrammerRepository $programmerRepository,
                                RequestRepository $requestRepository,
                                ProfileOptionsRepository $optionsRepository,
                                SubscriberRepository $subscriberRepository,
                                UserRelationshipRepository $relationshipRepository,
                                PropertyInfoExtractorInterface $infoExtractor)
    {
        $this->userRepository = $userRepository;
        $this->customerRepository = $customerRepository;
        $this->programmerRepository = $programmerRepository;
        $this->requestRepository = $requestRepository;
        $this->optionsRepository = $optionsRepository;
        $this->subscriberRepository = $subscriberRepository;
        $this->relationshipRepository = $relationshipRepository;
        $this->infoExtractor = $infoExtractor;
    }

    private function provideData(string $entity, int $page)
    {
        if ($entity == "User")
        {
            $allEntities = $this->userRepository->findBy([],[],null,(5 * ($page - 1)));
            $entityPerPage = $this->userRepository->findBy([],[],5,(5 * ($page - 1)));
            $numberOfEntities = count($allEntities);
            $attributes = $this->infoExtractor->getProperties(User::class);

            array_splice($attributes,3,5);
            array_splice($attributes,7,9);

        }

        if ($entity == "Customer")
        {
            $allEntities = $this->customerRepository->findBy([],[],null,(5 * ($page - 1)));
            $entityPerPage = $this->customerRepository->findBy([],[],5,(5 * ($page - 1)));
            $numberOfEntities = count($allEntities);
            $attributes = $this->infoExtractor->getProperties(Customer::class);
        }

        if ($entity == "Programmer")
        {
            $allEntities = $this->programmerRepository->findBy([],[],null,(5 * ($page - 1)));
            $entityPerPage = $this->programmerRepository->findBy([],[],5,(5 * ($page - 1)));
            $numberOfEntities = count($allEntities);
            $attributes = $this->infoExtractor->getProperties(Programmer::class);
        }

        if ($entity == "Request")
        {
            $allEntities = $this->requestRepository->findBy([],[],null,(5 * ($page - 1)));
            $entityPerPage = $this->requestRepository->findBy([],[],5,(5 * ($page - 1)));
            $numberOfEntities = count($allEntities);
            $attributes = $this->infoExtractor->getProperties(Request::class);
        }

        if ($entity == "Profile Options")
        {
            $allEntities = $this->optionsRepository->findBy([],[],null,(5 * ($page - 1)));
            $entityPerPage = $this->optionsRepository->findBy([],[],5,(5 * ($page - 1)));
            $numberOfEntities = count($allEntities);
            $attributes = $this->infoExtractor->getProperties(ProfileOptions::class);
        }

        if ($entity == "Subscriber")
        {
            $allEntities = $this->subscriberRepository->findBy([],[],null,(5 * ($page - 1)));
            $entityPerPage = $this->subscriberRepository->findBy([],[],5,(5 * ($page - 1)));
            $numberOfEntities = count($allEntities);
            $attributes = $this->infoExtractor->getProperties(Subscriber::class);
        }

        if ($entity == "Relationship")
        {
            $allEntities = $this->relationshipRepository->findBy([],[],null,(5 * ($page - 1)));
            $entityPerPage = $this->relationshipRepository->findBy([],[],5,(5 * ($page - 1)));
            $numberOfEntities = count($allEntities);
            $attributes = $this->infoExtractor->getProperties(UserRelationship::class);
        }

        return ['number' => $numberOfEntities, 'entities' => $entityPerPage, 'attributes' => $attributes];
    }


    #[Route('/admin/show/{entity}/{page}', name: 'admin_show_entity')]
    public function index(string $entity, int $page): Response
    {
        try {
            $data = $this->provideData($entity, $page);
            if (!$data)
            {
                throw new \Exception('Data faulty');
            } else {
                $numberOfEntities = $data['number'];
                $entities = $data['entities'];
                $attributes = $data['attributes'];



            }
        } catch (\Exception $e) {
            $this->addFlash('error', $e->getMessage());
            $this->redirectToRoute('admin_page');
        }

        if ($numberOfEntities > 5)
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


        return $this->render('admin_pages/AdminShowPage.html.twig', [
            'nextPage' => $nextPage,
            'nextPageUrl' => '/request/all_requests/'.(string)$nextPage,
            'currentPage' => $page,
            'lastPageUrl' => '/request/all_requests/'.(string)$lastPage,
            'lastPage' => $lastPage,
            'numberOfEntities' => 5,
            'entities' => $entities,
            'attributes' => $attributes
        ]);
    }
}
