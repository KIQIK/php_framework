<?php

namespace app\controllers;

use app\core\Application;
use app\core\Request;

class SiteController extends Controller {


    public function home()
    {
        $params = [
            'name' => 'The site owner'
        ];

        return $this->render('home', $params);
    }

    public function contact()
    {
        return $this->render('contact');
    }
    
    public function handelContact(Request $request)
    {
        $body = $request->getBody();
        return 'Handling form submitted';
    }

}
