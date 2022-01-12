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
        $registerModel = new RegisterModel();

        if($request->isPost()) {
            $registerModel->loadData($request->getBody());

            if($registerModel->validate() && $registerModel->register()) {
                return 'Success';
            }

            return $this->render('register', [
                'model' => $registerModel
            ]);
        }

        $this->setLayout('_auth');

        return $this->render('register');
    }
}