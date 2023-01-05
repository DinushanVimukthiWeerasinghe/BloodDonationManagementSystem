<?php

namespace App\view\components\WebComponent\Image;

class RoundedImage extends BaseImage
{
    protected int $round=50;

    public function __construct($src, $alt, $class, $size,$round)
    {
        parent::__construct($src, $alt, $class, $size,$round);
        $this->round=$round;
    }

}