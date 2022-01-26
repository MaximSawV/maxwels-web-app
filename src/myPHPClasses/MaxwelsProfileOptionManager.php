<?php
/**
 * Created by PhpStorm.
 * User: maxim
 * Date: 1/5/22
 * Time: 10:25 AM
 */

namespace App\myPHPClasses;


use App\Entity\ProfileOptions;
use Doctrine\ORM\EntityManagerInterface;

class MaxwelsProfileOptionManager
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createProfileOptions($user)
    {
        $profileOptions = new ProfileOptions();
        $profileOptions->setUser($user);
        $profileOptions->setPublicContact(true);
        $profileOptions->setShowStatus(true);
        $profileOptions->setHidden(false);
        $profileOptions->setDarkmode(false);

        $this->entityManager->persist($profileOptions);

        return $profileOptions;
    }

    public function deleteProfileOptions(ProfileOptions $profileOptions)
    {
        $this->entityManager->remove($profileOptions);
        $this->entityManager->flush();
    }
}