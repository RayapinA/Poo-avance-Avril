<?php

declare(strict_types=1);

use Core\Routing;

function myAutoloader($class): void
{
    $className = substr($class, strpos($class, '\\') + 1);

    $arrayOfClass = array(
        'core/'.$className.'.php',
        'models/'.$className.'.php',
        'Form/'.$className.'.php',
        'manager/'.$className.'.php',
        'Repository/'.$className.'.php',
        'Authentication/'.$className.'.php',
        'ValueObject/'.$className.'.php',
    );
    foreach ($arrayOfClass as $classPath) {
        if (file_exists($classPath)) {
            include $classPath;
        }
    }
}

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

//The fonction myAutoloader is running on the class called not found
spl_autoload_register('myAutoloader');

//Getting the parameters in the url - Routing
$urlForRouting = explode('?', $_SERVER['REQUEST_URI']);
$slug = $urlForRouting[0];

$routes = Routing::getRoute($slug);
$controllerPath = $routes['controllerPath'];
$controller = $routes['controller'];
$action = $routes['action'];

$container = [];
$container['config'] = require 'config/global.php';
$container += require 'config/di.global.php';

//Check the existence of the file and the class to load the controller
if (file_exists($controllerPath)) {
    include $controllerPath;
    if (class_exists('Controllers\\'.$controller)) {
        //instantiate dynamically the controller
        $controllerObject = $container['Controllers\\'.$controller]($container);
        if (method_exists($controllerObject, $action)) {
            //Call dynamically method
            $controllerObject->$action();
        } else {
            die('La methode '.$action." n'existe pas");
        }
    } else {
        die('La class controller controller '.$controller." n'existe pas");
    }
} else {
    die('Le fichier controller '.$controllerPath." n'existe pas");
}
