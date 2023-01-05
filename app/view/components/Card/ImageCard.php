<?php

namespace App\view\components\Card;

class ImageCard
{
    private string $title;
    private string $img;

    public function __construct($title, $img)
    {
        $this->title = $title;
        $this->img = $img;
    }

    public function render(): string
    {
        return "
        <div class='img-card'>
            <div class='card-body'>
                <img class='card-img' src='$this->img' height='80%' alt=''>
            </div>
            <div class='card-header'>
                <h3 class='card-title'>$this->title</h3>
            </div>
        </div>
        ";
    }

}