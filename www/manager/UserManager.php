<?php

declare(strict_types=1);

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

    public function save(Users $user): void
    {
        $this->userRepository->saveUser($user);
    }
}
