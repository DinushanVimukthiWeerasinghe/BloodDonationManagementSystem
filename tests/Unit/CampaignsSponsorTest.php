<?php

namespace Unit;

use App\model\sponsor\CampaignsSponsor;
use PHPUnit\Framework\TestCase;

class CampaignsSponsorTest extends TestCase
{
    public function testGetSponsoredAmount():void{
        $sponsor = new CampaignsSponsor();
        $sponsor->setSponsoredAmount(1000);
        $this->assertEquals($sponsor->getSponsoredAmount(),1000);
    }
    public function testGetDescription():void{
        $sponsor = new CampaignsSponsor();
        $sponsor->setDescription('My First Payment');
        $this->assertEquals($sponsor->getDescription(),'My First Payment');
    }

}
