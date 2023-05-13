<?php

namespace App\controller;

use App\middleware\medicalOfficerMiddleware;
use App\model\Blood\BloodGroup;
use App\model\Blood\BloodPackets;
use App\model\Blood\DonorBloodCheck;
use App\model\Campaigns\Campaign;
use App\model\Campaigns\CampaignDonorQueue;
use App\model\Campaigns\ReportedCampaign;
use App\model\Donations\AcceptedDonations;
use App\model\Donations\Donation;
use App\model\Donations\RejectedDonations;
use App\model\Donor\DonorHealthCheckUp;
use App\model\MedicalTeam\MedicalTeam;
use App\model\MedicalTeam\TeamMembers;
use App\model\Notification\MedicalOfficerNotification;
use App\model\Organization\ReportOrganization;
use App\model\users\Donor;
use App\model\users\MedicalOfficer;
use App\model\users\Organization;
use App\model\users\User;
use App\model\Utils\Security;
use Core\Application;
use Core\BaseMiddleware;
use Core\File;
use Core\Request;
use Core\Response;

class medicalOfficerController extends \Core\Controller
{

    public function __construct()
    {
        $this->setLayout('MedicalOfficer');

        $this->registerMiddleware(new medicalOfficerMiddleware(['dashboard'], BaseMiddleware::FORBIDDEN_ROUTES));

    }

    public function getNotification(Request $request,Response $response)
    {
        $Notifications=MedicalOfficerNotification::RetrieveAll(false,[],true,['Target_ID'=>Application::$app->getUser()->getId()],['Notification_Date'=>'ASC']);
//        Convert values to array
        $Notifications=array_merge(...array_fill(0,100,$Notifications));
        $Notifications = array_map(function ($object) {
            return $object->toArray();
        }, $Notifications);
//        Change the date format to a readable format
        foreach ($Notifications as $key=>$value){
            $Notifications[$key]['Notification_Date']=date('Y-M-d h:i:s',strtotime($value['Notification_Date']));
        }
        return json_encode([
            'status'=>true,
            'notifications'=>$Notifications
        ]);

    }

    public function Dashboard(Request $request, Response $response)
    {
        $Campaign=MedicalOfficer::getAssignedCampaign();
        if ($Campaign) {
            $Campaign = array_filter($Campaign, function ($object) {
                return $object->getCampaignDate() >= date('Y-m-d');
            });
        }
        $User = Application::$app->getUser();
//        $Campaign = Campaign::RetrieveAll(false,[],false,[],['Campaign_Date'=>'ASC']);
        return $this->render('/MedicalOfficer/MedicalOfficerdashboard',
            [
                'page'=>'dashboard',
                'Campaigns'=>$Campaign,
                'User'=>$User
            ]);
    }

    public function ManageHistory(Request $request, Response $response)
    {
        $UserID = Application::$app->getUser()->getId();
        /** @var Campaign[] $Campaigns */
        $Campaigns = MedicalOfficer::GetAllCampaign($UserID);
        $toDate = $request->getBody()['ToDate'] ?? null;
        $fromDate = $request->getBody()['FromDate'] ?? null;
        if ($toDate && $fromDate) {
            $Campaigns = array_filter($Campaigns, function ($object) use ($toDate, $fromDate) {
                return $object->getCampaignDate() >= $fromDate && $object->getCampaignDate() <= $toDate;
            });
        }
        if (!empty($Campaigns)){
            return $this->render('/MedicalOfficer/OfficerHistory',[
                'page'=>'history',
                'BrandTitle'=>'History',
                'Campaigns'=>$Campaigns
            ]);
        }else{
            return $this->render('/MedicalOfficer/OfficerHistory',[
                'page'=>'history',
                'BrandTitle'=>'History',
                'Campaigns'=>[]
            ]);
        }

    }

    public function CampaignAssignment(Request $request, Response $response)
    {
        $UserID = Application::$app->getUser()->getId();
        $team=TeamMembers::findOne(['Member_ID' => $UserID]);
        $model=[];
        if ($team){
            $Position=$team->getPosition();
            $CampaignID=$team->getCampaignID();
            $Campaign = Campaign::findOne(['Campaign_ID' => $CampaignID]);
            $CampaignName=$Campaign->getCampaignName();
            $model=[
                'Position'=>$Position,
                'CampaignName'=>$CampaignName
            ];

        }
        return $this->render('/MedicalOfficer/AssignCampaign',$model);
    }

    public function VerifyDonor(Request $request, Response $response)
    {
        $Donor_ID = $request->getBody()['Donor_ID'] ?? 'Dnr_01';
        $Donor = Donor::findOne(['Donor_ID' => $Donor_ID]);
        return $this->render('/MedicalOfficer/VerifyDonor', ['data' => $Donor]);
    }

    public function FindDonor(Request $request, Response $response)
    {
        $Donor_ID = $request->getBody()['nic'];
        $Donor = Donor::findOne(['NIC' => $Donor_ID]);
        return json_encode([
            'status'=>true,
            'donor'=>[
                'name'=>$Donor->getFullName(),
                'nic'=>$Donor->getNIC(),
                'id'=>$Donor->getID(),
                'address'=>$Donor->getAddress(),
                'profileImage'=>$Donor->getProfileImage(),
                'gender'=>$Donor->getGender(),
            ]]);
    }

    public function ViewReport(Request $request,Response $response)
    {
        /** @var $Campaigns Campaign[]*/
        /** @var $Campaign Campaign*/
        $UserID = Application::$app->getUser()->getId();
        $Campaigns = MedicalOfficer::GetAllCampaign($UserID);
        $CampaignID = $request->getBody()['campaignID'];
        if (!empty($Campaigns)){
            header('Content-Type: application/json');
            $Campaign = array_filter($Campaigns, function ($object) use ($CampaignID) {
                return $object->getCampaignID() == $CampaignID;
            });
            if (count($Campaign)<=0){
                return json_encode([
                    'status'=>false,
                    'message'=>'No Campaigns Found!'
                ]);
            }
            // Make the array index 0
            $Campaign = array_values($Campaign);
            $Campaign = $Campaign[0];
            /**@var $Campaign Campaign*/
            return json_encode([
                'status'=>true,
                'campaigns'=>[
                    'Campaign_Name'=>$Campaign->getCampaignName(),
                    'Campaign_Date'=>$Campaign->getCampaignDate(),
                    'Campaign_Description'=>$Campaign->getCampaignDescription(),
                    'Venue'=>$Campaign->getVenue(),
                    'Latitude'=>$Campaign->getLatitude(),
                    'Longitude'=>$Campaign->getLongitude(),
                ]
            ]);
        }else{
            return json_encode([
                'status'=>false,
                'message'=>'No Campaigns Found!'
            ]);
        }


    }

    public function ViewTeam(Request $request,Response $response)
    {
        if ($request->isPost()){
            $CampaignID=$request->getBody()['campaignID'];
            $Campaign = Campaign::findOne(['Campaign_ID' => $CampaignID]);

            if ($Campaign){
                if ($Campaign->getStatus()!==Campaign::CAMPAIGN_STATUS_FINISHED){
                    return json_encode([
                        'status'=>false,
                        'message'=>'Campaign Is Not Finished Yet!'
                    ]);
                }
                /** @var $MedicalTeam MedicalTeam*/
                /** @var $TeamMember TeamMembers*/
                $MedicalTeam = MedicalTeam::findOne(['Campaign_ID' => $CampaignID]);
                $TeamMembers = TeamMembers::RetrieveAll(false,[],false,['Team_ID'=>$MedicalTeam->getTeamID()]);
                $TeamMembersArray = [];
                foreach ($TeamMembers as $TeamMember){
                    $TeamMembersArray[]=[
                        'MemberID'=>$TeamMember->getMemberID(),
                        'MemberName'=>$TeamMember->getMember()->getFullName(),
                        'Position'=>$TeamMember->getPosition(),
                    ];
                }
                return json_encode([
                    'status'=>true,
                    'team'=>$TeamMembersArray
                ]);

            }else{
                return json_encode([
                    'status'=>false,
                    'message'=>'No Campaign Found!'
                ]);
            }


        }

    }

    public function ManageCampaigns(Request $request, Response $response)
    {
        $UserID = Application::$app->getUser()->getId();
        $Date=date('Y-m-d');
        /* @var Campaign $Campaign*/

        $Campaign=MedicalOfficer::getAssignedCampaign($Date);

        if (!$Campaign){
            $this->setFlashMessage('error','No Campaign Assigned!');
            return $this->render('/MedicalOfficer/ManageCampaigns',['page'=>'campaigns']);
        }
        if ($Campaign->getStatus()===Campaign::CAMPAIGN_STATUS_FINISHED){
            $this->setFlashMessage('error','Campaign Ended!');
            return $this->render('/MedicalOfficer/ManageCampaigns',['page'=>'campaigns']);
        }
        $MedicalTeam = MedicalTeam::findOne(['Campaign_ID' => $Campaign->getCampaignID()]);
        $Organization = Organization::findOne(['Organization_ID' => $Campaign->getOrganizationID()]);

        $model['page']='campaigns';
        if ($Campaign){
            $Position = MedicalTeam::findOne(['Campaign_ID' => $Campaign->getCampaignID(), 'Team_Leader' => $UserID],false) ? MedicalTeam::TEAM_LEADER : MedicalTeam::TEAM_MEMBER;
            $model=[
                'page'=>'campaigns',
                'Position'=>$Position,
                'Campaign'=>$Campaign,
                'MedicalTeam'=>$MedicalTeam,
                'Organization'=>$Organization
            ];
        }
        return $this->render('/MedicalOfficer/ManageCampaigns',$model);
    }

    public function EndCampaigns(Request $request, Response $response)
    {
        if ($request->isPost()){
            $CampaignID = $request->getBody()['CampaignID'];
            if ($CampaignID){
                $CampaignID = trim($CampaignID);
                $Campaign=Campaign::findOne(['Campaign_ID'=>$CampaignID]);
                if ($Campaign){
                    /**@var $Campaign Campaign */
                    $Campaign->setStatus(Campaign::CAMPAIGN_STATUS_FINISHED);
                    $Campaign->update($Campaign->getCampaignID(),[],['Status']);
                    $this->setFlashMessage('success','Campaign Ended Successfully!');
                    return json_encode([
                        'status'=>true,
                        'message'=>'Campaign Ended Successfully!'
                    ]);
                }else{
                    $this->setFlashMessage('error','Invalid Campaign!');
                    return json_encode([
                        'status'=>false,
                        'message'=>'Invalid Campaign !'
                    ]);
                }
            }else{
                $this->setFlashMessage('error','Invalid Campaign ID!');
                return json_encode([
                    'status'=>false,
                    'message'=>'Invalid Campaign !'
                ]);
            }

        }
    }
    public function GetStatistics(Request $request,Response $response)
    {
        if ($request->isPost()){
            $ID=$request->getBody()['ID'];
            if ($ID){
                $IsOfficerExist=MedicalOfficer::findOne(['Officer_ID'=>$ID]);
                if ($IsOfficerExist){

                    $AllMedicalTeamAssignments= TeamMembers::RetrieveAll(false,[],true,['Member_ID'=>$ID]);
                    $TotalAssignmentsInMonth = ['January' => 0, 'February' => 0, 'March' => 0, 'April' => 0, 'May' => 0, 'June' => 0, 'July' => 0, 'August' => 0, 'September' => 0, 'October' => 0, 'November' => 0, 'December' => 0];
                    foreach ($AllMedicalTeamAssignments as $Assignment){
                        $CampaignDate=$Assignment->getCampaign()->getCampaignDate();
                        $Month=date('F',strtotime($CampaignDate));
                        $TotalAssignmentsInMonth[$Month]++;
                    }
                    $AllAssignedCampaigns = MedicalOfficer::GetAllCampaign($ID);
                    if ($AllAssignedCampaigns)
                        $AllAssignedCampaigns = array_merge($AllAssignedCampaigns,MedicalOfficer::GetAllCampaign($ID,Campaign::CAMPAIGN_STATUS_APPROVED));
                    else
                        $AllAssignedCampaigns = MedicalOfficer::GetAllCampaign($ID,Campaign::CAMPAIGN_STATUS_APPROVED);
                    $AllAssignedCampaignsArray = [];
                    /** @var Campaign[] $AllAssignedCampaigns */
                    if ($AllAssignedCampaigns) {
                        foreach ($AllAssignedCampaigns as $Campaign) {
                            $AllAssignedCampaignsArray[] = [
                                'CampaignName' => $Campaign->getCampaignName(),
                                'CampaignDate' => $Campaign->getCampaignDate(),
                                'CampaignDescription' => $Campaign->getCampaignDescription(),
                                'Venue' => $Campaign->getVenue(),
                                'Latitude' => $Campaign->getLatitude(),
                                'Longitude' => $Campaign->getLongitude(),
                                'Status' => $Campaign->getStatus(),
                                'CampaignStatus' => $Campaign->getCampaignStatus(),
                                'OrganizationName' => $Campaign->getOrganization()->getOrganizationName(),
                                'OrganizationCity' => $Campaign->getOrganization()->getCity(),
                                'OrganizationContactNo' => $Campaign->getOrganization()->getContactNo(),
                                'OrganizationEmail' => $Campaign->getOrganization()->getEmail(),
                                'TeamPosition' => MedicalOfficer::getRoleOfCampaign($ID, $Campaign->getCampaignID())
                            ];
                        }
                    }

                    return json_encode([
                        'status'=>true,
                        'data'=>[
                            'TotalAssignmentsInMonth'=>$TotalAssignmentsInMonth,
                            'Campaigns'=>$AllAssignedCampaignsArray
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

    public function CampaignOverview(Request $request, Response $response)
    {
        if ($request->isGet()){
            return $this->render('/MedicalOfficer/CampaignOverview',['page'=>'overview']);
        }
    }

    public function ManageDonation(Request $request, Response $response)
    {
        if ($request->isGet())
        {
            $UserID = Application::$app->getUser()->getId();
            $Date=date('Y-m-d');
            /* @var Campaign $Campaign*/
            $Campaign=MedicalOfficer::getAssignedCampaign($Date);
            if (!empty($Campaign) && $Campaign->IsReported()){
                $this->setFlashMessage('error','Campaign Is Reported!');
                Application::Redirect('/medicalofficer/dashboard');
                exit();
            }
            if (!empty($Campaign) && $Campaign->getOrganization()->IsReported()){
                $this->setFlashMessage('error','Organization Is Reported!');
                Application::Redirect('/medicalofficer/dashboard');
                exit();
            }

            if (!$Campaign){
                $this->setFlashMessage('error','No Campaign Assigned!');
                Application::Redirect('/medicalofficer/dashboard');
                exit();
            }


            $MedicalTeam = MedicalTeam::findOne(['Campaign_ID' => $Campaign->getCampaignID()]);
            $Organization = Organization::findOne(['Organization_ID' => $Campaign->getOrganizationID()]);
            $model=[
                'Campaign'=>$Campaign,
                'page'=>'donations',
            ];


            if ($MedicalTeam){
                $TeamMember = TeamMembers::findOne(['Team_ID' => $MedicalTeam->getTeamID(), 'Member_ID' => $UserID],false);
                if ($TeamMember){
                    $Task = $TeamMember->getTask();
                    if ($Task===TeamMembers::TASK_REGISTRATION){
                        $model['Task']=$TeamMember->getTaskName();
                        $NIC = $request->getBody()['NIC'] ?? null;
                        if ($NIC)
                        {
                            $Donor = Donor::findOne(['NIC' => $NIC]);
                            if ($Donor)
                            {
                                $model['Donor']=$Donor;

                                return $this->render('/MedicalOfficer/DonorRegistration', $model);
                            }else{
                                $this->setFlashMessage('error','Donor not found! Ask the donor to register first.');
                                Application::Redirect('/mofficer/take-donation');
                            }
                        }else{
                            return $this->render('/MedicalOfficer/DonorRegistration', $model);
                        }

                    }
                    else if ($Task===TeamMembers::TASK_HEALTH_CHECK){
                        $NIC = $request->getBody()['NIC'] ?? null;
                        if ($NIC) {
                            $Donor = Donor::findOne(['NIC' => $NIC]);
                            $IsDonorInQueue= CampaignDonorQueue::findOne(['Campaign_ID' => $Campaign->getCampaignID(), 'Donor_ID' => $Donor->getID()]);
                            if (!$IsDonorInQueue) {
                                $this->setFlashMessage('error','Donor not found in the queue! Ask the donor to register first.');
                                Application::Redirect('/mofficer/task-donation');
                            }
                            if ($Donor) {
                                $model['Donor']=$Donor;
                                return $this->render('/MedicalOfficer/HealthCheck', $model);
                            }else{
                                $this->setFlashMessage('error','Donor not found! Ask the donor to register first.');
                                $DonorForCheckHealth= CampaignDonorQueue::RetrieveAll(false,[],true,['Campaign_ID'=>$Campaign->getCampaignID(),'Donor_Status'=>CampaignDonorQueue::STAGE_1]);
                                $model['DonorForCheckHealth']=$DonorForCheckHealth;
                                return $this->render('/MedicalOfficer/HealthCheckQueue', $model);
                            }
                        }
                        else{
                            $DonorForCheckHealth= CampaignDonorQueue::RetrieveAll(false,[],true,['Campaign_ID'=>$Campaign->getCampaignID(),'Donor_Status'=>CampaignDonorQueue::STAGE_1]);
                            $model['DonorForCheckHealth']=$DonorForCheckHealth;
                            return $this->render('/MedicalOfficer/HealthCheckQueue', $model);
                        }
                    }
                    else if ($Task===TeamMembers::TASK_BLOOD_CHECK){
                        $NIC = $request->getBody()['NIC'] ?? null;
                        if ($NIC) {
                            $NIC = Security::Decrypt($NIC);
                            /* @var $IsDonorInQueue CampaignDonorQueue*/
                            /* @var $Donor Donor*/
                            $Donor = Donor::findOne(['NIC' => $NIC]);
                            if (!$Donor){
                                $this->setFlashMessage('error','Donor not found! Ask the donor to register first.');
                                Application::Redirect('/mofficer/take-donation');
                            }
                            if ($Donor->getDonationAvailability()!==Donor::AVAILABILITY_AVAILABLE){
                                $this->setFlashMessage('error','Donor not available for donation!');
                                Application::Redirect('/mofficer/take-donation');
                            }
                            $IsDonorInQueue= CampaignDonorQueue::findOne(['Campaign_ID' => $Campaign->getCampaignID(), 'Donor_ID' => $Donor->getDonorID(),'Donor_Status'=>CampaignDonorQueue::STAGE_2],false);

                            if (!$IsDonorInQueue) {
                                $this->setFlashMessage('error', 'Donor not found in the queue! Ask the donor to register first.');
                                Application::Redirect('/mofficer/take-donation');
                            }
                            if ($Donor) {
                                $model['Donor']=$Donor;
                                $BloodType=BloodGroup::RetrieveAll();
                                $model['BloodType']=$BloodType;
                                return $this->render('/MedicalOfficer/BloodCheck', $model);
                            }else{
                                $this->setFlashMessage('error','Donor not found! Ask the donor to register first.');
                                $DonorForCheckBlood= CampaignDonorQueue::RetrieveAll(false,[],true,['Campaign_ID'=>$Campaign->getCampaignID(),'Donor_Status'=>CampaignDonorQueue::STAGE_1]);

                                $model['DonorForCheckBlood']=$DonorForCheckBlood;
                                return $this->render('/MedicalOfficer/BloodCheckQueue', $model);
                            }
                        }
                        else{
                            /** @var CampaignDonorQueue[] $DonorForCheckBlood */
                            $DonorForCheckBlood= CampaignDonorQueue::RetrieveAll(false,[],true,['Campaign_ID'=>$Campaign->getCampaignID(),'Donor_Status'=>CampaignDonorQueue::STAGE_2]);
                            $DonorForCheckBlood = array_filter($DonorForCheckBlood, function ($DonorForCheckBlood) {
                                return $DonorForCheckBlood->getDonor()->getDonationAvailability()===Donor::AVAILABILITY_AVAILABLE;
                            });
                            $model['DonorForCheckBlood']=$DonorForCheckBlood;
                            return $this->render('/MedicalOfficer/BloodCheckQueue', $model);
                        }
                    }
                    else if ($Task===TeamMembers::TASK_BLOOD_RETRIEVAL){
                        $model['Task']=$TeamMember->getTaskName();
                        $NIC = $request->getBody()['NIC'] ?? null;


                        if ($NIC)
                        {
                            $Donor = Donor::findOne(['NIC' => $NIC]);

                            if ($Donor)
                            {
                                $Donation_Queue=CampaignDonorQueue::findOne(['Campaign_ID'=>$Campaign->getCampaignID(),'Donor_ID'=>$Donor->getID(),'Donor_Status'=>CampaignDonorQueue::STAGE_3],false);
                                if ($Donation_Queue){
                                    
                                }

                                if(!$Donation_Queue){
                                    $this->setFlashMessage('error','Donor not found in the queue! Ask the donor to register first.');
                                    $DonorTakeBloodDonation= CampaignDonorQueue::RetrieveAll(false,[],true,['Campaign_ID'=>$Campaign->getCampaignID(),'Donor_Status'=>CampaignDonorQueue::STAGE_3]);

                                    $model['DonorTakeBloodDonation']=$DonorTakeBloodDonation;
                                    return $this->render('/MedicalOfficer/TakeDonationQueue', $model);
                                }
                                $IsDonationStarted=Donation::findOne(['Donor_ID'=>$Donor->getID(),'Campaign_ID'=>$Campaign->getCampaignID()],false);
                                if ($IsDonationStarted){
                                    $model['Donation']=$IsDonationStarted;
                                    $model['BloodRetrievingStarted']=true;
                                }
                                $model['Donor']=$Donor;

                                return $this->render('/MedicalOfficer/TakeDonation', $model);
                            }else{
                                $this->setFlashMessage('error','Donor not found! Ask the donor to register first.');
                                Application::Redirect('/mofficer/take-donation');
                            }
                        }else{
                            $IsOngoingDonation=Donation::findOne(['Campaign_ID'=>$Campaign->getCampaignID(),'Status'=>Donation::STATUS_BLOOD_RETRIEVING,'Officer_ID'=>$UserID],false);
//                            $Donation_Queue = CampaignDonorQueue::findOne(['Donor_ID'=>])
                            if ($IsOngoingDonation){
                                $model['Donation']=$IsOngoingDonation;
                                $model['BloodRetrievingStarted']=true;
                                $model['Donor']=Donor::findOne(['Donor_ID'=>$IsOngoingDonation->getDonorID()]);
                                return $this->render('/MedicalOfficer/TakeDonation', $model);
                            }
                            $DonorTakeBloodDonation= CampaignDonorQueue::RetrieveAll(false,[],true,['Campaign_ID'=>$Campaign->getCampaignID(),'Donor_Status'=>CampaignDonorQueue::STAGE_3]);
//                            $DonorTakeBloodDonation = array_merge(...array_fill(0,50,$DonorTakeBloodDonation));
                            $model['DonorTakeBloodDonation']=$DonorTakeBloodDonation;
                            return $this->render('/MedicalOfficer/TakeDonationQueue', $model);
                        }
                    }
                    else{
                        $this->setFlashMessage('error','You are not assigned to any task!, Contact Team Leader');
                        Application::Redirect('/medicalofficer/dashboard');
                    }
                }
            }
        }
        else if ($request->isPost()){
            $type=$request->getBody()['Task'];
            $type= (int) $type;
            if ($type===TeamMembers::TASK_HEALTH_CHECK) {
                $DonorCheckHealth=new DonorHealthCheckUp();
                $DonorCheckHealth->loadData($request->getBody());
                $Diseases=$request->getBody()['Disease'] ?? null;
                if ($Diseases){
                    $DonorCheckHealth->setDiseases(implode(" ",$Diseases));
                }else{
                    $DonorCheckHealth->setDiseases("None");
                }
                /* @var $DonorQueue CampaignDonorQueue */
                $DonorQueue=CampaignDonorQueue::findOne(['Donor_ID'=>$DonorCheckHealth->getDonorID()]);
                if ($DonorQueue){
                    $CampaignID=$DonorQueue->getCampaignID();
                    $DonorCheckHealth->setCampaignID($CampaignID);
                    $UserID = Application::$app->getUser()->getID();
                    $DonorCheckHealth->setRecommendBy($UserID);
                    //TODO : CHECK IF THE DONOR IS ELIGIBLE TO DONATE
                    $DonorCheckHealth->IsEligible();
                    if ($DonorCheckHealth->validate() && $DonorCheckHealth->save()){
                        $DonorQueue->setDonor_Status(CampaignDonorQueue::STAGE_2);
                        $DonorQueue->update($DonorCheckHealth->getDonorID(),[],['Donor_Status']);

                        $this->setFlashMessage(key: 'success',message: 'Donor Health Check Up Completed!');
                        if ($DonorCheckHealth->getEligible()===DonorHealthCheckUp::NOT_ELIGIBLE){
                            $this->setFlashMessage(key: 'error',message: "Donor Cannot Donate the Blood");
                        }
                        Application::Redirect('/mofficer/take-donation');
                    }else{
                        $this->setFlashMessage('error','Donor Health Check Up Failed!');
                        Application::Redirect('/mofficer/take-donation');
                    }
                }
            }
            else if ($type===TeamMembers::TASK_BLOOD_CHECK){
                /* @var $DonorQueue CampaignDonorQueue*/
                $UserID = Application::$app->getUser()->getID();
                $DonorBloodCheck = new DonorBloodCheck();
                $DonorBloodCheck->loadData($request->getBody());
                $BloodPressure = $request->getBody()['Blood_Pressure'] ?? 0;
                if ($BloodPressure){
                    $UpperBloodPressure = (float)explode("/",$BloodPressure)[0];
                    $LowerBloodPressure = (float)explode("/",$BloodPressure)[1];
                    $DonorBloodCheck->setBloodPressureUpper($UpperBloodPressure);
                    $DonorBloodCheck->setBloodPressureLower($LowerBloodPressure);
                }
                $DonorBloodCheck->setCheckedAt(date('Y-m-d H:i:s'));
                $DonorBloodCheck->setCheckedBy($UserID);
                $DonorQueue=CampaignDonorQueue::findOne(['Donor_ID'=>$DonorBloodCheck->getDonorID()]);
                $CampaignID=$DonorQueue->getCampaignID();
                $DonorBloodCheck->setCampaignID($CampaignID);
                $Diseases=$request->getBody()['Disease'] ?? null;
                if ($Diseases){
                    $DonorBloodCheck->setInfectionDiseases(implode(" ",$Diseases));
                }else{
                    $DonorBloodCheck->setInfectionDiseases("None");
                }
                if ($DonorBloodCheck->validate() && $DonorBloodCheck->save()){
                    $DonorQueue->setDonor_Status(CampaignDonorQueue::STAGE_3);
                    $DonorQueue->update($DonorBloodCheck->getDonorID(),[],['Donor_Status']);
                    $this->setFlashMessage('success','Donor Blood Check Up Completed!');
                    Application::Redirect('/mofficer/take-donation');
                }else{
                    $Errors=$DonorBloodCheck->getErrors();
                    $FirstError=array_shift($Errors);
                    $this->setFlashMessage('error',$FirstError[0]);

                    $Donor=$DonorQueue->getDonor();
                    $model['Donor']=$Donor;
                    $model['BloodCheck']=$DonorBloodCheck;
                    $BloodType=BloodGroup::RetrieveAll();
                    $model['BloodType']=$BloodType;
                    return $this->render('/MedicalOfficer/BloodCheck', $model);
                }
            }
            else if ($type===TeamMembers::TASK_BLOOD_RETRIEVAL){
                var_dump("Blood Retrieval");


            }
        }
    }

    public function AbortDonation(Request $request,Response $response){
        /** @var $DonorQueue CampaignDonorQueue*/
        /** @var $Donation Donation*/
        if ($request->isPost()){
            $Reason = $request->getBody()['AbortDonationReason'];
            $DonorID = $request->getBody()['DonorID'];
            $ReasonOther = $request->getBody()['AbortDonationReasonOther'] ?? null;
            $DonorQueue=CampaignDonorQueue::findOne(['Donor_ID'=>$DonorID,'Donor_Status'=>CampaignDonorQueue::STAGE_3],false);
            if (!$DonorQueue){
                return json_encode(['status'=>false,'message'=>'Donor not ready for donation!']);
            }
            $DonorQueue->setDonor_Status(CampaignDonorQueue::STAGE_5);
            $Donation = Donation::findOne(['Donor_ID'=>$DonorID,'Campaign_ID'=>$DonorQueue->getCampaignID()],false);
            if (!$Donation){
                return json_encode(['status'=>false,'message'=>"No Donation"]);
            }
            $UserID = Application::$app->getUser()->getID();
            $RejectedDonation = new RejectedDonations();
            $RejectedDonation->setCampaignID($DonorQueue->getCampaignID());
            $RejectedDonation->setDonationID($Donation->getDonationID());
            $RejectedDonation->setReason($Reason);
            $RejectedDonation->setRejectedAt(date("Y-m-d H:i:s"));
            $RejectedDonation->setRejectedBy($UserID);
            $RejectedDonation->setDonorID($DonorID);
            $RejectedDonation->setType(RejectedDonations::TYPE_ABORT_BLOOD_RETRIEVING);
            if ($ReasonOther){
                $RejectedDonation->setOtherReason($ReasonOther);
            }
            if ($RejectedDonation->validate()){
                $RejectedDonation->save();
                $DonorQueue->update($DonorID,[],['Donor_Status'],['Campaign_ID'=>$DonorQueue->getCampaignID()]);
                return json_encode(['status'=>true,'message'=>'Aborted the Donation']);
            }else{
                return json_encode(['status'=>false,'message'=>'Error Occured','errors'=>$RejectedDonation->getErrors()]);
            }
        }
    }

    public function StartDonation(Request $request,Response $response){
        /* @var $DonorQueue CampaignDonorQueue*/
        if ($request->isPost()){
            $DonorID=$request->getBody()['DonorID'];
            $DonorQueue=CampaignDonorQueue::findOne(['Donor_ID'=>$DonorID,'Donor_Status'=>CampaignDonorQueue::STAGE_3],false);
            if (!$DonorQueue){
                return json_encode(['status'=>false,'message'=>'Donor not ready for donation!']);
            }
            $Donation=Donation::findOne(['Donor_ID'=>$DonorID,'Status'=>Donation::STATUS_BLOOD_RETRIEVING]);
            if ($Donation){
                return json_encode(['status'=>false,'message'=>'Donation already started!']);
            }
            $Donation = new Donation();
            $Donation->setDonationID(uniqid('Dnt_'));
            $Donation->setDonorID($DonorID);
            $Donation->setCampaignID($DonorQueue->getCampaignID());
            $Donation->setStatus(Donation::STATUS_BLOOD_RETRIEVING);
            $Donation->setStartAt(date('Y-m-d H:i:s'));
            $Donation->setOfficerID(Application::$app->getUser()->getID());
            if ($Donation->validate() && $Donation->save()) {
                return json_encode(['status' => true, 'message' => 'Donation Started!']);
            }else{
                $this->setFlashMessage('error', 'Donation Failed!');
                return json_encode(['status' => false, 'message' => 'Donation Failed!', 'errors' => $Donation->getErrors()]);
            }
        }
    }

    public function RejectDonation(Request $request,Response $response)
    {
        /** @var $DonorQueue CampaignDonorQueue*/
        /** @var $Donation Donation*/
        if ($request->isPost()){
            $Reason = $request->getBody()['AbortDonationReason'];
            $DonorID = $request->getBody()['DonorID'];
            $ReasonOther = $request->getBody()['AbortDonationReasonOther'] ?? null;
            $DonorQueue=CampaignDonorQueue::findOne(['Donor_ID'=>$DonorID,'Donor_Status'=>CampaignDonorQueue::STAGE_3],false);
            if (!$DonorQueue){
                return json_encode(['status'=>false,'message'=>'Donor not ready for donation!']);
            }
            $DonorQueue->setDonor_Status(CampaignDonorQueue::STAGE_5);
            $Donation = Donation::findOne(['Donor_ID'=>$DonorID,'Campaign_ID'=>$DonorQueue->getCampaignID()],false);
            if ($Donation){
                return json_encode(['status'=>false,'message'=>"Already Donation exist"]);
            }
            $Donation = new Donation();
            $Donation->setDonationID(uniqid('Dnt_'));
            $Donation->setDonorID($DonorID);
            $Donation->setCampaignID($DonorQueue->getCampaignID());
            $Donation->setStatus(Donation::STATUS_BLOOD_DONATION_ABORTED);
            $Donation->setOfficerID(Application::$app->getUser()->getID());
            $Donation->setStartAt(date('Y-m-d H:i:s'));
            if (!$Donation->validate()){
                return json_encode(['status'=>false,'message'=>'Error Occured','errors'=>$Donation->getErrors()]);
            }
            if (!$Donation->save()){
                return json_encode(['status'=>false,'message'=>'Error Occured','errors'=>$Donation->getErrors()]);
            }
            $UserID = Application::$app->getUser()->getID();
            $RejectedDonation = new RejectedDonations();
            $RejectedDonation->setCampaignID($DonorQueue->getCampaignID());
            $RejectedDonation->setDonationID($Donation->getDonationID());
            $RejectedDonation->setReason($Reason);
            $RejectedDonation->setRejectedAt(date("Y-m-d H:i:s"));
            $RejectedDonation->setRejectedBy($UserID);
            $RejectedDonation->setDonorID($DonorID);
            $RejectedDonation->setType(RejectedDonations::TYPE_ABORT_DONATION);
            if ($ReasonOther){
                $RejectedDonation->setOtherReason($ReasonOther);
            }
            if ($RejectedDonation->validate()){
                $RejectedDonation->save();
                $DonorQueue->update($DonorID,[],['Donor_Status'],['Campaign_ID'=>$DonorQueue->getCampaignID()]);
                return json_encode(['status'=>true,'message'=>'Rejected the Donation']);
            }else{
                return json_encode(['status'=>false,'message'=>'Error Occured','errors'=>$RejectedDonation->getErrors()]);
            }
        }
    }

    public function CompleteDonation(Request $request,Response $response)
    {
        /* @var $DonorQueue CampaignDonorQueue*/
        /* @var $Donation Donation*/
        if ($request->isPost()){
            $DonorID=$request->getBody()['DonorID'];
            $Volume=$request->getBody()['Volume'];
            $DonorQueue=CampaignDonorQueue::findOne(['Donor_ID'=>$DonorID,'Donor_Status'=>CampaignDonorQueue::STAGE_3],false);
            if (!$DonorQueue){
                return json_encode(['status'=>false,'message'=>'Donor not ready for donation!']);
            }
            $Donation=Donation::findOne(['Donor_ID'=>$DonorID,'Status'=>Donation::STATUS_BLOOD_RETRIEVING],false);
            if (!$Donation){
                return json_encode(['status'=>false,'message'=>'Donation not started!']);
            }
            $DonorQueue->setDonor_Status(CampaignDonorQueue::STAGE_4);
            $Donation->setStatus(Donation::STATUS_BLOOD_STORED);
            $Donation->setEndAt(date('Y-m-d H:i:s'));
            $BloodPacket = new BloodPackets();
            $BloodPacket->loadData($request->getBody());
            $BloodPacket->setStatus(BloodPackets::STATUS_STORED);
            $BloodPacket->setPackedBy(Application::$app->getUser()->getID());
            $BloodGroup=DonorBloodCheck::findOne(['Donor_ID'=>$DonorID],false)->getBloodGroup();
            $BloodPacket->setBloodGroup($BloodGroup);
            $BloodPacket->setStoredAt(date('Y-m-d H:i:s'));
            if ($BloodPacket->validate() && $BloodPacket->save()){
                $Accepted_Donation=new AcceptedDonations();
                $Accepted_Donation->setDonationID($Donation->getDonationID());
                $Accepted_Donation->setDonatedAt($Donation->getStartAt());
                $Accepted_Donation->setInTime($Donation->getStartAt());
                $Accepted_Donation->setOutTime($Donation->getEndAt());
                $Accepted_Donation->setPacketID($BloodPacket->getPacketID());
                $Accepted_Donation->setDonorID($DonorID);
                $Accepted_Donation->setVolume($Volume);
                $Accepted_Donation->setRetrievedBy(Application::$app->getUser()->getID());
                $Accepted_Donation->setVerifiedBy(Application::$app->getUser()->getID());
                $Donation->update($Donation->getDonationID(),[],['Status','End_At']);
                $DonorQueue->update($DonorQueue->getDonorID(),[],['Donor_Status']);
                if ($Accepted_Donation->validate() && $Accepted_Donation->save()) {
                    return json_encode(['status' => true, 'message' => 'Donation Completed!']);
                }else{

                    $this->setFlashMessage('error', 'Donation Failed!');
                    return json_encode(['status' => false, 'message' => 'Donation Failed!', 'error' => $Accepted_Donation->getErrors()]);
                }
            }else{
                $this->setFlashMessage('error', 'Donation Failed!');
                return json_encode(['status' => false, 'message' => 'Donation Failed!s']);
            }
        }
    }

    public function RegisterDonor(Request $request,Response $response)
    {
        /* @var File $NICFront*/
        if ($request->isPost()){
            $Donor = new Donor();
            $User= new User();

            $ID=uniqid('Dnr_');
            $Donor->setID($ID);
            $Donor->loadData($request->getBody());
            $NICFront = $request->getBody()['NICFront'];
            $NICBack = $request->getBody()['NICBack'];

            if ($NICFront && $NICBack){
                $NICFront->setFileName('Donor/NIC/'.$ID.'_NICFront.'.$NICFront->getExtension());
                $NICBack->setFileName('Donor/NIC/'.$ID.'_NICBack.'.$NICBack->getExtension());
                $Donor->setNICFront($NICFront->getFileName());
                $Donor->setNICBack($NICBack->getFileName());
            }else{
                return json_encode([
                    'status'=>false,
                    'message'=>'NIC Front and Back images are required!'
                ]);
            }
            $BloodDonation_Book_1 = $request->getBody()['BloodDonationBook_1'];
            $BloodDonation_Book_2 = $request->getBody()['BloodDonationBook_2'];
            if ($BloodDonation_Book_1 && $BloodDonation_Book_2) {
                $BloodDonation_Book_1->setFileName('Donor/BloodDonationBook/' . $ID . '_BloodDonationBook_1.' . $BloodDonation_Book_1->getExtension());
                $BloodDonation_Book_2->setFileName('Donor/BloodDonationBook/' . $ID . '_BloodDonationBook_2.' . $BloodDonation_Book_2->getExtension());
                $Donor->setBloodDonationBook1($BloodDonation_Book_1->getFileName());
                $Donor->setBloodDonationBook2($BloodDonation_Book_2->getFileName());
            }
            $Donor->setNearestBank(Application::$app->getUser()->getBranchID());
            $Donor->setDonationAvailability(Donor::AVAILABLE);
            $Donor->setVerified(Donor::VERIFIED);
            $Donor->setVerifiedAt(date('Y-m-d H:i:s'));
            $Donor->setVerifiedBy(Application::$app->getUser()->getId());
            $Donor->setCreatedAt(date('Y-m-d H:i:s'));
            $Donor->setUpdatedAt(date('Y-m-d H:i:s'));
            $Donor->setGender('M');
            $Donor->setStatus(Donor::ACTIVE);
            $hash_NIC = password_hash($Donor->getNIC(),PASSWORD_DEFAULT);
            $User->setEmail($Donor->getEmail());
            $User->setPassword($hash_NIC);
            $User->setRole(User::DONOR);
            $User->setUid($ID);
            $User->setAccountStatus(User::ACTIVE);
            if ($User->validate() && $Donor->validate()) {
                $User->save();
                $Donor->save();
                $NICFront->saveFile();
                $NICBack->saveFile();
                if ($BloodDonation_Book_1 && $BloodDonation_Book_2) {
                    $BloodDonation_Book_1->saveFile();
                    $BloodDonation_Book_2->saveFile();
                }
                $this->setFlashMessage('success','Donor Registered Successfully!');
                return json_encode([
                    'status' => true,
                    'message' => 'Donor Registered Successfully!'
                ]);
            }else{
                return json_encode([
                    'status'=>false,
                    'message'=>'Invalid Data!',
                    'errors'=>[
                        'User'=>$User->errors,
                        'Donor'=>$Donor->errors
                    ]
                ]);
            }

            //  TODO : Set Donor Password
        }
    }

    public function RegisterDonorForCampaign(Request $request,Response $response)
    {
        if ($request->isPost()){
            $Status = $request->getBody()['Status'];
            $DonorID = $request->getBody()['DonorID'];
            $CampaignID = $request->getBody()['CampaignID'];
            if (!$Status || !$DonorID || !$CampaignID){
                return json_encode([
                    'status'=>false,
                    'message'=>'Invalid Data!'
                ]);
            }
            /** @var Donor $Donor */
            $Donor = Donor::findOne(['Donor_ID'=>$DonorID],false);
            $Campaign = Campaign::findOne(['Campaign_ID'=>$CampaignID],false);
            if (!$Donor || !$Campaign){
                return json_encode([
                    'status'=>false,
                    'message'=>'Invalid Data!'
                ]);
            }

            if ($Status==='1'){
                $OngoingDonationVerification = CampaignDonorQueue::findOne(['Donor_ID'=>$DonorID,'Campaign_ID'=>$CampaignID],false);
                if ($OngoingDonationVerification){
                    return json_encode([
                        'status'=>false,
                        'message'=>'Donor already registered for this campaign!'
                    ]);
                }
                if (!$Donor->getNICFront() || !$Donor->getNICBack()){
                    return json_encode([
                        'status'=>false,
                        'message'=>'Donor NIC Front and Back images are required!'
                    ]);
                }
                $OngoingDonationVerification = new CampaignDonorQueue();
                $OngoingDonationVerification->setDonorID($DonorID);
                $OngoingDonationVerification->setCampaignID($CampaignID);
                $OngoingDonationVerification->setDonor_Status(CampaignDonorQueue::STAGE_1);
                $OngoingDonationVerification->setLastUpdated(date('Y-m-d H:i:s'));

                if ($OngoingDonationVerification->validate()) {
                    $OngoingDonationVerification->save();
                    $this->setFlashMessage('success', 'Donor Registered Successfully!');
                    return json_encode([
                        'status' => true,
                        'message' => 'Donor Registered Successfully!'
                    ]);
                }else{
                    return json_encode([
                        'status'=>false,
                        'message'=>'Invalid Data!',
                        'errors'=>[
                            'CampaignDonorQueue'=>$OngoingDonationVerification->errors,
                        ]
                    ]);
                }
            }
        }
    }

    public function UploadDonorNICFront(Request $request,Response $response)
    {
        if ($request->isPost()){

            $DonorID = $request->getBody()['DonorID'];
            $File = $request->getBody()['NICFront'];
            /** @var Donor $Donor */
            /** @var File $File */

            $Donor = Donor::findOne(['Donor_ID'=>$DonorID],false);
            if (!$Donor){
                return json_encode([
                    'status'=>false,
                    'message'=>'Invalid Donor ID!'
                ]);
            }
            $File->setFileName('Donor/NIC/'.$DonorID.'/'.uniqid("NICFront_").".".$File->getExtension());
            $Donor->setNICFront($File->getFileName());
            if ($Donor->validate(true)) {
                $Donor->update($Donor->getID(),[],['NIC_Front']);
                $File->saveFile();
                return json_encode([
                    'status' => true,
                    'message' => 'NIC Front Uploaded Successfully!'
                ]);
            }else{
                return json_encode([
                    'status'=>false,
                    'message'=>'Invalid Data!',
                    'errors'=>[
                        'Donor'=>$Donor->errors,
                    ]
                ]);
            }
        }
    }
    public function UploadDonorNICBack(Request $request,Response $response)
    {
        if ($request->isPost()){

            $DonorID = $request->getBody()['DonorID'];
            $File = $request->getBody()['NICBack'];
            /** @var Donor $Donor */
            /** @var File $File */

            $Donor = Donor::findOne(['Donor_ID'=>$DonorID],false);
            if (!$Donor){
                return json_encode([
                    'status'=>false,
                    'message'=>'Invalid Donor ID!'
                ]);
            }
            $File->setFileName('Donor/NIC/'.$DonorID.'/'.uniqid("NICBack_").".".$File->getExtension());
            $Donor->setNICBack($File->getFileName());
            if ($Donor->validate(true)) {
                $Donor->update($Donor->getID(),[],['NIC_Back']);
                $File->saveFile();
                return json_encode([
                    'status' => true,
                    'message' => 'NIC Back Uploaded Successfully!'
                ]);
            }else{
                return json_encode([
                    'status'=>false,
                    'message'=>'Invalid Data!',
                    'errors'=>[
                        'Donor'=>$Donor->errors,
                    ]
                ]);
            }

        }
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return false|string
     */
    public function VerifyOrganization(Request $request, Response $response)
    {
        if ($request->isPost()){
            $status = $request->getBody()['Status'];
            $OrganizationID = $request->getBody()['OrganizationID'];
            $Reason = $request->getBody()['Reason'] ?? null;
            /** @var Organization $Organization */
            $Organization = Organization::findOne(['Organization_ID'=>$OrganizationID],false);
            if (!$Organization){
                return json_encode([
                    'status'=>false,
                    'message'=>'Invalid Operation!'
                ]);
            }
            $ID = Application::$app->getUser()->getID();
            $status= strtolower($status);
            $message = "";
            if ($status==="verify"){
                $Organization->setStatus(Organization::ORGANIZATION_VERIFIED);
                $Organization->setVerifiedBy($ID);
                $Organization->setVerifiedAt(date('Y-m-d H:i:s'));
                $message = "Organization Verified Successfully!";
            }elseif ($status==="reject"){
                if ($Reason===null){
                    return json_encode([
                        'status'=>false,
                        'message'=>'Reason is required!'
                    ]);
                }
                if (trim($Reason)===""){
                    return json_encode([
                        'status'=>false,
                        'message'=>'Reason is required!'
                    ]);
                }
                ReportOrganization::ReportOrganization($OrganizationID,$ID,$Reason);
                $Organization->setStatus(Organization::ORGANIZATION_REJECTED);
                $message = "Organization Rejected Successfully!";
            }else{
                return json_encode([
                    'status'=>false,
                    'message'=>'Invalid Operation!'
                ]);
            }
            $Organization->update($Organization->getID(),[],['Status','Verified_By','Verified_At','Remarks']);
            return json_encode([
                'status'=>true,
                'message'=>$message
            ]);
        }
        return json_encode([
            'status'=>true,
            'message'=>'Organization Verified Successfully!'
        ]);
    }
    public function ReportCampaign(Request $request,Response $response)
    {
        if ($request->isPost()){
            $CampaignID = $request->getBody()['CampaignID'];
            $Reason = $request->getBody()['Reason'] ?? 0;
            $Description = $request->getBody()['Description'];
            if ($Reason===0){
                return json_encode([
                    'status'=>false,
                    'message'=>'Invalid Operation!'
                ]);
            }
            /** @var Campaign $Campaign */
            $Campaign = Campaign::findOne(['Campaign_ID'=>$CampaignID],false);
            if (!$Campaign){
                return json_encode([
                    'status'=>false,
                    'message'=>'Invalid Operation!'
                ]);
            }


            $Reason = intval($Reason);
            if ($Reason===5){
                if (empty($Description)){
                    return json_encode([
                        'status'=>false,
                        'message'=>'Description is required!'
                    ]);
                }
            }
            $Campaign->setStatus(Campaign::CAMPAIGN_STATUS_REPORTED);
            if ($Reason===5){
                ReportedCampaign::ReportCampaign($CampaignID,$Reason,$Description);
            }else{
                ReportedCampaign::ReportCampaign($CampaignID,$Reason);
            }
            $Campaign->update($Campaign->getCampaignID(),[],['Status']);
            return json_encode([
                'status'=>true,
                'message'=>'Campaign Reported Successfully!'
            ]);
        }

    }

    public function UndoReportCampaign(Request $request,Response $response)
    {
        if ($request->isPost()){
            $CampaignID = $request->getBody()['CampaignID'];
            /** @var Campaign $Campaign */
            $Campaign = Campaign::findOne(['Campaign_ID'=>$CampaignID],false);
            if (!$Campaign){
                return json_encode([
                    'status'=>false,
                    'message'=>'Invalid Operation!'
                ]);
            }
            /** @var ReportedCampaign $ReportedCampaign */
            $ReportedCampaign = ReportedCampaign::findOne(['Campaign_ID'=>$CampaignID],false);
            $UserID = Application::$app->getUser()->getID();
            if ($ReportedCampaign->getReportedBy() !== $UserID){
                return json_encode([
                    'status'=>false,
                    'message'=>'Invalid Operation!'
                ]);
            }
            $Campaign->setStatus(Campaign::CAMPAIGN_STATUS_APPROVED);
            ReportedCampaign::UndoReportCampaign($CampaignID);

            $Campaign->update($Campaign->getCampaignID(),[],['Status']);
            return json_encode([
                'status'=>true,
                'message'=>'Campaign Reported Undo Successfully!'
            ]);
        }

    }

    public function AssignTasks(Request $request,Response $response)
    {
        if ($request->isPost())
        {
            $OfficerTasks = $request->getBody()['OfficerTasks'] ?? [];
            $TeamID = $request->getBody()['MedicalTeamID'] ?? null;

            if (!empty($OfficerTasks)){
                foreach ($OfficerTasks as $OfficerTask){
                    TeamMembers::updateOne(['Team_ID'=>$TeamID,'Member_ID'=>$OfficerTask['OfficerID']],['Task'=>$OfficerTask['OfficerTask']]);
                }
                return json_encode([
                    'status'=>true,
                    'message'=>'Tasks Assigned Successfully!'
                ]);
            }else{
                return json_encode([
                    'status'=>false,
                    'message'=>'No Tasks Assigned!'
                ]);
            }

        }
    }

    public function ChangeProfileImage(Request $request,Response $response)
    {
        /** @var $File File*/
        /** @var $MedicalOfficer MedicalOfficer*/
        $UserID= Application::$app->getUser()->getId();
        $MedicalOfficer = MedicalOfficer::findOne(['Officer_ID'=>$UserID]);
        $ExistingFile = $MedicalOfficer->getProfileImage();
        $File=$request->getBody()['profileImage'];
        if($File) {
            $File->setPath('Profile/MedicalOfficer');
            $filename = $File->GenerateFileName('MO_');
            $MedicalOfficer->setProfileImage($filename);
            if ($MedicalOfficer->update($MedicalOfficer->getID(), [], ['Profile_Image'])){
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

    public function ChangePassword(Request $request,Response $response)
    {
        if ($request->isPost()){
            $CurrentPassword = $request->getBody()['CurrentPassword'];
            $NewPassword = $request->getBody()['NewPassword'];
            $ConfirmPassword = $request->getBody()['ConfirmPassword'];
            if (empty($CurrentPassword) || empty($NewPassword) || empty($ConfirmPassword)){
                if (empty($CurrentPassword)){
                    return json_encode([
                        'status'=>false,
                        'message'=>'Current Password is required!',
                        'field'=>'CurrentPassword'
                    ]);
                }
                if (empty($NewPassword)){
                    return json_encode([
                        'status'=>false,
                        'message'=>'New Password is required!',
                        'field'=>'NewPassword'
                    ]);
                }
                if (empty($ConfirmPassword)){
                    return json_encode([
                        'status'=>false,
                        'message'=>'Confirm Password is required!',
                        'field'=>'ConfirmPassword'
                    ]);
                }
            }
            if (strlen($NewPassword)<8){
                return json_encode([
                    'status'=>false,
                    'message'=>'Password must be at least 8 characters long!',
                    'field'=>'NewPassword'
                ]);
            }

//            if (preg_match('/[A-Z]/', $NewPassword)===0){
//                return json_encode([
//                    'status'=>false,
//                    'message'=>'Password must contain at least one uppercase letter!'
//                ]);
//            }
//
//            if (preg_match('/[a-z]/', $NewPassword)===0){
//                return json_encode([
//                    'status'=>false,
//                    'message'=>'Password must contain at least one lowercase letter!'
//                ]);
//            }
//
//            if (preg_match('/[0-9]/', $NewPassword)===0){
//                return json_encode([
//                    'status'=>false,
//                    'message'=>'Password must contain at least one number!'
//                ]);
//            }
//
//            if (preg_match('/[^a-zA-Z\d]/', $NewPassword)===0){
//                return json_encode([
//                    'status'=>false,
//                    'message'=>'Password must contain at least one special character!'
//                ]);
//            }
//
//            if (preg_match('/\s/', $NewPassword)===1){
//                return json_encode([
//                    'status'=>false,
//                    'message'=>'Password must not contain any whitespace!'
//                ]);
//            }

            if ($ConfirmPassword!==$NewPassword){
                return json_encode([
                    'status'=>false,
                    'message'=>'New Password and Confirm Password does not match!',
                    'field'=>'ConfirmPassword'
                ]);
            }

            if ($CurrentPassword===$NewPassword){
                return json_encode([
                    'status'=>false,
                    'message'=>'New Password and Current Password cannot be same!',
                    'field'=>'NewPassword'
                ]);
            }


            $User = User::findOne(['UID'=>Application::$app->getUser()->getId()]);
            if (password_verify($CurrentPassword,$User->getPassword())){
                if ($NewPassword===$ConfirmPassword){
                    $User->setPassword(password_hash($NewPassword,PASSWORD_DEFAULT));
                    if ($User->update($User->getID(),[],['Password'])){
                        return json_encode([
                            'status'=>true,
                            'message'=>'Password Changed Successfully!'
                        ]);
                    }else{
                        return json_encode([
                            'status'=>false,
                            'message'=>'Password Not Changed!'
                        ]);
                    }
                }else{
                    return json_encode([
                        'status'=>false,
                        'message'=>'New Password and Confirm Password does not match!'
                    ]);
                }
            }else{
                return json_encode([
                    'status'=>false,
                    'message'=>'Current Password is incorrect!'
                ]);
            }
        }

    }


}