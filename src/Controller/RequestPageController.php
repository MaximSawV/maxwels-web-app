<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class RequestPageController extends AbstractController
{
    #[Route('/request', name: 'request_page')]
    public function index(Security $security, UserRepository $userRepository): Response
    {
        $user = $security->getUser();
        $username = $user->getUserIdentifier();

        $query = $userRepository->createQueryBuilder('u')
            ->select('u.current_Role')
            ->where('u.username = :username')
            ->setParameter('username', $username);

        $currentRole = $query->getQuery()->getOneOrNullResult();


        return $this->render('request_page/index.html.twig', [
            'username' => $username,
            'currentRole' => $currentRole,
        ]);
    }
}
