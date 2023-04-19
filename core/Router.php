<?php


namespace app\core;

class Router
{
    public Request $request;
    public Response $response;
    protected array $routes = [];


    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }



    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }



    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }


    public function resolve()
    {

        $path = $this->request->getPath();
        $method = $this->request->method();

        $callback = $this->routes[$method][$path] ?? false;
        if ($callback === false) {
            App::$app->controller = new Controller;
            $this->response->setStatusCode(404);
            return $this->renderView("layouts/errors/_404");
            exit;
        }
        if (is_string($callback)) {
            return $this->renderView($callback);
        }
        if (is_array($callback)) {
            App::$app->controller = new $callback[0]();
            $callback[0] = App::$app->controller;
        }
        return call_user_func($callback,  $this->request);
    }



    public function layoutContent()
    {
        $layout = App::$app->controller->layout;
        ob_start();
        include_once App::$ROOT_DIR . "/views/layouts/{$layout}.php";
        return ob_get_clean();
    }

    public function renderView($view, $params = [])
    {   
        $layoutContent = $this->newTitle($view, $this->layoutContent());
        $viewContent = $this->renderFooter($this->newTitle($view, $this->renderOnlyView($view, $params)));
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    public function renderOnlyView($view, $params)
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        ob_start();
        include_once App::$ROOT_DIR . "/views/{$view}.php";
        return ob_get_clean();
    }


    public function renderContent($viewContent)
    {
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    public function prepareTitle($viewName)
    {
        $position = strpos($viewName, '-');

        if ($position === false) {
            return ucwords($viewName);
        }

        return ucwords(str_replace('-', ' ', $viewName));
    }

    public function newTitle($viewName, $viewContent)
    {
        $newTitle = $this->prepareTitle($viewName);
        return str_replace('{{title}}', $newTitle, $viewContent);
    }
    public function footerContent()
    {
        ob_start();
        include_once App::$ROOT_DIR . "/views/layouts/footer.php";
        return ob_get_clean();    }

    public function renderFooter($viewContent)
    {
        $footerContent = $this->footerContent();
        return str_replace('{{footer}}', $footerContent, $viewContent);
    }
}
