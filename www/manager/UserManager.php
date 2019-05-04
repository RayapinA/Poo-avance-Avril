<?php

namespace Manager;

use Repository\UserRepository;
use Models\Users;
class UserManager
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function save(Users $user)
    {
        $this->userRepository->saveUser($user);
    }
}