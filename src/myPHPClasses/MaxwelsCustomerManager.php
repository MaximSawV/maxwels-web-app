<?php
/**
 * Created by PhpStorm.
 * User: maxim
 * Date: 1/26/22
 * Time: 9:58 AM
 */

namespace App\myPHPClasses;


use App\Entity\Customer;
use App\Entity\User;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;

class MaxwelsCustomerManager
{
    private $customerRepository;
    private $entityManager;

    public function __construct(CustomerRepository $customerRepository,
                                EntityManagerInterface $entityManager)
    {
        $this->customerRepository = $customerRepository;
        $this->entityManager = $entityManager;
    }

    public function createCustomer(User $user)
    {
        $customer = new Customer();
        $customer->setUserId($user);
        $customer->setNumberOfRequests(0);

        $this->entityManager->persist($customer);
        $this->entityManager->flush();
    }

    public function deleteCustomer(Customer $customer)
    {
        $this->entityManager->remove($customer);
        $this->entityManager->flush();
    }
}