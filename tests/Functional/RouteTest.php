<?php


namespace Tests\Functional;

use Core\Application;
use Dotenv\Dotenv;
use PHPMailer\PHPMailer\Exception;
use Tests\Support\FunctionalTester;

class RouteTest extends \Codeception\Test\Unit
{

    /**
     * @var FunctionalTester
     */
    protected FunctionalTester $tester;



    protected function _before()
    {
    }

    /**
     * @throws Exception
     */
    private function getApp(): Application
    {
        require_once __DIR__ . '/../../vendor/autoload.php';
        $dotenv = Dotenv::createImmutable(dirname(__DIR__).'/../');
        $dotenv->load();



        require_once __DIR__ . '/../../public/config.php';


        $config=[
            'db'=>[
                'dsn'=>DB_DSN,
                'user'=>$_ENV['DB_USER'],
                'password'=>$_ENV['DB_PASSWORD'] ?? ''
            ],
            'email'=>[
                'host'=>$_ENV['EMAIL_HOST'],
                'port'=>$_ENV['EMAIL_PORT'],
                'username'=>$_ENV['EMAIL_USERNAME'],
                'password'=>$_ENV['EMAIL_PASSWORD'],
                'encryption'=>$_ENV['EMAIL_ENCRYPTION'],
                'from'=>$_ENV['EMAIL_FROM']
            ],
            'map'=>[
                'key'=>$_ENV['MAP_API_KEY']
            ],
        ];

        return new Application(dirname(__DIR__), $config);
    }

    // tests
    /**
     * @dataProvider getRoutes
     */
    public function testRoutes($url,$method,$type)
    {
        $I = new FunctionalTester($this->getScenario());
        $app = $this->getApp();
        if ($type === 'get'){
            $app->router->get($url,$method);
        }else{
            $app->router->post($url,$method);
        }
        $this->assertEquals($method, $app->router->getRoutes()[$type][$url]);
        session_destroy();
    }

    public function testInvalidRoutes()
    {
        $I = new FunctionalTester($this->getScenario());
        $I->amOnPage('/invalid');
        $I->see('Be Positive');
    }

    public function getRoutes(): array
    {
        return[
            ['/','home','get'],
            ['/','home','post'],
            ['/login','login','get']
        ];
    }





}
