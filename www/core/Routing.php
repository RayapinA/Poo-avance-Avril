<?php

declare(strict_types=1);

namespace Core;

class Routing
{
    public static $routeFile = 'routes.yml';

    public static function getRoute(string $slug): array
    {
        //Don't use else Keyword && One level indentation

        $routes = yaml_parse_file(self::$routeFile);

        if (!isset($routes[$slug])) {
            return ['controller' => '', 'action' => '', 'controllerPath' => ''];
        }

        if (empty($routes[$slug]['controller']) || empty($routes[$slug]['action'])) {
            die('Il y a une erreur dans le fichier routes.yml');
        }

        $controller = ucfirst($routes[$slug]['controller']).'Controller';
        $action = $routes[$slug]['action'].'Action';
        $controllerPath = 'controllers/'.$controller.'.php';

        return ['controller' => $controller, 'action' => $action, 'controllerPath' => $controllerPath];
    }

    public static function getSlug(string $controller, string $action): string
    {
        $routes = yaml_parse_file(self::$routeFile);

        foreach ($routes as $slug => $data) {
            if (!empty($data['controller']) &&
                !empty($data['action']) &&
                $data['controller'] == $controller &&
                $data['action'] == $action) {
                return $slug;
            }
        }

        return 'null';
    }
}
