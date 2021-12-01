<?php

namespace App\Controller;

use App\Entity\Subscriber;
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

    public function __construct(Security $security, UserRepository $userRepository)
    {
        $this->security = $security;
        $this->userRepository = $userRepository;
    }

    #[Route('/subscripton', name: 'subscripton')]
    public function index(Request $request): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->security->getUser();

        $userName = $currentUser->getUserIdentifier();
        $qb = $this->userRepository->createQueryBuilder('u');
        $setSubTrue = $qb
            ->update('User', 'u')
            ->set('u.Subscribe', 1)
            ->where('u.Username = :username')
            ->setParameter('username', $userName)
            ->getQuery();
        $em = $this->getDoctrine()->getManager();

        $em->persist($setSubTrue);
        //$em->flush();

        $subscriber = new Subscriber();
        $subscriber->setActive(false);
        $subscriber->setNumberOfDonations(0);
        $subscriber->setEmail($currentUser);

        $form =$this->createForm(SubscriptionType::class, $subscriber, [
            'action' => $this->generateUrl('subscripton')
        ]);



        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            $em->persist($subscriber);
            $em->flush();

            return $this->redirectToRoute('main_page');
        }

        return $this->render('subscripton/index.html.twig', [
            'sub_form' => $form->createView(),
        ]);
    }
}
