<?php

namespace App\controller;

use App\model\Authentication\Login;
use App\model\users\Manager;
use App\model\users\User;
use Core\Application;
use Core\BaseMiddleware;
use Core\Controller;
use Core\middleware\AuthenticationMiddleware;
use Core\Request;
use Core\Response;

class authController extends Controller
{

    public function __construct()
    {
        if (Application::$app->getUser()) {

            $role = Application::$app->getUser()->getRole();
            Application::Redirect('/' . strtolower($role) . '/dashboard');

        }else{
            $this->registerMiddleware(new AuthenticationMiddleware(['UserLogin'], BaseMiddleware::ALLOWED_ROUTES));
        }

    }

    public function UserLogin(Request $request,Response $response )
    {
        $login = new Login();

        if ($request->isPost())
        {
            $login->loadData($request->getBody());
            if ($login->validate() && $login->login())
            {
                $response->redirect('/'.strtolower(Application::$app->getUser()->getRole()).'/dashboard');
            }else{
                print_r("Not Login");
            }
        }
        return $this->render('Authentication/UserLogin',['model'=>$login]);
    }



    public function logout()
    {
        if (Application::$app->isGuest())
        {
//            Application::$app->response->redirect('/');
                Application::$app->response->redirect('/login');
        }else{
            Application::$app->logout();
//            Application::$app->response->redirect('/');
            Application::$app->response->redirect('/login');
        }
    }

}