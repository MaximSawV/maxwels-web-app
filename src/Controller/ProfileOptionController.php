<?php

namespace App\Controller;

use App\Repository\ProfileOptionsRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class ProfileOptionController extends AbstractController
{
    #[Route('user/{user}/profile/option/', name: 'profile_option')]
    public function index(int $user, Security $security, ProfileOptionsRepository $optionsRepository, UserRepository $userRepository): Response
    {
        $profileOptions = $optionsRepository->findBy(['User' => $userRepository->find($user)]);
        $publicContact = $profileOptions[0]->getPublicContact();
        $showStatus = $profileOptions[0]->getShowStatus();
        $hidden = $profileOptions[0]->getHidden();
        $darkmode = $profileOptions[0]->getDarkmode();

        return $this->render('profile_option/index.html.twig', [
            'publicContact' => $publicContact,
            'showStatus' => $showStatus,
            'hidden' => $hidden,
            'darkmode' => $darkmode
        ]);
    }

    #[Route('user/{user}/profile/option/{optionid}/{option}/{bool}', name: 'change_option')]
    public function changeOption(ProfileOptionsRepository $optionsRepository, int $optionid, string $option, string $bool, EntityManagerInterface $entityManager, int $user): Response
    {
        $profileOption = $optionsRepository->find($optionid);

        if ($bool == "true")
        {
            $bool = true;
        } else {
            $bool = false;
        }


        if ($option == "ShowStatus")
        {
            $profileOption->setShowStatus($bool);
        }

        if ($option == "PublicContact")
        {
            $profileOption->setPublicContact($bool);
        }

        if ($option == "Hidden")
        {
            $profileOption->setHidden($bool);
        }

        if ($option == "Darkmode")
        {
            $profileOption->setDarkmode($bool);
        }

        $entityManager->persist($profileOption);
        $entityManager->flush();

        return $this->redirect('/user/'.$user.'/profile/option/');
    }
}
