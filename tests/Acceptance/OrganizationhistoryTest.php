<?php

namespace Acceptance;
use Tests\Support\AcceptanceTester;


class OrganizationhistoryTest extends \Codeception\Test\Unit
{

    protected AcceptanceTester $tester;

    /**
      * @dataProvider dashboardComponentProvider
     * @param $page
     * @param $element
     * @param $excepted
     * @return void
     **/

    public function testdashboardComponents($page, $element, $excepted){
        $this->tester->amOnpage($page);
        $this->tester->seeElement($element);
        $this->tester->click($element);
        $this->tester->seeInCurrentUrl($excepted);
    }
    public function dashboardComponentProvider():array{
        return [
            ['/organization/history','#details','/organization/campDetails?id=Camp_6448cc689b005']
        ];
    }
}
