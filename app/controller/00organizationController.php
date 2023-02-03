<?php

namespace App\controller;

use App\model\users\organization;
use App\model\Authentication\Login;
use App\model\users\Campaign;
use App\model\users\User;
use Core\Application;
use Core\BaseMiddleware;
use Core\middleware\AuthenticationMiddleware;
use Core\middleware\ManagerMiddleware;
use Core\middleware\OrganisationMiddleware;
use Core\Request;
use Core\Response;

class oldOrganizationController extends \Core\Controller{

    public function __construct()
    {
        if (Application::$app->getUser()) {
            $role = Application::$app->getUser()->getRole();
//            Application::Redirect('/' . $role);

        }else{
            $this->registerMiddleware(new AuthenticationMiddleware(['UserLogin','register'], BaseMiddleware::ALLOWED_ROUTES));
        }
    }

    public function register(Request $request,Response $response): string
    {
        $user = new User();
        if($request->isPost()){
//            require_once Application::$ROOT_DIR.'/API/adduser.php';
//            $this->render('register','register');
            $user -> loadData($request->getBody());
            $user->setPassword(password_hash($request->getBody()['password'],PASSWORD_BCRYPT));
//            echo '<pre>';
//            print_r($request->getBody());
//            echo '</pre>';

            if($user->validate() && $user->register()){

                Application::$app->session->setFlash('success','Thanks for Registering.');
                Application::$app->response->redirect('/login');
            }

            return $this->render('Organization/register',[
                'model' => $user
            ]);
        }
//        $this->setLayout('auth');
        return $this->render('Organization/register',['model'=>$user]);
    }
    public function orglogin(Request $request,Response $response): string
    {
        $loginForm = new Login();
        if($request->isPost()){
            $loginForm->loadData($request->getBody());
            if($loginForm->validate() && $loginForm->login()){
                $response->redirect('/organization');
            }
        }
//        return $this->render('Organisation/login',[
//            'model' => $loginForm
//        ]);
        return $this->render('organization/login',['model'=>$loginForm]);
    }
    public function home(Request $request,Response $response): string
    {
//        $userName='';
        /* @var organization $organisation*/
        $organisation = organization::findOne(['id' => Application::$app->session->get('user')]);
        $params=[
            'name'=>$organisation->getName(),
        ];
//        if (isset($_SESSION['userInfo'])){
//            $userName=$_SESSION['userInfo'];
//        }
//        if($request->isPost()){
//            require_once Application::$ROOT_DIR.'/API/adduser.php';
//        }

        return $this->render('Organization',$params);
    }

    public function profile(Request $request,Response $response): string
    {
        if($request->isPost()){
            require_once Application::$ROOT_DIR.'/API/adduser.php';
        }
        return $this->render('Organisation\profile',);
    }

    public function manage(Request $request,Response $response): string
    {
//        $userPassword = '';
//        $userEmail = '';
//        $userEmail = $_SESSION['email'];
//        $userName = $_SESSION['userInfo'];

//        if($request->isPost()){
//            require_once Application::$ROOT_DIR.'/API/adduser.php';
//        }
        return $this->render('Organisation\manage');
    }
    public function create(Request $request,Response $response): string
    {
        $campaign = new Campaign();
        if($request->isPost()){
            $campaign -> loadData($request->getBody());
//            require_once Application::$ROOT_DIR.'/API/adduser.php';
            $campaign->create();
            Application::$app->response->redirect('/organisation/history');
        }
        return $this->render('Organisation\create');
    }
    public function history(Request $request,Response $response): string
    {
        $campaign='';
        $donor='';
        $history = new Organization();

          $data=$history::findAll(['manage'=>$_SESSION['user']]);
        if($request->isPost()){
            require_once Application::$ROOT_DIR.'/API/adduser.php';
        }
        return $this->render('Organisation\history',['campaign'=>$campaign,'donor'=>$donor,'data'=>$data]);
    }

    public function logout(Request $request,Response $response): string
    {
        if($request->isPost()){
            require_once Application::$ROOT_DIR.'/API/adduser.php';
        }
//        return $this->render('Organisation\home','Orghome');
        Application::$app->logout();
    }
}