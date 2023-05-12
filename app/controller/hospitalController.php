<?php
 namespace App\controller;

 use App\middleware\hospitalMiddleware;
 use App\model\Authentication\Login;
 use App\model\BloodBankBranch\BloodBank;
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
        return $this->render('Hospital/profile',['user'=>$user]);
    }

    public function dashboard():string
    {
     /* @var Hospital $hospital */
        $BloodBank = BloodBank::retrieveAll();
        return $this->render('Hospital/dashboard', ['BloodBanks' => $BloodBank]);
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
                $limit = 10;
        $page = Application::$app->request->getBody()['page'] ?? 1;
        $initial = ($page - 1) * $limit;
        $total_rows= BloodRequest::getCount(false, ['Status'=>BloodRequest::REQUEST_STATUS_PENDING]);
        $total_pages = ceil($total_rows / $limit);
        $requests=BloodRequest::RetrieveAll(true,[$initial,$limit],true,['Requested_By'=>Application::$app->getUser()->getID(),'Status'=>BloodRequest::REQUEST_STATUS_PENDING]);
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

            ];
        }
        //print_r($reqData);
     return $this->render('Hospital/showRequests',['data'=>$reqData,'total_pages'=>$total_pages,'current_page'=>$page]);
    }

    public function notification(Request $request, Response $response): string
    {
        if ($request->isPost()){
            $Notifications=HospitalNotification::RetrieveAll(false,[],true,['Target_ID'=>Application::$app->getUser()->getId()],['Notification_Date'=>'ASC']);
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
            $BloodRequest->setRequestID($newRequestID);
            $BloodRequest->setBloodGroup($newBloodGroup);
            $BloodRequest->setType($newType);
            $BloodRequest->setVolume($newQuantity);
            $BloodRequest->setRemarks($newRemarks);
            $BloodRequest->setRequestedAt($newRequestedAt);
            $BloodRequest->setRequestedBy($newRequestedBy);
            $BloodRequest->setStatus($newStatus);
            $BloodRequest->setRequestedFrom($newRequestFrom);
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
    public function takeBlood(Request $request, Response $response): string
    {
        $data = $request->getBody();
//        print_r($data);
//        exit();
        $donorInfo = Donor::findOne(['Donor_ID' => $data['Donor_ID']]);
//        print_r($donorInfo);
//        exit();
        $reqData[]=[
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
        ];

        return $this->render('Hospital/HospitalBloodDonation', ['data' => $reqData]);
    }

    public function bloodRequestHistory(Request $request, Response $response): string
    {
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

            ];
        }
        //print_r($reqData);
        return $this->render('Hospital/bloodRequestHistory',['data'=>$reqData,'total_pages'=>$total_pages1,'current_page'=>$page1]);
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
        if ($request->validate()){
            $request->update($request->getRequestID(),[],['Remarks','Volume']);
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
         $Donors = Donor::Search(['City' => $keyword, 'Donor_ID' => $keyword, 'NIC' => $keyword, 'First_Name' => $keyword, 'Last_Name' => $keyword, 'Email' => $keyword, 'Contact_No' => $keyword]);
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
                 'NIC_Back'=>$Donor->getNICBack()

//                 'Type'=>$Donor->getType(),
//                 'Last_Donated'=>Date::GetProperDateTime($Donor->getLastDonated()),
//                 'Status'=>$Donor->getStatus(),
             ];
         }
         header('Content-Type: application/json');
         return json_encode($returnData);
     }
}