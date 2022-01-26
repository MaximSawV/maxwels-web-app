<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\ProfileOptions;
use App\Entity\Programmer;
use App\Entity\Subscriber;
use App\Entity\User;
use App\Entity\UserRelationship;
use App\Form\CreateCustomerType;
use App\Form\CreateProfileOptionsType;
use App\Form\CreateProgrammerType;
use App\Form\CreateRelationshipType;
use App\Form\CreateRequestType;
use App\Form\CreateSubscriberType;
use App\Form\CreateUserType;
use App\myPHPClasses\MaxwelsProfileOptionManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminManageEntityController extends AbstractController
{
    #[Route('/admin/ask/{function}/entity{entity}', name: 'admin_confirm_entity')]
    public function index(string $entity, string $function)
    {

    }
}
