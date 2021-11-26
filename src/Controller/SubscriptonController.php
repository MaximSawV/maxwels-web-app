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
        $currentUser = $this->security->getUser()->getUserIdentifier();

        $currentUser = $this->security->getUser()->getUserIdentifier();
        $query1 = $this
            ->userRepository
            ->createQueryBuilder('u')
            ->andWhere('u.username = :currentUser')
            ->setParameter('currentUser', $currentUser);

        /** @var User $cuID */
        $cuID = $query1->getQuery()->getOneOrNullResult();


        $subscriber = new Subscriber();
        $subscriber->setCreatedBy($cuID);
        $subscriber->setActive(false);
        $subscriber->setNumberOfDonations(0);

        $form =$this->createForm(SubscriptionType::class, $subscriber, [
            'action' => $this->generateUrl('subscripton')
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();

            $em->persist($subscriber);
            $em->flush();
        }

        return $this->render('subscripton/index.html.twig', [
            'sub_form' => $form->createView(),

        ]);
    }
}
