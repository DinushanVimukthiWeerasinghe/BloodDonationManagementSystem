<?php

namespace App\view\components\Loader;

class Loader
{
    public static function GetLoader(): string
    {
        return <<<HTML
        <style>
            .loader{
                position: absolute;
                background: rgba(255,255,255,0.99);
                z-index: 5000;
                min-height: 100vh;
                min-width: 100vw;
                display: flex;
                justify-content: center;
                align-items: center;
            }
        </style>
        
        <div class="loader">
            <img src="/public/loading2.svg" alt="" width="200px">
        </div>
        <script>
            window.addEventListener('load', function () {
                setTimeout(function () {
                    document.querySelector('.loader').style.display = 'none';
                }, 500);
            })
        </script>
HTML;

    }
}