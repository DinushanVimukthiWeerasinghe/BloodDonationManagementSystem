<?php

namespace Functional;

use App\model\Authentication\OrganizationBankAccount;
use App\model\Notification\DonorNotification;
use App\model\Notification\OrganizationNotification;
use Core\Application;
use Dotenv\Dotenv;
use PHPMailer\PHPMailer\Exception;

class OrganizationBankDetailsTest extends \Codeception\Test\Unit
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
     * @dataprovider  OrganizationBankID
     * @param string $OrganizationID
     * @param string $bankAccountNo
     * @param bool $expected
     * @return void
     */
    public function testValidOrganizationID(string $OrganizationID,string $bankAccountNo,bool $expected)
    {
//        $this->getApp();
        $bankAccount = new OrganizationBankAccount();
        $bankAccount->setOrganizationID($OrganizationID);
        $bankAccount->setBankName('People\'s Bank');
        $bankAccount->setBranchName('Beliatta');
        $bankAccount->setAccountName('YES');
        $bankAccount->setAccountNumber($bankAccountNo);
        $this->assertEquals($expected,$bankAccount->save());
        session_destroy();

    }

    public function OrganizationBankID()
    {
        return [
            ['ORG_05','856754754',true],
            ['ORG_05','579863126',false],
            ['Org_00','478935412',false],
            ['ORG_06','415',false],
            ['ORG_05','478935412',false],
        ];
    }






}