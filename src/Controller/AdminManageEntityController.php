<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\ProfileOptions;
use App\Entity\Programmer;
use App\Entity\Subscriber;
use App\Entity\User;
use App\Entity\UserRelationship;
use App\Form\AdminCreateCustomerType;
use App\Form\AdminCreateProfileOptionsType;
use App\Form\AdminCreateProgrammerType;
use App\Form\AdminCreateRelationshipType;
use App\Form\AdminCreateRequestType;
use App\Form\AdminCreateSubscriberType;
use App\Form\AdminCreateUserType;
use App\myPHPClasses\ProfileOptionManager;
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
