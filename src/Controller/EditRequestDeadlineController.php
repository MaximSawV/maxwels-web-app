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

    public function __construct(RequestRepository $requestRepository)
    {
        $this->requestRepository = $requestRepository;
    }


    #[Route('/request/user/all_requests/edit_deadline', name: 'edit_deadline')]
    public function editDeadline()
    {
        $newDate = $_POST["newDeadline"];
        $deadline = new \DateTime($newDate);
        $requestID = $_POST["request_id"];

        $query = $this
            ->requestRepository
            ->createQueryBuilder('r')
            ->set('r.Deadline', ':deadline')
            ->where('r.id = :rid')
            ->setParameter('deadline', $deadline)
            ->setParameter('rid', $requestID);
        $result = $query->getQuery()->execute();



        return $this->redirectToRoute("request_user");


    }
}