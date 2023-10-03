<?php

namespace App\view\components\Card;

class ClickableCard
{
    public string $title;
    public string $image;
    public string $img_alt;

    public function __construct(string $title, string $image, string $img_alt)
    {
        $this->title = $title;
        $this->image = $image;
        $this->img_alt = $img_alt;
    }

    public function render(): string
    {
        return <<<HTML
        <div class="card">
            <div class="card-header flex-column">
                <i class="{$this->image}" style="font-size: 4.5rem"></i>
                <h3 class="card-title">{$this->title}</h3>
            </div>
          
        </div>
        HTML;
    }

}