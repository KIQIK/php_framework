<?php

namespace app\core;

use app\core\exception\NotFoundException;

class Router
{
    protected array $routes = [];


    public Request $request;
    public Response $response;

    /**
     * @param Request $request
     */
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

    public function layoutContent()
    {
        $layout = Application::$app->layout;
        if(Application::$app->controller) {
            $layout = Application::$app->controller->layout;
        }

        ob_start();
        require_once Application::$ROOT_DIR."/views/layouts/$layout.php";
        return ob_get_clean();
    }

    public function renderOnlyView($view, $params)
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }

        ob_start();
        require_once Application::$ROOT_DIR."/views/$view.php";
        return ob_get_clean();
    }

    public function renderView($view, $params = [])
    {
        $layout = $this->layoutContent();
        $content = $this->renderOnlyView($view, $params);
        
        return str_replace('{{content}}', $content, $layout);
    }



    public function resolve()
    {
        $method = $this->request->method();
        $path = $this->request->getPath();

        $callback = $this->routes[$method][$path] ?? false;
        


        if($callback === false) {
            Application::$app->response->setStatusCode(404);;
            throw new NotFoundException();
        }
        if(is_string($callback)) {
            return $this->renderView($callback);
        }
        if(is_array($callback)) {
            $controller = new $callback[0]();
            Application::$app->controller =  $controller;
            $controller->action =  $callback[1];
            $callback[0] = $controller;

            foreach ($controller->getMiddlewares() as $middleware) {
                       $middleware->execute();
            }
        }
        
        return call_user_func($callback, $this->request, $this->response);
    }
}