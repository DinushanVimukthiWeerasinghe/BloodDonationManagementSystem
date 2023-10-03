<?php

namespace Functional;

use App\model\Campaigns\Campaign;
use Codeception\Template\Unit;
use Codeception\Test\Test;
use Core\Application;
use Dotenv\Dotenv;
use PHPMailer\PHPMailer\Exception;
use Tests\Support\FunctionalTester;
use Unit\AppClass;

class CreateCampaignTest extends \Codeception\Test\Unit
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

    /**
     * @dataprovider  ValidCampaignIDProvider
     * @param string $Campaign_ID
     * @param bool $expected
     * @return void
     * @throws Exception
     */
    public function testCampaigns($Campaign_ID,bool $expected){
        $app = AppClass::getApp();
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
        $campaign->setOrganizationID('Org_01');
        $campaign->setNearestBloodBank('BB_02');
        $campaign->setLatitude(1.5555);
        $campaign->setLongitude(2.5555);
        $this->assertEquals($expected,$campaign->save());
        session_destroy();
    }

    public function ValidCampaignIDProvider(){
        return [
            ['Camp_002',true],
        ];
    }

}