<?php

namespace TEST;


use App\model\Campaigns\Campaign;
use PHPUnit\Framework\TestCase;

class CampaignTest extends TestCase
{
    public function testGetCampaignName():void{
        $campaign = new Campaign();
        $campaign->setCampaignName('Suwa Sahana');
        $this->assertEquals($campaign->getCampaignName(),'Suwa Sahana');
    }
    public function testGetCampaignDate():void{
        $campaign = new Campaign();
        $campaign->setCampaignDate(2020-01-17);
        $this->assertEquals($campaign->getCampaignDate(),2020-01-17);
    }
    public function testGetVenue():void{
        $campaign = new Campaign();
        $campaign->setVenue('Colombo');
        $this->assertEquals($campaign->getVenue(),'Colombo');
    }
    public function testGetExpectedAmount():void{
        $campaign = new Campaign();
        $campaign->setExpectedAmount(5000);
        $this->assertEquals($campaign->getExpectedAmount(),5000);
    }
    public function testGetCampaignDescription():void{
        $campaign = new Campaign();
        $campaign->setCampaignDescription('This is a test description.');
        $this->assertEquals($campaign->getCampaignDescription(),'This is a test description.');
    }

}
