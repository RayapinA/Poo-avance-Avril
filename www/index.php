<?php

require 'conf.inc.php';

use \Controllers\PagesController;

function myAutoloader($class)
{
    $className = substr($class, strpos($class,'\\') + 1  );
    $classPath = 'core/'.$className.'.class.php'; var_dump($classPath);
    $classModel = 'models/'.$className.'.class.php';var_dump($classModel);

    if (file_exists($classPath)) {
        include $classPath;
    } elseif (file_exists($classModel)) {
        include $classModel;
    }
}

// La fonction myAutoloader est lancé sur la classe appelée n'est pas trouvée
spl_autoload_register('myAutoloader');

// Récupération des paramètres dans l'url - Routing
$slug = explode('?', $_SERVER['REQUEST_URI'])[0];var_dump($slug);
$routes = \Core\Routing::getRoute($slug);
extract($routes);

$container = [] ;
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
