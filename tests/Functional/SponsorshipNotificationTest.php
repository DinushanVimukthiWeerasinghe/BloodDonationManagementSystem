<?php

namespace Functional;

use App\model\Notification\SponsorNotification;
use App\model\users\Sponsor;
use Core\Application;
use Dotenv\Dotenv;
use PHPMailer\PHPMailer\Exception;

class SponsorshipNotificationTest extends \Codeception\Test\Unit
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
     * @dataprovider  SponsorNotificationProvider
     * @param null|string $NotificationID
     * @param string $TargetID
     * @param bool $expected
     * @return void
     * @throws Exception
     */
    public function testValidSponsorNotification($NotificationID, $TargetID, bool $expected)
    {
        $this->getApp();
        $Sponsor_notification = new SponsorNotification();
        $Sponsor_notification->setNotificationID($NotificationID);
        $Sponsor_notification->setNotificationTitle('Test Notification');
        $Sponsor_notification->setNotificationMessage('This is a Test Message');
        $Sponsor_notification->setTargetID($TargetID);
        $Sponsor_notification->setValidUntil(date('Y-m-d'));
        $Sponsor_notification->setNotificationDate(date('Y-m-d'));
        $Sponsor_notification->setNotificationType(SponsorNotification::STATE_PENDING);
        $this->assertEquals($expected,$Sponsor_notification->save());
        session_destroy();

    }

    public function SponsorNotificationProvider()
    {
        return [
            ['Not_001','Spn_02',true],
            ['Not_001','Spn_02',false],
            ['Not_002','Spn_00',false],
            ['Not_002','Spn_02',true],
        ];
    }






}