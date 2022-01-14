<?php

namespace app\controllers;

use app\core\Application;
use app\core\Request;
use app\models\User;

class AuthController extends  Controller
{
    public function login(Request $request)
    {
        if($request->isPost()) {
            return 'Submitted data';
        }

        return $this->render('login');
    }

    public function register(Request $request)
    {
        $user = new User();

        if($request->isPost()) {
            $user->loadData($request->getBody());

            if($user->validate() && $user->save()) {
                Application::$app->response->redirect('/');
            }
            

            return $this->render('register', [
                'model' => $user
            ]);
        }

        $this->setLayout('_auth');

        return $this->render('register', [
            'model' => $user
        ]);
    }
}