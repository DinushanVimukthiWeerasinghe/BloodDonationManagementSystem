<?php

namespace App\controller;

use App\middleware\organizationMiddleware;
use App\model\Authentication\Login;
use App\model\Authentication\OrganizationBankAccount;
use App\model\BloodBankBranch\BloodBank;
use App\model\database\dbModel;
use App\model\Email\Email;
use App\model\inform\informDonors;
use App\model\Notification\DonorNotification;
use App\model\Notification\OrganizationNotification;
use App\model\Requests\additional_sponsorship_request;
use App\model\Requests\AttendanceAcceptedRequest;
use App\model\Requests\SponsorshipRequest;
use App\model\sponsor\CampaignsSponsor;
use App\model\users\organization;
use App\model\Campaigns\Campaign;
use App\model\users\Sponsor;
use App\model\users\User;
use App\model\Utils\Notification;
use App\model\Utils\Security;
use Core\Application;
use Core\BaseMiddleware;
use Core\Controller;
use Core\File;
use Core\middleware\AuthenticationMiddleware;
use Core\middleware\ManagerMiddleware;
use Core\Request;
use Core\Response;
use Core\SessionObject;
use MongoDB\BSON\UTCDateTime;
use PHPMailer\PHPMailer\Exception;

class OrganizationController extends Controller
{

    public function __construct()
    {
        $this->setLayout('Organization');
        $this->registerMiddleware(new organizationMiddleware());
//        $this->registerMiddleware(new AuthenticationMiddleware(['login','register'], BaseMiddleware::ALLOWED_ROUTES));
//        $this->registerMiddleware(new ManagerMiddleware());
    }

    public function profile()
    {
        $user=Application::$app->getUser();
        return $this->render('organization/profile',['user'=>$user]);
    }



    public function register(Request $request,Response $response ): string
    {
        $organization=new Organization();
        if ($request->isPost())
        {
            $user = new User();
            $organization->loadData($request->getBody());
            $organization->getFile()->saveFile();
            $user->loadData($request->getBody());
            $organization->loadData($request->getBody());
            $id =mt_rand(1000,10000);
            $organization->setID($id);
            $user ->setID($id);

            if($user->validate() && $user->save()) {
                if ($organization->validate() && $organization->save()) {
                    $response->redirect('/login');
                } else {
                    print_r($organization->errors);
                }
            }else{
                print_r($user->errors);
            }
        }
        return $this->render('organization\register', ['model' => $organization]);
    }

    public function dashboard(): string
    {
        /* @var Organization $organization*/

        $organization = Organization::findOne(['Organization_ID' => Application::$app->getUser()->getID()]);
        $ID=Application::$app->getUser()->getID();
        $AlreadyCreatedCampaigns=Campaign::RetrieveAll(false,[],true,['Organization_ID'=>$ID,'Status'=> Campaign::CAMPAIGN_STATUS_PENDING]);
        $AlreadyCreatedCampaigns=array_merge($AlreadyCreatedCampaigns,Campaign::RetrieveAll(false,[],true,['Organization_ID'=>$ID,'Status'=> Campaign::CAMPAIGN_STATUS_APPROVED]));

        $Exist=false;
        $identity = 0;
//        $params = [];
        if($AlreadyCreatedCampaigns){
            foreach ($AlreadyCreatedCampaigns as $camp) {
                if ($camp && $camp->getCampaignDate() >= date('Y-m-d')) {
                    $Exist = true;
                    $identity = $camp->getCampaignID();
                }
            }
        }

       $params=[
            'organization_Name'=> $organization->getOrganizationName(),
        ];

        return $this->render('Organization/organizationBoard',[$params,'campaign_exist'=>$Exist,'id' => $ID,'identity' => $identity]);
    }

//    public function manage()
//    {
//        /* @var Campaign $campaign */
//        $ID=Application::$app->getUser()->getID();
//        $AlreadyCreatedCampaign=Campaign::RetrieveAll(false,[],true,['Organization_ID'=>$ID,'Status'=> Campaign::PENDING]);
//        $AlreadyCreatedCampaigns=Campaign::RetrieveAll(false,[],true,['Organization_ID'=>$ID,'Status'=> Campaign::APPROVED]);
//
//        $Exist=false;
//        $identity = 0;
////        $params = [];
//        if($AlreadyCreatedCampaign){
//            foreach ($AlreadyCreatedCampaign as $camp) {
//                if ($camp && $camp->getCampaignDate() >= date('Y-m-d')) {
//                    $Exist = true;
//                    $identity = $camp->getCampaignID();
//                }
//            }
//        }
//        if($AlreadyCreatedCampaigns) {
//            foreach ($AlreadyCreatedCampaigns as $camp) {
//                if ($camp && $camp->getCampaignDate() >= date('Y-m-d')) {
//                    $Exist = true;
//                    $identity = $camp->getCampaignID();
//                }
//            }
//        }
//
//        return $this->render('Organization/manageCampaign',[
//            'campaign_exist'=>$Exist,'id' => $ID,'identity' => $identity
//        ]);
//    }

    public function CreateCampaign(Request $request,Response $response): string
    {
        $ID = Application::$app->getUser()->getID();
        $AlreadyCreatedCampaigns = Campaign::RetrieveAll(false, [], true, ['Organization_ID' => $ID, 'Status' => Campaign::CAMPAIGN_STATUS_PENDING]);
        if ($AlreadyCreatedCampaigns){
            $AlreadyCreatedCampaigns = array_merge($AlreadyCreatedCampaigns, Campaign::RetrieveAll(false, [], true, ['Organization_ID' => $ID, 'Status' => Campaign::CAMPAIGN_STATUS_APPROVED]));
        }else{
            $AlreadyCreatedCampaigns = Campaign::RetrieveAll(false, [], true, ['Organization_ID' => $ID, 'Status' => Campaign::CAMPAIGN_STATUS_APPROVED]);
        }
        $Exist=false;
        $identity = 0;
        if($AlreadyCreatedCampaigns) {
            foreach ($AlreadyCreatedCampaigns as $camp) {
                if ($camp->getCampaignDate() >= date('Y-m-d')) {
                    $Exist = true;
                    $identity = $camp->getCampaignID();
                    break;
                }
            }
        }
        if($Exist) {
            Application::$app->session->setFlash('error', 'Already Created Campaign is in Progress!');
            Application::Redirect('/organization/dashboard');
        }else{
            $campaign = new Campaign();
            $bank = BloodBank::RetrieveAll(false, [], false);
            if ($request->isPost()) {
                $campaign->loadData($request->getBody());
                $campaign->setOrganizationID(Application::$app->getUser()->getID());
//                $campaign->setCampaignDate(date("Y-m-d H:i:s"));
                $campaign->setStatus(Campaign::CAMPAIGN_STATUS_PENDING);
                $campaign->setVerified(Campaign::NOT_VERIFIED);
                $campaign->setCreatedAt(date("Y-m-d H:i:s"));
                $id = uniqid("Camp_");
                $campaign->setCampaignID($id);

                if ($campaign->validate() && $campaign->save()) {
                    $this->setFlashMessage('success', 'You Successfully Created a Campaign! Please Wait for the Admin Approval.');
                    $response->redirect('/organization/campDetails?id='.urlencode(Security::Encrypt($id)));
                } else {
                    Application::$app->session->setFlash('error', 'Something Went Wrong!');
                    Application::Redirect('/organization/campaign/create');
                }

            }
            return $this->render('Organization/createCampaign', ['banks' => $bank]);
        }
        return "";
    }

    public function ViewCampaign(Request $request,Response $response)
    {
        print_r("ViewCampaign");
    }

    public function near()
    {
        /* @var Campaign $campaign */
        $city = Application::$app->getUser()->getCity();
        $result = Campaign::RetrieveAll(false, [],true,['Status' => Campaign::CAMPAIGN_STATUS_APPROVED]);
        return $this->render('Organization/campaign/NearByCampaigns',['data'=>$result,'city'=>$city]);
    }
    public function report()
    {

        return $this->render('Organization/report');
    }
    public function history()
    {
        /* @var Campaign $campaign */
        $ID = Application::$app->getUser()->getID();
        $result = Campaign::RetrieveAll(false, [], true, ['Organization_ID' => $ID]);
        $expired = 0;
        $params = [];
        foreach ($result as $res){
            if($res->getCampaignDate() < date("Y-m-d") || $res->getCampaignStatus() === 'Rejected'){
                $params[] = [
                    'Campaign_Name' => $res->getCampaignName(),
                    'Campaign_Date' => $res->getCampaignDate(),
                    'Status' => $res->getCampaignStatus(),
                    'Campaign_ID' => $res->getCampaignID()
                ];
            }
        }

//        $campaign = Campaign::findOne(['Organization_ID' => $_SESSION['Email']]);
//        $params=[
//            'Campaign_Name'=> $campaign->getName(),
//            'Campaign_Date' => $campaign->getDate(),
//
//        ];
        return $this->render('Organization/history',$params);
    }

    public function GetNotification(Request $request,Response $response): string
    {
        if ($request->isPost()){
            $Notifications=OrganizationNotification::RetrieveAll(false,[],true,['Target_ID'=>Application::$app->getUser()->getId()],['Notification_Date'=>'ASC']);
            if ($Notifications){
                $Notifications = array_map(function ($object) {
                    return $object->toArray();
                }, $Notifications);
            }
            return json_encode([
                'status'=>true,
                'notifications'=>$Notifications
            ]);
        }
    }


//    public function inform(Request $request, Response $response)
//    {
//        $id = $_GET['id'];
//        if ($request->isPost()) {
//            $informdonor = new informDonors();
//            $informdonor->loadData($request->getBody());
//            $informdonor->setMessageID(uniqid('Msg_'));
//            if ($informdonor->save()) {
//                Application::Redirect('/organization/campDetails?id='.$id);
//                return json_encode(['status' => true, 'message' => 'sending success']);
//            } else {
//                return json_encode(['status' => false, 'message' => 'Something went wrong!']);
//            }
//        }
//
//        return $this->render('Organization/inform');
//
//    }
public function inform(Request $request, Response $response)
{
    $id = $_GET['id'];
    $id = Security::Decrypt($id);
    $donors = AttendanceAcceptedRequest::RetrieveAll(false,[],true,['Campaign_ID' => $id]);
    if($id) {
        if ($donors) {
            if ($request->isPost()){
                $informdonor = new informDonors();
                $informdonor->loadData($request->getBody());
                $informdonor->setMessageID(uniqid('Msg_'));
                foreach ($donors as $donor) {
                    $donornotification = new DonorNotification();
                    $donornotification->setNotificationID(uniqid('Not_'));
                    $donornotification->setNotificationMessage($informdonor->getMessage());
                    $donornotification->setNotificationDate(date('Y-m-d'));
                    $donornotification->setTargetID($donor->getDonorID());
                    $donornotification->setNotificationState(1);
                    $donornotification->save();
                }
                Application::Redirect('/organization/campDetails?id=' . urlencode(Security::Encrypt($id)));
            }
            //    print_r($informdonor);
            return $this->render('Organization/inform');
        } else {
            Application::$app->session->setFlash('error', 'You do not have any Donors Yet.');
            Application::Redirect('/organization/campDetails?id=' . urlencode(Security::Encrypt($id)));
        }
    }
    else{
        Application::$app->session->setFlash('error','Access Denied!');
        Application::Redirect('/organization/dashboard');
    }
}

    public function ChangeProfileImage(Request $request,Response $response)
    {
        if($request->isPost()){
            /* @var $Organization Organization*/
            $UserID= Application::$app->getUser()->getId();
            $Organization = Organization::findOne(['Organization_ID'=>$UserID]);
            $ExistingFile = $Organization->getProfileImage();
            $File=$request->getBody()['profileImage'];
            if($File) {
                $File->setPath('Profile/Organization');
                $filename = $File->GenerateFileName('ORG_');
                $Organization->setProfileImage($filename);
                if ($Organization->update($Organization->getID(), [], ['Profile_Image'])){
                    $File->saveFile();
                    File::DeleteFileByPath($ExistingFile);
                    return json_encode([
                        'status' => true,
                        'filename' => $filename,
                        'data' => $File,
                        'message' => 'File Selected!'
                    ]);
                }else{
                    return json_encode([
                        'status'=>false,
                        'message'=>'File Not Selected!'
                    ]);
                }
            }else{
                return json_encode([
                    'status'=>false,
                    'message'=>'No File Selected!'
                ]);
            }
        }

    }

    public function GetOrganizationBankAccountDetails(Request $request,Response $response)
    {
        if ($request->isPost()){
            /** @var $BankAccount OrganizationBankAccount*/
            $UserID = Application::$app->getUser()->getID();
            $BankAccount = OrganizationBankAccount::findOne(['Organization_ID' => $UserID]);
            if ($BankAccount){
                $BankAccountNumber = Security::Decrypt($BankAccount->getAccountNumber());
                $BankAccountName = $BankAccount->getAccountName();
                $BankName = $BankAccount->getBankName();
                $BankBranch = $BankAccount->getBranchName();
                return json_encode(['status'=>true,"data"=>[
                        'BankAccountNumber' => $BankAccountNumber,
                        'BankAccountName' => $BankAccountName,
                        'BankName' => $BankName,
                        'BankBranch' => $BankBranch
                ]]);
            }else{
                return json_encode(['status'=>true,'data'=>[]]);
            }
        }

    }

    public function AddOrganizationBankAccountDetails(Request $request,Response $response)
    {
        /** @var $BankAccount OrganizationBankAccount*/
        if ($request->isPost()){
            $BankName = $request->getBody()['bankName'];
            $BankBranch = $request->getBody()['branchName'];
            $BankAccountNumber = $request->getBody()['bankAccountNo'];
            $BankAccountName = $request->getBody()['bankAccountName'];
            $UserID = Application::$app->getUser()->getID();
            $BankAccount = OrganizationBankAccount::findOne(['Organization_ID' => $UserID]);
            if ($BankAccount){
                $BankAccount->setBankName($BankName);
                $BankAccount->setBranchName($BankBranch);
                $BankAccount->setAccountNumber(Security::Encrypt($BankAccountNumber));
                $BankAccount->setAccountName($BankAccountName);
                if ($BankAccount->update($BankAccount->getOrganizationID(),[],['Bank_Name','Branch_Name','Account_Number','Account_Name'])) {
                    return json_encode([
                        'status' => true,
                    ]);
                }
                else{
                    return json_encode(['status'=>false,'errors'=>$BankAccount->errors]);
                }
            }else{
                $BankAccount = new OrganizationBankAccount();
                $BankAccount->setBankName($BankName);
                $BankAccount->setBranchName($BankBranch);
                $BankAccount->setAccountNumber(Security::Encrypt($BankAccountNumber));
                $BankAccount->setAccountName($BankAccountName);
                $BankAccount->setOrganizationID($UserID);
                if ($BankAccount->validate() && $BankAccount->save()){
                    return json_encode([
                        'status'=>true,
                    ]);
                }else{
                    return json_encode(['status'=>false]);
                }
            }
        }
    }
    public function updateCampaign(Request $request,Response $response){
        $id = $_GET['id'];
        $id = Security::Decrypt($id);
        $campaign = Campaign::findOne(['Campaign_ID'=>$id]);
        if($request->isPost()){
            $campaign->loadData($request->getBody());
                if ($campaign->update($id)) {
                    Application::$app->session->setFlash('success','Campaign Updated Successfully!');
                     Application::Redirect('/organization/campDetails?id='.urlencode(Security::Encrypt($id)));

                }

        }
        return $this->render('Organization/campaign/updateCampaign',['campaign'=>$campaign]);
    }

    public function RequestSponsorship(Request $request,Response $response)
    {
        $id = $_GET['id'];
//        $id = Security::Decrypt($id);
        if ($request->isPost()){
            $SponsorshipRequest = new SponsorshipRequest();
            $SponsorshipRequest->loadData($request->getBody());
            $Report = $request->getBody()['BudgetReport'];
            /** @var File $Report*/
            $Report->setPath('SponsorshipRequest/BudgetReport');
            $Report->GenerateFileName('SR_');
            $Campaign = Campaign::findOne(['Campaign_ID' => $id]);
                if ($Campaign){
                    if (SponsorshipRequest::findOne(['Campaign_ID'=>$id]))
                        return json_encode(['status'=>false,'message'=>'You have already requested sponsorship for this campaign!']);
                    $SponsorshipRequest->setCampaignID($id);
                }else{
                    return json_encode(['status'=>false,'message'=>'You have not created any Campaigns!']);
                }
            $SponsorshipRequest->setSponsorshipID(uniqid('SR_'));
            $SponsorshipRequest->setReport($Report->getFileName());
            $SponsorshipRequest->setSponsorshipDate(date('Y-m-d H:i:s'));
            $SponsorshipRequest->setSponsorshipStatus(SponsorshipRequest::STATUS_PENDING);

            if ($SponsorshipRequest->validate()){
                if ($Report->saveFile()){
                    $SponsorshipRequest->save();
                    return json_encode(['status'=>true]);
                }else{
                    return json_encode(['status'=>false,'message'=>'Something went wrong!']);
                }
            }else{
                return json_encode(['status'=>false,'errors'=>$SponsorshipRequest->errors,'message'=>'Something went wrong!']);
            }
        }

    }
    public function received()
    {
        $id = $_GET['id'];
        $income = SponsorshipRequest::findOne(['Campaign_ID'=>$id]);

    }
    public function accepted()
    {
        $attendance = new AttendanceAcceptedRequest();
        $id = $_GET['id'];
        $condition = ['Campaign_ID' => $id];
        $count = $attendance::getCount(false,$condition);
//        $count = 10;
        return $this->render('Organization/accepted',['count' => $count]);
    }
    public function guideline()
    {

        return $this->render('Organization/guideline');
    }
    public function campDetails(Request $request,Response $response)
    {
        /* @var Campaign $Campaign */
        $id = $_GET['id'];
        $id = Security::Decrypt($id);
        $user = Application::$app->getUser()->getID();

        $bank = OrganizationBankAccount::findOne(['Organization_ID' => $user]);

//        $id = Security::Decrypt($id);
        $disable = 0;
        $expired = 0;
        $Campaign = Campaign::findOne(['Campaign_ID' => $id]);
        /** @var $SponsorshipRequest SponsorshipRequest */
        $ReceivedAmount = 0;
        $SponsorshipRequest = SponsorshipRequest::findOne(['Campaign_ID' => $id]);

        if ($SponsorshipRequest) {

            $SponsoredDetails = CampaignsSponsor::RetrieveAll(false, [], true, ['Sponsorship_ID' => $SponsorshipRequest->getSponsorshipID()]);
            $ReceivedAmount = array_sum(array_map(function ($SponsoredDetail) {
                return $SponsoredDetail->getSponsoredAmount();
            }, $SponsoredDetails));
        }
        $ReceivedAmount = number_format($ReceivedAmount, 2);



        if ($Campaign->getCampaignStatus() === Campaign::CAMPAIGN_STATUS_PENDING) {
            $disable = 1;
        }
        if ($Campaign->getCampaignDate() < date("Y-m-d")) {
            $expired = 1;
        }
        $attendance = new AttendanceAcceptedRequest();
        $condition = ['Campaign_ID' => $id];
        $count = $attendance::getCount(false, $condition);

        return $this->render('Organization/campDetails', ['campaign' => $Campaign, 'disable' => $disable, 'expired' => $expired, 'ReceivedAmount' => $ReceivedAmount, 'count' => $count, 'bank' => $bank]);


    }

    public function upload(Request $request, Response $response)
    {
        $folderPath = Application::$ROOT_DIR."/public/upload/test/";
        $image_parts = explode(";base64,", $request->getBody()['image']);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = uniqid() . '.png';
        $file = $folderPath . $fileName;
        file_put_contents($file, $image_base64);
        return json_encode($file);
    }

    public function GetCampaignCoordinate(Request $request, Response $response)
    {
        if ($request->isPost()){
            $CampaignID = $request->getBody()['CampaignID'] ?? null;
            $CampaignDateFrom = $request->getBody()['CampaignDateFrom'] ?? null;
            $CampaignDateTo = $request->getBody()['CampaignDateTo'] ?? null;

            if ($CampaignDateFrom && $CampaignDateTo) {
                $Campaigns= Campaign::RetrieveAll(false,[],true,['Status'=> Campaign::CAMPAIGN_STATUS_APPROVED]);
                $CampaignsArray = [];
                foreach ($Campaigns as $Campaign) {
                    if ($Campaign->getCampaignDate() >= $CampaignDateFrom && $Campaign->getCampaignDate() <= $CampaignDateTo) {
                        $CampaignsArray[] = $Campaign->toArray();
                    }
                }
                return json_encode(['status' => true, 'Campaigns' => $CampaignsArray]);
            }
            if ($CampaignID) {
                $Campaign = Campaign::findOne(['Campaign_ID' => $CampaignID]);
                if ($Campaign) {
                    return json_encode(['status' => true, 'lat' => $Campaign->getLatitude(), 'lng' => $Campaign->getLongitude()]);
                } else {
                    return json_encode(['status' => false, 'message' => 'Campaign Not Found']);
                }
            } else {
                $Campaigns= Campaign::RetrieveAll(false, [], true, ['Status'=> Campaign::CAMPAIGN_STATUS_APPROVED]);
                $CampaignsArray = [];
                foreach ($Campaigns as $Campaign) {
                    if($Campaign->getCampaignDate() >= date('Y-m-d'))
                    $CampaignsArray[] = $Campaign->toArray();
                }
                return json_encode(['status' => true, 'Campaigns' => $CampaignsArray]);
            }
        }
    }
    public function delete(Request $request,Response $response){
        $id = $_GET['id'];
//        $id = Security::Decrypt($id);
        $campaign = Campaign::findOne(['Campaign_ID' => $id]);
        if($campaign->delete()) {
            Application::$app->session->setFlash('success','Your Campaign Deleted Successfully!');
            $response->redirect('/organization/dashboard');
        }else{
            Application::$app->session->setFlash('error','Message deletion Unsuccessful!');
        }

    }

    public function ResetPassword(Request $request,Response $response){
        if($request->isPost()){
            $user = Application::$app->getUser()->getID();
            $userDetails = User::findOne(['UID' => $user]);
            $password = $request->getBody()['NewPassword'];
            $oldpassword = $userDetails->getPassword();
            $encryptpassword = password_hash($password,PASSWORD_DEFAULT);
            $userDetails->setPassword($encryptpassword);
            if(password_verify($password,$oldpassword)){
                return json_encode([
                    'status' => false,
                    'message' => 'New and Old Passwords cannot be Equal',
                ]);
            }
            else {
                if ($userDetails->update($user, [], ['Password'])) {

                    return json_encode([
                        'status' => true,
                    ]);
                } else {
                    return json_encode([
                        'status' => false,
                        'message' => 'Please Try Again Later',

                    ]);
                }
            }
        }
    }
}
