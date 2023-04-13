<?php

namespace App\view\components\Image;

abstract class BaseImage
{
    protected string $src;
    protected string $alt;
    protected string $class;
    protected string $size;

    public function __construct($src, $alt, $class,$size)
    {
        $this->src = $src;
        $this->alt = $alt;
        $this->class = $class;
        $this->size=$size;
    }

    public function render(): string
    {
        return "
        <img src='$this->src' alt='$this->alt' width='$this->size' class='$this->class'/>
        ";
    }


}