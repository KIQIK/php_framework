<?php

namespace app\core;

class View
{
public string $title = '';

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
        $content = $this->renderOnlyView($view, $params);
        $layout = $this->layoutContent();

        return str_replace('{{content}}', $content, $layout);
    }
}