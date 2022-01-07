<?php
/**
 * Created by PhpStorm.
 * User: maxim
 * Date: 1/7/22
 * Time: 8:15 AM
 */

namespace App\myPHPClasses;


use App\Entity\MaxwelsAdmin;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Session\SessionManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Security;
use function Webmozart\Assert\Tests\StaticAnalysis\contains;
use function Webmozart\Assert\Tests\StaticAnalysis\string;

class MaxwelsAdminManager
{
    private $hasher;
    private $sessionManager;
    private $entityManager;
    private $flashBag;
    private $userRepository;

    public function __construct(UserPasswordHasherInterface $hasher,
                                SessionManager $sessionManager,
                                EntityManagerInterface $entityManager,
                                FlashBagInterface $flashBag,
                                UserRepository $userRepository)
    {
        $this->hasher = $hasher;
        $this->sessionManager = $sessionManager;
        $this->entityManager = $entityManager;
        $this->flashBag = $flashBag;
        $this->userRepository = $userRepository;
    }

    private function randomPassword() :string
    {

        $seed = str_split('abcdefghijklmnopqrstuvwxyz'
            .'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
            .'!@#$%^&*()');

        shuffle($seed);

        $randomPassword = "";
        $counter = 0;

        while($counter <= rand(3,6))
        {
            $randInt = rand(0,5);
            if($randInt == 0)
            {
                $randomPassword .= string(rand(10, 99));
                $counter += 1;
            } elseif ($randInt == 1)
            {
                foreach (array_rand($seed, 3) as $k) $randomPassword .= $seed[$k];
                $counter +=1;
            }
        }

        return $randomPassword;
    }

    public function createAdminKey(User $user)
    {
        $plainPassword = $this->randomPassword();
        $adminKeyHash = $this->hasher->hashPassword($user, $plainPassword);

        return $adminKeyHash;
    }

    public function createAdmin(User $user) :string
    {
        $roles = $this->sessionManager->getUser()->getRoles();
        if (in_array('ROLE_PROMOTE_TO_ADMIN', $roles))
        {
            $admin = new MaxwelsAdmin($this);
            $admin->setUser($user);
            $admin->setGrantedBy($this->sessionManager->getUser());
            $admin->setAdminKey();
            $this->entityManager->persist($admin);
            $this->entityManager->flush();

            $userRoles = $user->getRoles();
            array_push($userRoles, 'ROLE_ADMIN');
            $user->setRoles($userRoles);
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            return "Succesfull";
        } else {
            return "NO PERMISSION";
        }
    }
}