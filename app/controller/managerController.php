<?php

namespace App\controller;

use App\middleware\managerMiddleware;
use App\model\Authentication\Login;
use App\model\Blood\BloodGroup;
use App\model\BloodBankBranch\BloodBank;
use App\model\Campaigns\ApprovedCampaigns;
use App\model\Campaigns\Campaign;
use App\model\Campaigns\CampaignStatistics;
use App\model\Campaigns\RejectedCampaign;
use App\model\Donations\AcceptedDonations;
use App\model\Donations\Donation;
use App\model\Donations\RejectedDonations;
use App\model\Email\Email;
use App\model\MedicalTeam\MedicalTeam;
use App\model\MedicalTeam\TeamMembers;
use App\model\Notification\DonorNotification;
use App\model\Notification\ManagerNotification;
use App\model\Notification\MedicalOfficerNotification;
use App\model\Notification\OrganizationNotification;
use App\model\Requests\BloodRequest;
use App\model\Requests\SponsorshipRequest;
//use App\model\sponsor\SponsorshipPackages;
use App\model\sponsor\CampaignsSponsor;
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
use DateTime;
use Dompdf\Dompdf;
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
        $ID=Application::$app->getUser()->getID();
        $manager = Manager::findOne(['Manager_ID' => Application::$app->getUser()->getID()]);
        $Data = [
            'Total_Campaigns'=>0,
            'Total_Donations'=>[
                'Successful'=>0,
                'Percentage'=>0,
                'Total'=>0,
            ],
        ];
        /** @var ApprovedCampaigns[] $ApproveCampaigns */
        /** @var $Campaign Campaign */
        $ApproveCampaigns = ApprovedCampaigns::RetrieveAll(false, [], true, ['Approved_By' => $ID]);
        echo '<pre>';
        foreach ($ApproveCampaigns as $campaign) {
            $Campaign = Campaign::findOne(['Campaign_ID' => $campaign->getCampaignID()]);
            $CampaignYear = date('Y', strtotime($Campaign->getCampaignDate()));
            $CurrentYear = date('Y');
            if ($CampaignYear == $CurrentYear) {
                $Data['Total_Campaigns']++;
            }
            if ($Campaign->getStatus()===Campaign::CAMPAIGN_STATUS_FINISHED){
                $Donations = Donation::RetrieveAll(false,[],true,['Campaign_ID'=>$Campaign->getCampaignID()]);
                foreach ($Donations as $donation){
                    if ($donation->getStatus()===Donation::STATUS_BLOOD_STORED){
                        $Data['Total_Donations']['Successful']++;
                    }
                    $Data['Total_Donations']['Total']++;
                }
            }
        }
        $Data['Total_Donations']['Percentage']=intval(($Data['Total_Donations']['Successful']/$Data['Total_Donations']['Total'])*100);
        print_r($Data);
        exit();
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
                    'page'=>'mngCampaign',
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
                $IsAlreadyApproved = ApprovedCampaigns::findOne(['Campaign_ID'=>$campaign->getCampaignID()]);
                if ($IsAlreadyApproved){
                    return json_encode(['status'=>false,'message'=>'Campaign Already Approved ! Refresh the page !']);
                }
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
                $campaign->setVerified(Campaign::REJECTED);
                $campaign->update($campaign->getCampaignID(),[],['Status','Verified']);
                return json_encode(['status'=>true,'message'=>'Campaign Rejected Successfully !']);
            }
        }
    }

    public function GetStatistics(Request $request,Response $response)
    {
        if ($request->isPost()){
            $ID=Application::$app->getUser()->getID();
            if ($ID){

                $IsOfficerExist=Manager::findOne(['Manager_ID'=>$ID]);
                if ($IsOfficerExist){
                    $TotalAssignmentsInMonth = ['January' => 0, 'February' => 0, 'March' => 0, 'April' => 0, 'May' => 0, 'June' => 0, 'July' => 0, 'August' => 0, 'September' => 0, 'October' => 0, 'November' => 0, 'December' => 0];
                    $TotalDonations = [
                        'January' => 0,
                        'February' => 0,
                        'March' => 0,
                        'April' => 0,
                        'May' => 0,
                        'June' => 0,
                        'July' => 0,
                        'August' => 0,
                        'September' => 0,
                        'October' => 0,
                        'November' => 0,
                        'December' => 0
                    ];
                    $BloodGroups = ['A+'=>0,'A-'=>0,'B+'=>0,'B-'=>0,'AB+'=>0,'AB-'=>0,'O+'=>0,'O-'=>0];
                    //                    Dummy Data
                    $ApprovedCampaigns = ApprovedCampaigns::RetrieveAll(false,[],true,['Approved_By'=>$ID]);
//                    print_r($ApprovedCampaigns);
                    /** @var ApprovedCampaigns[] $FinishedCampaigns */
                    foreach ($ApprovedCampaigns as $key => $value){
                        $TotalAssignmentsInMonth[date('F',strtotime($value->getApprovedAt()))]++;
                        $Donations = Donation::RetrieveAll(false,[],true,['Campaign_ID'=>$value->getCampaignID(),'Status'=>Donation::STATUS_BLOOD_STORED]);
                        /** @var Donation[] $Donations */
                        foreach ($Donations as $key => $donation){
                            $BloodGroups[$donation->getBloodGroup()]++;
                        }
                    }
                    $FinishedCampaigns = array_filter($ApprovedCampaigns,function ($campaign){
                        return $campaign->getCampaign()->getStatus() == Campaign::CAMPAIGN_STATUS_FINISHED;
                    });

//                    Random Data
                    foreach ($BloodGroups as $key => $value){
                        $BloodGroups[$key] = rand(1,10);
                    }
                    foreach ($TotalAssignmentsInMonth as $key => $value){
                        $TotalAssignmentsInMonth[$key] += rand(1,10);
                    }



                    return json_encode([
                        'status'=>true,
                        'data'=>[
                            'TotalAssignmentsInMonth'=>$TotalAssignmentsInMonth,
                            'BloodGroups'=>$BloodGroups
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
//                if ($user->validate()){
                    if (MODE!==DEVELOPMENT)
                        $medicalOfficer->sendAccountCreatedEmail();
                    $TargetID=$medicalOfficer->getID();
                    $Title='Account Created';
                    $Message = "Welcome to BePositive Blood Bank Management System. Your account has been created successfully. Please login to the system using your NIC number as the username and NIC number as the password. You can change your password after login.";
                    MedicalOfficer::CreateNotification($TargetID,$Title,$Message);
                    $file->saveFile();
                    Application::$app->session->setFlash('success', 'Successfully Added Medical Officer!');
                    return json_encode(['status' => true, 'message' => 'Successfully Added Medical Officer!']);
                }else{
                    return json_encode(['status' => false, 'message' => $user->getErrors()[0], 'errors' => $user->errors]);
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
            /** @var Donor $donor */
            $donor = Donor::findOne(['Donor_ID' => $id]);

            $email = $donor->getEmail();

            $subject = $request->getBody()['subject'];
            $message = $request->getBody()['message'];
            /* @var $attachment File*/
            $attachment = $request->getBody()['attachment'] ?? null;
//            TODO : Attachment Thing


    //        $file=new File($attachment,'Emails');
            $mail = Application::$app->email;
            if (MODE===DEVELOPMENT){
                $mail->setTo(DEV_EMAIL);
            }else{
                $mail->setTo($email);
            }
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
        $params=[
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

    public function FindSponsors(Request $request,Response $response)
    {
        if ($request->isPost()){
            $ID=$request->getBody()['id'] ?? null;
            if ($ID!=null) {
                /** @var Sponsor $Sponsor */
                $Sponsor = Sponsor::findOne(['Sponsor_ID' => $ID]);
                if ($Sponsor) {
                    $CampaignSponsor = CampaignsSponsor::RetrieveAll(false, [], true, ['Sponsor_ID' => $ID, 'Status' => CampaignsSponsor::PAYMENT_STATUS_PAID]);
                    $Campaigns = [];

                    $CampaignSponsor = array_merge(...array_fill(0,100,$CampaignSponsor));
                    /** @var CampaignsSponsor $item */
                    foreach ($CampaignSponsor as $item) {
                        /** @var Campaign $Campaign */
                        $Campaign = $item->getCampaign();
                        if ($Campaign) {
                            $Campaigns[] = [
                                'Campaign_Name' => $Campaign->getCampaignName(),
                                'Sponsored_Amount' => "LKR ".number_format($item->getSponsoredAmount(), 2),
                                'Sponsored_At' => date('Y-M-d', strtotime($item->getSponsoredAt())),
                            ];
                        }
                    }
                    return json_encode(['status' => true, 'data' => [
                        'Name' => $Sponsor->getSponsorName(),
                        'Address' => $Sponsor->getAddress(),
                        'Email' => $Sponsor->getEmail(),
                        'Contact' => $Sponsor->getContactNo(),
                        'Campaigns' => $Campaigns,
                        'TotalSponsored' => 'LKR '.number_format($Sponsor->getTotalSponsored(), 2),
                    ]]);
                } else {
                    return json_encode(['status' => false, 'message' => 'Sponsor Not Found!']);
                }
            }

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
                return json_encode(['status'=>true,"data"=>[
                    'campaignName'=> $Request->getCampaignName(),
                    'campaignDate'=>$Request->getCampaignDate(),
                    'organizationName'=>$Request->getOrganizationName(),
                    'date'=>$Request->getSponsorshipDate(),
                    'amount'=>$Request->getSponsorshipAmount(),
                    'description'=>$Request->getDescription(),
                    'report'=>$Request->getReport(),
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
                $Request->setManagedBy(Application::$app->getUser()->getID());
                $Request->setManagedAt(date('Y-m-d'));
                $Request->update($Request->getSponsorshipID(),[],['Sponsorship_Status','Managed_By','Managed_At']);
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
            $data= Campaign::RetrieveAll(true,[$initial,$limit],true,['Status'=>Campaign::APPROVED,'Verified'=>Campaign::VERIFIED]);
        }
        else if ($CampaignStatus===3){
            $total_rows = Campaign::getCount(true);
            $total_pages = ceil ($total_rows / $limit);
            $data= Campaign::RetrieveAll(true,[$initial,$limit],true,['Status'=>Campaign::REJECTED,'Verified'=>Campaign::REJECTED]);
        }
//        Filter the $data array that Campaign Date is not greater than 12 hours from now
        /**
         * @throws \Exception
         */
        $data=array_filter(/**
         * @throws \Exception
         */ /**
         * @throws \Exception
         */ /**
         */ $data,function ($item){
            /** @var $item Campaign*/
            $date = new DateTime($item->getCampaignDate());
            $now = new DateTime();
            $interval = $date->diff($now);
            $days = $interval->format('%d');
            $days = intval($days);
            if ($days>14){
                return true;
            }
            return false;
        });
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

        if (strtolower($format) !== 'json' && ($NIC===null && $ID===null)){
            return json_encode(['status'=>500,'message'=>'No NIC Provided']);
        }
        /* @var  $Donor Donor*/
        /* @var  $AcceptedDonation AcceptedDonations*/
        /* @var  $Donations Donation[]*/
        if ($ID){
            $Donor = Donor::findOne(['Donor_ID' => $ID]);
            if (strtolower($format) === 'json'){
                if ($Donor){
                    $DonationDetails = [];
                    $Donations = Donation::RetrieveAll(false,[],true,['Donor_ID'=>$Donor->getID()]);
                    if ($Donations){
                        $Donations = array_merge(...array_fill(0,100,$Donations));
                        usort($Donations,function ($a,$b){
                            return $a->getDonatedAt() <=> $b->getDonatedAt();
                        });
                        foreach ($Donations as $key=>$value){
                            /** @var Donation $value */
                            $DonationDetails[] = [
                                'Date'=>date('Y-M-d',strtotime($value->getDonatedAt())),
                                'PackageID'=>AcceptedDonations::findOne(['Donation_ID'=>$value->getDonationID()]) ? AcceptedDonations::findOne(['Donation_ID'=>$value->getDonationID()])->getPacketID() : 'N/A',
                                'Venue'=>$value->getCampaignName(),
                                'Status'=>$value->getStatus(true),
                            ];
                        }

                    }
                    return json_encode(['status'=>200,'data'=>[
                        'FullName'=>$Donor->getFullName(),
                        'NIC'=>$Donor->getNIC(),
                        'Address'=>$Donor->getAddress(),
                        'Age'=>$Donor->getAge(),
                        'ContactNo'=>$Donor->getContactNo(),
                        'Email'=>$Donor->getEmail(),
                        'Nationality'=>$Donor->getNationality(),
                        'BloodGroup'=>$Donor->getBloodGroup(),
                        'Donations'=>$DonationDetails,
                        'Availability'=>$Donor->getDonationAvailability(),
                    ]]);
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

    public function FinishedCampaignReport(Request $request,Response $response)
    {
        /** @var $ApprovedCampaigns array*/
        /** @var $ApprovedCampaign ApprovedCampaigns*/
        /** @var $Campaign Campaign*/
        /** @var $SponsorshipRequest SponsorshipRequest*/
        /** @var $Team MedicalTeam*/

        $Year = $request->getBody()['Year'] ?? date('Y');
        $Month = $request->getBody()['Month'] ?? 'all';
        $UserID = Application::$app->getUser()->getID();
        $ApprovedCampaigns =ApprovedCampaigns::RetrieveAll(false,[],true,['Approved_By'=>$UserID]);
        if (!$ApprovedCampaigns){
            return json_encode(['status'=>true,'message'=>'No Campaigns Found']);
        }
//        Sort the Campaigns
        $ApprovedCampaigns = array_filter($ApprovedCampaigns,function ($Campaign){
            /** @var $Campaign ApprovedCampaigns*/
            return $Campaign->getCampaign()->getStatus()===Campaign::CAMPAIGN_STATUS_FINISHED;
        });
        $ApprovedCampaigns = array_filter($ApprovedCampaigns,function ($Campaign) use ($Year) {
            /** @var $Campaign ApprovedCampaigns*/
            $CampaignDate =$Campaign->getCampaign()->getCampaignDate();
            return date('Y',strtotime($CampaignDate))==$Year;
        });
        if ($Month!=='all'){
            $ApprovedCampaigns = array_filter($ApprovedCampaigns,function ($Campaign) use ($Month) {
                /** @var $Campaign ApprovedCampaigns*/
                $CampaignDate =$Campaign->getCampaign()->getCampaignDate();
                return date('m',strtotime($CampaignDate))==$Month;
            });
        }
        usort($ApprovedCampaigns,function ($a,$b){
            /** @var $a ApprovedCampaigns */
            /** @var $b ApprovedCampaigns */
            return $a->getCampaign()->getCampaignDate()<$b->getCampaign()->getCampaignDate();
        });
//        TODO : Remove this
        $Data = [];
        $i=0;
        foreach ($ApprovedCampaigns as $ApprovedCampaign) {
            /** @var $ApprovedCampaign ApprovedCampaigns */
            /** @var $Stat CampaignStatistics */
            $Campaign = $ApprovedCampaign->getCampaign();
            $Data[$i]['CampaignName'] = $Campaign->getCampaignName();
            $Data[$i]['CampaignDate'] = $Campaign->getCampaignDate();
            $Data[$i]['CampaignLocation'] = $Campaign->getVenue();
            $Data[$i]['CampaignDescription'] = $Campaign->getCampaignDescription();

            $Organization = $Campaign->getOrganization();
            $Data[$i]['OrganizationName'] = $Organization->getOrganizationName();
            $Data[$i]['OrganizationType'] = $Organization->getType();

            $Stat = CampaignStatistics::findOne(['Campaign_ID' => $Campaign->getCampaignID()]);
            if ($Stat){
                $Data[$i]['SuccessfulDonation'] = $Stat->getNoOfSuccessfulDonations();
                $Data[$i]['RejectedDonation'] = $Stat->getNoOfAbortedDonations();
            }

            $Donations = Donation::RetrieveAll(false, [], true, ['Campaign_ID' => $Campaign->getCampaignID(),'Status'=>Donation::STATUS_BLOOD_STORED]);
            if ($Donations) {
                $Data[$i]['BloodCollected'] = 0;
                foreach ($Donations as $Donation) {
                    /** @var $Donation Donation */
                    $Data[$i]['BloodCollected'] += $Donation->getBloodVolume();
                }
            } else {
                $Data[$i]['BloodCollected'] = 0;
            }
            $Team = MedicalTeam::findOne(['Campaign_ID' => $Campaign->getCampaignID()]);
            if ($Team) {
                $Data[$i]['TeamID'] = $Team->getTeamIDDummy();
                $Data[$i]['TeamLeader'] = MedicalOfficer::findOne(['Officer_ID'=>$Team->getTeamLeader()])->getFullName();
                $Data[$i]['NoTeamMembers'] = count($Team->getTeamMembers());
            } else {
                $Data[$i]['TeamID'] = 'N/A';
                $Data[$i]['TeamLeader'] = 'N/A';
                $Data[$i]['NoTeamMembers'] = 0;
            }
            $SponsorshipRequest = SponsorshipRequest::findOne(['Campaign_ID' => $Campaign->getCampaignID(),'Sponsorship_Status'=>SponsorshipRequest::STATUS_APPROVED],false);
            if ($SponsorshipRequest){
                $Data[$i]['RequestedAmount'] = $SponsorshipRequest->getSponsorshipAmount();
                $Data[$i]['TransferredDate'] = $SponsorshipRequest->getTransferredAt();
                $CampaignSponsors = CampaignsSponsor::RetrieveAll(false,[],true,['Sponsorship_ID'=>$SponsorshipRequest->getSponsorshipID(),'Status'=>CampaignsSponsor::PAYMENT_STATUS_PAID]);
                if ($CampaignSponsors) {
                    $Data[$i]['SponsorshipAmount'] = 0;
                    foreach ($CampaignSponsors as $CampaignSponsor) {
                        /** @var $CampaignSponsor CampaignsSponsor */
                        $Data[$i]['SponsorshipAmount'] += $CampaignSponsor->getSponsoredAmount();
                    }

                }
            }
            $i++;

        }
        header('Content-Type: application/json');
        return json_encode(['status'=>true,'data'=>$Data,'year'=>$Year,'month'=>$Month]);
    }

    public function DonationReport(Request $request,Response $response)
    {
        /** @var $ApprovedCampaigns array*/
        /** @var $ApprovedCampaign ApprovedCampaigns*/
        /** @var $Campaign Campaign*/
        /** @var $SponsorshipRequest SponsorshipRequest*/
        /** @var $Team MedicalTeam*/
        if ($request->isPost()) {

            $Year = $request->getBody()['Year'] ?? date('Y');
            $Month = $request->getBody()['Month'] ?? 'all';
            $UserID = Application::$app->getUser()->getID();
            $ApprovedCampaigns = ApprovedCampaigns::RetrieveAll(false, [], true, ['Approved_By' => $UserID]);
            if (!$ApprovedCampaigns) {
                return json_encode(['status' => true, 'message' => 'No Campaigns Found']);
            }
//        Sort the Campaigns
            $ApprovedCampaigns = array_filter($ApprovedCampaigns, function ($Campaign) {
                /** @var $Campaign ApprovedCampaigns */
                return $Campaign->getCampaign()->getStatus() === Campaign::CAMPAIGN_STATUS_FINISHED;
            });
            $ApprovedCampaigns = array_filter($ApprovedCampaigns, function ($Campaign) use ($Year) {
                /** @var $Campaign ApprovedCampaigns */
                $CampaignDate = $Campaign->getCampaign()->getCampaignDate();
                return date('Y', strtotime($CampaignDate)) == $Year;
            });
            if ($Month !== 'all') {
                $ApprovedCampaigns = array_filter($ApprovedCampaigns, function ($Campaign) use ($Month) {
                    /** @var $Campaign ApprovedCampaigns */
                    $CampaignDate = $Campaign->getCampaign()->getCampaignDate();
                    return date('m', strtotime($CampaignDate)) == $Month;
                });
            }
            usort($ApprovedCampaigns, function ($a, $b) {
                /** @var $a ApprovedCampaigns */
                /** @var $b ApprovedCampaigns */
                return $a->getCampaign()->getCampaignDate() < $b->getCampaign()->getCampaignDate();
            });
            $BloodGroups = ['A+' => 0, 'A-' => 0, 'B+' => 0, 'B-' => 0, 'AB+' => 0, 'AB-' => 0, 'O+' => 0, 'O-' => 0];
            foreach ($ApprovedCampaigns as $approvedCampaign) {
                /** @var $approvedCampaign ApprovedCampaigns */
                $Campaign = $approvedCampaign->getCampaign();
                /** @var Donation $Donations */
                $Donations = Donation::RetrieveAll(false, [], true, ['Campaign_ID' => $Campaign->getCampaignID()]);
                foreach ($Donations as $Donation) {
                    /** @var $Donation Donation */
                    if ($Donation->getStatus() === Donation::STATUS_BLOOD_STORED) {
                        $BloodGroups[$Donation->getBloodGroup()] += $Donation->getBloodVolume();
                    }
                }
            }
//        header('Content-Type: application/json');
            return json_encode(['status' => true, 'data' => $BloodGroups, 'year' => $Year, 'month' => $Month]);
        }
    }

    public function OfficerReport(Request $request,Response $response)
    {
        /** @var $User Manager*/
        /** @var $MedicalOfficers MedicalOfficer[]*/
        $User = Application::$app->getUser();
        $BranchID = $User->getBloodBankID();
        $Data = [];
        $MedicalOfficers = MedicalOfficer::RetrieveAll(false,[],true,['Branch_ID'=>$BranchID]);
        /** @var MedicalOfficer $MedicalOfficer */
        foreach ($MedicalOfficers as $MedicalOfficer){
            $MedicalOfficerCampaigns = $MedicalOfficer->getAllCampaigns();
            $Campaign = [];
            if ($MedicalOfficerCampaigns){
                $MedicalOfficerCampaigns = array_filter($MedicalOfficerCampaigns,function ($Campaign){
                    /** @var $Campaign Campaign*/
                    return $Campaign->getStatus() === Campaign::CAMPAIGN_STATUS_FINISHED;
                });
                foreach ($MedicalOfficerCampaigns as $medicalOfficerCampaign){
                    /** @var Campaign $camp */
                    $Campaign[] = [
                        'Campaign_Name'=>$medicalOfficerCampaign->getCampaignName(),
                        'Campaign_Date'=>$medicalOfficerCampaign->getCampaignDate(),
                        'Campaign_Venue'=>$medicalOfficerCampaign->getVenue(),
                        'Task'=>MedicalOfficer::getTaskOfCampaign($MedicalOfficer->getOfficerID(),$medicalOfficerCampaign->getCampaignID()),
                        'Role'=>MedicalOfficer::getRoleOfCampaign($MedicalOfficer->getOfficerID(),$medicalOfficerCampaign->getCampaignID())
                    ];
                }
            }
            $Data[] = [
                'FullName'=>$MedicalOfficer->getFullName(),
                'Email'=>$MedicalOfficer->getEmail(),
                'Phone'=>$MedicalOfficer->getContactNo(),
                'Address'=>$MedicalOfficer->getAddress(),
                'NIC'=>$MedicalOfficer->getNIC(),
                'Gender'=>$MedicalOfficer->getGender(),
                'Nationality'=>$MedicalOfficer->getNationality(),
                'Position'=>$MedicalOfficer->getPosition(),
                'TotalCampaigns'=> $MedicalOfficerCampaigns ? count($MedicalOfficerCampaigns) : 0,
                'Campaign'=>$Campaign,

            ];
        }



        header('Content-Type: application/json');
        return json_encode(['status'=>true,'data'=>$Data]);

    }

    public function SponsorshipReport(Request $request,Response $response)
    {

        $Year = $request->getBody()['Year'] ?? date('Y');
        $Month = $request->getBody()['Month'] ?? 'all';
        $UserID = Application::$app->getUser()->getID();
        $ApprovedCampaigns = ApprovedCampaigns::RetrieveAll(false, [], true, ['Approved_By' => $UserID]);
        if (!$ApprovedCampaigns) {
            return json_encode(['status' => true, 'message' => 'No Campaigns Found']);
        }
//        Sort the Campaigns
        $ApprovedCampaigns = array_filter($ApprovedCampaigns, function ($Campaign) {
            /** @var $Campaign ApprovedCampaigns */
            return $Campaign->getCampaign()->getStatus() === Campaign::CAMPAIGN_STATUS_FINISHED;
        });
        $ApprovedCampaigns = array_filter($ApprovedCampaigns, function ($Campaign) use ($Year) {
            /** @var $Campaign ApprovedCampaigns */
            $CampaignDate = $Campaign->getCampaign()->getCampaignDate();
            return date('Y', strtotime($CampaignDate)) == $Year;
        });
        if ($Month !== 'all') {
            $ApprovedCampaigns = array_filter($ApprovedCampaigns, function ($Campaign) use ($Month) {
                /** @var $Campaign ApprovedCampaigns */
                $CampaignDate = $Campaign->getCampaign()->getCampaignDate();
                return date('m', strtotime($CampaignDate)) == $Month;
            });
        }
        usort($ApprovedCampaigns, function ($a, $b) {
            /** @var $a ApprovedCampaigns */
            /** @var $b ApprovedCampaigns */
            return $a->getCampaign()->getCampaignDate() < $b->getCampaign()->getCampaignDate();
        });
        $ApprovedCampaigns = array_merge(...array_fill(0, 100, $ApprovedCampaigns));
        $Data = [];
        foreach ($ApprovedCampaigns as $approvedCampaign) {
            /** @var $approvedCampaign ApprovedCampaigns */
            $Campaign = $approvedCampaign->getCampaign();
            /** @var $SponsorshipRequest SponsorshipRequest */
            $SponsorshipRequest = SponsorshipRequest::findOne(['Campaign_ID' => $Campaign->getCampaignID()]);
            if ($SponsorshipRequest){
                $SponsorCampaigns = $SponsorshipRequest->getSponsorCampaign();
                $SponsoredDetails = [];
                if ($SponsorCampaigns){
                    foreach ($SponsorCampaigns as $sponsorCampaign){
                        /** @var $sponsorCampaign CampaignsSponsor */
                        $Sponsor = $sponsorCampaign->getSponsor();
                        if (!$Sponsor){
                            $SponsoredDetails[] = "No Sponsor Found";
                        }else {
                            $SponsoredDetails[] = [
                                'SponsorName' => $Sponsor->getSponsorName(),
                                'SponsorEmail' => $Sponsor->getEmail(),
                                'SponsorAmount' => $sponsorCampaign->getSponsoredAmount(),
                                'SponsorDate' => $sponsorCampaign->getSponsoredAt(),
                                'SponsorshipStatus' => $SponsorshipRequest->getSponsorshipStatus(true),
                            ];
                        }
                    }
                }

                $Data[] = [
                    'CampaignName' => $Campaign->getCampaignName(),
                    'CampaignDate' => $Campaign->getCampaignDate(),
                    'SponsorshipAmount' => $SponsorshipRequest->getSponsorshipAmount(true),
                    'SponsorshipDate' => $SponsorshipRequest->getSponsorshipDate(),
                    'SponsorshipStatus' => $SponsorshipRequest->getSponsorshipStatus(true),
                    'Transferred'=> $SponsorshipRequest->getTransferred(),
                    'TransferredDate'=> $SponsorshipRequest->getTransferredAt(),
                    'TotalSponsoredAmount' => $SponsorshipRequest->getTotalSponsoredAmount(true),
                    'SponsoredDetails' => $SponsoredDetails,
                    'Report'=> $SponsorshipRequest->getReport()
                ];
            }
        }
        header('Content-Type: application/json');
        return json_encode(['status' => true, 'data' => $Data, 'year' => $Year, 'month' => $Month]);
    }

    public function DonationCampaignReport(Request $request,Response $response)
    {
        $Month=date('m');
        $Year=date('Y');
        $DonationCampaigns=Campaign::RetrieveAll();
        
    }

    public function CampaignReport(Request $request,Response $response): bool|string
    {
        /** @var $Campaign Campaign*/
        /** @var $Donation Donation*/
        /** @var $RejectedDonations RejectedDonations*/
        /** @var $AcceptedDonations AcceptedDonations*/
        $CampaignID = $request->getBody()['CampaignID'] ?? null;
        if ($CampaignID){
            $Campaign = Campaign::findOne(['Campaign_ID' => $CampaignID]);
            if ($Campaign){
//                TODO : Check if the campaign is Finished
                if ($Campaign->getStatus()===Campaign::APPROVED){
                    $Data = [];
                    $Data['CampaignName'] = $Campaign->getCampaignName();
                    $Data['CampaignDate'] = $Campaign->getCampaignDate();
                    $Donations = Donation::RetrieveAll(false,[],true,['Campaign_ID'=>$CampaignID]);
                    if ($Donations){
                        $Data['TotalDonations'] = count($Donations);
                        foreach ($Donations as $Donation){
                            if ($Donation->getStatus()===Donation::STATUS_BLOOD_STORED){
                                $Data['BloodStored'] = ($Data['BloodStored'] ?? 0) + 1;
                            }
                            $AcceptedDonations = AcceptedDonations::findOne(['Donation_ID'=>$Donation->getDonationID()]);
                            if ($AcceptedDonations){
                                $Data['AcceptedDonations'] = $Data['AcceptedDonations'] ?? [];
                                $Data['AcceptedDonations']['count'] = ($Data['AcceptedDonations']['count'] ?? 0) + 1;
                                $Data['AcceptedDonations']['TotalVolume'] = ($Data['AcceptedDonations']['TotalVolume'] ?? 0) + $AcceptedDonations->getVolume();
                            }
                            $RejectedDonations = RejectedDonations::findOne(['Donation_ID'=>$Donation->getDonationID()]);
                            if ($RejectedDonations){
                                $Data['RejectedDonations'] = $Data['RejectedDonations'] ?? [];
                                $Data['RejectedDonations']['count'] = ($Data['RejectedDonations']['count'] ?? 0) + 1;
                            }
                        }
                    }
                    var_dump($Data);
                    exit();
                }
            }
//            header('Content-Type: application/json');
            return json_encode(['status'=>true,'data'=>Campaign::findOne(['Campaign_ID'=>$CampaignID])->toArray()]);
        }
        return "Campaign Report";
    }
}