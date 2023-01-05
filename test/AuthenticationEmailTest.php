<?php

namespace TEST;

use App\model\Email\AuthenticationCodeEmail;
use PHPMailer\PHPMailer\Exception;
use PHPUnit\Framework\TestCase;

class AuthenticationEmailTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testSend(): void
    {
        $baseEmail = new AuthenticationCodeEmail([
            'username' => 'bdmsgroupcs46@gmail.com',
            'password' => 'bbwwuxgovicbbjqq',
            'host'=>'smtp.gmail.com',
            'from'=>'bdmsgroupcs46@gmail.com',
            'encryption'=>'ssl',
            'port'=>465

        ]);
        $this->assertTrue($baseEmail->send('bdmsgroupcs46@gmail.com','bdmsgroupcs46@gmail.com','test','test'));
    }

    /**
     * @throws Exception
     */
    public function testSendWithArray(): void
    {
        $baseEmail = new AuthenticationCodeEmail([
            'username' => 'bdmsgroupcs46@gmail.com',
            'password' => 'bbwwuxgovicbbjqq',
            'host' => 'smtp.gmail.com',
            'from' => 'bdmsgroupcs46@gmail.com',
            'encryption' => 'ssl',
            'port' => 465

        ]);
        $this->assertTrue($baseEmail->send(['bdmsgroupcs46@gmail.com', 'stdinushan@gmail.com'], 'bdmsgroupcs46@gmail.com', 'test', 'Array test'));
    }

}
