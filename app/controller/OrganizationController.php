<?php

namespace App\controller;

use App\middleware\organizationMiddleware;
use App\model\Authentication\Login;
use App\model\Authentication\OrganizationBankAccount;
use App\model\BloodBankBranch\BloodBank;
use App\model\database\dbModel;
use App\model\inform\informDonors;
use App\model\Notification\OrganizationNotification;
use App\model\Requests\additional_sponsorship_request;
use App\model\Requests\AttendanceAcceptedRequest;
use App\model\Requests\SponsorshipRequest;
use App\model\sponsor\campaigns_sponsors;
use App\model\sponsor\SponsorshipPackages;
use App\model\users\organization;
use App\model\Campaigns\Campaign;
use App\model\users\Sponsor;
use App\model\users\User;
use App\model\Utils\Notification;
use Core\Application;
use Core\BaseMiddleware;
use Core\Controller;
use Core\File;
use Core\middleware\AuthenticationMiddleware;
use Core\middleware\ManagerMiddleware;
use Core\Request;
use Core\Response;
use Core\SessionObject;

class OrganizationController extends Controller
{

    public function __construct()
    {
        $this->setLayout('Organization');
        $this->registerMiddleware(new organizationMiddleware(['dashboard'], BaseMiddleware::FORBIDDEN_ROUTES));

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
         print_r($organization);
            echo '<br>';
            echo '<br>';
            echo '<br>';
            print_r($user);
            echo '<br>';
            echo '<br>';
            echo '<br>';

            if($user->validate() && $user->saver()) {
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
//        print_r(Application::$app->getUser());
//        exit();
        $organization = Organization::findOne(['Organization_ID' => Application::$app->getUser()->getID()]);
//        print_r(Application::$app->getUser());
//        exit();
       $params=[
            'organization_Name'=> $organization->getOrganizationName()
        ];
        return $this->render('Organization/organizationBoard',$params);
    }

    public function manage()
    {
        /* @var Campaign $campaign */
        $ID=Application::$app->getUser()->getID();
        $AlreadyCreatedCampaign=Campaign::findOne(['Organization_ID'=>$ID,'Status'=> Campaign::PENDING],false);
        $AlreadyCreatedCampaign=Campaign::findOne(['Organization_ID'=>$ID,'Status'=> Campaign::APPROVED],false);

        $Exist=false;
        if ($AlreadyCreatedCampaign){
            $Exist=true;
        }

        return $this->render('Organization/manageCampaign',[
            'campaign_exist'=>$Exist,'id' => $ID
        ]);
    }

    public function CreateCampaign(Request $request,Response $response): string
    {
        $campaign = new Campaign();
        $bank = BloodBank::RetrieveAll(false,[],false);
        $packages = SponsorshipPackages::RetrieveAll(false,[],false);

        if($request->isPost()){
            $campaign->loadData($request->getBody());
            $campaign->setOrganizationID(Application::$app->getUser()->getID());
            $campaign->setCampaignDate(date("Y-m-d H:i:s"));
            $campaign->setStatus(Campaign::PENDING);
            $campaign->setCreatedAt(date("Y-m-d H:i:s"));
            $id = uniqid("Camp_");
            $campaign->setCampaignID($id);

            if($campaign->validate() && $campaign->save()) {
                $this->setFlashMessage('success', 'You Successfully Created a Campaign! Please Wait for the Admin Approval.');
                $response->redirect('/organization/campaign/view');
            }else{
                Application::$app->session->setFlash('error','Something Went Wrong!');
                Application::Redirect('/organization/campaign/create');
            }

        }
        Application::$app->session->setFlash('success','You Successfully Created a Campaign! Please Wait for the Admin Approval.');
        return $this->render('Organization/createCampaign',['banks'=> $bank,'package' => $packages]);
    }

    public function ViewCampaign(Request $request,Response $response)
    {
        print_r("ViewCampaign");
    }

    public function near()
    {
        /* @var Campaign $campaign */
        $city = Application::$app->getUser()->getCity();
        $result = Campaign::RetrieveAll(false, []);
//        $result =array_filter($result,function ($campaign){
//            return $campaign->getStatus() === Campaign::APPROVED;
//        });
//        return $this->render('Organization/near',['data'=>$result]);
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
        foreach ($result as $res){
            if($res->getCampaignDate() < date("Y-m-d")){
                $params[] = [
                    'Campaign_Name' => $res->getCampaignName(),
                    'Campaign_Date' => $res->getCampaignDate(),
                    'Status' => $res->getCampaignStatus(),
                    'Campaign_ID' => $res->getCampaignID(),
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


    public function inform(Request $request, Response $response)
    {
        $inform = new informDonors();
        if ($request->isPost()) {
            $inform->loadData($request->getBody());
            $id = uniqid("Message_");
            $inform->setMessageID($id);
            $inform->setCampaignID($_GET['id']);
            $inform->setStatus($inform::PENDING);

            if($inform->validate()) {
                if($inform->save()) {
                    $response->redirect('/organization/inform?id=' . $_GET['id']);
                    Application::$app->session->setFlash('success', 'You have successfully submitted your Message.');
                    return;

                }
            }else {
                    $errors = $inform->errors;
            }
        }
        return $this->render('Organization/inform',['inform' => $inform]);
    }
    public function request(Request $request,Response $response)
    {
        $req = new additional_sponsorship_request();
        $message = 0;
        if ($request->isPost()) {
            $req->loadData($request->getBody());
            $id = uniqid("Request_");
            $req->setRequestID($id);
            $req->setCampaignID($_GET['id']);
            $req->setStatus($req::PENDING);
            if($req->validate()) {
                $GLOBALS['message'] = 1;
                if($req->save()) {
                    $response->redirect('/organization/request?id=' . $_GET['id']);
                    Application::$app->session->setFlash('success', 'You have successfully submitted your Sponsorship Request.');
                    return;
                }
            }else {
                $errors = $req->errors;
            }
        }

        return $this->render('Organization/request',['req'=>$req]);
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
                $BankAccountNumber = $BankAccount->getAccountNumber();
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
                $BankAccount->setAccountNumber($BankAccountNumber);
                $BankAccount->setAccountName($BankAccountName);
                if ($BankAccount->update($BankAccount->getOrganizationID(),[],['Bank_Name','Branch_Name','Account_Number','Account_Name'])){
                    return json_encode(['status'=>true]);
                }else{
                    return json_encode(['status'=>false,'errors'=>$BankAccount->errors]);
                }
            }else{
                $BankAccount = new OrganizationBankAccount();
                $BankAccount->setBankName($BankName);
                $BankAccount->setBranchName($BankBranch);
                $BankAccount->setAccountNumber($BankAccountNumber);
                $BankAccount->setAccountName($BankAccountName);
                $BankAccount->setOrganizationID($UserID);
                if ($BankAccount->validate() && $BankAccount->save()){
                    return json_encode(['status'=>true]);
                }else{
                    return json_encode(['status'=>false]);
                }
            }
        }
    }

    public function RequestSponsorship(Request $request,Response $response)
    {
        if ($request->isPost()){
            $SponsorshipRequest = new SponsorshipRequest();
            $SponsorshipRequest->loadData($request->getBody());
            $Report = $request->getBody()['BudgetReport'];
            /** @var File $Report*/
            $Report->setPath('SponsorshipRequest/BudgetReport');
            $Report->GenerateFileName('SR_');
            $Campaign = Campaign::findOne(['Organization_ID'=>Application::$app->getUser()->getID(),'Verified'=>Campaign::APPROVED],false);
                if ($Campaign){
                    if (SponsorshipRequest::findOne(['Campaign_ID'=>$Campaign->getCampaignID()]))
                        return json_encode(['status'=>false,'message'=>'You have already requested sponsorship for this campaign!']);
                    $SponsorshipRequest->setCampaignID($Campaign->getCampaignID());
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
        /* @var Sponsor $sponser */
        /* @var SponsorshipPackages $pack */
        $attendance = new campaigns_sponsors();
        $total = 0;
        $reached = 0;
        $id = $_GET['id'];
        $condition = ['Campaign_ID' => $id];
        $count = $attendance::getCount(false,$condition);
        $campaign = Campaign::findOne(['Campaign_ID' => $id]);
        $amount = $campaign->getExpectedAmount();
        $sponsor = $attendance::findOne(['Campaign_ID' => $id]);
        if($sponsor){
            $package_ID = $sponsor->getPackageID();
            $package = SponsorshipPackages::findOne(['Package_ID' => $package_ID]);
            $price = $package->getPackagePrice();
            $total = $count * $price;
            $total = 25000;
        }
        if($amount == $total){
            Application::$app->session->setFlash('success','You have Reached Your Expected Amount! You campaign will not be visible to Sponsors.');
            $reached = 1;
        }
        return $this->render('Organization/received',['data' => $total, 'reach' => $reached]);
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
    public function view()
    {
        /* @var Campaign $campaign */
        $ID = Application::$app->getUser()->getID();
        $result = Campaign::findOne(['Organization_ID' => $ID, 'Status' => Campaign::PENDING],false);
        if (!$result){
            $result = Campaign::findOne(['Organization_ID' => $ID, 'Status' => Campaign::APPROVED],false);
        }
        if ($result){
            $id=$result->getCampaignID();
            $campaign = Campaign::findOne(['Campaign_ID'=> $id]);
            return $this->render('Organization/campDetails',['campaign'=>$campaign,'id'=>$id]);
        }
        else{
            Application::$app->session->setFlash('success','You have not created a Campaign yet!');
            return $this->render('Organization/campDetails',['campaign'=>$campaign]);
        }
    }
    public function campDetails(Request $request,Response $response)
    {
        /* @var Campaign $Campaign */
        $Organization_ID = Application::$app->getUser()->getID();
        $disable = 0;
        $expired = 0;
        $Campaign = Campaign::findOne(['Organization_ID' => $Organization_ID]);
        if ($Campaign){
            if($Campaign->getCampaignStatus() === Campaign::PENDING){
                $disable = 1;
            }
            if($Campaign->getCampaignDate() < date("Y-m-d")){
                $expired = 1;
            }
            return $this->render('Organization/campDetails',['campaign'=>$Campaign, 'disable' => $disable, 'expired' => $expired]);
        }else{
            /* @var Campaign $campaign */
            $ID=Application::$app->getUser()->getID();
            $Camp=Campaign::RetrieveAll(false,[],true,['Organization_ID'=>$ID]);
//        $AlreadyCreatedCampaign = $Camp::findOne(['Status' => Campaign::PENDING]);
            $Exist=false;
            $id = 0;

            if ($Camp){
                foreach ($Camp as $cam) {
                    if ($cam->getCampaignDate() >= date("Y-m-d")) {
                        Application::$app->session->setFlash('error', 'Previously Created Campaign is in Progress.');
                        $id = $cam->getCampaignID();
                        $Exist = true;
                    }
                }
            }
            $response->redirect('/organization/manageCampaign',['campaign_exist'=>$Exist,'id' => $id]);

        }

        $params=[];
//        $params= [
//            'Campaign_Name'=> $campaign->getCampaignName(),
//            'Campaign_Date' => $campaign->getCampaignDate(),
//            'Venue'=> $campaign->getVenue(),
//            'Status'=> $campaign->getStatus(),
//            'Campaign_ID'=> $campaign->getCampaignID(),
//        ];


//        return $this->render('Organization/campDetails',$params);
    }
    public function Notification(Request $request, Response $response): string
    {
        $limit = 10;
        $page = $request->getBody()['page'] ?? 1;
        $initial = ($page - 1) * $limit;
        $id=Application::$app->getUser()->getID();
        $total_rows = Notification::getCount(false,['Target_User' => $id]);
        $total_pages = ceil ($total_rows / $limit);
        $notification = Notification::RetrieveAll(true,[$initial,$limit],true,['Target_User' => $id]);
        return $this->render('Manager/Notification',['model'=>$notification,'total_pages'=>$total_pages,'current_page'=>$page]);
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
                $Campaigns= Campaign::RetrieveAll();
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
                $Campaigns= Campaign::RetrieveAll(false, [], );
                $CampaignsArray = [];
                foreach ($Campaigns as $Campaign) {
                    $CampaignsArray[] = $Campaign->toArray();
                }
                return json_encode(['status' => true, 'Campaigns' => $CampaignsArray]);
            }
        }
    }

}
