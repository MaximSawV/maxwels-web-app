<?php

namespace App\Controller;

use App\Session\SessionManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Profiler\Profiler;
use Symfony\Component\Security\Core\Security;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Contracts\Translation\TranslatorInterface;

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
    public function index(?Profiler $profiler, EntityManagerInterface $entityManager, SessionManager $sessionManager): Response
    {
        $user = $this->security->getUser();
        $isSubscriber = 1;
        if (isset($user) or $user != null){
            $loggedin = true;
            $currentUser = $user->getUserIdentifier();
            $query1 = $this
                ->userRepository
                ->createQueryBuilder('u')
                ->select('u.Subscribed')
                ->andWhere('u.username = :currentUser')
                ->setParameter('currentUser', $currentUser);

            $isSubscriber = $query1->getQuery()->getOneOrNullResult();

        } else {
            $loggedin = false;
        }

        if($this->security->getUser() != null)
        {
            $user = $sessionManager->getUser();
            $now = new \DateTimeImmutable('now');
            if($user->getLoggedOutTime() === null)
            {
                $minAgo = $now->modify('-1 sec');
                $user->setLoggedOutTime($minAgo);
                $entityManager->persist($user);
                $entityManager->flush();
            }
            if ($user->getLoggedOutTime() > $user->getLoggedInTime())
            {
                $user->setStatus('online');
                $user->setLoggedInTime($now);
                $entityManager->persist($user);
                $entityManager->flush();
            }
        }

        return $this->render('main_page/index.html.twig', [
            'logged' => $loggedin,
            'isSubscriber' => $isSubscriber
        ]);
    }
}
