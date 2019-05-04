<?php

require 'conf.inc.php';

function myAutoloader($class)
{
    //var_dump(substr($class, strpos($class,'\\') + 1  ));echo '<br>';

    $className = substr($class, strpos($class, '\\') + 1); //var_dump($className);echo '<br>';

    $classPath = 'core/'.$className.'.php'; //var_dump($classPath);echo '<br> 1';
    $classModel = 'models/'.$className.'.php'; // var_dump($classModel);echo '<br>2';
    $formRegister = 'Form/'.$className.'.php';
    $classManager = 'manager/'.$className.'.php';
    $classRepository = 'Repository/'.$className.'.php';
    $classAuthentication = 'Authentication/'.$className.'.php';

    if (file_exists($classPath)) {
        include $classPath;
    } elseif (file_exists($classModel)) {
        include $classModel;
    } elseif (file_exists($formRegister)) {
        include $formRegister;
    } elseif (file_exists($classManager)) {
        include $classManager;
    } elseif (file_exists($classRepository)) {
        include $classRepository;
    }elseif(file_exists($classAuthentication)){
        include $classAuthentication;
    }
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// La fonction myAutoloader est lancé sur la classe appelée n'est pas trouvée
spl_autoload_register('myAutoloader');

// Récupération des paramètres dans l'url - Routing
$slug = explode('?', $_SERVER['REQUEST_URI'])[0]; //var_dump($slug);echo '<br>';
$routes = \Core\Routing::getRoute($slug);
extract($routes);

$container = [];
$container['config'] = require 'config/global.php';
$container += require 'config/di.global.php';

// Vérifie l'existence du fichier et de la classe pour charger le controlleur
if (file_exists($cPath)) {
    include $cPath;
    if (class_exists('Controllers\\'.$c)) {
        //instancier dynamiquement le controller
        $cObject = $container['Controllers\\'.$c]($container);
        //vérifier que la méthode (l'action) existe
        if (method_exists($cObject, $a)) {
            //appel dynamique de la méthode
            $cObject->$a();
        } else {
            die('La methode '.$a." n'existe pas");
        }
    } else {
        die('La class controller controller'.$c." n'existe pas");
    }
} else {
    die('Le fichier controller '.$c." n'existe pas");
}
