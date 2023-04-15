<?php

namespace App\controller;

use App\middleware\managerMiddleware;
use App\model\Authentication\Login;
use App\model\Blood\BloodGroup;
use App\model\BloodBankBranch\BloodBank;
use App\model\Campaigns\ApprovedCampaigns;
use App\model\Campaigns\Campaign;
use App\model\Campaigns\RejectedCampaign;
use App\model\Email\Email;
use App\model\MedicalTeam\MedicalTeam;
use App\model\MedicalTeam\TeamMembers;
use App\model\Notification\DonorNotification;
use App\model\Notification\ManagerNotification;
use App\model\Notification\MedicalOfficerNotification;
use App\model\Notification\OrganizationNotification;
use App\model\Requests\BloodRequest;
use App\model\Requests\SponsorshipRequest;
use App\model\sponsor\SponsorshipPackages;
use App\model\users\Donor;
use App\model\users\Hospital;
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

    public function Profile(): string
    {
        $user=Application::$app->getUser();
        return $this->render('Manager/profile',['user'=>$user]);
    }
    public function dashboard(): string
    {
        /* @var Manager $manager*/
        $manager = Manager::findOne(['Manager_ID' => Application::$app->getUser()->getID()]);
        $params=[
            'page'=>'dashboard',
            'firstName'=>$manager->getFirstName(),
            'lastName'=>$manager->getLastName()
        ];
        return $this->render('Manager/managerBoard',$params);
    }

    public function ManageNotification(Request $request,Response $response): bool|string
    {
        if ($request->isPost()){
            $Notifications=ManagerNotification::RetrieveAll(false,[],true,['Target_ID'=>Application::$app->getUser()->getId()],['Notification_Date'=>'ASC']);
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
        return "";
    }

    public function AssignTeam(Request $request,Response $response)
    {
        if ($request->isGet()){
            $campaignID=$request->getBody()['campId'];
            if ($campaignID){
                $BranchID=Application::$app->getUser()->getBloodBankID();
                $ID=Application::$app->getUser()->getID();
                /* @var Manager $manager*/
                $manager = Application::$app->getUser();
                $page = $request->getBody()['page'] ?? 1;
                $limit = $request->getBody()['rpp'] ?? 15;
                $initial = ($page - 1) * $limit;
                /* @var Manager $user*/
                $user=Application::$app->getUser();
                $id=$user->getID();
//                $BranchID=$user->getBranchID();
                $total_rows = MedicalOfficer::getCount(false,['Branch_ID'=>$BranchID]);
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
                    $MedicalOfiicers = MedicalOfficer::RetrieveAll(true, [$initial, $limit], true, ['Status' => MedicalOfficer::AVAILABLE_MEDICAL_OFFICER,'Branch_ID'=>$BranchID]);
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
                    'Campaign_ID'=>$campaignID,
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
            else{
                Application::Redirect('/manager/mngCampaigns');
            }

        }

    }

    public function SupplyBloodRequest(Request $request,Response $response)
    {
        if ($request->isPost()){
            $Request_ID=$request->getBody()['Request_ID'];
            $Remarks=$request->getBody()['Remarks'];
            $BloodBankID=Application::$app->getUser()->getBloodBankID();
            $BloodBank=BloodBank::findOne(['BloodBank_ID'=>$BloodBankID]);
            /* @var $BloodBank BloodBank*/
            $BloodBankName=$BloodBank->getBankName();
            /* @var $Request BloodRequest*/
            $Request = BloodRequest::findOne(['Request_ID' => $Request_ID]);
            if($Request){
                $Request->setAction(BloodRequest::REQUEST_STATUS_FULFILLED);
                $Request->setRemarks($Remarks);
                $Request->setFullFilledBy($BloodBankName);
                $Request->update($Request_ID,[],['Action','Remarks','FullFilledBy']);
                return json_encode(['status'=>true,'message'=>'Request Fulfilled Successfully !']);
            }
        }

    }

    public function AssignTeamLeader(Request $request,Response $response)
    {
        if ($request->isPost()){
            $CampaignID=$request->getBody()['campId'];
            $TeamLeaderID=$request->getBody()['teamLeaderId'];
            if ($CampaignID && $TeamLeaderID){
                /** @var MedicalTeam $MedicalTeam*/
                /** @var TeamMembers $TeamMember*/
                $MedicalTeam=MedicalTeam::findOne(['Campaign_ID'=>$CampaignID]);
                if ($MedicalTeam){
                    $TeamMember = TeamMembers::findOne(['Team_ID' => $MedicalTeam->getTeamID(), 'Member_ID' => $TeamLeaderID],false);
                    if ($TeamMember){
                        if ($TeamMember->getPosition() == MedicalTeam::TEAM_LEADER){
                            return json_encode(['status'=>false,'message'=>'This Officer is already Team Leader !']);
                        }
                        if ($MedicalTeam->getTeamLeader()){
                            $PreviousLeader=TeamMembers::findOne(['Team_ID'=>$MedicalTeam->getTeamID(),'Member_ID'=>$MedicalTeam->getTeamLeader()],false);
                            $PreviousLeader->setPosition(MedicalTeam::TEAM_MEMBER);
                            $PreviousLeader->update($PreviousLeader->getTeamID(),[],['Position'],['Member_ID'=>$PreviousLeader->getMemberID()]);
                        }
                        $TeamMember->setPosition(MedicalTeam::TEAM_LEADER);
                        $TeamMember->update($TeamMember->getTeamID(),[],['Position'],['Member_ID'=>$TeamLeaderID]);
                        $MedicalTeam->setTeamLeader($TeamLeaderID);
                        $MedicalTeam->update($MedicalTeam->getTeamID(),[],['Team_Leader']);
                        return json_encode(['status'=>true,'message'=>'Team Leader Assigned Successfully !']);
                    }

                }
                else{
                    return json_encode(['status'=>false,'message'=>'No Team Found !']);
                }
            }
            else{
                return json_encode(['status'=>false,'message'=>'Invalid Request !']);
            }
        }
    }

    public function getTeamMembers(Request $request,Response $response)
    {
        if ($request->isPost()){
            $CampaignID=$request->getBody()['campId'];
            $MedicalTeam = MedicalTeam::findOne(['Campaign_ID' => $CampaignID]);
            if ($MedicalTeam){
                $TeamMembers=TeamMembers::RetrieveAll(false,[],true,['Team_ID'=>$MedicalTeam->getTeamID()]);
                $TeamMembers=array_map(function ($object){
                    $object->Name=$object->getMember()->getFirstName().' '.$object->getMember()->getLastName();
                    $object->NIC=$object->getMember()->getNIC();
                    return $object->toArray();
                },$TeamMembers);
                return json_encode(['status'=>true,'data'=>$TeamMembers]);
            }
            else{
                return json_encode(['status'=>false,'message'=>'No Team Members Found !']);
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

    public function ViewCampaign(Request $request, Response $response)
    {
        if ($request->isPost()){
            $id=$request->getBody()['id'];
            /* @var $campaign Campaign*/
            $campaign = Campaign::findOne(['Campaign_ID' => $id]);
            $Org_ID=$campaign->getOrganizationID();
            $Org=Organization::findOne(['Organization_ID' => $Org_ID]);

            if ($campaign){
                if ($campaign->IsVerified()){
                    $ApprovedDetails = ApprovedCampaigns::findOne(['Campaign_ID' => $id]);
                    return json_encode(['status'=>true,'data'=>$campaign->toArray(),'org'=>$Org->toArray(),'approved'=>$ApprovedDetails->toArray()]);
                }
                if ($campaign->IsRejected()){
                    $RejectedDetails = RejectedCampaign::findOne(['Campaign_ID' => $id]);
                    return json_encode(['status'=>true,'data'=>$campaign->toArray(),'org'=>$Org->toArray(),'rejected'=>$RejectedDetails->toArray()]);
                }
                return json_encode(['status'=>true,'data'=>$campaign->toArray(),'org'=>$Org->toArray()]);
            }
        }
//        return $this->render('Manager/viewCampaign');
    }

    public function AcceptCampaign(Request $request, Response $response)
    {
        if ($request->isPost()){
            $id=$request->getBody()['id'];
            $remarks=$request->getBody()['remarks'] ?? 'No remarks';
            /* @var $campaign Campaign*/
            $campaign = Campaign::findOne(['Campaign_ID' => $id]);
            if ($campaign){
                $ApprovedCampaign = new ApprovedCampaigns();
                $ApprovedCampaign->setCampaignID($campaign->getCampaignID());
                $ApprovedCampaign->setApprovedBy(Application::$app->getUser()->getID());
                $ApprovedCampaign->setApprovedAt(date('Y-m-d H:i:s'));
                $ApprovedCampaign->setRemarks($remarks);
                if ($ApprovedCampaign->validate() && $ApprovedCampaign->save()){
                    $campaign->setVerified(Campaign::VERIFIED);
                    $campaign->setStatus(Campaign::APPROVED);
                    $MedicalTeam = new MedicalTeam();
                    $MedicalTeam->generateTeamID();
                    $MedicalTeam->setCampaignID($campaign->getCampaignID());
                    $MedicalTeam->setNoOfMembers(0);
                    $MedicalTeam->setAssignedBy(Application::$app->getUser()->getID());
                    $MedicalTeam->save();
                    if($campaign->update($campaign->getCampaignID(),[],['Verified','Status'])){
                        OrganizationNotification::AddCampaignAcceptedNotification($campaign->getCampaignID());
                        return json_encode(['status'=>true,'message'=>'Campaign Accepted Successfully !']);
                    }else{
                        return json_encode(['status'=>false,'message'=>'Error on Server','data'=>$campaign->errors]);
                    }
                }else{
                    return json_encode(['status'=>false,'message'=>'Error on Server','data'=>$ApprovedCampaign->errors]);
                }
            }
        }
    }

    public function RejectCampaign(Request $request, Response $response)
    {
        if ($request->isPost()){
            $id=$request->getBody()['id'];
            /* @var $campaign Campaign*/
            $campaign = Campaign::findOne(['Campaign_ID' => $id]);
            if ($campaign){
                $RejectedCampaign = new RejectedCampaign();
                $RejectedCampaign->setCampaignID($campaign->getCampaignID());
                $RejectedCampaign->setRejectedBy(Application::$app->getUser()->getID());
                $RejectedCampaign->setRejectedAt(date('Y-m-d H:i:s'));
                $RejectedCampaign->setRemarks($request->getBody()['remarks'] ?? 'No remarks');
                if (!$RejectedCampaign->validate())
                    return json_encode(['status'=>false,'message'=>'Error on Server','data'=>$RejectedCampaign->errors]);
                $RejectedCampaign->save();
                $campaign->setStatus(Campaign::REJECTED);
                $campaign->update($campaign->getCampaignID(),[],['Status']);
                return json_encode(['status'=>true,'message'=>'Campaign Rejected Successfully !']);
            }
        }
    }

    public function GetStatistics(Request $request,Response $response)
    {
        if ($request->isPost()){
            $ID=$request->getBody()['ID'];
            if ($ID){

                $IsOfficerExist=Manager::findOne(['Manager_ID'=>$ID]);
                if ($IsOfficerExist){
                    $TotalAssignmentsInMonth = ['January' => 0, 'February' => 0, 'March' => 0, 'April' => 0, 'May' => 0, 'June' => 0, 'July' => 0, 'August' => 0, 'September' => 0, 'October' => 0, 'November' => 0, 'December' => 0];
//                    Dummy Data
                    foreach ($TotalAssignmentsInMonth as $key => $value){
                        $TotalAssignmentsInMonth[$key]=rand(0,10);
                    }

                    return json_encode([
                        'status'=>true,
                        'data'=>[
                            'TotalAssignmentsInMonth'=>$TotalAssignmentsInMonth
                        ]
                    ]);


                }else{
                    return json_encode([
                        'status'=>false,
                        'message'=>'Medical Officer Not Found!'
                    ]);
                }
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

        if ($page<1){
            $page=1;
        }
        $limit = $request->getBody()['rpp'] ?? 15;
        $initial = ($page - 1) * $limit;
        $id=Application::$app->getUser()->getID();
        $user=Application::$app->getUser();
        $id=$user->getID();
        $Branch_ID=$user->getBloodBankID();
        $total_rows = MedicalOfficer::getCount(false,['Branch_ID' => $Branch_ID]);
        $total_pages = ceil ($total_rows / $limit);
        $BloodBanks=BloodBank::RetrieveAll();

        $medicalOfficers=MedicalOfficer::RetrieveAll(true,[$initial,$limit],true,['Branch_ID' => $Branch_ID]);
        $params=[
            'page'=>'mngOfficer',
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

    public function AddMedicalOfficer(Request $request, Response $response)
    {
        $medicalOfficer=new MedicalOfficer();
        if (Application::$app->request->isPost()){
            $medicalOfficer->loadData($request->getBody());
            $medicalOfficer->setID(uniqid('MO_'));
            $medicalOfficer->setStatus(1);
            $medicalOfficer->setGenderFromNIC();
            $medicalOfficer->setJoinedAt(date('Y-m-d H:i:s'));
            $file=new File($_FILES['image'],'Profile/MedicalOfficer');
            $fileName=$file->GenerateFileName('MO');
            $medicalOfficer->setProfileImage($fileName);
            $hash = password_hash($medicalOfficer->getNIC(), PASSWORD_DEFAULT);
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
    public function UpdateMedicalOfficer(Request $request, Response $response)
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
    public function ManageSponsors(Request $request,Response $response): string
    {
        $page = $request->getBody()['page'] ?? 1;
        if ($page<1){
            $page=1;
        }
        $limit = $request->getBody()['rpp'] ?? 15;
        $initial = ($page - 1) * $limit;
        $id=Application::$app->getUser()->getID();
        $total_rows = Sponsor::getCount();
        $total_pages = ceil ($total_rows / $limit);
        $Sponsors=Sponsor::RetrieveAll(true,[$initial,$limit]);
        $Packages=SponsorshipPackages::RetrieveAll();
        $params=[
            'packages'=>$Packages,
            'page'=>'mngSponsor',
            'rpp'=>$limit,
            'total_pages'=>$total_pages,
            'current_page'=>$page,
            'data'=>$Sponsors
        ];
        return $this->render('Manager/ManageSponsors',$params);
    }

    public function SearchSponsors(Request $request,Response $response)
    {
        if ($request->isPost()){
            $search=$request->getBody()['q'];
            $search=str_replace(' ','%',$search);
            $CampaignStatus = $request->getBody()['status'] ?? 1;
            $CampaignStatus=intval($CampaignStatus);
            $limit = 15;
            $page = $request->getBody()['page'] ?? 1;
            $initial = ($page - 1) * $limit;
            $id=Application::$app->getUser()->getID();
            $data=Sponsor::Search(['Sponsor_Name'=>$search,'City'=>$search]);
            $total_rows = count($data);
            $total_pages = ceil ($total_rows / $limit);
            return $this->render('Manager/ManageSponsors',
                [
                    'page'=>'mngSponsor',
                    'rpp'=>$limit,
                    'total_pages'=>$total_pages,
                    'current_page'=>$page,
                    'data'=>$data
                ]);
        }

    }
    public function ManageSponsorship(Request $request,Response $response)
    {
        $Status = $request->getBody()['status'] ?? 1;
        $Status=intval($Status);
        $limit = $request->getBody()['rpp'] ?? 15;
        $page = $request->getBody()['page'] ?? 1;
        $initial = ($page - 1) * $limit;
        $id=Application::$app->getUser()->getID();
        if ($Status==0){
            $total_rows = SponsorshipRequest::getCount();
            $total_pages = ceil ($total_rows / $limit);
            $SponsorshipRequest = SponsorshipRequest::RetrieveAll(true,[$initial,$limit]);
        }else if ($Status==1){
            $total_rows = SponsorshipRequest::getCount(false,['Sponsorship_Status'=>1]);
            $total_pages = ceil ($total_rows / $limit);
            $SponsorshipRequest = SponsorshipRequest::RetrieveAll(true,[$initial,$limit],true,['Sponsorship_Status'=>1]);
        }else if ($Status==2){
            $total_rows = SponsorshipRequest::getCount(false,['Sponsorship_Status'=>2]);
            $total_pages = ceil ($total_rows / $limit);
            $SponsorshipRequest = SponsorshipRequest::RetrieveAll(true,[$initial,$limit],true,['Sponsorship_Status'=>2]);
        }else if ($Status==3){
            $total_rows = SponsorshipRequest::getCount(false,['Sponsorship_Status'=>3]);
            $total_pages = ceil ($total_rows / $limit);
            $SponsorshipRequest = SponsorshipRequest::RetrieveAll(true,[$initial,$limit],true,['Sponsorship_Status'=>3]);
        }else{
            $total_rows = SponsorshipRequest::getCount();
            $total_pages = ceil ($total_rows / $limit);
            $SponsorshipRequest = SponsorshipRequest::RetrieveAll(true,[$initial,$limit]);
        }
        return $this->render('Manager/ManageSponsorship/ManageSponsorship',[
            'page'=>'mngSponsorship',
            'data'=>$SponsorshipRequest,
            'total_pages'=>intval($total_pages),
            'current_page'=>intval($page),
            'rpp'=>$limit,
        ]);
    }

    public function GetSponsorshipRequest(Request $request,Response $response)
    {
        if ($request->isPost()){
            /** @var SponsorshipRequest $Request*/
            $Req_ID = $request->getBody()['id'];
            $Request= SponsorshipRequest::findOne(['Sponsorship_ID'=>$Req_ID]);
            if ($Request){
                $Amount = $Request->getSponsorshipAmount();
                $SuggestedPackage = SponsorshipRequest::getSuggestedPackage($Amount);
                $suggest = [];
                if ($SuggestedPackage){
                    $suggest=[
                        'Package_ID'=>$SuggestedPackage[0]->getPackageID(),
                        'Package_Name'=>$SuggestedPackage[0]->getPackageName(),
                        'Package_Price'=>$SuggestedPackage[0]->getPackagePrice(),
                        'Package_Description'=>$SuggestedPackage[0]->getPackageDescription(),
                        'Package_Image'=>$SuggestedPackage[0]->getPackageImage(),
                    ];
                }
                return json_encode(['status'=>true,"data"=>[
                    'campaignName'=> $Request->getCampaignName(),
                    'campaignDate'=>$Request->getCampaignDate(),
                    'organizationName'=>$Request->getOrganizationName(),
                    'date'=>$Request->getSponsorshipDate(),
                    'amount'=>$Request->getSponsorshipAmount(),
                    'description'=>$Request->getDescription(),
                    'report'=>$Request->getReport(),
                    'suggest'=>$suggest
                ]]);
                            }else{
                return json_encode(['status'=>false,'message'=>"No Request Found"]);
            }
        }
    }

    public function ApproveSponsorshipRequest(Request $request,Response $response)
    {
        /** @var SponsorshipRequest $Request*/
        if ($request->isPost()){
            $Req_ID = $request->getBody()['id'];
            $Request= SponsorshipRequest::findOne(['Sponsorship_ID'=>$Req_ID]);
            if ($Request){
                $Request->setSponsorshipStatus(SponsorshipRequest::STATUS_APPROVED);
                $Request->update($Request->getSponsorshipID(),[],['Sponsorship_Status']);
                $OrgNotification = new OrganizationNotification();
                $OrgNotification->setTargetID($Request->getOrganizationID());
                $OrgNotification->setNotificationType(OrganizationNotification::TYPE_SPONSORSHIP_REQUEST);
                $OrgNotification->setNotificationState(OrganizationNotification::STATE_PENDING);
                $OrgNotification->setNotificationMessage("Your Sponsorship Request for ".$Request->getCampaignName()." has been Approved");
                $OrgNotification->setNotificationDate(date('Y-m-d'));
                $OrgNotification->setNotificationTitle("Sponsorship Request Approved");
                $OrgNotification->setValidUntil(date('Y-m-d',strtotime("+1 month")));
                $OrgNotification->setNotificationID(uniqid("OrgNot__"));
                if ($OrgNotification->validate() && $OrgNotification->save()){
                    return json_encode(['status'=>true,'message'=>"Request Approved"]);
                }else{
                    return json_encode(['status'=>false,'message'=>"Error Occurred"]);
                }
            }else{
                return json_encode(['status'=>false,'message'=>"No Request Found"]);
            }
        }
    }

    public function RejectSponsorshipRequest(Request $request,Response $response)
    {
        /** @var SponsorshipRequest $Request*/
        /** @var OrganizationNotification $OrgNotification*/
        if ($request->isPost()){
            $Req_ID = $request->getBody()['id'];
            $Request= SponsorshipRequest::findOne(['Sponsorship_ID'=>$Req_ID]);
            if ($Request){
                $Request->setSponsorshipStatus(SponsorshipRequest::STATUS_REJECTED);
                $Request->update($Request->getSponsorshipID(),[],['Sponsorship_Status']);
                $OrgNotification = new OrganizationNotification();
                $OrgNotification->setTargetID($Request->getOrganizationID());
                $OrgNotification->setNotificationType(OrganizationNotification::TYPE_SPONSORSHIP_REQUEST);
                $OrgNotification->setNotificationState(OrganizationNotification::STATE_PENDING);
                $OrgNotification->setNotificationMessage("Your Sponsorship Request for ".$Request->getCampaignName()." has been rejected");
                $OrgNotification->setNotificationDate(date('Y-m-d'));
                $OrgNotification->setNotificationTitle("Sponsorship Request Rejected");
                $OrgNotification->setValidUntil(date('Y-m-d',strtotime("+1 month")));
                $OrgNotification->setNotificationID(uniqid("OrgNot__"));
                if ($OrgNotification->validate() && $OrgNotification->save()){
                    return json_encode(['status'=>true,'message'=>"Request Rejected"]);
                }else{
                    return json_encode(['status'=>false,'message'=>"Error Occurred"]);
                }
            }else{
                return json_encode(['status'=>false,'message'=>"No Request Found"]);
            }
        }
    }

    public function SendEmailToOrganization(Request $request,Response $response)
    {
        if ($request->isPost()) {
            $Sp_ID = $request->getBody()['Sponsorship_ID'];
            $Sponsorship = SponsorshipRequest::findOne(['Sponsorship_ID' => $Sp_ID]);
            if (!$Sponsorship) {
                return json_encode(['status' => false, 'message' => "No User Found"]);
            }
            $Campaign = Campaign::findOne(['Campaign_ID' => $Sponsorship->getCampaignID()]);
            if (!$Campaign) {
                return json_encode(['status' => false, 'message' => "No User Found"]);
            }

            $Organization = Organization::findOne(['Organization_ID' => $Sponsorship->getOrganizationID()]);
            if (!$Organization) {
                return json_encode(['status' => false, 'message' => "No User Found"]);
            }
            $id = $Organization->getID();

            $email = $Organization->getEmail();

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
            $mail->setFrom($_ENV['EMAIL_USERNAME']);
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

    }
    public function ManageRequests(Request $request,Response $response): string
    {
        $limit = 15;
        $page = $request->getBody()['page'] ?? 1;
        $RequestStatus=$request->getBody()['status'] ?? 1;
        $RequestStatus=intval($RequestStatus);
        if ($page < 1){
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
        if ($RequestStatus===0){
            $total_rows = BloodRequest::getCount(false);
            $total_pages = ceil ($total_rows / $limit);
            $requests=BloodRequest::RetrieveAll(true,[$initial,$limit]);
        }else if ($RequestStatus===1){
            $total_rows = BloodRequest::getCount(false);
            $total_pages = ceil ($total_rows / $limit);
            $requests=BloodRequest::RetrieveAll(true,[$initial,$limit],true,['Action'=>BloodRequest::REQUEST_STATUS_PENDING]);
        }else if ($RequestStatus===2) {
            $requests = BloodRequest::RetrieveAll(true, [$initial, $limit], true, ['Action' => BloodRequest::REQUEST_STATUS_FULFILLED]);
        }else if ($RequestStatus===3) {
            $requests = BloodRequest::RetrieveAll(true, [$initial, $limit], true, ['Action' => BloodRequest::REQUEST_STATUS_SENT_TO_DONOR]);
        }else{
            $requests=BloodRequest::RetrieveAll(true,[$initial,$limit],true,['Action'=>BloodRequest::REQUEST_STATUS_PENDING]);
        }
        return $this->render('Manager/ManageRequests',[
            'page'=>'mngRequest',
            'data'=>$requests,
            'total_pages'=>intval($total_pages),
            'current_page'=>intval($page),
            'rpp'=>$limit,
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
                        'Request_ID'=>$BloodRequest->getRequestID(),
                        'Requested_By'=>$BloodRequest->getRequestedBy(),
                        'BloodGroup'=>$BloodRequest->getBloodGroup(),
                        'Requested_At'=>$BloodRequest->getRequestedAt(),
                        'Status'=>$BloodRequest->getStatus(),
                        'Type'=>$BloodRequest->getType(),
                        'Volume'=>$BloodRequest->getVolume(),
                        'Action'=>$BloodRequest->getAction(),
                    ]
                ];
                return json_encode($data);
            }

            endif;

        }
    }
    public function SearchRequest(Request $request,Response $response)
    {
        if ($request->isPost()){
                $search=$request->getBody()['q'];
                $search=str_replace(' ','%',$search);
                $CampaignStatus = $request->getBody()['status'] ?? 1;
                $CampaignStatus=intval($CampaignStatus);
                $limit = 14;
                $page = $request->getBody()['page'] ?? 1;
                $initial = ($page - 1) * $limit;
                $id=Application::$app->getUser()->getID();
                $total_rows = BloodRequest::getCount(false,['BloodGroup'=>$search]);
                $Hospitals=Hospital::Search(['Hospital_Name'=>$search]);
                if ($Hospitals){
                    $Hos_Id=[];
                    foreach ($Hospitals as $Hospital){
                        $IsExist=BloodRequest::findOne(['Requested_By'=>$Hospital->getHospitalID()]);
                        if ($IsExist){
                            $Hos_Id[]=$IsExist;
                        }
                    }
                    $data=$Hos_Id;
                }else{
                    $data= BloodRequest::Search(['BloodGroup'=>$search],[],[$initial,$limit]);
                }
                $bloodGroup=BloodRequest::Search(['BloodGroup'=>$search],[],[$initial,$limit]);
                $data=array_merge($data,$bloodGroup);
//                Remove Duplicates
                $data=array_unique($data,SORT_REGULAR);
                $total_pages = ceil ($total_rows / $limit);
                return $this->render('Manager/ManageRequests',
                    [
                        'page'=>'mngRequest',
                        'rpp'=>$limit,
                        'total_pages'=>$total_pages,
                        'current_page'=>$page,
                        'data'=>$data
                    ]);
            }
    }
    public function ManageDonors(Request $request,Response $response): string
    {
        $page = $request->getBody()['page'] ?? 1;
        $BloodGroup = $request->getBody()['BloodGroup'] ?? null;
        if ($page < 1){
            $page=1;
        }
        $limit = $request->getBody()['rpp'] ?? 15;
        $initial = ($page - 1) * $limit;
        $id=Application::$app->getUser()->getID();
        $total_rows = Donor::getCount();
        $total_pages = ceil ($total_rows / $limit);
        if ($total_pages<$page){
            $page=1;
            $initial = ($page - 1) * $limit;
            $id=Application::$app->getUser()->getID();
            $total_rows = Donor::getCount();
            $total_pages = ceil ($total_rows / $limit);
        }
        $data= Donor::RetrieveAll(true,[$initial,$limit]);
        $BloodTypes =BloodGroup::RetrieveAll();
        $BGroup='All';
        if ($BloodGroup){
            if ($BloodGroup==='All'){
                $data=Donor::RetrieveAll(true,[$initial,$limit]);
            }else{
                $isValidBloodGroup = BloodGroup::findOne(['BloodGroup_Name'=>$BloodGroup]);
                if ($isValidBloodGroup){
                    $BGroup=$BloodGroup;
                    $data=Donor::RetrieveAll(true,[$initial,$limit],true,['BloodGroup'=>$BloodGroup]);
                }else{
                    $this->setFlashMessage('danger','Blood Group Not Found');
                    $data=Donor::RetrieveAll(true,[$initial,$limit]);
                }

            }

        }
        return $this->render('Manager/ManageDonors',
        [
            'page'=>'mngDonor',
            'BloodTypes'=>$BloodTypes,
            'BloodGroup'=>$BGroup,
            'rpp'=>$limit,
            'total_pages'=>$total_pages,
            'current_page'=>$page,
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
    public function ManageCampaigns(Request $request,Response $response): string
    {
        $page = $request->getBody()['page'] ?? 1;
        if ($page < 1){
            $page=1;
        }
        $CampaignStatus = $request->getBody()['status'] ?? 1;
        $limit = $request->getBody()['rpp'] ?? 15;
        $initial = ($page - 1) * $limit;
        $id=Application::$app->getUser()->getID();
        $total_rows = Campaign::getCount();
        $total_pages = ceil ($total_rows / $limit);
        $CampaignStatus=intval($CampaignStatus);
        if ($CampaignStatus===0){
            $total_rows = Campaign::getCount(false);
            $total_pages = ceil ($total_rows / $limit);
            $data= Campaign::RetrieveAll(true,[$initial,$limit]);
        }else if ($CampaignStatus===1){
            $total_rows = Campaign::getCount(false,['Status'=>Campaign::PENDING]);
            $total_pages = ceil ($total_rows / $limit);
            $data= Campaign::RetrieveAll(true,[$initial,$limit],true,['Status'=>Campaign::PENDING]);
        }else if ($CampaignStatus===2){
            $total_rows = Campaign::getCount();
            $total_pages = ceil ($total_rows / $limit);
            $data= Campaign::RetrieveAll(true,[$initial,$limit],true,['Status'=>Campaign::APPROVED]);
        }
        else if ($CampaignStatus===3){
            $total_rows = Campaign::getCount(true);
            $total_pages = ceil ($total_rows / $limit);
            $data= Campaign::RetrieveAll(true,[$initial,$limit],true,['Status'=>Campaign::REJECTED]);
        }
        return $this->render('Manager/ManageCampaigns',
            [
                'page'=>'mngCampaign',
                'rpp'=>$limit,
                'total_pages'=>$total_pages,
                'current_page'=>$page,
                'data'=>$data
            ]);
    }

    public function SearchCampaign(Request $request,Response $response)
    {
        if ($request->isPost()){
            $search=$request->getBody()['q'];
            $search=str_replace(' ','%',$search);
            $CampaignStatus = $request->getBody()['status'] ?? 1;
            $CampaignStatus=intval($CampaignStatus);
            $limit = 14;
            $page = $request->getBody()['page'] ?? 1;
            $initial = ($page - 1) * $limit;
            $id=Application::$app->getUser()->getID();
            $total_rows = Campaign::getCount(false,['Campaign_Name'=>$search]);
            $total_pages = ceil ($total_rows / $limit);
            $data= Campaign::Search(['Campaign_Name'=>$search],[],[$initial,$limit]);
            return $this->render('Manager/ManageCampaigns',
                [
                    'page'=>'mngCampaign',
                    'rpp'=>$limit,
                    'total_pages'=>$total_pages,
                    'current_page'=>$page,
                    'data'=>$data
                ]);
        }

    }
    public function ManageReport(): string
    {
        return $this->render('Manager/ManageReports',[
            'page'=>'mngReport'
        ]);
    }
    public function SearchMedicalOfficer(Request $request, Response $response): string
    {
        $type = $request->getBody()['type'] ?? 'none';
        $search=$request->getBody()['q'];
        $search=str_replace(' ','%',$search);
        $BranchID=Application::$app->getUser()->getBloodBankID();

        /* @var Manager $manager*/
        $manager = Application::$app->getUser();
        $limit = 14;
        $page = $request->getBody()['page'] ?? 1;
        $initial = ($page - 1) * $limit;
        $id=Application::$app->getUser()->getID();

        $total_rows = MedicalOfficer::getCount(true,['NIC'=>$search]);
        $total_pages = ceil ($total_rows / $limit);
        $medicalOfficers=MedicalOfficer::Search(['NIC'=>$search,'First_Name'=>$search,'Last_Name'=>$search,'Position'=>$search,'Email'=>$search],['Branch_ID'=>$BranchID],[$initial,$limit]);
        $params=[
            'page'=>'mngOfficer',
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
        $NIC = $request->getBody()['nic'] ?? null;
        $ID = $request->getBody()['ID'] ?? null;
        $format = $request->getBody()['format'] ?? 'html';
        if (strtolower($format) === 'json' && (!$NIC || !$ID)){
            return json_encode(['status'=>500,'message'=>'No NIC Provided']);
        }
        /* @var  $Donor Donor*/
        if ($ID){
            $Donor = Donor::findOne(['Donor_ID' => $ID]);
            if (strtolower($format) === 'json'){
                if ($Donor){
                    return json_encode(['status'=>200,'name'=>$Donor->getFullName()]);
                }else{
                    return json_encode(['status'=>500,'message'=>'No Donor Found']);
                }
            }
        }else{
            $Donor = Donor::findOne(['NIC' => $NIC]);
            if (strtolower($format) === 'json'){
                if ($Donor){
                    return json_encode(['status'=>200,'name'=>$Donor->getFullName()]);
                }else{
                    return json_encode(['status'=>500,'message'=>'No Donor Found']);
                }
            }
        }

        //Get the Donor Information
//        $this->layout="none";
        return $this->render('Manager/ManageDonor/findDonor', ['data' => $Donor]);
    }

    public function SendBloodRequestToDonor(Request $request,Response $response)
    {
        if ($request->isPost()) {
            /* @var $Request BloodRequest */
            $Request_ID = $request->getBody()['Request_ID'];
            $Request = BloodRequest::findOne(['Request_ID' => $Request_ID]);
            $Request->setAction(BloodRequest::REQUEST_STATUS_SENT_TO_DONOR);
            $Request->update($Request_ID, [], ['Action']);
            $Donor_notification = new DonorNotification();
            $Donor_notification->setTargetGroup($Request->getBloodGroup());
            $Donor_notification->setNotificationState(DonorNotification::NOTIFICATION_STATE_UNREAD);
            $Donor_notification->setNotificationTitle('Blood Request From ' . $Request->getRequestedBy());
            $Donor_notification->setNotificationMessage('Blood Request From ' . $Request->getRequestedBy() . ' for ' . $Request->getBloodGroup() . ' Blood Group. Please Contact ' . $Request->getRequestedBy() . ' for more details.');
            $Donor_notification->setValidUntil(date('Y-m-d H:i:s', strtotime('+2 day')));
            $Donor_notification->setNotificationDate(date('Y-m-d H:i:s'));
            $Donor_notification->setNotificationType(DonorNotification::INFORM_GROUP_OF_DONOR);
            if ($Donor_notification->validate() && $Donor_notification->save()) {
                return json_encode(['status' => true, 'message' => 'Request Sent']);
            }else{
                print_r($Donor_notification->getErrors());
            }
            return json_encode(['status' => false, 'message' => 'Request Not Sent']);
        }
        Application::Redirect('/manager/mngRequests');
        exit();
    }
    public function SearchDonor(Request $request,Response $response)
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

        $total_rows = Donor::getCount(true,['NIC'=>$search,'First_Name'=>$search,'Last_Name'=>$search,'Email'=>$search,'Contact_No'=>$search,'City'=>$search]);
        $total_pages = ceil ($total_rows / $limit);
        $medicalOfficers=Donor::Search(['NIC'=>$search,'First_Name'=>$search,'Last_Name'=>$search,'Email'=>$search,'Contact_No'=>$search,'City'=>$search],[],[$initial,$limit]);
        $params=[
            'type'=>$type,
            'data'=>$medicalOfficers,
            'q'=>$search
        ];
        $this->layout="none";

        return $this->render('Manager/ManageDonor/SearchDonor',$params);
    }

    public function ManageEmergencyRequests()
    {
//        $EmergencyRequests=EmergencyRequest::RetrieveAll();
        return $this->render('Manager/ManageRequest/EmergencyRequest');
    }

    public function DonationCampaignReport(Request $request,Response $response)
    {
        $Month=date('m');
        $Year=date('Y');
        $DonationCampaigns=Campaign::RetrieveAll();
        
    }
}