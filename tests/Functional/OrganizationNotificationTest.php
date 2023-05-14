<?php

namespace Functional;

use App\model\Notification\DonorNotification;
use App\model\Notification\OrganizationNotification;
use Core\Application;
use Dotenv\Dotenv;
use PHPMailer\PHPMailer\Exception;

class OrganizationNotificationTest extends \Codeception\Test\Unit
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
     * @dataprovider  OrganizationNotificationProvider
     * @param null|string $NotificationID
     * @param string $TargetID
     * @param bool $expected
     * @return void
     * @throws Exception
     */
    public function testValidDonorID($NotificationID, $TargetID, bool $expected)
    {
        $this->getApp();
        $Organization_notification = new OrganizationNotification();
        $Organization_notification->setNotificationID($NotificationID);
        $Organization_notification->setNotificationTitle('Test Notification');
        $Organization_notification->setNotificationState(OrganizationNotification::STATE_PENDING);
        $Organization_notification->setNotificationMessage('This is a Test Message');
        $Organization_notification->setTargetID($TargetID);
        $Organization_notification->setValidUntil(date('Y-m-d'));
        $Organization_notification->setNotificationDate(date('Y-m-d'));
        $Organization_notification->setNotificationType(OrganizationNotification::TYPE_CAMPAIGN);
        $this->assertEquals($expected,$Organization_notification->save());
        session_destroy();

    }

    public function OrganizationNotificationProvider()
    {
        return [
            ['Not_001','Org_01',true],
            ['Not_001','Org_01',false],
            ['Not_002','Org_00',false],
            ['Not_002','Org_03',true],
        ];
    }






}