<?php

namespace App\model\Email;

use Core\Email;

class AuthenticationCodeEmail extends Email
{

    private string $code;
    public function __construct(array $config)
    {
        parent::__construct($config);
    }

    public function send(mixed $to, string $from, string $subject, string $body): bool
    {
        //Authentication Code Message Body
        $this->code = $body;
        $body = "Your Authentication Code is: $this->code";
        
        return parent::send($to, $from, $subject, $body);
    }

}