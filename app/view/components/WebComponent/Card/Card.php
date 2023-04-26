<?php

namespace App\view\components\WebComponent\Card;

class Card
{
    public static function ImportCSS(): string
    {
        return <<<HTML
            <link rel="stylesheet" href="/public/css/components/card/card.css">
        HTML;
    }

    public static function ImportJS(): string
    {
        return <<<HTML
            <script src="/public/js/components/card/card.js"></script>
        HTML;
    }

    public static function Import(): string
    {
        return self::ImportCSS() . self::ImportJS();
    }

}