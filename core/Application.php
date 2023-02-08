<?php
namespace Core;
use App\model\Authentication\LoggingHistory;
use App\model\Authentication\Login;
use App\model\Authentication\OTPCode;
use App\model\Email\BaseEmail;
use App\model\users\Admin;
use App\model\users\Donor;
use App\model\users\Hospital;
use App\model\users\Manager;
use App\model\users\MedicalOfficer;
use App\model\users\Organization;
use App\model\users\Person;
use App\model\users\Sponsor;
use App\model\users\User;
use Exception;

class Application
{
    public string $layout = 'main';
    public static string $ROOT_DIR;
    public Router $router;
    public Request $request;
    public Response $response;

    private Person | Admin| Login | null $user;
    public static Application $app;
    public Controller $controller;
    public Database $db;
    public View $view;
    public Session $session;
    public forbiddenRoute $forbiddenRoute;
    public BaseEmail $email;

    public static function Redirect($path): void
    {
        Application::$app->response->redirect($path);
    }

    public static function CreateDirectories(array $directories): void
    {
        foreach ($directories as $directory) {

            if (!file_exists(Application::$ROOT_DIR.'/'.$directory)) {
                mkdir(Application::$ROOT_DIR.'/'.$directory, 0777, true);
            }
        }
    }

    /**
     * @param User|null $user
     */
    public function setUser(null | User | Login $user): void
    {
        $this->user = $user;
    }





    public static function getRole(): string
    {
        return self::$app->user->getRole();
    }

    /**
     * @return User|null
     */
    public function getUser(): Person | null | Admin | Login
    {
//        print_r($this->user);
        return $this->user;
    }

    public function isGuest(): bool
    {
        return $this->user === null;
    }

    public function getForbiddenRoutes(): forbiddenRoute
    {
        return $this->forbiddenRoute;
    }


    /**
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function __construct($path, array $config)
    {
        self::$app=$this;
        $this->view = new View();
        $this->db = new Database($config['db']);
        $this->forbiddenRoute = new forbiddenRoute();

        self::$ROOT_DIR = $path;
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);
        $this->email = new BaseEmail($config['email']);
//        $this->db->applyMigrations();

        if(isset($_SESSION['user']))
        {
            $UserClass=$_SESSION['user']->getSessionData()['UserClass'];

            $UserID=$_SESSION['user']->getSessionData()['UID'];
            $this->user = $UserClass::findOne([$UserClass::PrimaryKey()=>$UserID]);
        }
        else
        {
            $this->user = null;
        }
    }

    public function login(Login $user): bool
    {
        $Role=$user->getRole();
        $ID = $user->getID();
        $AuthCode = new OTPCode();
        if ($Role === User::MANAGER)
        {
            $this->user = Manager::findOne(['Manager_ID' => $ID]);

        }else if ($Role === User::MEDICAL_OFFICER)
        {
            $this->user = MedicalOfficer::findOne(['Officer_ID' => $ID]);
        }else if ($Role === User::ADMIN)
        {
            $this->user = Admin::findOne(['Admin_ID' => $ID]);
        }else if ($Role === User::DONOR)
        {
            $this->user = Donor::findOne(['Donor_ID' => $ID]);
        }else if ($Role === User::HOSPITAL)
        {
            $this->user = Hospital::findOne(['Hospital_ID' => $ID]);
        } else if ($Role === User::ORGANIZATION) {
            $this->user = Organization::findOne(['Organization_ID' => $ID]);
        } else if ($Role === User::SPONSOR) {
            $this->user = Sponsor::findOne(['Sponsor_ID' => $ID]);
        } else {
            return false;
        }
        if ($this->user === null) {
            return false;
        }

        $primaryKey = $user->primaryKey();

        $primaryValue = $user->getID();
//        Create Login Sessions

        //TODO Update the minutes to 30
        $this->session->set('user', ['UID' => $primaryValue, 'UserClass' => get_class($this->user)], 60);
        $this->session->setFlash('success', 'Welcome Back ' . $user->getEmail());
        $login = new LoggingHistory();
        $login->setSessionID($this->session->get('user')->getSessionID());
        $login->setUserID($primaryValue);
        $login->setSessionEnd(date('Y-m-d H:i:s'));
        $login->setSessionStart(date('Y-m-d H:i:s'));
        if (!$login->save(['Session_End']))
        {
            return false;
        }
        return true;
    }

    public function run(): void
    {
        try {
            echo self::$app->router->resolve();
        }catch (Exception $e){
//            $this->Redirect('/');
            throw $e;
        }
    }

    public function logout(): void
    {
        $sessionID=$this->session->get('user')->getSessionID();
        LoggingHistory::updateOne(['Session_ID'=>$sessionID],['Session_End'=>date('Y-m-d H:i:s'),'Session_End_Type'=>LoggingHistory::Logout]);
        $this->user=null;
        $this->session->remove('user');
    }

}