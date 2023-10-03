<?php

namespace Tests;

use App\model\Authentication\Login;

class LoginTest extends \Codeception\Test\Unit
{
    /**
     * @dataProvider getLoginData
     */
    public function testGetEmail($email,$password,$expected):void
    {
        $login = new Login();
        $login->setEmail($email);
        $login->setPassword($password);
        $this->assertEquals($expected, $login->validate());
    }

    public function getLoginData(): array
    {
        return [
            ['manager@test.com', '1234',true],
            ['admin@test.com', '1234',true],
            ['email#test.com', '1234',false],
            ['email,email.com', '1234',false],
        ];
    }

}
