<?php
/**
 * Created by PhpStorm.
 * User: maxim
 * Date: 1/5/22
 * Time: 3:21 PM
 */

namespace App\myPHPClasses;


use App\Repository\CustomerRepository;
use App\Repository\ProgrammerRepository;
use App\Repository\UserRepository;

class FormUserManager
{
    private $userRepository;
    private $customerRepository;
    private $programmerRepository;

    public function __construct(UserRepository $userRepository,
                                CustomerRepository $customerRepository,
                                ProgrammerRepository $programmerRepository)
    {
        $this->userRepository = $userRepository;
        $this->customerRepository = $customerRepository;
        $this->programmerRepository = $programmerRepository;
    }

    public function getAllNotCustomerUser()
    {
        $users = $this->userRepository->findBy(['customer_or_programmer' => ['customer', 'both']]);
        $customer = $this->customerRepository->findAll();
        $idList = [];
        $freeUsers = array();

        if (count($customer) > 0)
        {

            foreach ($customer as $entity)
            {
                array_push($idList, $entity->getUserId()->getId());
            }

            foreach ($users as $user)
            {
                $id = $user->getId();
                if (!in_array($id, $idList))
                {
                    array_push($freeUsers, $user);
                }
            }
        } else {
            $freeUsers = $users;
        }
        return $freeUsers;
    }

    public function getAllNotProgrammers()
    {
        $users = $this->userRepository->findBy(['customer_or_programmer' => ['programmer', 'both']]);
        $programmer = $this->programmerRepository->findAll();
        $idList = [];
        $freeUsers = array();
        if (count($programmer) > 0)
        {

            foreach ($programmer as $entity)
            {
                array_push($idList, $entity->getUser()->getId());
            }

            foreach ($users as $user)
            {
                $id = $user->getId();
                if (!in_array($id, $idList))
                {
                    array_push($freeUsers, $user);
                }
            }
        } else {
            $freeUsers = $users;
        }
        return $freeUsers;
    }

}