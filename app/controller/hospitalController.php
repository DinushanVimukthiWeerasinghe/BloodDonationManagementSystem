<?php
 namespace App\controller;

 use App\middleware\hospitalMiddleware;
 use App\model\Authentication\Login;
 use App\model\Blood\BloodGroup;
 use App\model\Blood\BloodPackets;
 use App\model\Blood\DonorBloodCheck;
 use App\model\BloodBankBranch\BloodBank;
 use App\model\Campaigns\CampaignDonorQueue;
 use App\model\Donations\AcceptedDonations;
 use App\model\Donations\Donation;
 use App\model\Donations\HospitalBloodDonations;
 use App\model\Donations\RejectedDonations;
 use App\model\Donor\DonorHealthCheckUp;
 use App\model\Notification\HospitalNotification;
 use App\model\Notification\ManagerNotification;
 use App\model\Requests\BloodRequest;
 use App\model\users\Donor;
 use App\model\users\Hospital;
 use App\model\users\Manager;
 use App\model\users\MedicalOfficer;
 use App\model\users\User;
 use App\model\Utils\Date;
 use App\model\Utils\Notification;
 use Core\Application;
 use Core\BaseMiddleware;
 use Core\Controller;
 use Core\File;
 use Core\middleware\AuthenticationMiddleware;
 use Core\Request;
 use Core\Response;
 use Core\SessionObject;
 use http\Message;

 class hospitalController extends Controller{
    public function __construct()
    {
         date_default_timezone_set('Asia/Colombo');
        $this->setLayout('hospital');
        $this->registerMiddleware(new hospitalMiddleware(['dashboard'], BaseMiddleware::FORBIDDEN_ROUTES));

    }
    public function profile(){
        $user=Application::$app->getUser();
//        print_r($user);
//        exit();
        return $this->render('Hospital/profile',['User'=>$user]);
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
             if (preg_match('/[A-Z]/', $NewPassword)===0){
                 return json_encode([
                     'status'=>false,
                     'message'=>'Password must contain at least one uppercase letter!'
                 ]);
             }

             if (preg_match('/[a-z]/', $NewPassword)===0){
                 return json_encode([
                     'status'=>false,
                     'message'=>'Password must contain at least one lowercase letter!'
                 ]);
             }

             if (preg_match('/[0-9]/', $NewPassword)===0){
                 return json_encode([
                     'status'=>false,
                     'message'=>'Password must contain at least one number!'
                 ]);
             }

             if (preg_match('/[^a-zA-Z\d]/', $NewPassword)===0){
                 return json_encode([
                     'status'=>false,
                     'message'=>'Password must contain at least one special character!'
                 ]);
             }

             if (preg_match('/\s/', $NewPassword)===1){
                 return json_encode([
                     'status'=>false,
                     'message'=>'Password must not contain any whitespace!'
                 ]);
             }

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

    public function dashboard():string
    {
     /* @var Hospital $hospital */
        $BloodBank = BloodBank::retrieveAll();
//        print_r($BloodBank);
//        exit();
        $user=Application::$app->getUser();
        return $this->render('Hospital/dashboard', ['User' => $user,'BloodBanks'=>$BloodBank]);
//        $limit = 10;
//        $page = Application::$app->request->getBody()['page'] ?? 1;
//        $initial = ($page - 1) * $limit;
//        $total_rows= BloodRequest::getCount(true, ['Requested_By' => Application::$app->getUser()->getID()]);
//        $total_pages = ceil($total_rows / $limit);
//        $requests=BloodRequest::RetrieveAll(true,[$initial,$limit],true,['Requested_By'=>Application::$app->getUser()->getID()]);
////     print_r($requests);
////     exit();
//        $reqData=array();
//        foreach ($requests as $request){
//            //echo $request->getRequestedBy();
//            //request->getRequestedAt();
//            $reqData[]=[
//                'Request ID'=>$request->getRequestID(),
//                'Blood Group'=>$request->getBloodGroup(),
//                'Requested At'=>Date::GetProperDateTime($request->getRequestedAt()),
//                'Type'=>$request->getType(),
//                'Status'=>$request->getStatus(),
//                'Volume'=>$request->getVolume(),
//                'Remarks'=>$request->getRemarks(),
//
//            ];
//        }
//        //print_r($reqData);
//     return $this->render('Hospital/dashboard',['data'=>$reqData,'total_pages'=>$total_pages,'current_page'=>$page]);
    }
    public function showRequests(){
        $user=Application::$app->getUser();
                $limit = 10;
        $page = Application::$app->request->getBody()['page'] ?? 1;
        $initial = ($page - 1) * $limit;
        $total_rows= BloodRequest::getCount(false, ['Status'=>BloodRequest::REQUEST_STATUS_PENDING]);
        $total_pages = ceil($total_rows / $limit);
        $requests=BloodRequest::RetrieveAll(true,[$initial,$limit],true,['Requested_By'=>Application::$app->getUser()->getID(),'Status'=>BloodRequest::REQUEST_STATUS_PENDING]);
//        print_r($requests);
//        exit();
//        print_r($total_pages);
//        print_r($total_rows);
//     exit();
        $reqData=array();
        foreach ($requests as $request){
            //echo $request->getRequestedBy();
            //request->getRequestedAt();
            $reqData[]=[
                'Request ID'=>$request->getRequestID(),
                'Blood Group'=>$request->getBloodGroup(),
                'Requested At'=>Date::GetProperDateTime($request->getRequestedAt()),
                'Type'=>$request->getType(),
                'Status'=>$request->getStatus(),
                'Volume'=>$request->getVolume(),
                'Remarks'=>$request->getRemarks(),
                'Name'=>$request->getName(),

            ];
        }
        //print_r($reqData);
     return $this->render('Hospital/showRequests',['data'=>$reqData,'total_pages'=>$total_pages,'current_page'=>$page,'User'=>$user]);
    }

    public function notification(Request $request, Response $response)
    {
        if ($request->isPost()){
            $Notifications=HospitalNotification::RetrieveAll(false,[],true,['Target_ID'=>Application::$app->getUser()->getId(),'Target_ID'=>null],['Notification_Date'=>'ASC']);
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

    public function addRequest(Request $request, Response $response)
    {
        $hospital = Hospital::findOne(['Hospital_ID' => Application::$app->getUser()->getID()]);
        $BloodRequest = new BloodRequest();
        $data =$request->getBody();
//        print_r($data);
//        exit();

        if ($request->isPost()){
//            print_r($request->getBody());
            $BloodRequest->loadData($request->getBody());
//            print_r($request->getBody());
//            exit();
            $newBloodGroup = $data['BloodGroup'];
            $newType = $data['Type'];
            $newQuantity = $data['Volume'];
            $newRemarks = $data['Remarks'];
            $newRequestFrom= $data['RequestFrom'];
            $newRequestedAt = date('Y-m-d H:i:s');
            $newRequestedBy =  Application::$app->getUser()->getID();
            $newStatus = 1;
            $newRequestID = $BloodRequest->getNewPrimaryKey($BloodRequest->getType());
            $newName = $data['Name'];
            $BloodRequest->setRequestID($newRequestID);
            $BloodRequest->setBloodGroup($newBloodGroup);
            $BloodRequest->setType($newType);
            $BloodRequest->setVolume($newQuantity);
            $BloodRequest->setRemarks($newRemarks);
            $BloodRequest->setRequestedAt($newRequestedAt);
            $BloodRequest->setRequestedBy($newRequestedBy);
            $BloodRequest->setStatus($newStatus);
            $BloodRequest->setRequestedFrom($newRequestFrom);
            $BloodRequest->setName($newName);
//            $BloodRequest->save();
            if($BloodRequest->getVolume()<1){
                $this->setFlashMessage('error','Please Enter Valid Quantity');
                Application::Redirect('/hospital/dashboard');
            }else if (trim($BloodRequest->getRemarks())==""){
                $this->setFlashMessage('error','Please Enter Remarks');
                Application::Redirect('/hospital/dashboard');
            }else if(strlen($BloodRequest->getRemarks())>100){
                $this->setFlashMessage('error','Remarks should be less than 100 characters');
                Application::Redirect('/hospital/dashboard');
            }else{
                if ($BloodRequest->validate() && $BloodRequest->save()){
                    $this->setFlashMessage('success','Request sent Successfully');
                }
                else{
                    $this->setFlashMessage('error','Request sending failed');
                }
            }
            $response->redirect('/hospital/dashboard');
        }
    }
    public function showDetails(Request $request, Response $response): string
    {
        $user=Application::$app->getUser();
        $data = $request->getBody();
//        print_r($data);
//        exit();
        $donorInfo = Donor::findOne(['Donor_ID' => $data['Donor_ID']]);
//        print_r($donorInfo);
//        exit();
        $reqData=[
            'Donor_ID'=>$donorInfo->getDonorID(),
            'First_Name'=>$donorInfo->getFirstName(),
            'Last_Name'=>$donorInfo->getLastName(),
            'NIC'=>$donorInfo->getNIC(),
            'Email'=>$donorInfo->getEmail(),
            'Contact_No'=>$donorInfo->getContactNo(),
            'City'=>$donorInfo->getCity(),
            'Blood_Group'=>$donorInfo->getBloodGroup(),
            'Donation_Availability'=>$donorInfo->getDonationAvailability(),
            'Verified'=>$donorInfo->getVerified(),
            'NIC_Front'=>$donorInfo->getNICFront(),
            'NIC_Back'=>$donorInfo->getNICBack(),
            'Profile_Image'=>$donorInfo->getProfileImage(),
            'Donor'=>$donorInfo,
        ];

        return $this->render('Hospital/HospitalBloodDonation', ['data' => $reqData,'User'=>$user]);
    }

    public function bloodRequestHistory(Request $request, Response $response): string
    {
        $user=Application::$app->getUser();
        $limit = 10;
        $page1 = Application::$app->request->getBody()['page'] ?? 1;
        $initial1 = ($page1 - 1) * $limit;
        $total_rows1= BloodRequest::getCount(false, ['Status'=>BloodRequest::REQUEST_STATUS_FULFILLED]);
//        $total_rows1+=BloodRequest::getCount(false,['Requested_By'=>Application::$app->getUser()->getID()]);
        $total_pages1 = ceil($total_rows1/ $limit);
        $requests1=BloodRequest::RetrieveAll(true,[$initial1,$limit],true,['Requested_By'=>Application::$app->getUser()->getID(),'Status'=>BloodRequest::REQUEST_STATUS_FULFILLED]);
//        print_r($total_pages1);
//        print_r($total_rows1);
//        exit();
//     print_r($requests);
//     exit();
        $reqData=array();
        foreach ($requests1 as $request){
            //echo $request->getRequestedBy();
            //request->getRequestedAt();
            $reqData[]=[
                'Request ID'=>$request->getRequestID(),
                'Blood Group'=>$request->getBloodGroup(),
                'Requested At'=>Date::GetProperDateTime($request->getRequestedAt()),
                'Type'=>$request->getType(),
                'Status'=>$request->getStatus(),
                'Volume'=>$request->getVolume(),
                'Remarks'=>$request->getRemarks(),
                'Name'=>$request->getName(),

            ];
        }
        //print_r($reqData);
        return $this->render('Hospital/bloodRequestHistory',['data'=>$reqData,'total_pages'=>$total_pages1,'current_page'=>$page1,'User'=>$user]);
    }

    public function editRequest(Request $request, Response $response):string
    {
        $data = $request->getBody();
//        print_r($data);
//        exit();
        $requestID = $data['RequestId'];
//        print_r($data);
//        exit();
        $request = BloodRequest::findOne(['Request_ID'=>$requestID]);
        $request->setRemarks($data['Remarks']);
        $request->setVolume($data['Volume']);
        $request->setName($data['Name']);
        if ($request->validate()){
            $request->update($request->getRequestID(),[],['Remarks','Volume','Name']);
//            $request->save();
            $this->setFlashMessage('success','Request Updated Successfully');
        }
        else{
            $this->setFlashMessage('error','Request Updation Failed');
        }
        $response->redirect('/hospital/requests');


    }
     public function deleteRequest(Request $request, Response $response):string
     {
            $data = $request->getBody();
//            print_r($data);
//            exit();
            $requestID = $data['RequestId'];
            $request = BloodRequest::findOne(['Request_ID'=>$requestID]);
            if ($request->delete(['Request_ID'=>$requestID])){
                $this->setFlashMessage('success','Request Deleted Successfully');
            }
            else{
                $this->setFlashMessage('error','Request Deletion Failed');
            }
            $response->redirect('/hospital/requests');
     }

     public function searchDonor(Request $request, Response $response): string
     {
         $data = $request->getBody();
            $keyword = $data['keyword'];
         $Donors = Donor::Search(['City' => $keyword, 'Donor_ID' => $keyword, 'NIC' => $keyword, 'First_Name' => $keyword, 'Last_Name' => $keyword, 'Email' => $keyword, 'Contact_No' => $keyword] );
//            $donors = Donor::search(['Donor_ID'=>$keyword]);
//         print_r($Donors);
         $returnData = array();
         foreach ($Donors as $Donor){
             $returnData[] = [
                 'Donor_ID'=>$Donor->getDonorID(),
                 'First_Name'=>$Donor->getFirstName(),
                 'Last_Name'=>$Donor->getLastName(),
                 'NIC'=>$Donor->getNIC(),
                 'Email'=>$Donor->getEmail(),
                 'Contact_No'=>$Donor->getContactNo(),
                 'City'=>$Donor->getCity(),
                 'Blood_Group'=>$Donor->getBloodGroup(),
                 'Donation_Availability'=>$Donor->getDonationAvailability(),
                 'Verified'=>$Donor->getVerified(),
                 'NIC_Front'=>$Donor->getNICFront(),
                 'NIC_Back'=>$Donor->getNICBack(),

//                 'Type'=>$Donor->getType(),
//                 'Last_Donated'=>Date::GetProperDateTime($Donor->getLastDonated()),
//                 'Status'=>$Donor->getStatus(),
             ];
         }
         header('Content-Type: application/json');
         return json_encode($returnData);
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

     public function HealthCheckup(Request $request, Response $response)
     {
         $user = Application::$app->getUser();
         if ($request->isGet()) {
             $data = $request->getBody();

             $Id = $_GET['Id'];
             $donorInfo = Donor::findOne(['Donor_ID' => $Id]);
//         print_r($data);
//         exit();
//         $donorInfo = Donor::findOne(['NIC' => $data['NIC']]);

//        print_r($donorInfo);
//        exit();
             $reqData = [
                 'Donor_ID' => $donorInfo->getDonorID(),
                 'First_Name' => $donorInfo->getFirstName(),
                 'Last_Name' => $donorInfo->getLastName(),
                 'NIC' => $donorInfo->getNIC(),
                 'Email' => $donorInfo->getEmail(),
                 'Contact_No' => $donorInfo->getContactNo(),
                 'City' => $donorInfo->getCity(),
                 'Blood_Group' => $donorInfo->getBloodGroup(),
                 'Donation_Availability' => $donorInfo->getDonationAvailability(),
                 'Verified' => $donorInfo->getVerified(),
                 'NIC_Front' => $donorInfo->getNICFront(),
                 'NIC_Back' => $donorInfo->getNICBack(),
                 'Profile_Image' => $donorInfo->getProfileImage(),
                 'Donor' => $donorInfo,
             ];

//         $model['Donor']=$Donor;
//         return $this->render('/Hospital/HealthCheck', $model);
             return $this->render('/Hospital/HealthCheck', ['data' => $reqData, 'User' => $user]);
         } else if ($request->isPost()) {
//                $data = $request->getBody();
             $Id = $_GET['Id'];
             Application::Redirect('/hospital/bloodCheck?Id=' . $Id);



         }
     }

     public function BloodCheck(Request $request, Response $response): string
     {
         $user=Application::$app->getUser();
//         print_r($request->getBody());
//         exit();
//         $data = $request->getBody();
//            $Id= $_GET['Id'];
//         $Donor = Donor::findOne(['Donor_ID' => $Id]);
////            print_r($Id);
////            exit();
//         if ($request->isGet()) {
//             return $this->render('/Hospital/BloodCheck',['Donor'=>$Donor]);
//         }
         if ($request->isPost()) {
             $UserID = Application::$app->getUser()->getID();
             $DonorBloodCheck = new DonorBloodCheck();
             $DonorBloodCheck->loadData($request->getBody());
             $BloodPressure = $request->getBody()['Blood_Pressure'] ?? 0;
             if ($BloodPressure) {
                 $UpperBloodPressure = (float)explode("/", $BloodPressure)[0];
                 $LowerBloodPressure = (float)explode("/", $BloodPressure)[1];
                 $DonorBloodCheck->setBloodPressureUpper($UpperBloodPressure);
                 $DonorBloodCheck->setBloodPressureLower($LowerBloodPressure);
             }
             $DonorBloodCheck->setCheckedAt(date('Y-m-d H:i:s'));
             $DonorBloodCheck->setCheckedBy($UserID);
             $DonorQueue = CampaignDonorQueue::findOne(['Donor_ID' => $DonorBloodCheck->getDonorID()]);
             $CampaignID = $DonorQueue->getCampaignID();
             $DonorBloodCheck->setCampaignID($CampaignID);
             $Diseases = $request->getBody()['Disease'] ?? null;
             if ($Diseases) {
                 $DonorBloodCheck->setInfectionDiseases(implode(" ", $Diseases));
             } else {
                 $DonorBloodCheck->setInfectionDiseases("None");
             }
             if ($DonorBloodCheck->validate() && $DonorBloodCheck->save()) {
                 $DonorQueue->setDonor_Status(CampaignDonorQueue::STAGE_3);
                 $DonorQueue->update($DonorBloodCheck->getDonorID(), [], ['Donor_Status']);
                 $this->setFlashMessage('success', 'Donor Blood Check Up Completed!');
                 Application::Redirect('/hospital/bloodCheck?Id='.$DonorBloodCheck->getDonorID());
             } else {
                 $Errors = $DonorBloodCheck->getErrors();
                 $FirstError = array_shift($Errors);
                 $this->setFlashMessage('error', 'err');

                 $Donor = $DonorQueue->getDonor();
                 $model['Donor'] = $Donor;
                 $model['BloodCheck'] = $DonorBloodCheck;
                 $BloodType = BloodGroup::RetrieveAll();
                 $model['BloodType'] = $BloodType;
                 return $this->render('/Hospital/BloodCheck', $model);
             }
         }else{
                $Id= $_GET['Id'];
                $BloodType = BloodGroup::RetrieveAll();
             $Donor = Donor::findOne(['Donor_ID' => $Id]);
             return $this->render('/Hospital/BloodCheck',['Donor'=>$Donor,'BloodType'=>$BloodType,'User'=>$user]);
         }
     }

         public function TakeDonation(Request $request, Response $response): string
         {
             $user=Application::$app->getUser();
             $data = $request->getBody();
            $Id= $_GET['id'];
             $Donor = Donor::findOne(['Donor_ID' => $Id]);
             $IsDonationStarted=HospitalBloodDonations::findOne(['Donor_ID'=>$Donor->getID()],false);
             if ($IsDonationStarted){
                 $model['Donation']=$IsDonationStarted;
                 $model['BloodRetrievingStarted']=true;

             }
             $model['Donor']=$Donor;
             $model['User']=$user;
//             print_r($Donor);
//                exit();
             return $this->render('/Hospital/TakeBlood', $model);
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
         if ($request->isPost()){
             $DonorID=$request->getBody()['DonorID'];
             $Donation=new HospitalBloodDonations();
                $Donation->setDonorID($DonorID);
                $Donation->setDonationAt(date('Y-m-d H:i:s'));
                $Donation->setDonationID(uniqid('D'));
                $Donation->setVolume(1);
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
         $RejectedDonation = new RejectedDonations();
         if ($request->isPost()){
                 return json_encode(['status'=>true,'message'=>'Rejected the Donation']);
             }else{
                 return json_encode(['status'=>false,'message'=>'Error Occured','errors'=>$RejectedDonation->getErrors()]);
             }

     }

     public function CompleteDonation(Request $request,Response $response)
     {
         /* @var $DonorQueue CampaignDonorQueue*/
         /* @var $Donation Donation*/
         if ($request->isPost()){
             $DonorID=$request->getBody()['DonorID'];
             $Volume=$request->getBody()['Volume'];

             $Donation=HospitalBloodDonations::findOne(['Donor_ID'=>$DonorID],false);
             if (!$Donation){
                 return json_encode(['status'=>false,'message'=>'Donation not started!']);
             }
             $Donation= HospitalBloodDonations::findOne(['Donor_ID'=>$DonorID],false);
             $Donation->delete();
             return json_encode(['status' => true, 'message' => 'Donation Completed!']);
             }else{
                 $this->setFlashMessage('error', 'Donation Failed!');
                 return json_encode(['status' => false, 'message' => 'Donation Failed!s']);
             }

     }

 }