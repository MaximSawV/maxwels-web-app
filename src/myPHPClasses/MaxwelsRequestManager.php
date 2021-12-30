<?php
/**
 * Created by PhpStorm.
 * User: maxim
 * Date: 12/30/21
 * Time: 8:19 AM
 */

namespace App\myPHPClasses;


use App\Entity\Request;
use App\Entity\User;
use App\Repository\RequestRepository;
use App\Session\SessionManager;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class MaxwelsRequestManager
{

    private $requestRepository;
    private $entityManager;
    private $security;
    private $sessionManager;
    private $currentUser;
    private $request;

    public function __construct(RequestRepository $requestRepository,
                                Security $security,
                                SessionManager $sessionManager,
                                EntityManagerInterface $entityManager)
    {
        $this->requestRepository = $requestRepository;
        $this->security = $security;
        $this->entityManager = $entityManager;
        $this->sessionManager = $sessionManager;
        $this->currentUser = $this->sessionManager->getUser();
    }


    public function createRequest(User $createdBy = null, User $workingOn = null, string $status = 'offline', \DateTime $createdOn = null, \DateTime $deadline = null, string $context = "missing", bool $vote = false)
    {
        if ($createdBy == null)
        {
            $createdBy = $this->currentUser;
        }

        if ($createdOn == null)
        {
            $createdOn = new \DateTime();
        }

        $newRequest = new Request();
        $newRequest->setCreatedBy($createdBy);
        $newRequest->setWorkingOn($workingOn);
        $newRequest->setStatus($status);
        $newRequest->setCreatedOn($createdOn);
        $newRequest->setDeadline($deadline);
        $newRequest->setContext($context);
        $newRequest->setVote($vote);

        $this->entityManager->persist($newRequest);
        $this->entityManager->flush();
    }


    public function getMyRequestsPerPage(int $page)
    {
        $cuID = $this->currentUser->getId();

        $firstResult = (5*($page-1));

        $query = $this
            ->requestRepository
            ->createQueryBuilder('r')
            ->where('r.Created_by = :currentUser')
            ->orWhere('r.Working_on = :currentUser')
            ->andWhere('r.Status != \'Done\'')
            ->setFirstResult($firstResult)
            ->setMaxResults(5)
            ->setParameter('currentUser', $cuID);

        /** @var @var Request[] $myRequests */
        $myRequests = $query->getQuery()->getResult();

        return $myRequests;
    }

    public function getNumberOfRequests(int $page)
    {
        $cuID = $this->currentUser->getId();
        $firstResult = (5 * ($page - 1));
        $query = $this
            ->requestRepository
            ->createQueryBuilder('r')
            ->where('r.Created_by = :currentUser')
            ->orWhere('r.Working_on = :currentUser')
            ->andWhere('r.Status != \'Done\'')
            ->setFirstResult($firstResult)
            ->setParameter('currentUser', $cuID);

        /** @var @var Request[] $myRequests */
        $myRequestsTotal = $query->getQuery()->getResult();

        $numberOfRequests = count($myRequestsTotal);

        return $numberOfRequests;
    }

    public function getDoneRequests(int $page)
    {
        $cuID = $this->currentUser->getId();

        $firstResult = (5*($page-1));

        $query = $this
            ->requestRepository
            ->createQueryBuilder('r')
            ->where('r.Created_by = :currentUser')
            ->orWhere('r.Working_on = :currentUser')
            ->andWhere('r.Status = \'Done\'')
            ->setFirstResult($firstResult)
            ->setMaxResults(5)
            ->setParameter('currentUser', $cuID);

        /** @var @var Request[] $myRequests */
        $myRequests = $query->getQuery()->getResult();

        return $myRequests;
    }

    public function getNumberOfDoneRequests(int $page)
    {
        $cuID = $this->currentUser->getId();
        $firstResult = (5 * ($page - 1));
        $query = $this
            ->requestRepository
            ->createQueryBuilder('r')
            ->where('r.Created_by = :currentUser')
            ->orWhere('r.Working_on = :currentUser')
            ->andWhere('r.Status = \'Done\'')
            ->setFirstResult($firstResult)
            ->setParameter('currentUser', $cuID);

        /** @var @var Request[] $myRequests */
        $myRequestsTotal = $query->getQuery()->getResult();

        $numberOfRequests = count($myRequestsTotal);

        return $numberOfRequests;
    }

    public function getRequestedRequests(int $page)
    {
        $cuID = $this->currentUser->getId();
        $firstResult = (5*($page-1));

        $query = $this
            ->requestRepository
            ->createQueryBuilder('r')
            ->where('r.Created_by != :currentUser')
            ->andWhere('r.Status = \'Requested\'')
            ->setParameter('currentUser', $cuID)
            ->setFirstResult($firstResult)
            ->setMaxResults(5);

        /** @var @var Request[] $myRequests */
        $allOpenRequests = $query->getQuery()->getResult();

        return $allOpenRequests;
    }

    public function getNumberOfRequestedRequests(int $page)
    {
        $cuID = $this->currentUser->getId();
        $firstResult = (5 * ($page - 1));
        $query = $this
            ->requestRepository
            ->createQueryBuilder('r')
            ->where('r.Created_by = :currentUser')
            ->orWhere('r.Working_on = :currentUser')
            ->andWhere('r.Status = \'Done\'')
            ->setFirstResult($firstResult)
            ->setParameter('currentUser', $cuID);

        /** @var @var Request[] $myRequests */
        $myRequestsTotal = $query->getQuery()->getResult();

        $numberOfRequests = count($myRequestsTotal);

        return $numberOfRequests;
    }
}