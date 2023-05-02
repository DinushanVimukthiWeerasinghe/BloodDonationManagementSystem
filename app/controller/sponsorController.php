<?php

namespace App\controller;
use App\middleware\sponsorMiddleware;
use App\model\Authentication\Login;
use App\model\Campaigns\ApprovedCampaigns;
use App\model\Campaigns\RejectedCampaign;
use App\model\Notification\OrganizationNotification;
use App\model\Notification\SponsorNotification;
use App\model\Requests\AttendanceAcceptedRequest;
use App\model\Requests\SponsorshipRequest;
use App\model\sponsor\CampaignsSponsor;
//use App\model\sponsor\SponsorshipPackages;
use App\model\users\organization;
use App\model\Campaigns\Campaign;
use App\model\users\Sponsor;
use App\model\users\User;
use App\model\Utils\Date;
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
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;


class sponsorController extends Controller
{
    public function __construct()
    {
//        print_r('Kk');
        $this->setLayout('sponsors');
        $this->registerMiddleware(new sponsorMiddleware());

//        $this->registerMiddleware(new AuthenticationMiddleware(['login','register'], BaseMiddleware::ALLOWED_ROUTES));
//        $this->registerMiddleware(new ManagerMiddleware());
    }
    public function profile()
    {
        $user=Application::$app->getUser();
        return $this->render('organization/profile',['user'=>$user]);
    }

    /**
     * @throws ApiErrorException
     * @throws \Exception
     */
    public function MakePayment(Request $request, Response $response)
    {
        /** @var $SponsorshipRequest SponsorshipRequest*/
//        $preAmount = $SponsorshipRequest->getToBeSponsoredAmount();
        if ($request->isPost()){
            $RequestID = $request->getBody()['Request'];
            $Amount = $request->getBody()['Amount'];
            $Description = $request->getBody()['Description'];

            if (!isset($Amount) || !isset($Description) || !isset($RequestID)){
                $this->setFlashMessage('error','Invalid Request');
                Application::Redirect('/sponsor/sponsor');
                exit();
            }
//            Check Amount
            if (!is_numeric($Amount)){
                $Amount = intval($Amount);
            }

            if ($Amount <= 0){
                $this->setFlashMessage('error','Invalid Amount');
                Application::Redirect('/sponsor/sponsor');
                exit();
            }

            $SponsorshipRequest = SponsorshipRequest::findOne(['Sponsorship_ID' => $RequestID]);
            if (!$SponsorshipRequest){
                $this->setFlashMessage('error','Invalid Request');
                Application::Redirect('/sponsor/sponsor');
                exit();
            }

            if ($SponsorshipRequest->getToBeSponsoredAmount() < $Amount){
                $Amount = $SponsorshipRequest->getToBeSponsoredAmount();
            }


            $SponsorshipRequestedAmount = intval($SponsorshipRequest->getSponsorshipAmount());
            $CampaignName = $SponsorshipRequest->getCampaignName();

            $SponsorshipRequest = SponsorshipRequest::findOne(['Sponsorship_ID' => $RequestID]);
            $RequestID = Security::Encrypt($RequestID);
            $RequestID = urlencode($RequestID);

            $stripe = new \Stripe\StripeClient($_ENV['STRIPE_SECRET_KEY']);
            $line_items[] = [
                'price_data' => [
                    'currency' => 'lkr',
                    'unit_amount' => $Amount * 100,
                    'product_data' => [
                        'name' => 'Sponsorship for '.$CampaignName,
                    ],
                ],
                'quantity' => 1,
            ];
            $EncAmount = Security::Encrypt($Amount);
            $EncAmount = urlencode($Amount);
            $Description =Security::Encrypt($Description);
            $Description = urlencode($Description);
            /** @var $SponsorshipRequest SponsorshipRequest*/
            $UserID = Application::$app->getUser()->getID();

            Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);
            $checkout_session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => $line_items,
                'mode' => 'payment',
                'success_url' => HOST . '/sponsor/makePayment?success=true&RequestID='.$RequestID.'&Amount='.$EncAmount.'&Description='.$Description.'&session_id='.'{CHECKOUT_SESSION_ID}' ,
                'cancel_url' => HOST . '/sponsor/makePayment?success=false',
                'custom_text'=>[
                    'submit' =>[
                        'message' => 'We\'ll send you an email with a link to download your receipt.'
                    ]
                ]
            ]);

            $SessionID = $checkout_session->id;
            $SponsorshipRequest->sponsor($UserID,$Amount,$SessionID,$Description);
            return json_encode(['status'=>true,'redirect'=>$checkout_session->url]);
        }else if ($request->isGet()){
            /** @var $SponsorshipRequest SponsorshipRequest*/
            $status = $request->getBody()['success'];
            if ($status==='true'){
                $RequestID = $request->getBody()['RequestID'];
                $Amount = $request->getBody()['Amount'];
                $Description = $request->getBody()['Description'];
                $SessionID = $request->getBody()['session_id'];
                $RequestID = Security::Decrypt($RequestID);
                $Amount = Security::Decrypt($Amount);
                $Description = Security::Decrypt($Description);
                /** @var $SponsorshipRequest CampaignsSponsor*/
                $SponsorshipRequest = CampaignsSponsor::RetrieveAll(false,[],false,['Sponsorship_ID'=>$RequestID],['Sponsored_At'=>'DESC']);
                if (!$SponsorshipRequest){
                    $this->setFlashMessage('error','Invalid Request');
                    Application::Redirect('/sponsor/sponsor');
                    exit();
                }
                if (count($SponsorshipRequest)>=1){
                    $SponsorshipRequest = $SponsorshipRequest[0];
                }
                if ($SponsorshipRequest->IsSessionValid($SessionID)){
                    $SponsorshipRequest->setStatus(CampaignsSponsor::PAYMENT_STATUS_PAID);
//                    var_dump("Hello");
//                    exit();
                    $SponsorshipRequest->update($SponsorshipRequest->getSponsorshipID(),[],['Status'],['Session_ID'=>Security::HashData($SessionID)]);
                    $this->setFlashMessage('success','Payment Successful!');
                    Application::Redirect('/sponsor/sponsor');
                }else{
                    $this->setFlashMessage('error','Transaction Failed');
                    Application::Redirect('/sponsor/sponsor');
                    exit();
                }
            }else{
//                $SponsorshipRequest->setToBeSponsoredAmount($preAmount);
                $this->setFlashMessage('error','Transaction Failed');
                Application::Redirect('/sponsor/sponsor');
                exit();
            }
        }
    }

    public function MakeDonation(Request $request,Response $response): string
    {
        /** @var SponsorshipRequest $SponsorshipRequests */
        /* @var Sponsor $sponsor*/
        $SponsorshipRequests = SponsorshipRequest::RetrieveAll(false,[],true,['Sponsorship_Status' => SponsorshipRequest::STATUS_APPROVED]);
//        print_r($SponsorshipRequests->getSponsorshipID());
//        exit();
//        print_r($SponsorshipRequests);
//        exit();
        array_filter($SponsorshipRequests,function ($campaign){
            return ($campaign->getCampaignDate() >= date('Y-m-d'));

        });
//        $para = [];
//        foreach ($SponsorshipRequests as $sponse){
//            $para[]=[
//              'hello' => $sponse->getSponsorshipID(),
//            ];
//
//        }
//        print_r($para);
//        exit();
        return $this->render('sponsors/ViewCampaigns',[
            'SponsorshipRequests' => $SponsorshipRequests,
        ]);
    }

    public function Test(Request $request, Response $response)
    {
        $user = Application::$app->getUser();
        $params = [
            'user' => $user,
        ];
        return $this->render('sponsors/test', $params);
    }



//    public function register(Request $request,Response $response ): string
//    {
//        $sponsor=new Sponsor();
////        if ($request->isPost())
////        {
////            $user = new User();
////            $organization->loadData($request->getBody());
////            $organization->getFile()->saveFile();
////            $user->loadData($request->getBody());
////            $organization->loadData($request->getBody());
////            $id =mt_rand(1000,10000);
////            $organization->setID($id);
////            $user ->setID($id);
////            print_r($organization);
////            echo '<br>';
////            echo '<br>';
////            echo '<br>';
////            print_r($user);
////            echo '<br>';
////            echo '<br>';
////            echo '<br>';
////
////            if($user->validate() && $user->saver()) {
////                if ($organization->validate() && $organization->save()) {
////                    $response->redirect('/login');
////                } else {
////                    print_r($organization->errors);
////                }
////            }else{
////                print_r($user->errors);
////            }
////        }
////
////        return $this->render('organization\register', ['model' => $organization]);
//    }

    public function dashboard(): string
    {
        /* @var sponsor $sponsor*/
        $sponsor = sponsor::findOne(['Sponsor_ID' => Application::$app->getUser()->getID()]);
//        print_r(Application::$app->getUser());
//        exit();
        $params=[
            'sponsor_Name'=> $sponsor->getSponsorName(),
        ];

        return $this->render('sponsors/sponsorBoard',$params);
    }

    public function manage()
    {
        return $this->render('sponsors/manage');
    }
    public function history()
    {


        $id = Application::$app->getUser()->getID();
//        print_r($id);
//        exit();
        $conditions = ['Sponsor_ID' => Application::$app->getUser()->getID()];
        $campaigns = CampaignsSponsor::RetrieveAll(false,[],true, $conditions);

//        print_r($campaigns);
//        exit();
//        $mycampaign = array_filter($campaigns,function ($campaign)use($id){
//            return $campaign->getSponsorID()==$id;
//        });
//        var_dump($id);
//        echo '<pre>';
//        print_r($campaigns);
//        exit();
        $para = [];
        foreach ($campaigns as $campaign) {
            $camp = SponsorshipRequest::findOne(['Sponsorship_ID' => $campaign->getSponsorshipID()]);
            $cam = Campaign::findOne(['Campaign_ID' => $camp->getCampaignID()]);
//            print_r($camp);
//            exit();
            $para[]=[
                'Campaign_Name' => $cam->getCampaignName(),
                'Sponsored_Amount' => $campaign->getSponsoredAmount(),
                'Sponsored_At' => $campaign->getSponsoredAt(),
                'Date' => Date::getTodayDate()
            ];

        }
//        echo '<pre>';
//        print_r($para);
//        exit();
//        print_r($campaigns);
//        exit();
        return $this->render('sponsors/history',['para'=>$para]);
    }

    public function inform()
    {


        return $this->render('Organization/inform');
    }
    public function request()
    {
        return $this->render('Organization/request');
    }
    public function received()
    {

        return $this->render('Organization/received');
    }
    public function accepted()
    {
        $attendance = new AttendanceAcceptedRequest();
        $id = $_GET['id'];
        $condition = ['Campaign_ID' => $id];
        $count = $attendance::getCount(false,$condition);
//        $count = 10;
//        return $this->render('Organization/accepted',['count' => $count]);
    }
    public function guideline()
    {

        return $this->render('sponsors/guideline');
    }

    public function GetCampaignDetails(Request $request,Response $response)
    {
        if ($request->isPost()){
            $id=$request->getBody()['id'];
            /* @var $campaign Campaign*/
            $campaign = Campaign::findOne(['Campaign_ID' => $id]);
            $Org_ID=$campaign->getOrganizationID();
            $Org=Organization::findOne(['Organization_ID' => $Org_ID]);

            if ($campaign){
                /** @var $SponsorshipRequests SponsorshipRequest*/
                if ($campaign->IsVerified()){
                    $ApprovedDetails = ApprovedCampaigns::findOne(['Campaign_ID' => $id]);
                    $SponsorshipRequests = SponsorshipRequest::findOne(['Campaign_ID' => $id,'Sponsorship_Status'=>SponsorshipRequest::STATUS_APPROVED],false);
                    if ($SponsorshipRequests){
                        $data = $SponsorshipRequests->toArray();
                        $data['remaining'] = $SponsorshipRequests->getToBeSponsoredAmount();
                        return json_encode(['status'=>true,'data'=>$campaign->toArray(),'org'=>$Org->toArray(),'approved'=>$ApprovedDetails->toArray(),'sponsorship'=>$data]);
                    }
                    return json_encode(['status'=>true,'data'=>$campaign->toArray(),'org'=>$Org->toArray(),'approved'=>$ApprovedDetails->toArray()]);
                }
                if ($campaign->IsRejected()){
                    $RejectedDetails = RejectedCampaign::findOne(['Campaign_ID' => $id]);
                    return json_encode(['status'=>true,'data'=>$campaign->toArray(),'org'=>$Org->toArray(),'rejected'=>$RejectedDetails->toArray()]);
                }
                return json_encode(['status'=>true,'data'=>$campaign->toArray(),'org'=>$Org->toArray()]);
            }
        }

    }
//    public function campDetails()
//    {
//        /* @var Campaign $campaign */
//        $id = $_GET['id'];
//        $campaign = Campaign::findOne(['Campaign_ID'=> $id]);
//        $SponsoredDetails =SponsorshipRequest::findOne(['Campaign_ID'=> $id]);
//        $params= [
//            'Campaign_Name'=> $campaign->getCampaignName(),
//            'Campaign_Date' => $campaign->getCampaignDate(),
//            'Venue'=> $campaign->getVenue(),
//            'Status'=> $campaign->getStatus(),
//            'Campaign_ID'=> $campaign->getCampaignID(),
//            'id' => $id,
//        ];
//        return $this->render('sponsors/campDetails',$params);
//    }
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
    public function GetNotification(Request $request,Response $response): string
    {
        if ($request->isPost()){
            $Notifications=SponsorNotification::RetrieveAll(false,[],true,['Target_ID'=>Application::$app->getUser()->getId()],['Notification_Date'=>'ASC']);
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
    public function ChangeProfileImage(Request $request,Response $response)
    {
        /* @var $sponsor Sponsor*/

        if($request->isPost()){

            $UserID= Application::$app->getUser()->getId();
            $sponsor = Sponsor::findOne(['Sponsor_ID'=>$UserID]);
            $ExistingFile = $sponsor->getProfileImage();
            $File=$request->getBody()['profileImage'];
            if($File) {
                $File->setPath('Profile/Sponsor');
                $filename = $File->GenerateFileName('SPN_');
                $sponsor->setProfileImage($filename);
                if ($sponsor->update($sponsor->getID(), [], ['Profile_Image'])){
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
}