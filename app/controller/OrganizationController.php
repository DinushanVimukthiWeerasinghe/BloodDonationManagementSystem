<?php

namespace App\controller;

use App\model\Authentication\Login;
use App\model\users\organization;
use App\model\Campaigns\campaigns;
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

//    public function __construct()
//    {
//        $this->setLayout('Manager');
//        $this->registerMiddleware(new AuthenticationMiddleware(['login','register'], BaseMiddleware::ALLOWED_ROUTES));
////        $this->registerMiddleware(new ManagerMiddleware());
//    }

    public function profile()
    {
        $user=Application::$app->getUser();
        return $this->render('organization/profile',['user'=>$user]);
    }



    public function register(Request $request,Response $response ): string
    {
        $organization=new organization();
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
        /* @var organization $organization*/
        $organization = organization::findOne(['Organization_ID' => Application::$app->getUser()->getID()]);
//        print_r(Application::$app->getUser());
//        exit();
       $params=[
            'organization_Name'=> $organization->getName()
        ];

       Application::$app->session->setFlash('success','Welcome Back!'.' '.$organization->getName().' '.'Organization');
        return $this->render('Organization/organizationBoard',$params);
    }

    public function manage()
    {

        return $this->render('Organization/manage');
    }

    public function create(Request $request,Response $response)
    {
        $campaign = new campaigns();
        if($request->isPost()){
            $campaign->setOrganizationID(Application::$app->getUser()->getID());
            $campaign->setStatus(1);
            $id = uniqid("Camp_");
            $campaign->setCampaignID($id);
            $campaign->loadData($request->getBody());
//            print_r($campaign);
//            exit();
            if($campaign->validate() && $campaign->saver()) {
                    $response->redirect('/organization/history');
            }else{
                print_r($campaign->errors);
            }

        }
        Application::$app->session->setFlash('success','You Successfully Created a Campaign! Please Wait for the Admin Approval.');
        return $this->render('Organization/create');
    }
    public function near()
    {
        /* @var campaigns $campaign */
        $result = campaigns::RetrieveAll(false, [], false);
        foreach ($result as $campaign) {
            $params[] = [
                'Campaign_Name'=> $campaign->getName(),
                'Campaign_Date' => $campaign->getDate(),
                'Venue'=> $campaign->getVenue(),
                'Campaign_Date'=> $campaign->getDate(),
                'Status'=> $campaign->getStatus(),
                'Campaign_ID'=> $campaign->getID(),
            ];
        }

        return $this->render('Organization/near',$params);
    }
    public function report()
    {

        return $this->render('Organization/report');
    }
    public function history()
    {
        /* @var campaigns $campaign */
        $conditions = ['Organization_ID' => $_SESSION['Email']];
        $result = campaigns::RetrieveAll(false, [], true, $conditions);
//        $campaign = campaigns::findOne(['Organization_ID' => $_SESSION['Email']]);
//        $params=[
//            'Campaign_Name'=> $campaign->getName(),
//            'Campaign_Date' => $campaign->getDate(),
//
//        ];
        $params = [];
        foreach ($result as $campaign) {
            $params[] = [
                'Campaign_Name'=> $campaign->getName(),
                'Campaign_Date' => $campaign->getDate(),
                'Venue'=> $campaign->getVenue(),
                'Campaign_Date'=> $campaign->getDate(),
                'Status'=> $campaign->getStatus(),
                'Campaign_ID'=> $campaign->getID(),
            ];
        }

        return $this->render('Organization/history',$params);
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
        return $this->render('Organization/accepted');
    }
    public function guideline()
    {

        return $this->render('Organization/guideline');
    }
    public function campDetails()
    {
        /* @var campaigns $campaign */
        $id = $_GET['id'];
        $campaign = campaigns::findOne(['Campaign_ID'=> $id]);
        $params= [
            'Campaign_Name'=> $campaign->getName(),
            'Campaign_Date' => $campaign->getDate(),
            'Venue'=> $campaign->getVenue(),
            'Campaign_Date'=> $campaign->getDate(),
            'Status'=> $campaign->getStatus(),
            'Campaign_ID'=> $campaign->getID(),
        ];


        return $this->render('Organization/campDetails',$params);
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
