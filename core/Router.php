<?php

namespace app\core;

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
        $layout = Application::$app->controller->layout;
        ob_start();
        require_once Application::$ROOT_DIR."/../views/layouts/$layout.php";
        return ob_get_clean();
    }

    public function renderOnlyView($view, $params)
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }

        ob_start();
        require_once Application::$ROOT_DIR."/../views/$view.php";
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
            return $this->renderView('_404');
        }
        if(is_string($callback)) {
            return $this->renderView($callback);
        }
        if(is_array($callback)) {
            Application::$app->controller= new $callback[0]();
            $callback[0] = Application::$app->controller;
        }
        
        return call_user_func($callback, $this->request);
    }
}