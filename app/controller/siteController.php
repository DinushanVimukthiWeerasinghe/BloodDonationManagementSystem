<?php

namespace App\controller;


use Core\Application;
use Core\middleware\AuthenticationMiddleware;
use Core\Request;
use Core\Response;

class siteController extends \Core\Controller
{

    public function Loader()
    {
        return $this->render('Utils/Loader');
    }
    public function __construct()
    {
        $this->registerMiddleware( new AuthenticationMiddleware(['homes']));
    }

    public function home(): string
    {

        $params=[
            'name'=>['first'=>'Mohamed','last'=>'Ali'],
            'Author'=>'Dinushan Vimukthi',
        ];
        return $this->render('home',['params'=>$params]);
    }

    public function userRegister(Request $request, Response $response)
    {
        return $this->render('Authentication/UserRegister');
    }

    public function userLogin(Request $request, Response $response)
    {
        return $this->render('Authentication/UserLogin');
    }

    public function about(Request $request,Response $response)
    {
        if($request->isPost()){
            require_once Application::$ROOT_DIR.'/API/adduser.php';
        }
        return $this->render('about');
    }
    public function contact(Request $request,Response $response)
    {
        if($request->isPost()){
            require_once Application::$ROOT_DIR.'/API/adduser.php';
        }
        return $this->render('contact');
    }

    public function ManagerLogin()
    {
        
    }

    public function Test()
    {
        $this->layout='none';
        return $this->render('Email/PasswordReset');
    }

}