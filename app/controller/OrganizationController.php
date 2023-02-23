<?php

namespace App\controller;

use App\middleware\organizationMiddleware;
use App\model\Authentication\Login;
use App\model\Requests\AttendanceAcceptedRequest;
use App\model\users\organization;
use App\model\Campaigns\Campaign;
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

       Application::$app->session->setFlash('success','Welcome Back!'.' '.$organization->getOrganizationName().' '.'Organization');
        return $this->render('Organization/organizationBoard',$params);
    }

    public function manage()
    {
        $ID=Application::$app->getUser()->getID();
        $AlreadyCreatedCampaign=Campaign::findOne(['Organization_ID'=>$ID,'Status'=>Campaign::PENDING]);
        $Exist=false;
        if ($AlreadyCreatedCampaign){
            $Exist=true;
        }
        return $this->render('Organization/manage',[
            'campaign_exist'=>$Exist
        ]);
    }

    public function CreateCampaign(Request $request,Response $response)
    {
        $campaign = new Campaign();
        if($request->isPost()){
            $campaign->loadData($request->getBody());
            $campaign->setOrganizationID(Application::$app->getUser()->getID());
            $campaign->setCampaignDate(date("Y-m-d H:i:s"));
            $campaign->setStatus(Campaign::PENDING);
            $campaign->setCreatedAt(date("Y-m-d H:i:s"));
            $id = uniqid("Camp_");
            $campaign->setCampaignID($id);
            if($campaign->validate() && $campaign->save()) {
                    $response->redirect('/organization/history');
            }else{
                print_r($campaign->errors);
            }

        }
        Application::$app->session->setFlash('success','You Successfully Created a Campaign! Please Wait for the Admin Approval.');
        return $this->render('Organization/create');
    }

    public function ViewCampaign(Request $request,Response $response)
    {
        print_r("ViewCampaign");
    }

    public function near()
    {
        /* @var Campaign $campaign */
        $result = Campaign::RetrieveAll(false, [], true,['Nearest_City'=>Application::$app->getUser()->getCity()]);
        $result =array_filter($result,function ($campaign){
            return $campaign->getStatus() === Campaign::APPROVED;
        });
        return $this->render('Organization/near',['data'=>$result]);
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
//        $campaign = Campaign::findOne(['Organization_ID' => $_SESSION['Email']]);
//        $params=[
//            'Campaign_Name'=> $campaign->getName(),
//            'Campaign_Date' => $campaign->getDate(),
//
//        ];
        return $this->render('Organization/history',['data'=>$result]);
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

        return $this->render('Organization/guideline');
    }
    public function view()
    {
        /* @var Campaign $campaign */
        $ID = Application::$app->getUser()->getID();
        $result = Campaign::RetrieveAll(false, [], true, ['Organization_ID' => $ID]);

        return $this->render('Organization/campaign/view',['data'=>$result]);
    }
    public function campDetails()
    {
        /* @var Campaign $campaign */
        $Campaign = Campaign::findOne(['Organization_ID' => Application::$app->getUser()->getID()]);
        if ($Campaign){
            $id=$Campaign->getCampaignID();
            $campaign = Campaign::findOne(['Campaign_ID'=> $id]);
            return $this->render('Organization/campDetails',['campaign'=>$campaign]);
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

}
