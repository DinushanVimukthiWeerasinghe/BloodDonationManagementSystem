<?php

namespace App\view\components\ButtonGroup;

abstract class BaseGroup
{
    protected array $buttons;

    public function __construct($buttons)
    {
        $this->buttons = $buttons;
    }

    public function render(): string
    {
        $btngrp='<div class="btn-group">';
        foreach ($this->buttons as $button) {
            $btngrp.=$button->render();
        }
        $btngrp.='</div>';
        return $btngrp;
    }


}