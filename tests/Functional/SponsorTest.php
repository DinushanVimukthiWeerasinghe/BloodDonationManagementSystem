<?php

namespace Functional;

use App\model\Notification\SponsorNotification;
use App\model\users\Sponsor;
use Core\Application;
use Dotenv\Dotenv;
use PHPMailer\PHPMailer\Exception;

class SponsorTest extends \Codeception\Test\Unit
{

    /**
     * @throws Exception
     */
    private function getApp():Application{
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

    /**
     * @dataprovider  SponsorProvider
     * @param null|string $SponsorID
     * @param string $Email
     * @param bool $expected
     * @return void
     * @throws Exception
     */
    public function ttestValidSponsor($SponsorID, $Email, bool $expected)
    {
        $this->getApp();
        $sponsor = new Sponsor();
        $sponsor->setSponsorID($SponsorID);
        $sponsor->setEmail($Email);
        $sponsor->setAddress1('Matara');
        $sponsor->setAddress2('Matara');
        $sponsor->setNIC('956789134V');
        $sponsor->setCity('Matara');
        $sponsor->setContactNo('0765431234');
        $sponsor->setType(1);
        $sponsor->setProfileImage('user');
        $this->assertEquals($expected,$sponsor->save());
        session_abort();

    }

    public function SponsorProvider()
    {
        return [
            ['Spn_35','amal@gmail.com',true],
            ['Spn_35','namal@gmail.com',false],
            ['Spn_36','namal@gmail.com',false],
        ];
    }






}