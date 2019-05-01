<?php

namespace Core;

class View
{
    private $v;
    private $t;
    private $data = [];

    public function __construct($v, $t = 'back')
    {
        $this->setView($v);
        $this->setTemplate($t);//var_dump($v);
    }

    public function setView(string $v):void
    {
        $viewPath = 'views/'.$v.'.view.php';
        if (file_exists($viewPath)) {
            $this->v = $viewPath;
        } else {
            die("Attention le fichier view n'existe pas ".$viewPath);
        }
    }

    public function setTemplate(string $t):void
    {
        $templatePath = 'views/templates/'.$t.'.tpl.php';
        if (file_exists($templatePath)) {
            $this->t = $templatePath;
        } else {
            die("Attention le fichier template n'existe pas ".$templatePath);
        }
    }

    public function addModal($modal, $config):void
    {
        $modalPath = 'views/modals/'.$modal.'.mod.php';

        if (!file_exists($modalPath)) {
            die("Attention le fichier modal n'existe pas ".$modalPath);
        }

        include $modalPath;
    }

    public function assign( $key,  $value)
    {
        //var_dump($key); echo'<br>';
        //var_dump($value);echo'<br>';
        $this->data[$key] = $value;
    }

    public function __destruct()
    {
        extract($this->data);
        include $this->t;
    }
}
