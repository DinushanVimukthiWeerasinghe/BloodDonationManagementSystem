<?php

namespace App\model\Email;

use Core\Email;

class BaseEmail extends Email
{
    public function __construct(array $config)
    {
        parent::__construct($config);
    }

    public function send(mixed $to, string $from, string $subject, string $body): bool
    {
        return parent::send($to, $from, $subject, $body);
    }

}