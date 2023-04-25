<?php

namespace App\controller;

use App\model\BloodBankBranch\BloodBank;
use Core\Controller;

class apiController extends Controller
{
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
