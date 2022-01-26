<?php
/**
 * Created by PhpStorm.
 * User: maxim
 * Date: 1/26/22
 * Time: 11:11 AM
 */

namespace App\Controller;


use App\Entity\ProfileOptions;
use App\Form\CreateProfileOptionsType;
use App\myPHPClasses\MaxwelsProfileOptionManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ApiProfileOptionsController extends AbstractController
{
    private  $profileOptionManager;

    public function __construct(MaxwelsProfileOptionManager $profileOptionManager)
    {
        $this->profileOptionManager = $profileOptionManager;

    }

    public function createProfileOptions(Request $request)
    {
        $pOptions = new ProfileOptions();
        $form = $this->createForm(CreateProfileOptionsType::class, $pOptions);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pOptions);
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

    public function deleteProfileOptions(ProfileOptions $profileOptions)
    {
        if (!$profileOptions)
        {
            $this->addFlash(
                'fail',
                'Entity not found'
            );
        } else {
            $this->profileOptionManager->deleteProfileOptions($profileOptions);
            $this->addFlash(
                'success',
                'Entity deleted'
            );
        }

        return $this->redirectToRoute('api_page');
    }
}