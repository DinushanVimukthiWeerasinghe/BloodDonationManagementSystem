<?php

namespace App\view\components\MobileComponent\Button;

abstract class MBaseButton
{

    private string $text;
    private string $class;
    private string $href;

    public function __construct($text, $href,$class)
    {
        $this->text = $text;
        $this->class = $class;
        $this->href = $href;
    }

    public function render(): string
    {
        return "
        <a href='$this->href' class='btn mobile $this->class'>$this->text</a>
        ";
    }

}