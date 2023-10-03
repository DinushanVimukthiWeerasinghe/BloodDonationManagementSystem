<?php
//
//namespace Tests\Acceptance;
//use Tests\Support\AcceptanceTester;
//
//
//class OrganizationDashboardTest extends \Codeception\Test\Unit
//{
//
//    protected AcceptanceTester $tester;
//    private function logout(){
//        $this->tester->click('a[href="/logout"]');
//    }
//    private function LogAsOrganization(){
//        $this->tester->amOnPage('/login');
//        $this->tester->fillField('Email','org@test.com');
//        $this->tester->fillField('Password','1234');
//        $this->tester->click('form input[type=submit]');
//        $this->tester->see('Dashboard');
//    }
//
//    /**
//     * @dataprovider  dashboardComponentsProvider
//     * @param string $page
//     * @param string $element
//     * @param string $excepted
//     * @return void
//     */
//
//    public function testdashboardComponents(string $page, string $element,string $excepted){
//        $this->LogAsOrganization();
//        $this->tester->amOnPage($page);
////        $e = $this->tester->grabAttributeFrom($element,'onclick');
////        var_dump($e);
//        $this->tester->seeElement($element);
//        $this->tester->click(['js' => "document.getElementById('$element').click()"]);
//        $this->tester->seeInCurrentUrl($excepted);
//        $this->logout();
//    }
//    public function dashboardComponentsProvider():array{
//        return [
//            ['/organization/dashboard','#guideline','/organization/guideline']
//
//        ];
//    }
//}
