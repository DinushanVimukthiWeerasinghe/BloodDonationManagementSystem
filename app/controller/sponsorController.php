<?php

namespace App\controller;
use App\middleware\sponsorMiddleware;
use App\model\Authentication\Login;
use App\model\Notification\OrganizationNotification;
use App\model\Notification\SponsorNotification;
use App\model\Requests\AttendanceAcceptedRequest;
use App\model\Requests\SponsorshipRequest;
use App\model\sponsor\campaigns_sponsors;
use App\model\sponsor\SponsorshipPackages;
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
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;


class sponsorController extends Controller
{
    public function __construct()
    {
//        print_r('Kk');
        $this->setLayout('sponsors');
//        $this->registerMiddleware(new sponsorMiddleware());

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
     */
    public function MakePayment(Request $request, Response $response)
    {
        if ($request->isPost()){
            $RequestID = $request->getBody()['Request'];
            $Package = $request->getBody()['Package'];

//            URL encode the RequestID

            if (!isset($RequestID) || !isset($Package)){
                $this->setFlashMessage('error','Invalid Request');
                Application::Redirect('/sponsor/dashboard');
                exit();
            }
            $IsPackageExist= SponsorshipPackages::findOne(['Package_Price_ID' => $Package]);
            if (!$IsPackageExist){
                $this->setFlashMessage('error','Invalid Package');
                Application::Redirect('/sponsor/dashboard');
                exit();
            }
            $RequestID = Security::Encrypt($RequestID);
            $RequestID = urlencode($RequestID);
            Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);
            $checkout_session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price'=> $Package,
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => HOST . '/sponsor/makePayment?success=true&RequestID='.$RequestID,
                'cancel_url' => HOST . '/sponsor/makePayment?success=false',
            ]);
            Application::Redirect($checkout_session->url);
        }else if ($request->isGet()){
            /** @var $SponsorshipRequest SponsorshipRequest*/
            $status = $request->getBody()['success'];
            if ($status==='true'){
                $RequestID = $request->getBody()['RequestID'];
                $RequestID = Security::Decrypt($RequestID);
                if (!isset($RequestID) || !$RequestID){
                    $this->setFlashMessage('error','Invalid Request');
                    Application::Redirect('/sponsor/dashboard');
                    exit();
                }
                $UserID = Application::$app->getUser()->getID();
                $SponsorshipRequest = SponsorshipRequest::findOne(['Sponsorship_ID' => $RequestID]);
                $SponsorshipRequest->sponsor($UserID);
                $OrganizationID = $SponsorshipRequest->getOrganizationID();
                OrganizationNotification::CreateNewSponsorshipAcceptedRequest($OrganizationID);
                $this->setFlashMessage('success','Payment Successful');
                Application::Redirect('/sponsor/dashboard');

            }else{
                $this->setFlashMessage('error','Payment Failed');
                Application::Redirect('/sponsor/dashboard');
            }
        }
    }

    public function MakeDonation(Request $request,Response $response): string
    {
        /** @var SponsorshipRequest $SponsorshipRequests */
        /* @var Sponsor $sponsor*/
        $SponsorshipRequests = SponsorshipRequest::RetrieveAll(false,[],true,['Sponsorship_Status' => SponsorshipRequest::STATUS_APPROVED]);
        array_filter($SponsorshipRequests,function ($campaign){
            return $campaign->getCampaignDate() >= date('Y-m-d');
        });
        return $this->render('sponsors/ViiewCampaigns',[
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

        Application::$app->session->setFlash('success','Welcome Back!'.' '.$sponsor->getSponsorName());
        return $this->render('sponsors/sponsorBoard',$params);
    }

    public function manage()
    {
        return $this->render('sponsors/manage');
    }

    public function create(Request $request,Response $response)
    {
        $campaign = new Campaign();
        if($request->isPost()){
            $campaign->setOrganizationID(Application::$app->getUser()->getID());
            $campaign->setStatus(1);
            $id = uniqid("Camp_");
            $campaign->setCampaignID($id);
            $campaign->loadData($request->getBody());
//            print_r($campaign);
//            exit();
            if($campaign->validate() && $campaign->save()) {
                $response->redirect('/organization/history');
            }else{
                print_r($campaign->errors);
            }

        }
        Application::$app->session->setFlash('success','You Successfully Created a Campaign! Please Wait for the Admin Approval.');
        return $this->render('Organization/create');
    }



    public function report()
    {

        return $this->render('Organization/report');
    }
    public function history()
    {


        $id = Application::$app->getUser()->getID();
        $conditions = ['Sponsor_ID' => Application::$app->getUser()->getID()];
        $campaigns = campaigns_sponsors::RetrieveAll(false,[],true, $conditions);

//        $mycampaign = array_filter($campaigns,function ($campaign)use($id){
//            return $campaign->getSponsorID()==$id;
//        });
//        var_dump($id);
//        echo '<pre>';
//        print_r($campaigns);
//        exit();
        $para = [];
        foreach ($campaigns as $campaign) {
            $para[] = Campaign::findOne(['Campaign_ID' => $campaign->getID()]);

        }
//        echo '<pre>';
//        print_r($para);
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
        return $this->render('Organization/accepted',['count' => $count]);
    }
    public function guideline()
    {

        return $this->render('sponsors/guideline');
    }
    public function campDetails()
    {
        /* @var Campaign $campaign */
        /* @var SponsorshipPackages $para */
        $id = $_GET['id'];
        $campaign = Campaign::findOne(['Campaign_ID'=> $id]);
        $params= [
            'Campaign_Name'=> $campaign->getCampaignName(),
            'Campaign_Date' => $campaign->getCampaignDate(),
            'Venue'=> $campaign->getVenue(),
            'Status'=> $campaign->getStatus(),
            'Campaign_ID'=> $campaign->getCampaignID(),
            'id' => $id,
            'Package_Name' => $para?->getPackageName(),
        ];
        return $this->render('sponsors/campDetails',$params);
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