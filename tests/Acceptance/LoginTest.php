<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

class LoginTest extends \Codeception\Test\Unit
{

    protected AcceptanceTester $tester;

    protected function _before()
    {
    }

    // tests
    public function AdminLogin(): void
    {
        $this->tester->amOnPage('/login');
        $this->tester->fillField('Email', 'admin@test.com');
        $this->tester->fillField('Password', '1234');
        $this->tester->click('form input[type=submit]');
        $this->tester->see('Important Stats');


    }
}
