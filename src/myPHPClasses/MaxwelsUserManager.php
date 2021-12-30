<?php
/**
 * Created by PhpStorm.
 * User: maxim
 * Date: 12/30/21
 * Time: 12:26 PM
 */

namespace App\myPHPClasses;


use App\Entity\User;
use App\Repository\UserRepository;
use App\Session\SessionManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class MaxwelsUserManager
{
    private $hasher;
    private $entityManager;
    private $sessionManager;
    private $userRepository;


    public function __construct(UserPasswordHasherInterface $hasher,
                                EntityManagerInterface $entityManager,
                                UserRepository $userRepository,
                                SessionManager $sessionManager)
    {
        $this->hasher = $hasher;
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
        $this->sessionManager = $sessionManager;
    }

    public function createUser(string $username, array $roles, string $plainPassword, string $email, bool $isVerified = false,
                               string $paymentInfo = null, bool $isSubscriber = false, string $CoP = 'customer', string $status = 'offline')
    {
        $newUser = new User();
        $newUser->setUsername($username);
        $newUser->setRoles($roles);
        $newUser->setPassword($this->hasher->hashPassword($newUser, $plainPassword));
        $newUser->setEmail($email);
        $newUser->setIsVerified($isVerified);
        $newUser->setPaymentInformation($paymentInfo);
        $newUser->setSubscribed($isSubscriber);
        $newUser->setCustomerOrProgrammer($CoP);
        $newUser->setStatus($status);

        $this->entityManager->persist($newUser);
        $this->entityManager->flush();
    }

    public function updateStatus(string $status)
    {
        $user = $this->userRepository->find($this->sessionManager->getUser()->getId());
        $user->setStatus($status);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}