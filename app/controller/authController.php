<?php

namespace App\controller;

use App\model\Authentication\Login;
use App\model\Authentication\OTPCode;
use App\model\Authentication\PasswordReset;
use App\model\users\User;
use Core\Application;
use Core\Controller;
use Core\Request;
use Core\Response;

class authController extends Controller
{

    public function __construct()
    {
        if (Application::$app->getUser()) {

            $role = Application::$app->getUser()->getRole();
            Application::Redirect('/' . strtolower($role) . '/dashboard');

        } else {
//            $this->registerMiddleware(new AuthenticationMiddleware(['UserLogin'], BaseMiddleware::ALLOWED_ROUTES));
        }
    }

    public function OTP(Request $request, Response $response)
    {
        $response->redirect('/' . strtolower(Application::$app->getUser()->getRole()) . '/dashboard');
    }

    public function OTPValidation(Request $request, Response $response): bool|string
    {
        /** @var OTPCode $OTP */
        $Regenerate = $request->getBody()['regenerate'] ?? false;
        $OTPSession = Application::$app->session->get('OTP');
        if ($OTPSession) {
            $OTP = $OTPSession->getSessionData();
        }
//        if ($Regenerate){
//            $ID = $OTP->getUserID();
//            $OTP->DeleteOne(['UserID'=>$ID]);
//            $OTP = new OTPCode();
//            $OTP->setUserID($ID);
//            $OTP->setType(0);
//            $OTP->GenerateCode('stdinushan@gmail.com');
//            $OTP->setUpdatedAt(date('Y-m-d H:i:s'));
//            $OTP->sendCode();
//            $OTP->save();
//            return json_encode(['status'=>true,'message'=>'OTP Regenerated']);
//        }
        if ($Regenerate) {
            $ID = $OTP->getUserID();
            $OTP->DeleteOne(['UserID' => $ID]);
            $OTP = new OTPCode();
            $OTP->setUserID($ID);
            $OTP->setType(0);
            $OTP->GenerateCode('stdinushan@gmail.com');
            $OTP->sendCode();
            $OTP->update($ID, ['Verified_At']);
            return json_encode(['status' => true, 'message' => 'OTP Regenerated']);
        }


        $OTPCode = $request->getBody()['otp'];
        if ($OTP->getCode() != $OTPCode) {
            $OTP->setAttempts($OTP->getAttempts() + 1);
            $OTP->update($OTP->getUserID(), ['Verified_At']);
            if ($OTP->IsExpired()) {
                return json_encode(['status' => false, 'message' => 'OTP Expired']);
            } elseif ($OTP->IsExceedAttempts()) {
                return json_encode(['status' => false, 'message' => 'OTP Exceed Attempts']);
            } else {
                return json_encode(['status' => false, 'message' => 'OTP Validation Failed']);
            }

        } else {
            $OTP->setStatus(OTPCode::STATUS_VERIFIED);
            $OTP->setVerifiedAt(date('Y-m-d H:i:s'));
            $OTP->setAttempts($OTP->getAttempts() + 1);
            $OTP->update($OTP->getUserID());
//            $OTP->DeleteOne(['UserID'=>$OTP->getUserID()]);
            $userLogin = Application::$app->session->get('User')->getSessionData();
            Application::$app->login($userLogin);
//            Application::$app->session->remove('OTP');
            return json_encode(['status' => true, 'message' => 'OTP Validation Success', 'redirect' => '/' . strtolower(Application::$app->getUser()->getRole()) . '/dashboard']);
        }
    }

    public function UserLogin(Request $request, Response $response): string
    {
        $login = new Login();

        if ($request->isPost()) {
            $login->loadData($request->getBody());
            if ($login->validate()) {
                if(!$login->SecurityCheck()){
                    $this->setFlashMessage('error',$login->errors['account'][0]);
                    return $this->render('Authentication/UserLogin',['model'=>$login]);
                }
                $user = $login->ValidateOTP();
                if (!$user) {
                    print_r("Not Login");
                }
                return $this->render('Authentication/OTPAuthentication');

            } else {
                print_r("Not Login");
            }
        }
        return $this->render('Authentication/UserLogin',['model'=>$login]);
    }

    public function UserRegister(Request $request,Response $response)
    {
        $user = new User();
        if ($request->isPost()){
            $Role = $request->getBody()['role'];
            if (trim($Role) == '' || !$user->IsValidRole($Role)) {
                $this->setFlashMessage('error', 'Please Select Role');
            }
            else {
                $user->setRole(match ($Role) {
                    'Donor' => User::DONOR,
                    'Organization' => User::ORGANIZATION,
                    'Sponsor' => User::SPONSOR
                });
                $user->loadData($request->getBody());
                if ($user->validate()) {
                    $user->setPassword(password_hash($user->getPassword(), PASSWORD_DEFAULT));
                    $user->save();
                    $this->setFlashMessage('success', 'User Registered Successfully');
                    Application::$app->response->redirect('/auth/login');
                }
            }
        }
        else{
            $Role= $request->getBody()['type'] ?? 'Donor';
            $ValidRole= match ($Role) {
                'Organization' => User::ORGANIZATION,
                'Sponsor' => User::SPONSOR,
                default => User::DONOR
            };
            return $this->render('Authentication/UserRegister',[
                'model'=>$user,
                'role'=>$ValidRole
            ]);
        }


    }


    public function ResetPassword(Request $request,Response $response)
    {
        $errors = [];
        if ($request->isPost()){
            $password = $request->getBody()['password'];
            $confirmPassword = $request->getBody()['confirmPassword'];
            $token = $request->getBody()['token'];
            if (trim($password) == '')
                $errors['error'] = 'Password is required';
            else if (trim($confirmPassword) == '')
                $errors['error'] = 'Confirm Password is required';
//            Need at least 8 characters
//            else if (strlen($password) < 8)
//                $errors['error'] = 'Password must be at least 8 characters';
//            else if (strlen($password) > 20)
//                $errors['error'] = 'Password must be less than 20 characters';
//            else if (!preg_match("#[0-9]+#", $password))
//                $errors['error'] = 'Password must include at least one number!';
//            else if (!preg_match("#[a-zA-Z]+#", $password))
//                $errors['error'] = 'Password must include at least one letter!';
//            else if (strlen($confirmPassword) < 8)
//                $errors['error'] = 'Confirm Password must be at least 8 characters';
//            else if (strlen($confirmPassword) > 20)
//                $errors['error'] = 'Confirm Password must be less than 20 characters';
//            else if(trim($password) != trim($confirmPassword))
//                $errors['error'] = 'Password and Confirm Password not match';
            else if ($password == $confirmPassword){
                $Reset = PasswordReset::findOne(['Token'=>$token],false);
                if (!$Reset){
                    Application::Redirect('/login');
                }
                $user = Login::findOne(['UID'=>$Reset->getUID()],false);
                $hash = password_hash($password,PASSWORD_DEFAULT);
                $user->setPassword($hash);
                $user->update(['UID'=>$user->getID()]);
                $Reset->DeleteOne(['Token'=>$token]);
                Application::$app->session->setFlash('success','Password Changed Successfully');
                Application::Redirect('/login');
            }else{
                $errors['error'] = 'Password and Confirm Password not match';
            }
            $this->layout = 'NonAuth';
            return $this->render('Authentication/ChangePassword',['errors'=>$errors]);
        }else{
            $token = $request->getBody()['token'];
            $userResetRequest=PasswordReset::findOne(['Token'=>$token],false);
            if (!$userResetRequest){
                Application::Redirect('/login');
            }else{
                $this->layout = 'NonAuth';
                return $this->render('Authentication/ChangePassword',['errors'=>$errors,'token'=>$token]);
            }
        }


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