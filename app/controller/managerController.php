<?php

namespace App\controller;

use App\middleware\managerMiddleware;
use App\model\Requests\BloodRequest;
use App\model\users\Donor;
use App\model\users\Manager;
use App\model\users\MedicalOfficer;
use App\model\users\Sponsor;
use App\model\Utils\Notification;
use Core\Application;
use Core\BaseMiddleware;
use Core\Controller;
use Core\File;
use Core\middleware\AuthenticationMiddleware;
use Core\Request;
use Core\Response;

class managerController extends Controller
{

    public function __construct()
    {
        $this->setLayout('Manager');
        $this->registerMiddleware(new managerMiddleware(['dashboard'], BaseMiddleware::FORBIDDEN_ROUTES));
//        $this->registerMiddleware(new ManagerMiddleware());
    }

    public function Profile()
    {
        $user=Application::$app->getUser();
        return $this->render('Manager/profile',['user'=>$user]);
    }
    public function dashboard(): string
    {
        /* @var Manager $manager*/
        $manager = Manager::findOne(['Manager_ID' => Application::$app->getUser()->getID()]);
        $params=[
            'firstName'=>$manager->getFirstName(),
            'lastName'=>$manager->getLastName()
        ];
        return $this->render('Manager/managerBoard',$params);
    }

    public function ViewCampaign()
    {

        return $this->render('Manager/viewCampaign');
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

    public function ManageMedicalOfficer(Request $request, Response $response): string
    {
        $ID=Application::$app->getUser()->getID();

        /* @var Manager $manager*/
        $manager = Application::$app->getUser();
        $limit = 14;
        $page = $request->getBody()['page'] ?? 1;
        $initial = ($page - 1) * $limit;
        $id=Application::$app->getUser()->getID();
        $total_rows = MedicalOfficer::getCount();
        $total_pages = ceil ($total_rows / $limit);

        $medicalOfficers=MedicalOfficer::RetrieveAll(true,[$initial,$limit]);
        $params=[
            'firstName'=>$manager->getFirstName(),
            'lastName'=>$manager->getLastName(),
            'data'=>$medicalOfficers,
            'total_pages'=>$total_pages,
            'current_page'=>$page
        ];
        return $this->render('Manager/mngMedicalOfficer',$params);
    }

    public function AddMedicalOfficer(Request $request, Response $response):string
    {
        $medicalOfficer=new MedicalOfficer();
        if (Application::$app->request->isPost()){
            $medicalOfficer->loadData($request->getBody());
            $medicalOfficer->setID('Mof' . rand(1000, 999999));
            $medicalOfficer->setStatus(1);
            $file=new File($_FILES['image'],'Profile/MedicalOfficer');
            $fileName=$file->GenerateFileName('MO');
            $medicalOfficer->setProfileImage($fileName);
            $hash = password_hash($medicalOfficer->getNIC(), PASSWORD_DEFAULT);
            if ($medicalOfficer->validate() && $medicalOfficer->save()) {
                $file->saveFile();
                Application::$app->session->setFlash('success', 'Successfully Added Medical Officer!');
                $response->redirect('/manager/mngMedicalOfficer');
            } else {
                print_r($medicalOfficer->errors);
                exit();
            }
        }
        return $this->render('Manager/ManageMOfficer/addMedicalOfficer', [
            'model' => $medicalOfficer
        ]);
    }


    public function ViewMedicalOfficer(Request $request, Response $response)
    {
        if ($request->isGet()){
            $medicalOfficer=MedicalOfficer::findOne(['Officer_ID'=>$request->getBody()['id']]);
            if (Application::$app->session->get('ID')){
                Application::$app->session->remove('ID');
            }
            Application::$app->session->setPermanant('ID',$medicalOfficer->getID());
            return $this->render('Manager/ManageMOfficer/viewMedicalOfficer', [
                'model' => $medicalOfficer
            ]);
        }
        if ($request->isPost()){
            $Officer_ID=Application::$app->session->get('ID');
            $medicalOfficer=MedicalOfficer::findOne(['ID'=>$Officer_ID]);
            $medicalOfficer->loadData($request->getBody());

            if ($medicalOfficer->validate(true) && $medicalOfficer->update($Officer_ID)){
                Application::$app->session->setFlash('success','Successfully Updated Medical Officer!');
                $response->redirect('/manager/mngMedicalOfficer?update=true');
            }
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

    public function ManageSponsors()
    {
        $Sponsors=Sponsor::RetrieveAll();
        $params=[
            'data'=>$Sponsors
        ];
        return $this->render('Manager/ManageSponsors',$params);
    }

    public function ManageRequests(Request $request,Response $response): string
    {
        $limit = 2;
        $page = $request->getBody()['page'] ?? 1;
        if (intval($page)<0){
            $page=1;
        }
        $initial = ($page - 1) * $limit;
        $id=Application::$app->getUser()->getID();
        $total_rows = MedicalOfficer::getCount();
        $total_pages = ceil ($total_rows / $limit);
        if ($total_pages<$page){
            $page=1;
            $initial = ($page - 1) * $limit;
            $id=Application::$app->getUser()->getID();
            $total_rows = MedicalOfficer::getCount();
            $total_pages = ceil ($total_rows / $limit);
        }

        $requests=BloodRequest::RetrieveAll(true,[$initial,$limit]);
        return $this->render('Manager/ManageRequests',[
            'data'=>$requests,
            'total_pages'=>intval($total_pages),
            'current_page'=>intval($page)
        ]);
    }

    public function FindRequest(Request $request,Response $response)
    {
        if ($request->isPost()){
            $Request_ID=$request->getBody()['id'];
            if ($Request_ID):
                $BloodRequest=BloodRequest::findOne(['Request_ID'=>$Request_ID]);
            if ($BloodRequest){
//                TODO ADD data to the array
                $data=[
                    'success'=>true,
                    'data'=>[
                        'id'=>$BloodRequest->getRequestID(),
                        'hospital'=>'Hospital',
                        'bloodGroup'=>$BloodRequest->getBloodGroup(),
                        'Urgency'=>'Urgency',
                        'Contact'=>'Contact',
                        'type'=>'type',
                    ]
                ];
                return json_encode($data);
            }

            endif;

        }
    }

    public function ManageDonors(): string
    {
        return $this->render('Manager/ManageDonors');
    }


    public function ManageCampaigns(): string
    {
        return $this->render('Manager/ManageCampaigns');
    }
    public function ManageReport(): string
    {
        return $this->render('Manager/ManageReports');
    }

    public function SearchMedicalOfficer(Request $request, Response $response): string
    {
        $search=$request->getBody()['q'];

        /* @var Manager $manager*/
        $manager = Application::$app->getUser();
        $limit = 14;
        $page = $request->getBody()['page'] ?? 1;
        $initial = ($page - 1) * $limit;
        $id=Application::$app->getUser()->getID();

        $total_rows = MedicalOfficer::getCount(true,['NIC'=>$search]);
        $total_pages = ceil ($total_rows / $limit);
        $medicalOfficers=MedicalOfficer::Search(['NIC'=>$search,'First_Name'=>$search,'Position'=>$search],[],[$initial,$limit]);

//        $medicalOfficers=medicalOfficer::RetrieveAll(true,[$initial,$limit]);
        $params=[
            'firstName'=>$manager->getFirstName(),
            'lastName'=>$manager->getLastName(),
            'data'=>$medicalOfficers,
            'total_pages'=>$total_pages,
            'current_page'=>$page,
            'q'=>$search
        ];
        $this->layout="none";

        return $this->render('Manager/SearchMedicalOfficer',$params);
    }

    public function IsDonorExist(Request $request,Response $response): bool|string
    {
        $NIC = $request->getBody()['nic'];
        $Donor=Donor::findOne(['NIC'=>$NIC]);
        if ($Donor){
            return json_encode(['status'=>true,'message'=>'Donor Found!']);
        }
        return json_encode(['status'=>false,'message'=>'Donor Not Found!']);
    }

    public function ReportedDonor(Request $request,Response $response): string
    {
        $q=$request->getBody()['q'] ?? '';
        if ($q){
            $Donors=Donor::ReportedDonors($q);
            return $this->render('Manager/ManageDonor/reportedDonors',['data'=>$Donors]);
        }
        $Donors=Donor::ReportedDonors();
        return $this->render('Manager/ManageDonor/reportedDonors',['data'=>$Donors]);
    }

    public function InformDonor(Request $request,Response $response): string
    {
        if ($request->isPost()){
            $body=$request->getBody();
            $title=$body['title'];
            $message=$body['message'];
            $validUntill=$body['valid_until'] ?? null;
            $group=$body['group'];
            $targetBloodType='all';
            if (strtolower($group)==='custom'){
                $targetBloodType=$body['TargetBloodType'];
                Donor::InformDonors(['title'=>$title,'message'=>$message,'valid_until'=>$validUntill,'Target_Group'=>$targetBloodType]);
                Application::$app->session->setFlash('success','Notification Sent');
                Application::Redirect('/manager/mngDonors');
            }else{
                Donor::InformDonors(['title'=>$title,'message'=>$message,'valid_until'=>$validUntill,'Target_Group'=>$group]);
                Application::$app->session->setFlash('success','Notification Sent');
                Application::Redirect('/manager/mngDonors');
            }
        }
        return $this->render('Manager/ManageDonor/informDonor');
    }

    public function FindDonor(Request $request,Response $response): bool|string
    {
        $NIC = $request->getBody()['nic'];
        $format = $request->getBody()['format'] ?? 'html';
        /* @var  $Donor Donor*/
        $Donor = Donor::findOne(['NIC' => $NIC]);
        if (strtolower($format) === 'json'){
            if ($Donor){
                return json_encode(['status'=>200,'name'=>$Donor->getFullName()]);
            }else{
                return json_encode(['status'=>500,'message'=>'No Donor Found']);
            }
        }
        //Get the Donor Information
//        $this->layout="none";
        return $this->render('Manager/ManageDonor/findDonor', ['data' => $Donor]);
    }

    public function ManageEmergencyRequests()
    {
//        $EmergencyRequests=EmergencyRequest::RetrieveAll();
        return $this->render('Manager/ManageRequest/EmergencyRequest');
    }
}