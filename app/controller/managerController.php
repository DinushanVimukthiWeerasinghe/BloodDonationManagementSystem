<?php

namespace App\controller;

use App\middleware\managerMiddleware;
use App\model\Authentication\Login;
use App\model\BloodBankBranch\BloodBank;
use App\model\Campaigns\Campaign;
use App\model\Email\Email;
use App\model\MedicalTeam\MedicalTeam;
use App\model\MedicalTeam\TeamMembers;
use App\model\Requests\BloodRequest;
use App\model\users\Donor;
use App\model\users\Manager;
use App\model\users\MedicalOfficer;
use App\model\users\Organization;
use App\model\users\Person;
use App\model\users\Sponsor;
use App\model\users\User;
use App\model\Utils\Notification;
use Core\Application;
use Core\BaseMiddleware;
use Core\Controller;
use Core\File;
use Core\middleware\AuthenticationMiddleware;
use Core\Request;
use Core\Response;
use PHPMailer\PHPMailer\Exception;

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

    public function AssignTeam(Request $request,Response $response): string
    {
        if ($request->isGet()){
            $campaignID=$request->getBody()['campId'];
            if ($campaignID){
                $ID=Application::$app->getUser()->getID();
                /* @var Manager $manager*/
                $manager = Application::$app->getUser();
                $page = $request->getBody()['page'] ?? 1;
                $limit = $request->getBody()['rpp'] ?? 15;
                $initial = ($page - 1) * $limit;
                $id=Application::$app->getUser()->getID();
                $total_rows = MedicalOfficer::getCount();
                $total_pages = ceil ($total_rows / $limit);
                $BloodBanks=BloodBank::RetrieveAll();
                $Campaign=Campaign::findOne(['Campaign_ID' => $campaignID]);
//                $Date=date('Y-m-d',strtotime($Campaign->getCampaignDate().'+1 day'));
                $Date=$Campaign->getCampaignDate();
                $Campaigns_On_Same_Date = Campaign::RetrieveAll(false, [], true, ['Campaign_Date' => $Date]);
                $Teams= [];
                foreach ($Campaigns_On_Same_Date as $campaign){
                    $Team=MedicalTeam::findOne(['Campaign_ID'=>$campaign->getCampaignID()]);
                    if ($Team){
                        $Teams[]=$Team;
                    }
                }
                $AssignedOfficersOnSameDate=[];
                if (count($Teams)>0){
                    foreach ($Teams as $team){
                        $members=TeamMembers::RetrieveAll(false,[],true,['Team_ID'=>$team->getTeamID()]);
                        foreach ($members as $member){
                            $ID=$member->getMemberID();
                            if (!in_array($ID,$AssignedOfficersOnSameDate)){
                                $AssignedOfficersOnSameDate[]=$member->getMemberID();
                            }

                        }
                    }
                }
                $MedicalOfiicers=[];
                if ($AssignedOfficersOnSameDate) {
                    $MedicalOfiicers = MedicalOfficer::RetrieveAvailableMedicalOfficer(false, [$initial, $limit], $AssignedOfficersOnSameDate);
                }
                else{
                    $MedicalOfiicers = MedicalOfficer::RetrieveAll(false, [$initial, $limit], true, ['Status' => MedicalOfficer::AVAILABLE_MEDICAL_OFFICER]);
                }
                /* @var $AssignedMedicalTeam MedicalTeam*/
                /* @var $members array*/
                /* @var $member MedicalOfficer*/
                $AssignedMedicalTeam=MedicalTeam::findOne(['Campaign_ID'=>$campaignID]);
                $AssignedMedicalOfficers=[];
                if ($AssignedMedicalTeam){
//                    echo '<pre>';
                    $members= TeamMembers::RetrieveAll(false,[],true,['Team_ID'=>$AssignedMedicalTeam->getTeamID()]);
                    foreach ($members as $value){
                        $member=MedicalOfficer::findOne(['Officer_ID'=>$value->getMemberID()]);
                        $AssignedMedicalOfficers[]=$member;
                    }
                }
                $params=[
                    'rpp'=>$limit,
                    'firstName'=>$manager->getFirstName(),
                    'lastName'=>$manager->getLastName(),
                    'data'=>$MedicalOfiicers,
                    'total_pages'=>$total_pages,
                    'current_page'=>$page,
                    'bloodBanks'=>$BloodBanks,
                    'AssignedMedicalOfficers'=>$AssignedMedicalOfficers,
                ];
                return $this->render('Manager/ManageCampaign/AssignMedicalTeam',$params);
            }

        }

    }

    public function AssignTeamMember(Request $request,Response $response)
    {
        $CampaignID=$request->getBody()['Campaign_ID'];
        $MemberID=$request->getBody()['Member_ID'];
        $Position=$request->getBody()['Position'] ?? 'Member';
        /* @var $MedicalTeam MedicalTeam */
        /* @var $MedicalOfficer MedicalOfficer */
        $MedicalTeam=MedicalTeam::findOne(['Campaign_ID' => $CampaignID]);
        $MedicalOfficer = MedicalOfficer::findOne(['Officer_ID' => $MemberID]);
        $Campaign=Campaign::findOne(['Campaign_ID'=>$CampaignID]);
        $AssignedCampaigns=$MedicalOfficer->getAssignedCampaignsDate();
        $CampaignDate=$Campaign->getCampaignDate();

//        print_r($CampaignDate);
//        print_r($AssignedCampaigns);
//        exit();
        if (!$MedicalOfficer){
            return json_encode(['status'=>false,'message'=>'Medical Officer Not Found !']);
        }
        if ($MedicalOfficer->getStatus() != MedicalOfficer::AVAILABLE_MEDICAL_OFFICER){
            return json_encode(['status'=>false,'message'=>'Medical Officer Not Available !']);
        }
        $TeamMember= new TeamMembers();
        if (!$MedicalTeam) {
            $MedicalTeam = new MedicalTeam();
            $MedicalTeam->generateTeamID();
            $MedicalTeam->setCampaignID($CampaignID);
            $ManagerID = Application::$app->getUser()->getID();
            $MedicalTeam->setAssignedBy($ManagerID);

            if (!($MedicalTeam->validate() && $MedicalTeam->save())) {
                return json_encode(['status' => false, 'message' => 'Error on Server', 'data' => $MedicalTeam->errors]);
            }
        }
        $IsAlreadyAssigned=TeamMembers::findOne(['Member_ID'=>$MemberID,'Team_ID'=>$MedicalTeam->getTeamID()],false);
        if ($IsAlreadyAssigned){
            return json_encode(['status'=>false,'message'=>'Medical Officer Already Assigned !']);
        }
        $MedicalTeam->setNoOfMembers($MedicalTeam->getNoOfMembers()+1);
        $MedicalTeam->update($MedicalTeam->getTeamID(),[],['No_Of_Member']);

        $TeamMember->setTeamID($MedicalTeam->getTeamID());
        $TeamMember->setMemberID($MemberID);
        $TeamMember->setPosition($Position);

        if ($TeamMember->validate() && $TeamMember->save()) {
//            $MedicalOfficer->setStatus(MedicalOfficer::ASSIGNED_FOR_TEAM);
//            $MedicalOfficer->update($MedicalOfficer->getOfficerID(), [], ['Status']);
            return json_encode(['status' => true, 'message' => 'Medical Team Assigned Successfully !']);
        }
        else{
            return json_encode(['status'=>false,'message'=>'Error on Server','data'=>$TeamMember->errors]);
        }



        $TeamMember->setTeamID($MedicalTeam->getTeamID());
        if($Position=='Leader'){
            $MedicalTeam->setTeamLeader($MemberID);
            $MedicalTeam->update($MedicalTeam->getTeamID(),[],['Team_Leader']);
            $TeamMember->setMemberID($MemberID);
            $TeamMember->setPosition($Position);
        }else if ($Position=='Member'){
            $TeamMember->setTeamID($MedicalTeam->getTeamID());
            $TeamMember->setMemberID($MemberID);
            $TeamMember->setPosition($Position);
        }else{
            return json_encode(['status'=>false,'message'=>'Assigned for the Team !']);
        }

    }

    public function RemoveTeamMember(Request $request,Response $response): bool|string
    {
        $CampaignID=$request->getBody()['Campaign_ID'];
        $MemberID=$request->getBody()['Member_ID'];
        /* @var $MedicalTeam MedicalTeam */
        /* @var $MedicalOfficer MedicalOfficer */
        $MedicalTeam=MedicalTeam::findOne(['Campaign_ID' => $CampaignID]);
        $MedicalOfficer = MedicalOfficer::findOne(['Officer_ID' => $MemberID]);
        if (!$MedicalOfficer){
            return json_encode(['status'=>false,'message'=>'Medical Officer Not Found !']);
        }
        if ($MedicalOfficer->getStatus() != MedicalOfficer::AVAILABLE_MEDICAL_OFFICER){
            return json_encode(['status'=>false,'message'=>'Medical Officer Not Assigned for the Team !']);
        }
        $TeamMember= TeamMembers::findOne(['Team_ID'=>$MedicalTeam->getTeamID(),'Member_ID'=>$MemberID]);
        if (!$TeamMember){
            return json_encode(['status'=>false,'message'=>'Medical Officer Not Assigned for the Team !']);
        }
        if ($TeamMember->delete(['Member_ID'=>$MemberID,'Team_ID'=>$MedicalTeam->getTeamID()])){
            $MedicalOfficer->setStatus(MedicalOfficer::AVAILABLE_MEDICAL_OFFICER);
            $MedicalOfficer->update($MedicalOfficer->getOfficerID(), [], ['Status']);
            return json_encode(['status' => true, 'message' => 'Medical Team Member Removed Successfully !']);
        }
        else{
            return json_encode(['status'=>false,'message'=>'Error on Server','data'=>$TeamMember->errors]);
        }
    }

    public function ViewCampaign(Request $request, Response $response): string
    {
        if ($request->isPost()){
            $id=$request->getBody()['id'];
            /* @var $campaign Campaign*/
            $campaign = Campaign::findOne(['Campaign_ID' => $id]);
            $Org_ID=$campaign->getOrganizationID();
            $Org=Organization::findOne(['Organization_ID' => $Org_ID]);
            if ($campaign){
                return json_encode(['status'=>true,'data'=>$campaign->toArray(),'org'=>$Org->toArray()]);
            }
        }
//        return $this->render('Manager/viewCampaign');
    }

    public function RejectCampaign(Request $request, Response $response): string
    {
        if ($request->isPost()){
            $id=$request->getBody()['id'];
            /* @var $campaign Campaign*/
            $campaign = Campaign::findOne(['Campaign_ID' => $id]);
            if ($campaign){
                $campaign->setVerifiedBy(Application::$app->getUser()->getID());
                $campaign->setVerifiedAt(date('Y-m-d H:i:s'));
                $campaign->setStatus(Campaign::REJECTED);
                $campaign->update($campaign->getCampaignID(),['Assigned_Team']);
                return json_encode(['status'=>true]);
            }
        }
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
//        $limit = 15;
        $page = $request->getBody()['page'] ?? 1;
        $limit = $request->getBody()['rpp'] ?? 15;
        $initial = ($page - 1) * $limit;
        $id=Application::$app->getUser()->getID();
        $total_rows = MedicalOfficer::getCount();
        $total_pages = ceil ($total_rows / $limit);
        $BloodBanks=BloodBank::RetrieveAll();

        $medicalOfficers=MedicalOfficer::RetrieveAll(true,[$initial,$limit]);
        $params=[
            'rpp'=>$limit,
            'firstName'=>$manager->getFirstName(),
            'lastName'=>$manager->getLastName(),
            'data'=>$medicalOfficers,
            'total_pages'=>$total_pages,
            'current_page'=>$page,
            'bloodBanks'=>$BloodBanks,
        ];
        return $this->render('Manager/mngMedicalOfficer',$params);
    }

    public function AddMedicalOfficer(Request $request, Response $response):string
    {
        $medicalOfficer=new MedicalOfficer();
        if (Application::$app->request->isPost()){
            $medicalOfficer->loadData($request->getBody());
            $medicalOfficer->setID('MO_' . rand(1000, 999999));
            $medicalOfficer->setStatus(1);
            $medicalOfficer->setGenderFromNIC();
            $medicalOfficer->setJoinedAt(date('Y-m-d H:i:s'));
            $file=new File($_FILES['image'],'Profile/MedicalOfficer');
            $fileName=$file->GenerateFileName('MO');
            $medicalOfficer->setProfileImage($fileName);
            $hash = password_hash($medicalOfficer->getNIC(), PASSWORD_DEFAULT);
//            print_r($medicalOfficer);

            if ($medicalOfficer->validate()) {
                $user= new User();
                $user->setUid($medicalOfficer->getID());
                $user->setPassword($hash);
                $user->setEmail($medicalOfficer->getEmail());
                $user->setRole(User::MEDICAL_OFFICER);
                if ($user->validate() && $user->save() && $medicalOfficer->save()){
                    $file->saveFile();
                    Application::$app->session->setFlash('success', 'Successfully Added Medical Officer!');
                    return json_encode(['status' => true, 'message' => 'Successfully Added Medical Officer!']);
                }else{
                    return json_encode(['status' => false, 'message' => 'Failed to Add Medical Officer!', 'errors' => $user->errors]);
                }

            } else {
                return json_encode(['status' => false, 'message' => 'Failed to Add Medical Officer!', 'errors' => $medicalOfficer->errors]);
            }
        }
    }

    /**
     * @throws Exception
     */
    public function SendEmail(Request $request, Response $response):string
    {
        if ($request->isPost()) {
            $id = $request->getBody()['Officer_ID'];
            $medicalOfficer = MedicalOfficer::findOne(['Officer_ID' => $id]);

            $email = $medicalOfficer->getEmail();

            $subject = $request->getBody()['subject'];
            $message = $request->getBody()['message'];
            /* @var $attachment File*/
            $attachment = $request->getBody()['attachment'] ?? null;
//            TODO : Attachment Thing


    //        $file=new File($attachment,'Emails');
            $mail = Application::$app->email;
            $mail->setTo($email);
            $mail->setSubject($subject);
            $mail->setBody($message);
            $mail->setFrom('bdmsgroupcs46@gmail.com');
            $EmailRecord=new Email();
            $EmailRecord->setReceiver($email);
            $EmailRecord->setSender($id);
            $EmailRecord->setSubject($subject);
            $EmailRecord->setBody($message);
            $EmailRecord->setEmailType(EMAIL::NORMAL_EMAIL);
            $EmailRecord->setEmailStatus(Email::EMAIL_PENDING);
            $EmailRecordId=uniqid('EA_');
            $EmailRecord->setEmailID($EmailRecordId);
            if ($EmailRecord->validate()) {
                if ($attachment && $attachment->getFileName() != '') {
                    $attachment->GenerateFileName('Email/' . $EmailRecordId);
                    $attachment->saveFile();
                    $AttachmentName =Application::$ROOT_DIR . $attachment->getFileName();
                    $mail->addAttachment($AttachmentName);
                    $EmailRecord->setAttachment($AttachmentName);
                }
                try {
//                    $mail->send();
                    $EmailRecord->setEmailStatus(Email::EMAIL_SENT);
                    if ($mail->send()):
                        if ($EmailRecord->save()):
//                        Application::$app->session->setFlash('success', 'Successfully Sent Email!');
                            return json_encode(['status' => true, 'message' => 'Successfully Sent Email!']);
                        else:
//                        Application::$app->session->setFlash('error', 'Failed to Send Email!');
                            return json_encode(['status' => false, 'message' => 'Failed to Send Email!']);
                        endif;
                        else:
//                        Application::$app->session->setFlash('error', 'Failed to Send Email!');
                        return json_encode(['status' => false, 'message' => 'Failed to Send Email!']);
                    endif;

                } catch (Exception $e) {
                    Application::$app->session->setFlash('error', 'Failed to Send Email!');
                    return json_encode(['status' => false, 'message' => 'Failed to Send Email!']);
                }
            }else{
                return json_encode(['status' => false, 'message' => 'Please Fill Required Information', 'errors' => $EmailRecord->errors]);
            }
        }
        return json_encode(['status' => false, 'message' => 'Failed to Send Emails!']);
    }


    public function UpdateMedicalOfficer(Request $request, Response $response):string
    {
        if (Application::$app->request->isPost()){
            $id=$request->getBody()['Officer_ID'];
            $medicalOfficer=MedicalOfficer::findOne(['Officer_ID'=>$id]);
            $medicalOfficer->loadData($request->getBody());
            $medicalOfficer->setStatus(1);
            $file=new File($_FILES['image'],'Profile/MedicalOfficer');
            $fileName=$file->GenerateFileName('MO');
            $medicalOfficer->setProfileImage($fileName);
//            $hash = password_hash($medicalOfficer->getNIC(), PASSWORD_DEFAULT);

            if ($medicalOfficer->validate(true) && $medicalOfficer->update($id)) {
                $file->saveFile();
                Application::$app->session->setFlash('success', 'Successfully Added Medical Officer!');
                return json_encode(['status' => true, 'message' => 'Successfully Updated Medical Officer!']);
            } else {
                return json_encode(['status' => false, 'message' => 'Failed to Add Medical Officer!', 'errors' => $medicalOfficer->errors]);
            }
        }
    }


    public function ViewMedicalOfficer(Request $request, Response $response)
    {
        if ($request->isPost()){
            $Officer_ID=$request->getBody()['Medical_Officer_ID'];
            $medicalOfficer=MedicalOfficer::findOne(['Officer_ID'=>$Officer_ID]);
            if ($medicalOfficer){
                return json_encode(['status'=>true,'data'=>$medicalOfficer->toArray()]);
            }else{
                return json_encode(['status'=>false,'message'=>'Medical Officer Not Found!']);
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
        $data= Donor::RetrieveAll();
        return $this->render('Manager/ManageDonors',
        [
            'data'=>$data
        ]);
    }

    public function DeleteMedicalOfficer(Request $request,Response $response)
    {
        if ($request->isPost()){
            $id=$request->getBody()['id'];
            $medicalOfficer=MedicalOfficer::findOne(['Officer_ID'=>$id]);
            if ($medicalOfficer){
                $medicalOfficer->setStatus(Person::USER_DELETED);
                $medicalOfficer->update($medicalOfficer->getID());
                return json_encode(['status'=>true,'message'=>'Successfully Deleted Medical Officer!']);
            }
            return json_encode(['status'=>false,'message'=>'Medical Officer Not Found!']);
        }

    }


    public function ManageCampaigns(): string
    {
        $data= Campaign::RetrieveAll();
        $total_pages=1;
        $current_page=1;
        return $this->render('Manager/ManageCampaigns',
            [
                'total_pages'=>$total_pages,
                'current_page'=>$current_page,
                'data'=>$data
            ]);
    }
    public function ManageReport(): string
    {
        return $this->render('Manager/ManageReports');
    }

    public function SearchMedicalOfficer(Request $request, Response $response): string
    {
        $type = $request->getBody()['type'] ?? 'none';
        $search=$request->getBody()['q'];
        $search=str_replace(' ','%',$search);

        /* @var Manager $manager*/
        $manager = Application::$app->getUser();
        $limit = 14;
        $page = $request->getBody()['page'] ?? 1;
        $initial = ($page - 1) * $limit;
        $id=Application::$app->getUser()->getID();

        $total_rows = MedicalOfficer::getCount(true,['NIC'=>$search]);
        $total_pages = ceil ($total_rows / $limit);
        $medicalOfficers=MedicalOfficer::Search(['NIC'=>$search,'First_Name'=>$search,'Last_Name'=>$search,'Position'=>$search,'Email'=>$search],[],[$initial,$limit]);
        $params=[
            'type'=>$type,
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
    public function SearchMedicalOfficerForTeam(Request $request, Response $response): string
    {
        $type = $request->getBody()['type'] ?? 'none';
        $search=$request->getBody()['q'];
        $search=str_replace(' ','%',$search);

        /* @var Manager $manager*/
        $manager = Application::$app->getUser();
        $limit = 14;
        $page = $request->getBody()['page'] ?? 1;
        $initial = ($page - 1) * $limit;
        $id=Application::$app->getUser()->getID();

        $total_rows = MedicalOfficer::getCount(true,['NIC'=>$search]);
        $total_pages = ceil ($total_rows / $limit);
        $medicalOfficers=MedicalOfficer::Search(['NIC'=>$search,'First_Name'=>$search,'Last_Name'=>$search,'Position'=>$search,'Email'=>$search],['Status'=>MedicalOfficer::AVAILABLE_MEDICAL_OFFICER],[$initial,$limit]);
        $params=[
            'type'=>$type,
            'firstName'=>$manager->getFirstName(),
            'lastName'=>$manager->getLastName(),
            'data'=>$medicalOfficers,
            'total_pages'=>$total_pages,
            'current_page'=>$page,
            'q'=>$search
        ];
        $this->layout="none";

        return $this->render('Manager/ManageCampaign/SearchMedicalOfficerTeamAssign',$params);
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