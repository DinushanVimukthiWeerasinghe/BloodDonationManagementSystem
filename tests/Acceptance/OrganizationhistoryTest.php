<?php

namespace Acceptance;
use Tests\Support\AcceptanceTester;


class OrganizationhistoryTest extends \Codeception\Test\Unit
{

    protected AcceptanceTester $tester;

    public function LogAsOrganization(){
        $this->tester->amOnPage('/login');
        $this->tester->fillField('Email','org@test.com');
        $this->tester->fillField('Password','12345678910');
        $this->tester->click('form input[type="submit"]');
        $this->tester->see('Dashboard');
    }

    /**
      * @dataProvider dashboardComponentProvider
     * @param $page
     * @param $element
     * @param $excepted
     * @return void
     **/

    public function TtestdashboardComponents($page, $element, $excepted){
        $this->LogAsOrganization();
        $this->tester->amOnpage($page);
        $this->tester->seeElement($element);
        $this->tester->click($element);
        $this->tester->seeInCurrentUrl($excepted);
        $this->tester->see('Campaign Details');
    }
    public function dashboardComponentProvider():array{
        return [
            ['/organization/history','#details','/organization/campDetails?id=mdX%2BUthEg9RksjAbHHnTNK9Lo5%2BakLFnEI8F7e6DioA%3D']
        ];
    }
}
