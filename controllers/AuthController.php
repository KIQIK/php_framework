<?php

namespace app\controllers;

use app\core\Request;
use app\models\RegisterModel;

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
        if($request->isPost()) {
            $registerModel = new RegisterModel();
            return 'Submitted data';
        }

        $this->setLayout('_auth');

        return $this->render('register');
    }
}