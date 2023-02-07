<?php

namespace App\controller;

use App\model\Authentication\AuthenticationCode;
use App\model\Authentication\PasswordReset;
use App\model\BloodBankBranch\BloodBank;
use App\model\Email\BaseEmail;
use App\model\users\Admin;
use App\model\users\Manager;
use App\model\users\User;
use Core\Application;
use Core\BaseMiddleware;
use Core\Email;
use Core\middleware\AuthenticationMiddleware;
use Core\Request;
use Core\Response;
use PHPMailer\PHPMailer\Exception;

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

    public function ResetPassword(Request $request, Response $response): bool|string
    {
        $id=trim($request->getBody()['id']);
        $user=User::findOne(['UID'=>$id]);
        if (!$user)
        {
            return json_encode(['status'=>false,'message'=>'User Not Found']);
        }
        $AlreadySent=PasswordReset::findOne(['UID'=>$id]);
        if ($AlreadySent)
        {
            return json_encode(['status'=>false,'message'=>'Password Reset Already Sent']);
        }
        $PasswordReset=new PasswordReset();
        $PasswordReset->setUID($id);
        $PasswordReset->setName($user->getFullName());
        $PasswordReset->setEmail($user->getEmail());
        $PasswordReset->setDeviceIP($request->getDeviceIP());
        try {
            $PasswordReset->GenerateToken();
//        print_r($PasswordReset);
            $PasswordReset->SendPasswordResetEmail(Email::PASSWORD_RESET);
            $PasswordReset->save();
            return json_encode(['status'=>true,'message'=>'Password Reset Successfully ']);
        }catch (Exception|\Exception $e)
        {
            return json_encode(['status'=>false,'message'=>$e->getMessage()]);
        }

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
        $Role=$request->getBody()['Role'] ?? 'Donor';
        $users=User::getUserInfo($Role);
//        print_r($users);
//        Deactivated Users
        $TemporaryDeactivatedUsers=array_filter($users,function ($user){
            /** @var User $user */
            return $user->getAccountStatus()==User::TEMPORARY_DEACTIVATED;
        });
        $BannedUsers=array_filter($users,function ($user){
            /** @var User $user */
            return $user->getAccountStatus()==User::PERMANENTLY_DEACTIVATED;
        });
        $ActiveUsers=array_filter($users,function ($user){
            /** @var User $user */
            return $user->getAccountStatus()==User::ACTIVE;
        });
//        Get length of array
        $length=count($users);
        $this->layout='none';
        return $this->render('Admin/manageUsers',[
            'users'=>$users,
            'TotalUsers'=>$length,
            'TotalActive'=>$length,
            'TotalDeactivated'=>count($TemporaryDeactivatedUsers),
            'TotalBanned'=>count($BannedUsers),
            'Role'=>$Role
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

    public function RemoveUser(Request $request, Response $response): bool|string
    {
        $id=trim($request->getBody()['id']);
        $user=User::findOne(['UID'=>$id]);
        if (!$user)
        {
            return json_encode(['status'=>false,'message'=>'User Not Found']);
        }
        $Role=$user->getRole();
        $user->setAccountStatus(User::PERMANENTLY_DEACTIVATED);
        $user->update($id);
        return json_encode(['status'=>true,'message'=>'User Removed Successfully','role'=>$Role]);
    }

    public function ReactivateUser(Request $request, Response $response): bool|string
    {
        if ($request->isPost()){
            $id=trim($request->getBody()['id']);
            $user=User::findOne(['UID'=>$id]);
            $Role=$user->getRole();
            if (!$user)
            {
                return json_encode(['status'=>false,'message'=>'User Not Found']);
            }
            if ($user->getAccountStatus()===User::ACTIVE)
            {
                return json_encode(['status'=>false,'message'=>'User Already Active']);
            }
            $user->setAccountStatus(User::ACTIVE);
            $user->update($id);
            return json_encode(['status'=>true,'message'=>'User Reactivated Successfully','role'=>$Role]);
        }
        Application::Redirect('/admin/dashboard');

    }

    public function DeactivateUser(Request $request, Response $response): bool|string
    {
        if ($request->isPost()) {
            $id = trim($request->getBody()['id']);
            $user = User::findOne(['UID' => $id]);
            $Role = $user->getRole();
            if (!$user) {
                return json_encode(['status' => false, 'message' => 'User Not Found']);
            }
            if ($user->getAccountStatus()===User::TEMPORARY_DEACTIVATED)
            {
                return json_encode(['status'=>false,'message'=>'User Already Deactivated']);
            }
            if ($user->getAccountStatus()===User::PERMANENTLY_DEACTIVATED)
            {
                return json_encode(['status'=>false,'message'=>'User Already Removed']);
            }
            $user->setAccountStatus(User::TEMPORARY_DEACTIVATED);
            $user->update($id);
            return json_encode(['status' => true, 'message' => 'User Deactivated Successfully', 'role' => $Role]);
        }
        Application::Redirect('/admin/dashboard');
    }

    public function ActivateUser(Request $request, Response $response): bool|string
    {
        if ($request->isPost()) {
            $id = trim($request->getBody()['id']);
            $user = User::findOne(['UID' => $id]);
            $Role = $user->getRole();
            if (!$user) {
                return json_encode(['status' => false, 'message' => 'User Not Found']);
            }
            if ($user->getAccountStatus()===User::ACTIVE)
            {
                return json_encode(['status'=>false,'message'=>'User Already Active']);
            }
            $user->setAccountStatus(User::ACTIVE);
            $user->update($id);
            return json_encode(['status' => true, 'message' => 'User Activated Successfully', 'role' => $Role]);
        }
        Application::Redirect('/admin/dashboard');
    }

    public function SearchUser(Request $request, Response $response): bool|string
    {
        if ($request->isPost() || $request->isGet()) {
            $Search = trim($request->getBody()['Search']);
            $Role=trim($request->getBody()['Role']);
            $Account= match (strtolower($Search)){
                'active'=>User::ACTIVE,
                'deactivated','inactive'=>User::TEMPORARY_DEACTIVATED,
                'removed', 'disabled', 'deleted' =>User::PERMANENTLY_DEACTIVATED,
                default=>5
            };
            if ($Account===5)
            {
                $user = User::Search(['UID' => $Search,'Email'=>$Search]);
                $FilterUser=array_filter($user,function ($user) use ($Role){
                    /** @var User $user */
                    return $user->getRole()===$Role;
                });

                $this->layout='none';
                return $this->render('Admin/searchUser',[
                    'users'=>$FilterUser
                ]);
            }else{
                $user = User::Search(['UID' => $Search,'Email'=>$Search],['Account_Status'=>$Account]);
                $FilterUser=array_filter($user,function ($user) use ($Role){
                    /** @var User $user */
                    return $user->getRole()===$Role;
                });

                $this->layout='none';
                return $this->render('Admin/searchUser',[
                    'users'=>$FilterUser
                ]);
            }


        }
        Application::Redirect('/admin/dashboard');
    }

}