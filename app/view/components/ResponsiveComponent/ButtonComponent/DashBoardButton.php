<?php

namespace App\view\components\ResponsiveComponent\ButtonComponent;

class DashBoardButton
{
    public static function getDashBoardButtonCSS(): string
    {
        return <<<HTML
    <link rel="stylesheet" href="/public/styles/btn.css">
    HTML;
    }

    public static function BackToDashBoard($path): string
    {
        return
        <<<HTML
        <div class="nav-dash" onclick="Redirect('$path')">
            <div class="dash-btn">
                <span class="dash-icon">
                    <img src="/public/images/icons/dashboard.png" alt="">
                </span>
                <span class="dash-text">Dashboard</span>
            </div>
        </div>
        HTML;
    }


}