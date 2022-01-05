<?php
/**
 * Created by PhpStorm.
 * User: maxim
 * Date: 1/5/22
 * Time: 3:21 PM
 */

namespace App\myPHPClasses;


use App\Repository\CustomerRepository;
use App\Repository\UserRepository;

class MaxwelsCustomerManager
{
    private $userRepository;
    private $customerRepository;

    public function __construct(UserRepository $userRepository,
                                CustomerRepository $customerRepository)
    {
        $this->userRepository = $userRepository;
        $this->customerRepository = $customerRepository;
    }

    public function getAllNotCustomerUser()
    {
        $users = $this->userRepository->findBy(['customer_or_programmer' => 'customer']);
        $customer = $this->customerRepository->findAll();
        $idList = [];
        $freeUsers = array();

        foreach ($customer as $entity)
        {
            array_push($idList, $entity->getUserId());
        }

        foreach ($users as $user)
        {
            $id = $user->getId();
            if (!in_array($id, $idList))
            {
                array_push($freeUsers, $user->getId());
            }
        }

        return $freeUsers;
    }
}