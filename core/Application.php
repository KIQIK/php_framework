<?php

namespace app\core;
use app\controllers\Controller;

class Application
{
    public static string $ROOT_DIR;
    public static Application $app;

    public Router $router;
    public Request $request;
    public Response $response;
    public Database $db;
    public Session $session;

    public Controller $controller;

    /**
     * @param Router $router
     */
    public function __construct($rootPath, array $config)
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;

        $this->response = new Response();
        $this->request = new Request();
        $this->router = new Router($this->request, $this->response);
        $this->session = new Session();

        $this->db= new Database($config['db']);
    }


    public function run()
    {
        echo $this->router->resolve();
    }

}