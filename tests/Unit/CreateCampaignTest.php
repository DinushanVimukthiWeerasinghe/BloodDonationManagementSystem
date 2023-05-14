<?php

namespace Unit;

use App\model\Campaigns\Campaign;
use Codeception\Template\Unit;
use Codeception\Test\Test;
use Core\Application;
use Dotenv\Dotenv;
use PHPMailer\PHPMailer\Exception;
use Tests\Support\FunctionalTester;

class CreateCampaignTest extends \Codeception\Test\Unit
{

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
     * @param bool $expected
     * @param string $BloodBankID
     * @param string $CampaignDate
     * @return void
     * @throws Exception
     */
    public function stestCampaigns($Campaign_ID,$BloodBankID,$CampaignDate, bool $expected){
//        $app = $this->getApp();
        $campaign = new Campaign();
        $campaign->setCampaignID($Campaign_ID);
        $campaign->setCampaignName('Test Campaign');
        $campaign->setCampaignDate($CampaignDate);
        $campaign->setCampaignDescription('This is a Test Campaign');
        $campaign->setNearestCity('Matara');
        $campaign->setVerified(Campaign::NOT_VERIFIED);
        $campaign->setUpdatedAt('2002-01-10');
        $campaign->setCreatedAt('2002-05-10');
        $campaign->setStatus(Campaign::CAMPAIGN_STATUS_PENDING);
        $campaign->setVenue('Matara');
        $campaign->setOrganizationID('Org_01');
        $campaign->setNearestBloodBank($BloodBankID);
        $campaign->setLatitude(1.5555);
        $campaign->setLongitude(2.5555);
        $this->assertEquals($expected,$campaign->validate());
//        session_destroy();
    }

    public function ValidCampaignIDProvider(){
        return [
            ['Camp_0022','BB_04','2023-06-15',true],
            ['Camp_0022','BB_04','2023-06-15',false],
            ['Camp_0023','BB_02','2023-06-15',false]
        ];
    }



}