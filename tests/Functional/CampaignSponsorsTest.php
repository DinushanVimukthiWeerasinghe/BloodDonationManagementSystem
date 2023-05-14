<?php

namespace Functional;

use App\model\Campaigns\Campaign;
use App\model\Utils\Date;
use Codeception\Template\Unit;
use Codeception\Test\Test;
use Core\Application;
use Dotenv\Dotenv;
use PHPMailer\PHPMailer\Exception;
use Tests\Support\FunctionalTester;

class CampaignSponsorsTest extends \Codeception\Test\Unit
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
     * @param string $Campaign_ID
     * @param string $BloodBankID
     * @param $OrganizationID
     * @param bool $expected
     * @return void
     * @throws Exception
     */
    public function testCampaigns($Campaign_ID,$BloodBankID,$OrganizationID, bool $expected){
        session_abort();
        $app = $this->getApp();
        $campaign = new Campaign();
        $campaign->setCampaignID($Campaign_ID);
        $campaign->setCampaignName('Test Campaign');
        $campaign->setCampaignDate(date('Y-m-d'));
        $campaign->setCampaignDescription('This is a Test Campaign');
        $campaign->setNearestCity('Matara');
        $campaign->setVerified(Campaign::NOT_VERIFIED);
        $campaign->setUpdatedAt('2002-01-10');
        $campaign->setCreatedAt('2002-05-10');
        $campaign->setStatus(Campaign::CAMPAIGN_STATUS_PENDING);
        $campaign->setVenue('Matara');
        $campaign->setOrganizationID($OrganizationID);
        $campaign->setNearestBloodBank($BloodBankID);
        $campaign->setLatitude(1.5555);
        $campaign->setLongitude(2.5555);
        $this->assertEquals($expected,$campaign->save());
//        session_destroy();
    }

    public function ValidCampaignIDProvider(){
        return [
            ['Camp_0022a','BB_04','Org_01',true],
            ['Camp_0022a','BB_04','Org_01',false],
            ['Camp_0023a','BB_02','Org_01',true],
            ['Camp_0023a','BB_04','Org_01',false],
            ['Camp_0024a','BB_04','Org_00',false],
            ['Camp_0025a','BB_02','Org_00',false],
        ];
    }



}