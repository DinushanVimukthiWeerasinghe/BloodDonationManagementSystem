<?php

namespace App\view\components\WebComponent\Button;

abstract class BaseButton
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
        <a href='$this->href' class='btn web $this->class'>$this->text</a>
        ";
    }

}