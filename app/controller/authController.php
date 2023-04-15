<?php

namespace App\controller;

use App\model\Authentication\Login;
use App\model\Authentication\OTPCode;
use App\model\Authentication\PasswordReset;
use App\model\Email\RegisterOTP;
use App\model\users\User;
use Core\Application;
use Core\Controller;
use Core\Request;
use Core\Response;
use PHPMailer\PHPMailer\Exception;

class authController extends Controller
{

    public function __construct()
    {
        $this->setLayout('auth');
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

    public function ValidateOTP(Request $request,Response $response)
    {
        if ($request->isPost()){
            $Email = $request->getBody()['Email'];
            $OTP = $request->getBody()['OTP'];
            if (trim($Email) == '' || trim($OTP) == ''){
                return json_encode(['status'=>false,'message'=>'Please fill the OTP']);
            }
            $OTP = RegisterOTP::findOne(['Email'=>$Email,'OTP'=>$OTP],false);
            if ($OTP){
                return json_encode(['status'=>true,'message'=>'OTP Verified']);
            }else{
                return json_encode(['status'=>false,'message'=>'Invalid OTP']);
            }
        }
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
//            echo "<pre>";
            $login->loadData($request->getBody());
            if ($login->validate()) {
                $user = $login->login();

//                var_dump($user);
//                exit();
                if (!$user) {
                    $this->setFlashMessage('error', 'Invalid Credentials');
                    Application::Redirect('/login');
                    exit();
                }
                if ($user === true){
                    Application::Redirect('/' . strtolower(Application::$app->getUser()->getRole()) . '/dashboard');
                }
//                return $this->render('Authentication/OTPAuthentication');

            } else {
                $this->setFlashMessage('error', 'Invalid Credentials');
                Application::Redirect('/login');
                exit();
            }
        }
        return $this->render('Authentication/UserLogin',['model'=>$login]);
    }

    public function UserRegister(Request $request,Response $response)
    {
        $user = new User();
        if ($request->isPost()){
            $Role = $request->getBody()['Role'];

            if (trim($Role) == '' || !$user->IsValidRole($Role)) {
                $this->setFlashMessage('error', 'Please Select Role');
            }
            else {
                $user->setRole(match ($Role) {
                    'Donor' => User::DONOR,
                    'Organization' => User::ORGANIZATION,
                    'Sponsor' => User::SPONSOR,
                });
                $user->generateUID();
                $Password=trim($request->getBody()['Password']);
                $ConfirmPassword=trim($request->getBody()['ConfirmPassword']);
                // Password must be 8 characters long
                if (strlen($Password) < 8) {
                    $this->setFlashMessage('error', 'Password must be 8 characters long');
                    return json_encode(['status'=>false,'message'=>'Password must be 8 characters long']);
                }
                // Password must contain at least one uppercase letter
                else if (!preg_match('/[A-Z]/', $Password)) {
                    $this->setFlashMessage('error', 'Password must contain at least one uppercase letter');
                    return json_encode(['status'=>false,'message'=>'Password must contain at least one uppercase letter']);
                }
                // Password must contain at least one number
                else if (!preg_match('/\d/', $Password)) {
                    $this->setFlashMessage('error', 'Password must contain at least one number');
                    return json_encode(['status'=>false,'message'=>'Password must contain at least one number']);
                }
                // Password must contain at least one special character
                else if (!preg_match('/[^a-zA-Z\d]/', $Password)) {
                    $this->setFlashMessage('error', 'Password must contain at least one special character');
                    return json_encode(['status'=>false,'message'=>'Password must contain at least one special character']);
                }
                else if ($Password != $ConfirmPassword){
                    $this->setFlashMessage('error', 'Password and Confirm Password Not Match');
                    return json_encode(['status'=>false,'message'=>'Password and Confirm Password Not Match']);
                }
                else {
                    $hash = password_hash($Password, PASSWORD_DEFAULT);
                    $user->loadData($request->getBody());
                    $user->setAccountStatus(User::ACCOUNT_NOT_VERIFIED);
                    $user->setPassword($hash);
                    if ($user->validate()) {
                        $user->save();
                        $this->setFlashMessage('success', 'User Registered Successfully');
                        return json_encode(['status'=>true,'message'=>'User Registered Successfully']);
                    }else{
                        $this->setFlashMessage('error', 'User Registration Failed');
                        return json_encode(['status'=>false,'message'=>'User Registration Failed']);
                    }
                }

            }
        }
        else{
            $Role= $request->getBody()['role'] ?? 'Donor';

            $ValidRole= match (strtolower($Role)) {
                'organization' => strtolower(User::ORGANIZATION),
                'sponsor' => strtolower(User::SPONSOR),
                default => strtolower(User::DONOR)
            };
            $ValidRole = ucfirst($ValidRole);
            return $this->render('Authentication/UserRegister',[
                'model'=>$user,
                'role'=>$ValidRole
            ]);
        }


    }

    /**
     * @throws Exception
     */
    public function SendRegistrationOTP(Request $request, Response $response)
    {
        if ($request->isPost()){
            $Email = $request->getBody()['Email'];
            $ApplicationEmail = Application::$app->email;
            /** @var RegisterOTP $RegisterOTP */

            if(!$RegisterOTP){
                $RegisterOTP = new RegisterOTP();
            }
            try {
                $RegisterOTP->SendOTP($Email);
                return json_encode(['status' => true, 'message' => 'OTP Sent Successfully']);
            }catch (Exception $e){
                return json_encode(['status' => false, 'message' => $e->getMessage()]);
            }

        }

    }

    public function ChangePassword(Request $request,Response $response): string
    {
        if ($request->isPost()){
            $CurrentPassword = $request->getBody()['CurrentPassword'];
            $NewPassword = $request->getBody()['NewPassword'];
            $ConfirmPassword = $request->getBody()['ConfirmPassword'];
            if (empty($CurrentPassword) || empty($NewPassword) || empty($ConfirmPassword)){
                if (empty($CurrentPassword)){
                    return json_encode([
                        'status'=>false,
                        'message'=>'Current Password is required!',
                        'field'=>'CurrentPassword'
                    ]);
                }
                if (empty($NewPassword)){
                    return json_encode([
                        'status'=>false,
                        'message'=>'New Password is required!',
                        'field'=>'NewPassword'
                    ]);
                }
                if (empty($ConfirmPassword)){
                    return json_encode([
                        'status'=>false,
                        'message'=>'Confirm Password is required!',
                        'field'=>'ConfirmPassword'
                    ]);
                }
            }
            if (strlen($NewPassword)<8){
                return json_encode([
                    'status'=>false,
                    'message'=>'Password must be at least 8 characters long!',
                    'field'=>'NewPassword'
                ]);
            }

//            if (preg_match('/[A-Z]/', $NewPassword)===0){
//                return json_encode([
//                    'status'=>false,
//                    'message'=>'Password must contain at least one uppercase letter!'
//                ]);
//            }
//
//            if (preg_match('/[a-z]/', $NewPassword)===0){
//                return json_encode([
//                    'status'=>false,
//                    'message'=>'Password must contain at least one lowercase letter!'
//                ]);
//            }
//
//            if (preg_match('/[0-9]/', $NewPassword)===0){
//                return json_encode([
//                    'status'=>false,
//                    'message'=>'Password must contain at least one number!'
//                ]);
//            }
//
//            if (preg_match('/[^a-zA-Z\d]/', $NewPassword)===0){
//                return json_encode([
//                    'status'=>false,
//                    'message'=>'Password must contain at least one special character!'
//                ]);
//            }
//
//            if (preg_match('/\s/', $NewPassword)===1){
//                return json_encode([
//                    'status'=>false,
//                    'message'=>'Password must not contain any whitespace!'
//                ]);
//            }

            if ($ConfirmPassword!==$NewPassword){
                return json_encode([
                    'status'=>false,
                    'message'=>'New Password and Confirm Password does not match!',
                    'field'=>'ConfirmPassword'
                ]);
            }

            if ($CurrentPassword===$NewPassword){
                return json_encode([
                    'status'=>false,
                    'message'=>'New Password and Current Password cannot be same!',
                    'field'=>'NewPassword'
                ]);
            }


            $User = User::findOne(['UID'=>Application::$app->getUser()->getId()]);
            if (password_verify($CurrentPassword,$User->getPassword())){
                if ($NewPassword===$ConfirmPassword){
                    $User->setPassword(password_hash($NewPassword,PASSWORD_DEFAULT));
                    if ($User->update($User->getID(),[],['Password'])){
                        return json_encode([
                            'status'=>true,
                            'message'=>'Password Changed Successfully!'
                        ]);
                    }else{
                        return json_encode([
                            'status'=>false,
                            'message'=>'Password Not Changed!'
                        ]);
                    }
                }else{
                    return json_encode([
                        'status'=>false,
                        'message'=>'New Password and Confirm Password does not match!'
                    ]);
                }
            }else{
                return json_encode([
                    'status'=>false,
                    'message'=>'Current Password is incorrect!'
                ]);
            }
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
                /* @var PasswordReset $Reset*/
                $Reset = PasswordReset::findOne(['Token'=>$token],false);
                if (!$Reset){
                    Application::Redirect('/login');
                }
                if ($Reset->IsExpired()){
                    Application::$app->session->setFlash('error','Token Expired! Please Reset Password Again');
                    Application::Redirect('/login');
                }
                if (!$Reset->IsTokenValid()){
                    Application::$app->session->setFlash('error','Password Already Reset! Please Login');
                    Application::Redirect('/login');
                }
                $user = Login::findOne(['UID'=>$Reset->getUID()],false);
                $hash = password_hash($password,PASSWORD_DEFAULT);
                $user->setPassword($hash);
                $Reset->setResetPasswordAt(date('Y-m-d H:i:s'));
                $Reset->setStatus(PasswordReset::STATUS_RESET);
                $Reset->update($Reset->getUID(),[],['Reset_At','Status']);
                Application::$app->session->setFlash('success','Password Changed Successfully');
                Application::Redirect('/login');
            }else{
                $errors['error'] = 'Password and Confirm Password not match';
            }
            $this->layout = 'NonAuth';
            return $this->render('Authentication/ChangePassword',['errors'=>$errors]);
        }else{
            $token = $request->getBody()['token'];
            /* @var $userResetRequest PasswordReset*/
            $userResetRequest=PasswordReset::findOne(['Token'=>$token],false);
            if (!$userResetRequest){
                Application::Redirect('/login');
            }else{
                $this->layout = 'NonAuth';
                if ($userResetRequest->IsExpired()){
                    Application::$app->session->setFlash('error','Token Expired! Please Reset Password Again');
                    Application::Redirect('/login');
                }
                if (!$userResetRequest->IsTokenValid()){
                    Application::$app->session->setFlash('error','Password Already Reset! Please Login');
                    Application::Redirect('/login');
                }
                return $this->render('Authentication/ChangePassword',['errors'=>$errors,'token'=>$token]);
            }
        }


    }

    /**
     * @throws \Exception
     */
    public function ForgotPassword(Request $request, Response $response)
    {
        if ($request->isPost()){
            $email = $request->getBody()['email'];
            $user = Login::findOne(['Email'=>$email],false);
            $IsAlreadySent = PasswordReset::findOne(['Email'=>$email],false);
            if ($IsAlreadySent){
                if ($IsAlreadySent->IsExpired()){
                    $IsAlreadySent->DeleteOne(['Email'=>$email]);
                }else{
                    return json_encode(['status'=>false,'message'=>'Password Reset Link Already Sent to your Email']);
                }
            }
            if (!$user){
                return json_encode(['status'=>false,'message'=>'Email not found']);
            }else{
                $Reset = new PasswordReset();
                $Reset->setUID($user->getID());
                $Reset->GenerateToken();
                $Reset->setCreatedAt(date('Y-m-d H:i:s'));
                $Reset->setLifetime(60);
                $Reset->setDeviceIP(Application::$app->request->getIP());
                $users=User::findOne(['UID'=>$user->getID()],false);
                $Reset->setEmail($users->getEmail());
                $Reset->setName($users->getFullName());
                if ($Reset->validate()){
                    $Reset->SendPasswordResetEmail();
                    $Reset->save();
                }
                else{
                    print_r($Reset->getErrors());
                }

                return json_encode(['status'=>true,'message'=>'Password Reset Link Sent to your Email']);

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