<?php
/**
 * Created by PhpStorm.
 * User: maxim
 * Date: 1/26/22
 * Time: 10:16 AM
 */

namespace App\Controller;


use App\Entity\Programmer;
use App\myPHPClasses\MaxwelsProgrammerManager;
use App\Repository\ProgrammerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiProgrammerController extends AbstractController
{
    private $programmerRepository;
    private $programmerManager;

    public function __construct(ProgrammerRepository $programmerRepository, MaxwelsProgrammerManager $programmerManager)
    {
        $this->programmerRepository = $programmerRepository;
        $this->programmerManager = $programmerManager;
    }

    public function deleteProgrammer(Programmer $programmer)
    {
        if(!$programmer)
        {
            $this->addFlash(
                'fail',
                'Entity not found'
            );
        } else {
            $this->programmerManager->deleteProgrammer($programmer);
            $this->addFlash(
                'success',
                'Entity deleted'
            );
        }
        return $this->redirectToRoute('api_page');
    }
}