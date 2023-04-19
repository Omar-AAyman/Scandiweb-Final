<?php


namespace app\core;

use app\core\Router;

class App
{
    public static string $ROOT_DIR;
    public Request $request;
    public Router $router;
    public Response $response;
    public Database $db;
    public static App $app;
    public Controller $controller;

    public function __construct($rootPath, array $config)
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request;
        $this->response = new Response;
        $this->router = new Router($this->request, $this->response);
        $this->db = new Database($config['db']);
    }

    public function run()
    {
        $data = $this->router->resolve();
        $this->response->output($data);
    }

    /**
     * Get the value of controller
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * Set the value of controller
     *
     * @return  self
     */
    public function setController($controller)
    {
        $this->controller = $controller;

        return $this;
    }
}
