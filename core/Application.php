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

    public function isAdmin(): bool
    {
        return $this->user!==null && $this->user->getRole() === User::ADMIN;
    }

    public function isDonor(): bool
    {
        return $this->user!==null && $this->user->getRole() === User::DONOR;
    }

    public function isManager(): bool
    {
        return $this->user!==null && $this->user->getRole() === User::MANAGER;
    }

    public function isOrganization(): bool
    {
        return $this->user!==null && $this->user->getRole() === User::ORGANIZATION;
    }

    public function isSponsor(): bool
    {
        return $this->user!==null && $this->user->getRole() === User::SPONSOR;
    }

    public function isHospital(): bool
    {
        return $this->user!==null && $this->user->getRole() === User::HOSPITAL;
    }

    public function isMedicalOfficer(): bool
    {
        return $this->user!==null && $this->user->getRole() === User::MEDICAL_OFFICER;
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
//        Set Timezone to Asia/Colombo
        date_default_timezone_set('Asia/Colombo');
//        $this->db->applyMigrations();
        if(isset($_SESSION['user']))
        {
//            unset($_SESSION['user']);
            $UserClass=$_SESSION['user']->getSessionData()['UserClass'];
            $UserID=$_SESSION['user']->getSessionData()['UID'];
            $this->user = $UserClass::findOne([$UserClass::PrimaryKey()=>$UserID]);
        }
        else
        {
            $this->user = null;
        }
    }

    /**
     * @throws Exception
     */
    public function login(Login $user): bool
    {
        $Role=$user->getRole();
        $ID = $user->getID();

        if ($user->IsUserVerified()) {
            if ($Role === User::MANAGER) {
                $this->user = Manager::findOne(['Manager_ID' => $ID]);

            } else if ($Role === User::MEDICAL_OFFICER) {
                $this->user = MedicalOfficer::findOne(['Officer_ID' => $ID]);
            } else if ($Role === User::ADMIN) {
                $this->user = Admin::findOne(['Admin_ID' => $ID]);
            } else if ($Role === User::DONOR) {
                $this->user = Donor::findOne(['Donor_ID' => $ID]);
                if ($this->user === null) {
                    $this->user = new Donor();
                }
            } else if ($Role === User::HOSPITAL) {
                $this->user = Hospital::findOne(['Hospital_ID' => $ID]);
            } else if ($Role === User::ORGANIZATION) {

                $this->user = Organization::findOne(['Organization_ID' => $ID]);
            } else if ($Role === User::SPONSOR) {
                $this->user = Sponsor::findOne(['Sponsor_ID' => $ID]);
            } else {
                throw new Exception('Invalid Role');
            }
            if ($this->user === null) {
                return false;
            }
            $primaryKey = $user->primaryKey();

            $primaryValue = $user->getID();
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
        }else{
            var_dump($Role);
            exit();
        }
        return true;
    }

    public function run(): void
    {
        try {
            echo self::$app->router->resolve();
        }catch (Exception $e){
//            Set Status Code to 500
//            http_response_code(404);
//            self::Redirect('/');
            var_dump($e->getMessage());
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