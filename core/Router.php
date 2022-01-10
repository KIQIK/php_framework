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

    public function layoutContent()
    {
        ob_start();
        require_once Application::$ROOT_DIR."/../views/layouts/_main.php";
        return ob_get_clean();
    }

    public function renderOnlyView($name)
    {
        ob_start();
        require_once Application::$ROOT_DIR."/../views/$name.php";
        return ob_get_clean();
    }

    public function renderView($name)
    {
        $layout = $this->layoutContent();
        $view = $this->renderOnlyView($name);

        return str_replace('{{content}}', $view, $layout);
    }



    public function resolve()
    {
        $method = $this->request->method();
        $path = $this->request->getPath();

        $callback = $this->routes[$method][$path] ?? false;
        

        if($callback === false) {
            Application::$app->response->setStatusCode(404);;
            return 'Not found';
        }
        if(is_string($callback)) {
            return $this->renderView($callback);
        }

        return call_user_func($this->routes[$method][$path]);
    }
}