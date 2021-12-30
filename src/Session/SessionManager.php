<?php

namespace App\Session;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\Security;
use App\Entity\User;

class SessionManager {

    private const USER_SESSION_KEY = "user";


    private $security;

    private $userRepository;

    private $session;


    public function __construct(Security $security,
                                UserRepository $userRepository,
                                SessionInterface $session)
    {
        $this->security = $security;
        $this->userRepository = $userRepository;
        $this->session = $session;
    }

    public function getUser(): User {

        $userInterface = $this->security->getUser();

        $user = null;
        if (!$this->session->has(SessionManager::USER_SESSION_KEY)) {
            $user = $this->userRepository->findOneBy(["username" => $userInterface->getUserIdentifier()]);

            if (!$user) {
                throw new UserNotFoundException();
            }

            $this->session->set(SessionManager::USER_SESSION_KEY, $user);
        } else {
            $user = $this->session->get(SessionManager::USER_SESSION_KEY);
        }


        return $user;
    }

}