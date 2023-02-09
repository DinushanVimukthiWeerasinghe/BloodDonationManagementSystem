<?php

namespace App\controller;

use App\middleware\medicalOfficerMiddleware;
use App\model\Campaigns\Campaign;
use App\model\MedicalTeam\TeamMembers;
use App\model\users\Donor;
use Core\Application;
use Core\BaseMiddleware;
use Core\Request;
use Core\Response;

class medicalOfficerController extends \Core\Controller
{

    public function __construct()
    {
        $this->setLayout('MedicalOfficer');

        $this->registerMiddleware(new medicalOfficerMiddleware(['dashboard'], BaseMiddleware::FORBIDDEN_ROUTES));

    }

    public function Dashboard(Request $request, Response $response)
    {
        return $this->render('/MedicalOfficer/MedicalOfficerdashboard');
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


}