<?php
 namespace App\controller;

 use App\middleware\hospitalMiddleware;
 use App\model\Authentication\Login;
 use App\model\Requests\BloodRequest;
 use App\model\users\Donor;
 use App\model\users\Hospital;
 use App\model\users\Manager;
 use App\model\users\MedicalOfficer;
 use App\model\users\User;
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
     $requests=BloodRequest::RetrieveAll(false,[],true,['Requested_By'=>Application::$app->getUser()->getID()]);
//     print_r($requests);
//     exit();
        $reqData=array();
        foreach ($requests as $request){
            //echo $request->getRequestedBy();
            //request->getRequestedAt();
            $reqData[]=[
                'Request ID'=>$request->getRequestID(),
                'Blood Group'=>$request->getBloodGroup(),
                'Requested At'=>$request->getRequestedAt(),
                'Type'=>$request->getType(),
                'Status'=>$request->getStatus(),
                'Quantity'=>$request->getQuantity(),
                'Remarks'=>$request->getRemarks(),
            ];
        }
        //print_r($reqData);
     return $this->render('Hospital/dashboard',['data'=>$reqData]);
    }

    public function notification(Request $request, Response $response): string
    {
        $limit = 10;
        $page = $request->getBody()['page'] ?? 1;
        $initial = ($page - 1) * $limit;
        $id=Application::$app->getUser()->getID();
        $total_rows = Notification::getCount(false,['Target_User' => $id]);
        $total_pages = ceil ($total_rows / $limit);
        $notifications = Notification::findAll(false, ['Target_User' => $id], $initial, $limit);
        $params = [
            'notifications' => $notifications,
            'total_pages' => $total_pages,
            'page' => $page
        ];
        return $this->render('Hospital/notification', $params);
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
//            $newBloodGroup = $data['bloodGroup'];
//            $newType = $data['type'];
//            $newQuantity = $data['quantity'];
//            $newRemarks = $data['remarks'];
            $newRequestedAt = date('Y-m-d H:i:s');
            $newRequestedBy =  Application::$app->getUser()->getID();
            $newStatus = 1;
            $newRequestID = $BloodRequest->getNewPrimaryKey($BloodRequest->getType());
            $BloodRequest->setRequestID($newRequestID);
//            $BloodRequest->setBloodGroup($newBloodGroup);
//            $BloodRequest->setType($newType);
//            $BloodRequest->setQuantity($newQuantity);
//            $BloodRequest->setRemarks($newRemarks);
            $BloodRequest->setRequestedAt($newRequestedAt);
            $BloodRequest->setRequestedBy($newRequestedBy);
            $BloodRequest->setStatus($newStatus);
//            $BloodRequest->save();
            if($BloodRequest->getQuantity()<1){
                $this->setFlashMessage('error','Please Enter Valid Quantity');
                Application::Redirect('/hospital/dashboard');
            }else if (trim($BloodRequest->getRemark())==""){
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
}