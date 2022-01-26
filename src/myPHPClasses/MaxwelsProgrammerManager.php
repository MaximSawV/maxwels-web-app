<?php
/**
 * Created by PhpStorm.
 * User: maxim
 * Date: 1/26/22
 * Time: 9:52 AM
 */

namespace App\myPHPClasses;


use App\Entity\Programmer;
use App\Entity\User;
use App\Repository\ProgrammerRepository;
use Doctrine\ORM\EntityManagerInterface;

class MaxwelsProgrammerManager
{
    private $programmerRepository;

    private $entityManager;

    public function __construct(ProgrammerRepository $programmerRepository, EntityManagerInterface $entityManager)
    {
        $this->programmerRepository = $programmerRepository;
        $this->entityManager = $entityManager;
    }

    public function createProgrammer(User $user)
    {
        $programmer = new Programmer();
        $programmer->setUser($user);
        $programmer->setDoneRequests(0);
        $programmer->setRating('0');

        $this->entityManager->persist($programmer);
        $this->entityManager->flush();
    }

    public function deleteProgrammer(Programmer $programmer)
    {
        $this->entityManager->remove($programmer);
        $this->entityManager->flush();
    }
}