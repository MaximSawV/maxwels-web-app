<?php
/**
 * Created by PhpStorm.
 * User: maxim
 * Date: 1/26/22
 * Time: 10:16 AM
 */

namespace App\Controller;


use App\Entity\Customer;
use App\myPHPClasses\MaxwelsCustomerManager;
use App\Repository\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiCustomerController extends AbstractController
{
    private $customerRepository;
    private $customerManager;

    public function __construct(CustomerRepository $customerRepository, MaxwelsCustomerManager $customerManager)
    {
        $this->customerRepository = $customerRepository;
        $this->customerManager = $customerManager;
    }

    public function deleteCustomer(Customer $customer)
    {
        if (!$customer)
        {
            $this->addFlash(
                'fail',
                'Entity not found'
            );
        } else {
            $this->customerManager->deleteCustomer($customer);
            $this->addFlash(
                'success',
                'Entity deleted'
            );
        }
        return $this->redirectToRoute('api_page');
    }
}