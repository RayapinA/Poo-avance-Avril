<?php

namespace Core;

class View
{
    private $view;
    private $template;
    private $data = [];

    public function __construct(string $view, string $template = 'back')
    {
        $this->setView($view);
        $this->setTemplate($template);
    }

    public function setView(string $view):void
    {
        $viewPath = 'views/'.$view.'.view.php';

        if (!file_exists($viewPath)) {
            die("Attention le fichier view n'existe pas ".$viewPath);
        }
        $this->view = $viewPath;
    }

    public function setTemplate(string $template):void
    {
        $templatePath = 'views/templates/'.$template.'.tpl.php';

        if (!file_exists($templatePath)) {
            die("Attention le fichier template n'existe pas ".$templatePath);
        }
        $this->template = $templatePath;
    }

    public function addModal(string $modal, array $config):void
    {
        $modalPath = 'views/modals/'.$modal.'.mod.php';

        if (!file_exists($modalPath)) {
            die("Attention le fichier modal n'existe pas ".$modalPath);
        }

        include $modalPath;
    }

    public function assign( string $key,  $value)
    {
        $this->data[$key] = $value;
    }

    public function __destruct()
    {
        extract($this->data);
        include $this->template;
    }
}
