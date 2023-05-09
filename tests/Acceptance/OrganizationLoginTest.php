<?php

namespace Acceptance;
use Tests\Support\AcceptanceTester;

class OrganizationLoginTest extends \Codeception\Test\Unit
{
    protected AcceptanceTester $tester;

    public function OrganizationLogin(){
        $this->tester->amOnPage('/login');
        $this->tester->fillField('Email','org@test.com');
        $this->tester->fillField('Password','1234');
        $this->tester->click('form input[type="submit"]');
        $this->tester->amOnPage('/organization/login');
    }
}
