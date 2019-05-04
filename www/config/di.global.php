<?php

use Controllers\PagesController;
use Controllers\UsersController;
use Manager\UserManager;
use Repository\UserRepository;
use Core\DataBaseConnection;
use Authentication\UserAuthentication;

return [
    UsersController::class => function ($container) {
        $userManager = $container[UserManager::class]($container);
        $userAuthentication = $container[UserAuthentication::class]($container);

        return new UsersController($userManager,$userAuthentication);
    },
    PagesController::class => function ($container) {
        return new controllers\PagesController();
    },
    UserManager::class => function ($container) {
        $userRepository = $container[UserRepository::class]($container);

        return new UserManager($userRepository);
    },
    UserRepository::class => function ($container) {
        $databaseConnection = $container[DataBaseConnection::class]($container);

        return new UserRepository($databaseConnection);
    },
    DataBaseConnection::class => function ($container) {
        $host = $container['config']['database']['host'];
        $driver = $container['config']['database']['driver'];
        $name = $container['config']['database']['name'];
        $user = $container['config']['database']['user'];
        $password = $container['config']['database']['password'];

        return new DataBaseConnection($driver, $host, $name, $user, $password);
    },
    UserAuthentication::class => function ($container){
        $databaseConnection = $container[DataBaseConnection::class]($container);

        return new UserAuthentication($databaseConnection);
    }
];
