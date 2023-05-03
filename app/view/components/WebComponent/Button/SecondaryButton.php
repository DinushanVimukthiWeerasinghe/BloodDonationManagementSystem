<?php

namespace App\view\components\WebComponent\Button;

class SecondaryButton extends BaseButton
{
    public function __construct($text, $href)
    {
        parent::__construct($text, 'btn-secondary', $href);
    }

}