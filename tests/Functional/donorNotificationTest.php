<?php

namespace Functional;

use App\model\Notification\DonorNotification;
use Core\Application;
use Dotenv\Dotenv;
use PHPMailer\PHPMailer\Exception;

class donorNotificationTest extends \Codeception\Test\Unit
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
     * @dataprovider  ValidDonorIDProvider
     * @param string|null $DonorID
     * @param bool $expected
     * @return void
     * @throws Exception
     */
    public function testValidDonorID($DonorID, bool $expected)
    {
        session_abort();
        $app = $this->getApp();
        $Donor_notification = new DonorNotification();
        $Donor_notification->setNotificationID('NOT_001');
        $Donor_notification->setTargetID($DonorID);
        $Donor_notification->setTargetGroup("A+");
        $Donor_notification->setNotificationState(DonorNotification::NOTIFICATION_STATE_UNREAD);
        $Donor_notification->setNotificationTitle('Test Title');
        $Donor_notification->setNotificationMessage('Description of the notification details.');
        $Donor_notification->setValidUntil(date('Y-m-d H:i:s', strtotime('+2 day')));
        $Donor_notification->setNotificationDate(date('Y-m-d H:i:s'));
        $Donor_notification->setNotificationType(DonorNotification::INFORM_GROUP_OF_DONOR);
        $this->assertEquals($expected,$Donor_notification->save());
    }

    public function ValidDonorIDProvider()
    {
        return [
            ['Dnr_01',true],
        ];
    }






}