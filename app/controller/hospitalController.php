<?php
 namespace App\controller;

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

class hospitalController extends Controller{
    public function __construct()
    {
        $this->setLayout('hospital');
        $this->registerMiddleware(new AuthenticationMiddleware(['login'], BaseMiddleware::ALLOWED_ROUTES));
    }
    public function profile(){
        $user=Application::$app->getUser();
        return $this->render('Hospital/profile',['user'=>$user]);
    }

    public function dashboard():string
    {
     /* @var Hospital $hospital */
     $requests=BloodRequest::RetrieveAll();
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
                'Status'=>$request->getStatus()
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
}