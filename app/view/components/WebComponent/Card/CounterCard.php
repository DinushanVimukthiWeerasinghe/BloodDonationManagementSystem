<?php

namespace App\view\components\WebComponent\Card;

class CounterCard
{
    public string $count;
    public string $title;
    public string $SecondaryTitle;
    public string $icon;

    public function __construct(mixed $title, string $count, string $img="")
    {
        if (is_string($title)) {
            $this->title = $title;
        } else if (is_array($title)) {
            $this->title = $title['primary'];
            $this->SecondaryTitle = $title['secondary'];
        }
        $this->count = $count;
        $this->icon = $img;
    }


    public function render(): string
    {
        if (trim($this->icon) == "") {
            return <<<HTML
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{$this->count}</h3>
                <h3 class="card-title">{$this->SecondaryTitle}</h3>
             
            </div>
            <div class="card-body">
                <h5 class="card-title">{$this->title}</h5>
            </div>
        </div>
        HTML;
        }else{
            return <<<HTML
                <div class="card">
            <div class="card-header">
                <img height="100%" src="{$this->icon}" alt="">
            </div>
            <div class="card-body">
                <h1 class="card-title">{$this->title}</h1>
                <h3 class="card-secondary-title">{$this->SecondaryTitle}</h3>
            </div>
            </div>
            HTML;

        }

    }

}