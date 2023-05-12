<?php

namespace App\controller;

use App\model\BloodBankBranch\BloodBank;
use App\model\Requests\AttendanceAcceptedRequest;
use App\model\users\Donor;
use App\model\users\Manager;
use Core\Controller;
use Core\Request;
use Core\Response;
class apiController extends Controller
{
    public function checkAttendance(Request $request, Response $response){
        $data = $request->getBody();
        $flag = false;
//        error_log($data['userID']);
//        error_log($data['campaignID']);

        $attendance = AttendanceAcceptedRequest::findOne(['Donor_ID'=>$data['userID'],'Campaign_ID'=>$data['campaignID']]);
        if ($attendance){$flag = true;}
        return json_encode($flag);
    }
    public function getBloodGroups(){
        $APositive = Donor::RetrieveAll(false,[],true,['BloodGroup'=>'A+']);
        $ANegative = Donor::RetrieveAll(false,[],true,['BloodGroup'=>'A-']);
        $BPositive = Donor::RetrieveAll(false,[],true,['BloodGroup'=>'B+']);
        $BNegative = Donor::RetrieveAll(false,[],true,['BloodGroup'=>'B-']);
        $ABPositive = Donor::RetrieveAll(false,[],true,['BloodGroup'=>'AB+']);
        $ABNegative = Donor::RetrieveAll(false,[],true,['BloodGroup'=>'AB-']);
        $OPositive = Donor::RetrieveAll(false,[],true,['BloodGroup'=>'O+']);
        $ONegative = Donor::RetrieveAll(false,[],true,['BloodGroup'=>'O-']);

        $bloodGroups = [
            'A+' => count($APositive),
            'A-'=> count($ANegative),
            'B+' => count($BPositive),
            'B-' => count($BNegative),
            'AB+' => count($ABPositive),
            'AB-' => count($ABNegative),
            'O+' => count($OPositive),
            'O-' => count($ONegative),
            ];
        error_log(implode('',
            $bloodGroups));
//        exit();
        return json_encode($bloodGroups);
    }
    public function getManagers(): bool|string{
        $managers = Manager::RetrieveAll();
        $mng = [];
        foreach ($managers as $manager){
            $managerID = $manager->getManagerID();
            $mng[$managerID] = ['id'=>$managerID ,'name'=>$manager->getFullName()];
        }
        return json_encode($mng);
    }
    public function getBloodBanks(): bool|string
    {
        $bloodBanks=BloodBank::RetrieveAll();
        $bb=[];
        foreach ($bloodBanks as $bloodBank)
        {
            $bankName=$bloodBank->getBankName();
            $bankId=$bloodBank->getBloodBankID();
//            $bankBranches=$bloodBank->getBankBranches();
            $bb[$bankName]=[
                'id'=>$bankId,
                'name'=>$bankName
            ];
        }
        
        return json_encode($bb);

    }

}
