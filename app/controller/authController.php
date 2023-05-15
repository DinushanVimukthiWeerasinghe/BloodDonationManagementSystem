<?php

namespace App\controller;

use App\model\Authentication\Login;
use App\model\Authentication\OrganizationBankAccount;
use App\model\Authentication\OTPCode;
use App\model\Authentication\PasswordReset;
use App\model\Email\RegisterOTP;
use App\model\OrganizationMembers\Organization_Members;
use App\model\users\Donor;
use App\model\users\Hospital;
use App\model\users\Manager;
use App\model\users\Organization;
use App\model\users\User;
use App\model\Utils\Security;
use Core\Application;
use Core\Controller;
use Core\File;
use Core\Request;
use Core\Response;
use PHPMailer\PHPMailer\Exception;
use PhpParser\Node\Expr\New_;

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
                header('Content-Type: application/json');
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

    public function OrganizationRegister(Request $request,Response $response): string
    {
        if ($request->isPost()){
            $OrganizationID = $request->getBody()['OrganizationID'];
            $OrganizationID=openssl_decrypt($OrganizationID,ENCRYPTION_METHOD,ENCRYPTION_KEY,0,ENCRYPTION_IV);
//            exit();
            if ($OrganizationID===false){
                $this->setFlashMessage('error','Invalid Data');
                Application::Redirect('/register');
                exit();
            }
            if (empty($OrganizationID)){
                $this->setFlashMessage('error','Organization ID is required');
                return json_encode(['status'=>false,'message'=>'Organization ID is required']);
//                Application::Redirect('/register');
//                exit();
            }
            $Organization = new Organization();
            $Organization->setID($OrganizationID);
            $Organization->loadData($request->getBody());
            $Organization->setOrganizationName($request->getBody()['OrganizationName']);
            $Organization->setEmail($request->getBody()['OrganizationEmail']);
            $Organization->setOrganizationEmail($request->getBody()['OrganizationEmail']);
            $Organization->setContactNo($request->getBody()['OrganizationPhone']);
            $Organization->setAddress1($request->getBody()['OrganizationAddress1']);
            $Organization->setAddress2($request->getBody()['OrganizationAddress2']);
            $Organization->setCity($request->getBody()['OrganizationAddress3']);
            $Organization->setStatus(1);
            $Organization->setProfileImage(Organization::getDefaultProfilePicture());
            $Organization->validate();

            //Register President
            $PresidentNIC = $request->getBody()['PresidentNIC'];
            $PresidentName = $request->getBody()['PresidentName'];
            $PresidentEmail = $request->getBody()['PresidentEmail'];
            $PresidentPhone = $request->getBody()['PresidentPhone'];
            $President=Organization_Members::CreateMember($OrganizationID,$PresidentNIC,"President",$PresidentPhone,$PresidentEmail,$PresidentName);

            //Register Secretary
            $SecretaryNIC = $request->getBody()['SecretaryNIC'];
            $SecretaryName = $request->getBody()['SecretaryName'];
            $SecretaryEmail = $request->getBody()['SecretaryEmail'];
            $SecretaryPhone = $request->getBody()['SecretaryPhone'];
            $Secretary=Organization_Members::CreateMember($OrganizationID,$SecretaryNIC,"Secretary",$SecretaryPhone,$SecretaryEmail,$SecretaryName);

            //Register Treasurer
            $TreasurerNIC = $request->getBody()['TreasurerNIC'];
            $TreasurerName = $request->getBody()['TreasurerName'];
            $TreasurerEmail = $request->getBody()['TreasurerEmail'];
            $TreasurerPhone = $request->getBody()['TreasurerPhone'];
            $Treasurer=Organization_Members::CreateMember($OrganizationID,$TreasurerNIC,"Treasurer",$TreasurerPhone,$TreasurerEmail,$TreasurerName);

            //Check whether Bank Account Details are provided
            $BankName = $request->getBody()['BankName'];
            $BankBranch = $request->getBody()['BankBranch'];
            $BankAccountNo = $request->getBody()['BankAccountNumber'];
            $BankAccountName = $request->getBody()['BankAccountName'];
            $BankAccount = null;
            if (!empty($BankName) && !empty($BankBranch) && !empty($BankAccountNo) && !empty($BankAccountName)){
                $BankAccount = new OrganizationBankAccount();
                $BankAccount->setOrganizationID($OrganizationID);
                $BankAccount->setBankName($BankName);
                $BankAccount->setBranchName($BankBranch);
                $BankAccount->setAccountNumber($BankAccountNo);
                $BankAccount->setAccountName($BankAccountName);
            }

            if ($Organization->validate()){
                /** @var $User User*/
                $User= User::findOne(['UID'=>$OrganizationID]);
                $User->setAccountStatus(User::ACTIVE);
                $User->update($User->getID(),[],['Account_Status']);
                $Organization->save();
                $BankAccount?->save();
                $President->save();
                $Secretary->save();
                $Treasurer->save();
                return json_encode(['status'=>true,'message'=>'User Registered Successfully','redirect'=>'/login']);
            }else{
                return json_encode(['status'=>false,'message'=>'Invalid Data','errors'=>$Organization->getErrors()]);
            }
        }
        else{

            $OrganizationID = $request->getBody()['uid'];
            $OrganizationID=openssl_decrypt($OrganizationID,ENCRYPTION_METHOD,ENCRYPTION_KEY,0,ENCRYPTION_IV);


            if (!$OrganizationID){
                $this->setFlashMessage('error','Invalid Data');
                Application::Redirect('/register');
                exit();
            }


            $User = User::findOne(['UID'=>$OrganizationID]);

            if (!$User){
                Application::Redirect('/register');
            }else{
                $Organization = Organization::findOne(['Organization_ID'=>$User->getID()]);

                if ($Organization){
                    $this->setFlashMessage('error','Organization Already Registered');
                    Application::Redirect('/login');
                }

                if ($User->getRole() != User::ORGANIZATION){
                    $this->setFlashMessage('error','Invalid User Role');
                    Application::Redirect('/login');
                }

                if ($User->getAccountStatus() !== User::ACCOUNT_NOT_VERIFIED){
                    var_dump($Organization);
                    exit();
                    $this->setFlashMessage('error','User Already Registered');
                    Application::Redirect('/login');
                }
            }
            return $this->render('Authentication/Registration/OrganizationRegistration',[
                'uid'=>$OrganizationID,
                'email'=>$User->getEmail(),
            ]);
        }

    }

    public function DonorRegister(Request $request,Response $response)
    {

        if ($request->isPost()){


            $UID = $request->getBody()['uid'];
            $UID=Security::Decrypt($UID);
            /** @var User $User */
            $User = User::findOne(['UID'=>$UID]);
            $Donor = new Donor();
            $Donor->setEmail($User->getEmail());
            $Donor->setDonorID($User->getID());
            $Donor->loadData($request->getBody());

            /** @var File $Image */
            $Image = $request->getBody()['ProfileImage'];
            if ($Image->getFileName()!==""){
                $Image->setPath(Donor::DEFAULT_PROFILE_IMAGE_LOCATION);
                $Image->setFileName(uniqid("Dnr_").'.'.$Image->getExtension());
                $Donor->setProfileImage($Image->getFileName());
            }

            $Donor->generateGenderByNIC();
            $Donor->setStatus(0);
            $Donor->setCreatedAt(date('Y-m-d H:i:s'));
            $Donor->setUpdatedAt(date('Y-m-d'));
            if ($Donor->validate()){
                if ($Image->getFileName()!==""){
                    $Image->saveFile();
                }

                $User->setAccountStatus(User::ACTIVE);
                $Donor->save();

                $User->update($User->getID(),[],['Account_Status']);
                $this->setFlashMessage('success','User Registered Successfully');
                Application::Redirect('/login');
            }else{
                var_dump($Donor->getErrors());
                exit();
                $this->setFlashMessage('error','Invalid Data');
                Application::Redirect('/register');
            }
        }
        else{
            $UID = $request->getBody()['uid'];
            $UID=Security::Decrypt($UID);

            if ($UID===false){
                $this->setFlashMessage('error','Invalid Data');
                Application::Redirect('/register');
                exit();
            }
            $User = User::findOne(['UID'=>$UID]);
            if (!$User) {
                Application::Redirect('/register');
                exit();
            }
            if ($User->getRole() != User::DONOR){
                $this->setFlashMessage('error','Invalid User Role');
                Application::Redirect('/login');
                exit();
            }
            if ($User->getAccountStatus() !== User::ACCOUNT_NOT_VERIFIED){
                $this->setFlashMessage('error','User Already Registered');
                Application::Redirect('/login');
                exit();
            }
            $Donor = Donor::findOne(['Donor_ID'=>$User->getID()]);
            if ($Donor){
                $this->setFlashMessage('error','Donor Already Registered');
                Application::Redirect('/login');
                exit();
            }

            $this->layout = 'auth';
            return $this->render('Authentication/Registration/DonorRegistration',[
                'uid'=>Security::Encrypt($UID),
                'email'=>$User->getEmail(),
            ]);
        }

    }

    public function UserRegister(Request $request,Response $response)
    {

        $user = new User();
        if ($request->isPost()){
            $Role = $request->getBody()['Role'];


            if (trim($Role) == '' || !$user->IsValidRole($Role)) {
                $this->setFlashMessage('error', 'Please Select Role');
                return json_encode(['status'=>false,'message'=>'Please Select Role']);
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
                // For Development Purpose

                if (MODE!==DEVELOPMENT) {
                    // Password must be 8 characters long
                    if (strlen($Password) < 8) {
                        $this->setFlashMessage('error', 'Password must be 8 characters long');
                        return json_encode(['status' => false, 'message' => 'Password must be 8 characters long']);
                    } // Password must contain at least one uppercase letter
                    else if (!preg_match('/[A-Z]/', $Password)) {
                        $this->setFlashMessage('error', 'Password must contain at least one uppercase letter');
                        return json_encode(['status' => false, 'message' => 'Password must contain at least one uppercase letter']);
                    } // Password must contain at least one number
                    else if (!preg_match('/\d/', $Password)) {
                        $this->setFlashMessage('error', 'Password must contain at least one number');
                        return json_encode(['status' => false, 'message' => 'Password must contain at least one number']);
                    } // Password must contain at least one special character
                    else if (!preg_match('/[^a-zA-Z\d]/', $Password)) {
                        $this->setFlashMessage('error', 'Password must contain at least one special character');
                        return json_encode(['status' => false, 'message' => 'Password must contain at least one special character']);
                    }

                }
                if ($Password != $ConfirmPassword){

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
                        $UserID = $user->getID();
                        $EncryptedUserID = openssl_encrypt($UserID,ENCRYPTION_METHOD,ENCRYPTION_KEY,0,ENCRYPTION_IV);

                        $this->setFlashMessage('success', 'Please Complete Your Registration');
                        if ($user->getRole() == User::ORGANIZATION)
                            return json_encode(['status'=>true,'message'=>'User Registered Successfully','redirect'=>'/organization/register?uid='.urlencode($EncryptedUserID)]);
                        else if ($user->getRole() == User::SPONSOR)
                            return json_encode(['status'=>true,'message'=>'User Registered Successfully','redirect'=>'/sponsor/register?uid='.urlencode($EncryptedUserID)]);
                        else
                            return json_encode(['status'=>true,'message'=>'User Registered Successfully','redirect'=>'/donor/register?uid='.urlencode($EncryptedUserID)]);

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
     */
    public function SendRegistrationOTP(Request $request, Response $response)
    {
        if ($request->isPost()){
            $Email = $request->getBody()['Email'];
            $ApplicationEmail = Application::$app->email;
            $User = User::findOne(['Email'=>$Email]);
            if ($User){
                return json_encode(['status'=>false,'message'=>'Email Already Registered']);
            }
            /** @var RegisterOTP $RegisterOTP */
            $RegisterOTP = RegisterOTP::findOne(['Email'=>$Email]);
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
                $Reset = PasswordReset::findOne(['Token'=>$token,'Status'=>PasswordReset::STATUS_ACTIVE],false);
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
                $user->update($user->getID(),[],['Password']);
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
                Application::$app->session->setFlash('error','Please Login for Logout.');
                Application::$app->response->redirect('/login');
        }else{
            Application::$app->logout();
//            Application::$app->response->redirect('/');
            Application::$app->session->setFlash('success','You have Successfully Logged Out.');
            Application::$app->response->redirect('/login');
        }
    }

}