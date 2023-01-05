<?php

namespace App\view\components\ResponsiveComponent\CardGroup;

use App\view\components\WebComponent\Card\Card;
use Core\Application;

class CardGroup
{
    public static function RenderCSS(): string
    {
        return <<<HTML
            <link rel="stylesheet" href="/public/css/components/cardGroup/index.css">
        HTML;

    }

    public static function CardPanel(): string
    {
        $css=static::RenderCSS();
        return <<<HTML
            {$css}
            <div class="panel">
                <div class="card-grp">
        HTML;
    }
    public static function CloseCardPanel(): string
    {
        return <<<HTML
                </div>
            </div>
        HTML;
    }
}