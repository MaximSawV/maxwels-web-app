<?php

namespace App\Controller;

use App\Entity\Subscriber;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\SubscriptionType;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Security;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class SubscriptonController extends AbstractController
{
    private $security;
    private $userRepository;
    private $entityManager;

    public function __construct(Security $security, UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        $this->security = $security;
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('/subscripton', name: 'subscripton')]
    public function index(Request $request): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->security->getUser();

        $userId = $currentUser->getId();

        $userEntity = $this->userRepository->find($userId);

        $userEntity
            ->setSubscribed(true);

        $this->entityManager->flush();


        $subscriber = new Subscriber();
        $subscriber->setActive(false);
        $subscriber->setNumberOfDonations(0);
        $subscriber->setEmail($currentUser);
        $subscriber->setUser($userEntity);

        $form =$this->createForm(SubscriptionType::class, $subscriber, [
            'action' => $this->generateUrl('subscripton')
        ]);



        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            $this->entityManager->persist($subscriber);
            $this->entityManager->flush();

            return $this->redirectToRoute('main_page');
        }

        return $this->render('subscripton/index.html.twig', [
            'sub_form' => $form->createView(),
        ]);
    }
}
