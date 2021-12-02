<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Profiler\Profiler;
use Symfony\Component\Security\Core\Security;
use App\Entity\User;
use App\Repository\UserRepository;

class MainPageController extends AbstractController
{
    private $userRepository;
    private $security;

    public function __construct(UserRepository $userRepository,
                                Security $security)
    {
        $this->userRepository = $userRepository;
        $this->security = $security;
    }


    #[Route('/', name: 'main_page')]
    public function index(?Profiler $profiler): Response
    {
        $user = $this->security->getUser();
        $cuID = 0;
        if (isset($user) or $user != null){
            $loggedin = true;
            $currentUser = $user->getUserIdentifier();
            $query1 = $this
                ->userRepository
                ->createQueryBuilder('u')
                ->select('u.Subscribed')
                ->andWhere('u.username = :currentUser')
                ->setParameter('currentUser', $currentUser);

            /** @var User $cuID */
            $cuID = $query1->getQuery()->getOneOrNullResult();
        } else {
            $loggedin = false;
        }

        return $this->render('main_page/index.html.twig', [
            'logged' => $loggedin,
            'test' => $cuID
        ]);
    }
}
