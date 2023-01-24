<?php

namespace App\controller;

use App\model\Authentication\AuthenticationCode;
use App\model\BloodBankBranch\BloodBank;
use App\model\users\Admin;
use App\model\users\Manager;
use App\model\users\User;
use Core\BaseMiddleware;
use Core\middleware\AuthenticationMiddleware;
use Core\Request;
use Core\Response;

class adminController extends \Core\Controller
{
    public function __construct()
    {
        $this->layout = 'admin';
//        $this->registerMiddleware(new AuthenticationMiddleware(['login'],BaseMiddleware::ALLOWED_ROUTES));
    }
    public function login(Request $request, Response $response): string
    {
        $this->layout='auth';
        return $this->render('Admin\login');
    }

    public function register(Request $request, Response $response): string
    {
        if ($request->isPost())
        {
            $admin=new Admin();
            $admin->loadData($request->getBody());
        }
        $this->layout='auth';
        return $this->render('Admin\register');
    }

    public function ResetPassword(Request $request,Response $response)
    {

    }

    public function adminBoard(Request $request, Response $response): string
    {
        $layout=$request->getBody()['layout'] ?? 'admin';
//        $re=AuthenticationCode::Verify('321763','user_01');
        $this->layout=$layout;
        return $this->render('Admin/adminBoard');
    }

    public function manageUsers(Request $request, Response $response): string
    {
        $users=User::getUserInfo();
        $this->layout='none';
        return $this->render('Admin/manageUsers',[
            'users'=>$users
        ]);
    }function manageDonors()
    {
        $this->layout='none';
        return $this->render('Admin/manageDonors');
    }
    public function manageTransactions()
    {
        $this->layout='none';
        return $this->render('Admin/manageTransactions');
    }

    public function manageSetting()
    {
        $this->layout='none';
        return $this->render('Admin/manageSetting');
    }
    public function manageAlerts()
    {
        $this->layout='none';
        return $this->render('Admin/manageAlerts');
    }

    public function manageBanks()
    {
        $this->layout='none';
        $BloodBanks=BloodBank::RetrieveAll();
        return $this->render('Admin/manageBank',[
            'BloodBanks'=>$BloodBanks
        ]);
    }

}