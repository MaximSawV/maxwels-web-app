<?php
/**
 * Created by PhpStorm.
 * User: maxim
 * Date: 1/26/22
 * Time: 10:38 AM
 */

namespace App\Controller;


use App\Form\CreateRequestType;
use App\myPHPClasses\MaxwelsRequestManager;
use App\Repository\RequestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ApiRequestController extends AbstractController
{
    private $requestRepository;

    private $requestManager;


    public function __construct(RequestRepository $requestRepository,
                                MaxwelsRequestManager $requestManager)
    {
        $this->requestRepository = $requestRepository;
        $this->requestManager = $requestManager;
    }

    public function createRequest(Request $request)
    {
        $requestEntity = new \App\Entity\Request();
        $form = $this->createForm(CreateRequestType::class, $requestEntity);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($requestEntity);
            $entityManager->flush();
            $this->addFlash(
                'success',
                'Entity created'
            );

            return $this->redirectToRoute('api_page');
        }

        return $this->renderForm('api/api_form.html.twig', [
            'form' => $form
        ]);
    }

    public function deleteRequest(\App\Entity\Request $request)
    {
        if(!$request)
        {
            $this->addFlash(
                'fail',
                'Entity not found'
            );
        } else {
            $this->requestManager->deleteRequest($request);
            $this->addFlash(
                'success',
                'Entity deleted'
            );
        }
        return $this->redirectToRoute('api_page');
    }

}