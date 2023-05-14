<?php

namespace Functional;

use App\model\Authentication\Login;
use App\model\Notification\SponsorNotification;
use App\model\users\Organization;
use App\model\users\Sponsor;
use App\model\users\User;
use Core\Application;
use Dotenv\Dotenv;
use PHPMailer\PHPMailer\Exception;

class OrganizationTest extends \Codeception\Test\Unit
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
     * @param null|string $OrganizationID
     * @param string $Email
     * @param bool $expected
     * @return void
     * @throws Exception
     */
    public function testValidOrganization( $OrganizationID, $Email, bool $expected)
    {
        $this->getApp();


        $organization = new Organization();
        $organization->setOrganizationID('Org_000');
        $organization->setOrganizationName('Sahana Society');
        $organization->setContactNo('07776548907');
        $organization->setAddress1('Matara');
        $organization->setAddress2('Matara');
        $organization->setType(1);
        $organization->setProfileImage('/public/upload/organization.png');
        $organization->setCity('Matara');
        $organization->setStatus(Organization::ORGANIZATION_NOT_VERIFIED);
        $organization->setEmail('org120@test.com');
        $this->assertEquals($expected,$organization->save());
        session_abort();

    }

    public function SponsorProvider()
    {
        return [
            ['Org_absd','sahanaSociety@bepositive.local',true],
            ['Org_35','vpSociety@bepositive.local',false],
            ['Org_36','mashin@bepositive.local',false],
        ];
    }






}