<?php

namespace App\view\components\ResponsiveComponent\Title;
use Core\Application;

class primaryTitle
{
    private string $title;

    /**
     * @param string $title
     */
    public function __construct(string $title)
    {
        $this->title = $title;
    }

    private function GetCss(): string
    {
        return <<<HTML
            <link rel="stylesheet" href="/public/css/components/title/index.css">
        HTML;
    }

    public function __toString(): string
    {
        return <<<HTML
            {$this->GetCss()}
            <div class="title">{$this->title}</div>
        HTML;

    }
}