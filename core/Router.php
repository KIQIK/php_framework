<?php

namespace app\core;

class Router
{
    protected array $routes = [];

    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function method()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);

    }

    public function getPath()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');
        if ($position === false) {
            return $path;
        }
        return substr($path, 0, $position);
    }

    public function resolve()
    {
        $method = $this->method();
        $path = $this->getPath();

        $callback = $this->routes[$method][$path] ?? false;
        

        if($callback === false) {
            return 'Not found';
        }
        if(is_string($callback)) {
            return $callback;
        }

        return call_user_func($this->routes[$method][$path]);
    }
}