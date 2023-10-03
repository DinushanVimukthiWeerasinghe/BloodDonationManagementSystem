<?php

namespace Unit;

use App\model\Requests\SponsorshipRequest;
use PHPUnit\Framework\TestCase;

class SponsorshipRequestTest extends TestCase
{
    public function testGetSponsoredAmount():void{
        $sponsor = new SponsorshipRequest();
        $sponsor->setSponsorshipDate('2023-04-10');
        $this->assertEquals($sponsor->getSponsorshipDate(),'2023-04-10');
    }
    public function testGetSponsorshipStatus():void{
        $sponsor = new SponsorshipRequest();
        $sponsor->setSponsorshipStatus($sponsor::TRANSFERRING_PENDING);
        $this->assertEquals($sponsor->getSponsorshipStatus(),$sponsor::TRANSFERRING_PENDING);
    }

}
