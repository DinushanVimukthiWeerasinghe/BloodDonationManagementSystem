<?php

namespace App\controller;
use App\middleware\sponsorMiddleware;
use App\model\Authentication\Login;
use App\model\Requests\AttendanceAcceptedRequest;
use App\model\sponsor\campaigns_sponsors;
use App\model\sponsor\sponsorship_packages;
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
            Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);
            $domain = $_SERVER['HTTP_HOST'];
            $checkout_session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price'=>'price_1MjRgaISR8yk3NdDF25nU94T',
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => 'http://' . $domain . '/test?success=true',
                'cancel_url' => 'http://' . $domain . '/test?success=false',
            ]);
            Application::Redirect($checkout_session->url);
        }
        
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
    public function donation()
    {
        /* @var Campaign $campaign */
        $today = date("Y-m-d");
//        $conditions = ['Package_ID'];
        /* @var Sponsor $sponsor*/
        $sponsor = sponsor::findOne(['Sponsor_ID' => Application::$app->getUser()->getID()]);
        $sponPack = sponsorship_packages::findOne(['Package_ID' => $sponsor->getPackageID()]);
        $pri = $sponPack->getPackagePrice();
        $result = Campaign::RetrieveAll(false, [], false);
        //check sponsored Campaigns
        $confirmsponse = campaigns_sponsors::RetrieveAll(false,[],true,['Sponsor_ID' => Application::$app->getUser()->getID()]);
        $par = [];
        //initialize sponsored state
        $paid = 0;
        $params = [];
        foreach ($result as $campaign) {
            $packid = $campaign->getPackageID();
            $pack = sponsorship_packages::findOne(['Package_ID' => $packid]);
            $price = $pack->getPackagePrice();
            foreach ($confirmsponse as $con) {
                if ($con->getID() === $campaign->getCampaignID()) {
                    $paid = 1;
                }
            }
                if ($price <= $pri && $paid == 0 && $campaign->getCampaignDate() >= date("Y-m-d")) {
                    $params[] = [
                        'Campaign_Name' => $campaign->getCampaignName(),
                        'Campaign_Date' => $campaign->getCampaignDate(),
                        'Venue' => $campaign->getVenue(),
                        'Status' => $campaign->getStatus(),
                        'Campaign_ID' => $campaign->getCampaignID(),
                        'Package_Name' => $pack->getPackageName(),
                    ];
                } else {
                    $params = [];
                }

        }
        print_r($params);
        exit();
        return $this->render('sponsors/donation',$params);
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
        /* @var sponsorship_packages $para */
        $id = $_GET['id'];
        $campaign = Campaign::findOne(['Campaign_ID'=> $id]);
        $para = sponsorship_packages::findOne(['Package_ID'=>$campaign->getPackageID()]);

        $params= [
            'Campaign_Name'=> $campaign->getName(),
            'Campaign_Date' => $campaign->getDate(),
            'Venue'=> $campaign->getVenue(),
            'Status'=> $campaign->getStatus(),
            'Campaign_ID'=> $campaign->getID(),
            'id' => $id,
            'Package_Name' => $para->getPackageName(),
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

}