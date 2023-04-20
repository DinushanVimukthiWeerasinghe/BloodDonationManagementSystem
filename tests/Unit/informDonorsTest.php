<?php

namespace Unit;

use App\model\inform\informDonors;
use PHPUnit\Framework\TestCase;

class informDonorsTest extends TestCase
{
    public function testGetCampaignID():void
    {
        $inform = new informDonors();
        $inform->setCampaignID('camp_01');
        $this->assertEquals($inform->getCampaignID(),'camp_01');
    }
    public function testGetMessageID():void
    {
        $inform = new informDonors();
        $inform->setMessageID('Msg_01');
        $this->assertEquals($inform->getMessageID(),'Msg_01');
    }
    public function testGetMessage():void
    {
        $inform = new informDonors();
        $inform->setMessage('This is a Test Message.');
        $this->assertEquals($inform->getMessage(),'This is a Test Message.');
    }
}
