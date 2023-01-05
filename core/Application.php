<?php
namespace Core;
use App\model\Authentication\Login;
use App\model\Email\BaseEmail;
use App\model\users\Manager;
use App\model\users\MedicalOfficer;
use App\model\users\Person;
use App\model\users\User;
use Exception;

class Application
{
    public string $layout = 'main';
    public static string $ROOT_DIR;
    public Router $router;
    public Request $request;
    public Response $response;

    private ?Person $user;
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
    public function setUser(?User $user): void
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
    public function getUser(): Person | null
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
        $this->forbiddenRoute = new forbiddenRoute();

        self::$ROOT_DIR = $path;
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);
        $this->db = new Database($config['db']);
        $this->email = new BaseEmail($config['email']);
//        $this->db->applyMigrations();

        if(isset($_SESSION['user']))
        {
            $UserClass=$_SESSION['user']->getSessionData()['UserClass'];
            $UserID=$_SESSION['user']->getSessionData()['UID'];
            $this->user = $UserClass::findOne(['ID'=>$UserID]);
        }
        else
        {
            $this->user = null;
        }
    }

    public function login(Login $user): bool
    {
        $Role=$user->getRole();
        $ID=$user->getID();
        if ($Role === 'Manager')
        {
            $this->user = Manager::findOne(['ID' => $ID]);
        }else if ($Role === 'MedicalOfficer')
        {
            $this->user = MedicalOfficer::findOne(['ID' => $ID]);
        }

        $primaryKey=$user->primaryKey();

        $primaryValue=$user->getID();
        //TODO Update the minutes to 30
        $this->session->set('user',['UID'=>$primaryValue,'UserClass'=>get_class($this->user)],60);
        $this->session->setFlash('success','Welcome Back '.$user->getEmail());
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
        $this->user=null;
        $this->session->remove('user');
    }

}