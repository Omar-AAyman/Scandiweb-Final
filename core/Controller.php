<?php


namespace app\Core;

use app\Core\App;

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
