<?php

namespace App\controller;

use App\middleware\adminMiddleware;
use App\model\Authentication\AuthenticationCode;
use App\model\Authentication\PasswordReset;
use App\model\Blog\Blog;
use App\model\Blood\BloodPackets;
use App\model\BloodBankBranch\BloodBank;
use App\model\Campaigns\ApprovedCampaigns;
use App\model\Campaigns\Campaign;
use App\model\Donations\AcceptedDonations;
use App\model\Email\BaseEmail;
use App\model\Notification\HospitalNotification;
use App\model\Notification\ManagerNotification;
use App\model\Requests\BloodRequest;
use App\model\Requests\SponsorshipRequest;
use App\model\sponsor\CampaignsSponsor;
use App\model\users\Admin;
use App\model\users\Donor;
use App\model\users\Hospital;
use App\model\users\Manager;
use App\model\users\MedicalOfficer;
use App\model\users\Organization;
use App\model\users\Sponsor;
use App\model\users\User;
use App\model\Utils\Backup;
use App\model\Utils\Date;
use App\model\Utils\Notification;
use App\view\components\ResponsiveComponent\Alert\FlashMessage;
use Core\Application;
use Core\BaseMiddleware;
use Core\Email;
use Core\middleware\AuthenticationMiddleware;
use Core\Request;
use Core\Response;
use DateTime;
use DateTimeZone;
use PHPMailer\PHPMailer\Exception;
use PHPUnit\Util\Json;

class adminController extends \Core\Controller
{
    public function __construct()
    {
        $this->layout = 'admin';
        $this->registerMiddleware(new adminMiddleware(['login'],BaseMiddleware::ALLOWED_ROUTES));
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

    public function FindBank(Request $request,Response $response)
    {
        if ($request->isPost()){
            $BloodBank_ID=$request->getBody()['BloodBank_ID'];
            $BloodBank=BloodBank::findOne(['BloodBank_ID'=>$BloodBank_ID]);
            if ($BloodBank)
            {
                return json_encode(['status'=>true,'message'=>'Blood Bank Found','data'=>$BloodBank->toArray()]);
            }
            return json_encode(['status'=>false,'message'=>'Blood Bank Not Found']);
        }

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
        $data = [
            'donorsCount' => Donor::getCount(),
            'availableDonors' => Donor::getCount(false,['Donation_Availability'=>'AVAILABILITY_AVAILABLE']),
            'bloodBanksCount' => BloodBank::getCount(),
            'bloodPacketsCount' => BloodPackets::getCount(),
            'medicalOfficerCount' => MedicalOfficer::getCount(),
            'onGoingCampaigns' => Campaign::getCount(false,['Status'=>'CAMPAIGN_STATUS_APPROVED']),
//            'pendingBloodRequests' => count(BloodRequest::RetrieveAll(false,[],true,['Status'=>'REQUEST_STATUS_PENDING']))
            'pendingBloodRequests' => BloodRequest::getCount(),
            'totalUsers' => User::getCount(),

        ];
//        print_r( $data);
//        exit();
        return $this->render('Admin/adminBoard', $data);
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

        $SponsorshipTransactions=CampaignsSponsor::RetrieveAll(false,[],true,['Status'=>CampaignsSponsor::PAYMENT_STATUS_PAID]);
        if ($SponsorshipTransactions)
        {
            $SponsorshipTransactions = array_filter($SponsorshipTransactions, function ($transaction) {
                /** @var CampaignsSponsor $transaction */
                return $transaction->getSponsorshipRequest()->getTransferred() === SponsorshipRequest::TRANSFERRING_PENDING;
            });
        }
        $SponsorshipTransactions = array_merge(...array_fill(0, 100, $SponsorshipTransactions));
        return $this->render('Admin/manageTransactions',[
            'Transactions'=>$SponsorshipTransactions
        ]);
    }

    public function manageSetting()
    {
        $this->layout='none';
        $Blogs = Blog::RetrieveAll();
        $Backups = Backup::RetrieveAll();
        return $this->render('Admin/manageSetting',[
            'Blogs'=>$Blogs,
            'Backups'=>$Backups
        ]);
    }
    public function manageAlerts(Request $request, Response $response)
    {
        $this->layout='none';

        $Role=$request->getBody()['Role'] ?? 'Hospital';
        $notificationList = [];
        $data = [];
        $receiver = null;
        $receiverName = '';
        if ($Role == 'Manager'){
            $data['Headings'] = ['Title','Message','Receiver'];
            $notificationList = ManagerNotification::RetrieveAll();
        } else if ($Role == 'Hospital'){
            $data['Headings'] = ['Title','Message','Receiver'];
            $notificationList = HospitalNotification::RetrieveAll();
        }
        foreach ($notificationList as $notification){
//            $receiver = User::findOne(['$UID' => $notification->getTargetID()]);
            if ($Role == 'Hospital'){
                $receiverName = 'All Hospitals';
                $receiver = Hospital::findOne(['Hospital_ID' => $notification->getTargetID()]);
            }else if ($Role == 'Manager'){
                $receiverName = 'All Managers';
                $receiver = Manager::findOne(['Manager_ID' => $notification->getTargetID()]);
            }
            if ($receiver){
                $receiverName = $receiver->getFullName();
            }
            $data[] = [
                'NotificationTitle' => $notification->getNotificationTitle(),
                'NotificationMessage' => $notification->getNotificationMessage(),
                'Receiver' => $receiverName
            ];
        }

//        print_r($data);
//        exit();
        $this->layout='none';
        return $this->render('Admin/manageAlerts',['notifications'=>$data]);
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
        /** @var  $user User */
        $DateAndTime = date('Y-m-d H:i:s');
        if ($request->isPost()){
            $id=trim($request->getBody()['id']);
            if (empty($id)){
                return json_encode(['status'=>false,'message'=>'User Not Found']);
            }
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
                $user = match ($Role) {
                    'Donor' => Donor::Search(['City' => $Search, 'Donor_ID' => $Search, 'NIC' => $Search, 'First_Name' => $Search, 'Last_Name' => $Search, 'Email' => $Search, 'Contact_No' => $Search]),
                    'Organization' => Organization::Search(['Organization_ID' => $Search, 'Organization_Name' => $Search, 'Organization_Email' => $Search, 'Contact_No' => $Search, 'City' => $Search]),
                    'MedicalOfficer' => MedicalOfficer::Search(['Officer_ID' => $Search, 'First_Name' => $Search, 'Last_Name' => $Search, 'Contact_No' => $Search, 'City' => $Search, 'Email' => $Search, 'NIC' => $Search, 'Position' => $Search]),
                    'Hospital' => Hospital::Search(['Hospital_ID' => $Search, 'Hospital_Name' => $Search, 'Email' => $Search, 'City' => $Search, 'Contact_No' => $Search]),
                    'Sponsor' => Sponsor::Search(['Sponsor_ID' => $Search, 'Sponsor_Name' => $Search, 'Email' => $Search, 'City' => $Search]),
                    'Manager' => Manager::Search(['Manager_ID' => $Search, 'First_Name' => $Search, 'Last_Name' => $Search, 'City' => $Search, 'Contact_No' => $Search, 'Email' => $Search]),
                    default => User::Search(['UID' => $Search, 'Email' => $Search]),
                };
                $this->layout='none';
                return $this->render('Admin/searchUser',[
                    'users'=>$user
                ]);
            }else{
                $userRole = match ($Role) {
                    'Donor' => new Donor(),
                    'Organization' => new Organization(),
                    'MedicalOfficer' => new MedicalOfficer(),
                    'Hospital' => new Hospital(),
                    'Sponsor' => new Sponsor(),
                    'Manager' => new Manager(),
                    default => new User(),
                };
                $user = $userRole::Search(['Account_Status'=>$Account]);

                $this->layout='none';
                return $this->render('Admin/searchUser',[
                    'users'=>$user
                ]);
            }


        }
        Application::Redirect('/admin/dashboard');
    }

    public function editBank(Request $request, Response $response){
//        Application::Redirect('/admin/dashboard');
//        ('/admin/dashboard');
        if ($request->isPost()){
            $data = $request->getBody();
            $BBank = new BloodBank();
            $BBank->loadData($data);
            if ($BBank->validate(true) && $BBank->update($BBank->getBloodBankID())){
                $this->setFlashMessage('success','Bank updated successfully');
            }
            else{
                $this->setFlashMessage('error','An error occurred while updating');
            }
//            print_r($BBank->errors);
//            exit();
            //BloodBank::updateOne();
            Application::Redirect('/admin/dashboard');
        }
    }

    public function deleteBank(Request $request, Response $response){
        if ($request->isPost()){
            $data = $request->getBody();
            $BID = $data['BloodBank_ID'];
            if (BloodRequest::findOne(['Requested_By'=>$BID])){
                $this->setFlashMessage('error', 'Cannot remove Bank there are pending Blood Requests');
            }elseif (MedicalOfficer::findOne(['Branch_ID'=>$BID])){
                $this->setFlashMessage('error', 'Cannot remove Bank there are Officers assigned to this Bank.');
            }elseif (Manager::findOne(['BloodBank_ID'=>$BID])){
                $this->setFlashMessage('error', 'Cannot remove Bank there are Managers assigned to this Bank.');
            }elseif (Donor::findOne(['Nearest_Bank'=>$BID])){
                $this->setFlashMessage('error', 'Cannot remove bank this Blood Bank assigned to some Donors.');
            }elseif (Hospital::findOne(['Nearest_Blood_Bank'=>$BID])){
                $this->setFlashMessage('error', 'Cannot remove bank this Blood Bank assigned to some Hospitals');
            }elseif (Campaign::findOne(['Nearest_BloodBank'=>$BID])){
                $this->setFlashMessage('error','Cannot remove bank this Blood Bank assigned to some Campaigns');
            }else{
                $bloodBank = new BloodBank();

                if (
                    $bloodBank->deleteOne(['BloodBank_ID' => $BID])
                ){
                    $this->setFlashMessage('success','Bank Deleted');
                }else{
                    $this->setFlashMessage('error', 'Something Went Wrong');
                }
            }


//            error_log($bloodBank->errors[0]);
            Application::Redirect('/admin/dashboard');
        }
    }

    public function addNewBank(Request $request, Response $response){
        if ($request->isPost()){
            $data = $request->getBody();
        $newBank = new BloodBank;
        $newBank->loadData($data);
        $newBank->setBloodBankID('BNK'.rand());
        if($newBank->validate() && $newBank->save()){
//            Application::Redirect('/admin/dashboard');
            $this->setFlashMessage('success', 'Bank has been created');
        }else{
            $this->setFlashMessage('error', 'An error has occurred');
//            print_r($newBank->errors);
        }
        }
        Application::Redirect('/admin/dashboard');
    }

    public function searchBank(Request $request, Response $response): bool|string
    {
        if ($request->isPost()){
            $keyword = $request->getBody()['Search'];
            $results = BloodBank::Search(['BloodBank_ID' => $keyword,
                'BankName' => $keyword,
                'Address1' => $keyword,
                'Address2' => $keyword,
                'City' => $keyword,
                'Telephone_No' => $keyword]);
            $data = array();
            foreach($results as $bank){
                $data[] = [
                    'id' => $bank->getBloodBankID(),
                    'name' => $bank->getBankName(),
                    'address' => $bank->getAddress1() . ', ' . $bank->getAddress2(),
                    'city' => $bank->getCity(),
                    'telephone' => $bank->getTelephoneNo(),
                    'numberOfDoctors' => $bank->getNoOfDoctors(),
                    'numberOfNurses' => $bank->getNoOfNurses(),
                    'numberOfBeds' => $bank->getNoOfBeds(),
                    'numberOfStorages' => $bank->getNoOfStorages(),
                    'type' => $bank->getType()
                ];
            }
            return json_encode($data);
        }
        return false;
    }

    function addManager(Request $request, Response $response){
        $bank = $request->getBody();
        print_r($bank);
    }

    public function addManagerNotification(Request $request, Response $response){
        $success = false;
        $managerID = null;

        $notificationData = $request->getBody();
        if($request->isPost()){

        $notification = new ManagerNotification();
        if($notificationData['managerId']!=='allManagers'){
            $managerID = $notificationData['managerId'];
        }
        $notification->setNotificationID(ManagerNotification::generateID());
        $notification->setNotificationStatus(1);
        $notification->setNotificationType(1);
        $notification->setNotificationDate(date('Y-m-d H:i:s'));
        $notification->setNotificationTitle($notificationData['title']);
        $notification->setNotificationMessage($notificationData['message']);
        $notification->setTargetID($managerID);
        $notification->setValidUntil($notificationData['expiration-date']);
        $alert = new \App\view\components\ResponsiveComponent\Alert\FlashMessage();
        if ($notification->validate()){
            if ($notification->save()){
                echo $alert->SuccessAlert("Notification Added Successfully");
            }else{
//                print_r($notification)
                echo $alert->ErrorAlert("Error adding notification");
            }
        }else{
            echo $alert->ErrorAlert("Error adding notification");

        }
        }
        Application::Redirect('/admin/dashboard');
    }

    public function BackupDatabase(Request $request, Response $response): bool|string
    {
        if(Backup::backupDatabase()){
            return json_encode(['status'=>true,'message'=>'Database Backup Successfully']);
        }else{
            return json_encode(['status'=>false,'message'=>'Database Backup Failed']);

        }
    }

    public function DownloadBackup(Request $request, Response $response): bool|string
    {
        if($request->isPost()){
            $Name = $request->getBody()['Backup_Name'];
            /** @var Backup $Backup */
            $Backup = Backup::findOne(['Backup_Name'=>$Name]);
            if($Backup){
                $FilePath = '../Backups/' . $Name . '.sql';
                if(file_exists($FilePath)) {
                    $file_path = $FilePath;
                    $file_data = base64_encode(file_get_contents($file_path));
                    $file_name = basename($file_path);
                    $file_mime = mime_content_type($file_path);
                    header("Content-Type: application/json");
                    return json_encode(['status'=>true,'message'=>'Backup Found','data'=>[
                        'file_name'=>$file_name,
                        'file_data'=>$file_data,
                        'file_mime'=>$file_mime,
                    ]]);
                }else{
                    return json_encode(['status'=>false,'message'=>'Backup Not Found']);
                }
            }else{
                return json_encode(['status'=>false,'message'=>'Backup Not Found']);
            }

        }
    }


    public function getAllHospitals(Request $request, Response $response)
    {
        $hospitals = Hospital::RetrieveAll();
        $data = [];
        foreach($hospitals as $hospital){
            $data[]=[
                'HospitalID' => $hospital->getHospitalID(),
                'HospitalName' => $hospital->getHospitalName(),
            ];
        }

        return json_encode($data);
    }

    public function addHospitalsNotification(Request $request, Response $response){
        $data = $request->getBody();
//        print_r($data);
        if($request->isPost()){
            $notification = new HospitalNotification();
            $notification->setNotificationID(HospitalNotification::generateID('HN_'));
            $notification->setNotificationDate(date('Y-m-d H:i:s'));
            $notification->setNotificationMessage($data['message']);
            $notification->setNotificationTitle($data['title']);
            $notification->setNotificationType(1);
            $notification->setNotificationStatus(1);
            if($data['hospitalId'] != 'allHospitals'){
//            print_r($data['hospitalId']);
//            exit();
                $notification->setTargetID($data['hospitalId']);
            }
            $notification->setValidUntil($data['expiration-date']);

            if ($notification->validate()){
//                $notification->save();
                if($notification->save()){
                    $this->setFlashMessage('success','Notification Added Success');
                }else{
                    $this->setFlashMessage('error','Something went wrong Saving Notification');
                }
            }else{

                $this->setFlashMessage('error','Something went wrong');
            }

//            print_r($notification);
//            exit();
        }
        $response->redirect('/admin/dashboard');
    }






    public function managerRegister(Request $request, Response $response) {
        if($request->isPost()){
            $data = $request->getBody();
            $user = new User();
            $user->setRole('Manager');
            $Password = $data['password'];
            $hash = password_hash($Password, PASSWORD_DEFAULT);
            $user->loadData($request->getBody());
//            $user->setAccountStatus(User::SEC_LEVEL_NORMAL);
            $user->setPassword($hash);
            $user->generateUID();
            $user->setEmail($data['Email']);
            $manager = new Manager();
            $manager->loadData($data);
//            $manager->setProfileImage('noPath');
            $manager->setID($user->getUid());
            $manager->setBloodBankID($data['bank']);
            $manager->setJoinedDate(date('Y-m-d H:i:s'));
            $manager->setJoinedAt(date('Y-m-d H:i:s'));
            $manager->setStatus(5);

//            var_dump($user);

//            exit();
            if($user->validate()){
                if($user->save()){
                    if ($manager->validate()){
//                      error_log($manager->getCity() .' '. $manager->getID() .' '. $manager->getFirstName() .' '. $manager->getLastName().' '.$manager->getAddress1().' '.$manager->getAddress2().' '.$manager->getContactNo().' '.$manager->getEmail().' '.$manager->getStatus().' '.$manager->getBloodBankID().' '.$manager->getProfileImage());
                        if($manager->save()){
                            $this->setFlashMessage('success', 'Manager Successfully Added');
                        }
                    }else{
                        $this->setFlashMessage('error', 'Could not validate Manager');
                    }
                }
            }else{
                $this->setFlashMessage('error', 'Error Occurred');
            }
//            error_log(print_r($manager->errors, true));
//            $response->redirect('/');
//            print_r($request);
        }
        $response->redirect('/admin/dashboard');
    }



    function hospitalRegister(Request $request, Response $response){
        if($request->isPost()){
            $data = $request->getBody();
            $user = new User();
//            $user->setEmail($data['Email']);
            $user->setRole('Hospital');
            $user->loadData($data);
            $user->generateUID();
            $user->setPassword(password_hash($data['password'],PASSWORD_DEFAULT));

            $hospital = new Hospital();
            $hospital->loadData($data);
            $hospital->setID($user->getId());

            if($user->validate()){
                if ($user->save()){
                    if ($hospital->validate()){
//                        error_log('Please work now im frustrated');
                        if($hospital->save()){
                            $this->setFlashMessage('success', 'Hospital added successfully');
                        }
                    }else{
                        $this->setFlashMessage('error', 'Could not validate');
                    }
                    error_log(print_r($hospital->errors, true));
                }
            }else{
                $this->setFlashMessage('error', 'Cannot Validate User Account');
            }
        }
        $response->redirect('/admin/dashboard');
    }


}