<?php

namespace app\core;
use app\controllers\Controller;
use app\core\db\Database;
use app\core\db\DbModel;

class Application
{
    public string $userClass;
    public string $layout = '_main';

    public static string $ROOT_DIR;
    public static Application $app;

    public Router $router;
    public View $view;
    public Request $request;
    public Response $response;
    public Database $db;
    public Session $session;
    public ?Controller $controller = null;
    public ?UserModel $user;

    const EVENT_BEFORE_REQUEST = 'beforeRequest';
    const EVENT_AFTER_REQUEST = 'afterRequest';

    protected array $eventListeners = [];

    /**
     * @param Router $router
     */
    public function __construct($rootPath, array $config)
    {

        self::$ROOT_DIR = $rootPath;
        self::$app = $this;

        $this->userClass = $config['userClass'];

        $this->response = new Response();
        $this->request = new Request();
        $this->router = new Router($this->request, $this->response);
        $this->view = new View();
        $this->session = new Session();

        $this->db= new Database($config['db']);

        $primaryValue = $this->session->get('user');
        if ($primaryValue) {
            $primaryKey = $this->userClass::primaryKey();
            $this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
        } else {
            $this->user = null;
        }

    }

    public function onEvent($event, $callback)
    {
        $this->eventListeners[$event][] = $callback;
    }

    public function triggerEvent($event)
    {
        $callbacks = $this->eventListeners[$event];
        foreach ($callbacks as $callback) {
            call_user_func($callback);
        }
    }


    public function run()
    {
        $this->triggerEvent(Application::EVENT_BEFORE_REQUEST);
        try {
            echo $this->router->resolve();
        } catch(\Exception $e) {
            $this->response->setStatusCode($e->getCode());
            echo $this->view->renderView('_error', [
                'exception' => $e
            ]);
        }
    }

    public function setController(Controller $controller): void
    {
        $this->controller = $controller;
    }

    public function login(UserModel $user)
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);
        return true;
    }

    public function logout()
    {
        $this->user = null;
        $this->session->remove('user');
    }

    public static function isGuest()
    {
        return !self::$app->user;
    }
}