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
        return <<<HTML
            <div class="d-flex w-60 flex-wrap flex-column bg-white-0-3 p-3 border-radius-10 justify-content-center align-items-center changepanel">
                <div class="d-flex flex-wrap align-items-center justify-content-center w-100">
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