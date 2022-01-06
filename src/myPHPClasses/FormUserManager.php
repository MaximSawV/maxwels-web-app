<?php
/**
 * Created by PhpStorm.
 * User: maxim
 * Date: 1/5/22
 * Time: 3:21 PM
 */

namespace App\myPHPClasses;


use App\Repository\CustomerRepository;
use App\Repository\ProfileOptionsRepository;
use App\Repository\ProgrammerRepository;
use App\Repository\SubscriberRepository;
use App\Repository\UserRepository;

class FormUserManager
{
    private $userRepository;
    private $customerRepository;
    private $programmerRepository;
    private $optionsRepository;
    private $subscriberRepository;

    public function __construct(UserRepository $userRepository,
                                CustomerRepository $customerRepository,
                                ProgrammerRepository $programmerRepository,
                                ProfileOptionsRepository $optionsRepository,
                                SubscriberRepository $subscriberRepository)
    {
        $this->userRepository = $userRepository;
        $this->customerRepository = $customerRepository;
        $this->programmerRepository = $programmerRepository;
        $this->optionsRepository = $optionsRepository;
        $this->subscriberRepository = $subscriberRepository;
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

    public function getAllNotProgrammer()
    {
        $users = $this->userRepository->findBy(['customer_or_programmer' => ['programmer', 'both']]);
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

    public function getAllUsersWithoutProfOptions()
    {
        $users = $this->userRepository->findAll();
        $profileOptions = $this->optionsRepository->findAll();
        $idList = [];
        $freeUsers = array();
        if (count($profileOptions) > 0)
        {

            foreach ($profileOptions as $entity)
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

    public function getAllUnsuscribedUsers()
    {
        $users = $this->userRepository->findAll();
        $subscribers = $this->subscriberRepository->findAll();
        $idList = [];
        $freeUsers = array();
        if (count($subscribers) > 0)
        {

            foreach ($subscribers as $entity)
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