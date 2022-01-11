<?php

namespace app\controllers;

use app\core\Request;

class AuthController
{
    public function login(Request $request)
    {
        if($request->isPost()) {
            return 'Submitted data';
        }

        $this->render('login');
    }

    public function register(Request $request)
    {
        if($request->isPost()) {
            return 'Submitted data';
        }

        $this->setLayout('auth');

        $this->render('register');
    }
}