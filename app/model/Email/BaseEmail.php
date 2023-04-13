<?php

namespace App\model\Email;

use Core\Email;

class BaseEmail extends Email
{
    public function __construct(array $config)
    {
        parent::__construct($config);
    }


}