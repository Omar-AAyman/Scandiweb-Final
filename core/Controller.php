<?php


namespace app\core;

use app\core\App;

class Controller
{

    public string $layout = 'main';
    public function render($view, $params = [])
    {
        return App::$app->router->renderView($view, $params);
    }
   
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }
}
