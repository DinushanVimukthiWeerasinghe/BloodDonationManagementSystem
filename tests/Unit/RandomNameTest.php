<?php


namespace Tests\Unit;

use App\model\users\Donor;
use Tests\Support\UnitTester;

class RandomNameTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testSomeFeature()
    {
        $Donor = new Donor();
        $Donor->setNIC('123456789V');
        $this->assertEquals('123456789V', $Donor->getNIC());

    }
}
