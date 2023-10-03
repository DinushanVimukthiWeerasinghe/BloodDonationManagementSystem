<?php

namespace Acceptance;
use Tests\Support\AcceptanceTester;


class OrganizationRegistrationTest extends \Codeception\Test\Unit
{

    protected AcceptanceTester $tester;
    private function registerform(){
        $this->tester->fillField('Email','janithheshara2@gmail.com');
        $this->tester->fillField('Password','1234');
        $this->tester->fillField('ConfirmPassword','1234');
    }
    /**
     * @dataprovider  dashboardComponentsProvider
     * @param $page
     * @param $element
     * @param $excepted
     * @return void
     **/
    public function testdashboardComponents(string $page, string $element,string $excepted){

        $this->tester->amOnPage($page);
        $this->tester->seeElement($element);
        $this->tester->click($element);
        $this->tester->seeInCurrentUrl($excepted);
    }
    public function dashboardComponentsProvider():array{
        return [
            ['/register','.text-primary','/register?role=organization']

        ];
    }
}
