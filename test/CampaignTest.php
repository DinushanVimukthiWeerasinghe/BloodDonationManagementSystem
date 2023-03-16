<?php

namespace TEST;

use App\model\Campaigns\Campaign;
use PHPUnit\Framework\TestCase;

class CampaignTest extends TestCase
{
    public function testCreateCampaign(){
        $Campaign = new Campaign();
        $Campaign->setCampaignName('Test Campaign');
        $Campaign->setCampaignDescription('Test Campaign Description');
        $Campaign->setCampaignDate('2019-01-01');
        $Campaign->setStatus(Campaign::PENDING);
        $Campaign->setVenue('Test Venue');
        $Campaign->setLatitude(1.234);
        $Campaign->setLongitude(1.234);
        $Campaign->setOrganizationID(1);
        $Campaign->setCreatedAt('2019-01-01');
        $Campaign->setUpdatedAt('2019-01-01');
        $Campaign->validate();
        $errors = $Campaign->errors;
        $this->assertEmpty($errors);
        $this->assertEquals('Test Campaign', $Campaign->getCampaignName());


    }
}