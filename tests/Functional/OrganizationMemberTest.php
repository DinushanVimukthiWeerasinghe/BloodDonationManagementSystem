<?php

namespace Functional;

use App\model\Campaigns\Campaign;
use App\model\OrganizationMembers\Organization_Members;
use App\model\Utils\Date;
use Codeception\Template\Unit;
use Codeception\Test\Test;
use Core\Application;
use Dotenv\Dotenv;
use PHPMailer\PHPMailer\Exception;
use Tests\Support\FunctionalTester;

class OrganizationMemberTest extends \Codeception\Test\Unit
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
    /**
     * @dataprovider  ValidCampaignIDProvider
     * @param string $NIC
     * @param string $OrganuzationID
     * @param bool $expected
     * @return void
     */
    public function testOrganizationMembers($OrganizationID,string $NIC,string $Email, bool $expected){
//        $app = $this->getApp();
        $member = new Organization_Members();
        $member->setOrganizationID($OrganizationID);
        $member->setNIC($NIC);
        $member->setEmail($Email);
        $member->setName('Test');
        $this->assertEquals($expected,$member->save());
        session_abort();
    }

    public function ValidCampaignIDProvider()
    {
        return [
            ['ORG_06','123456789V','testEmail1@bepositive.local',true],
            ['ORG_06','123456789V','testEmail2@bepositive.local',false],
            ['Org_02','123456777V','testEmail3@bepositive.local',false],
            ['Org_00','123456777V','testEmail4@bepositive.local',false],
            ['ORG_06','123456780V','testEmail1@bepositive.local',false],
        ];
    }



}