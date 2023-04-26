<?php

namespace App\view\components\ResponsiveComponent\ImageComponent;

use Core\Application;

class BackGroundImage
{
    private string $imgURL='/public/images/homebg.png';

    /**
     * @param string $imgURL
     */
    public function setImgURL(string $imgURL): void
    {
        $this->imgURL = $imgURL;
    }

    private function GetCss()
    {
        ob_start();
        include_once Application::$ROOT_DIR."/public/css/components/BackgroundImage/index.css";
        $css= ob_get_clean();
        return <<<HTML
            <style>{$css}</style>
        HTML;
    }
    
    public function __toString(): string
    {
        return <<<HTML
            {$this->GetCss()}
            <img class="background" src="{$this->imgURL}" alt=""/>
        HTML;
    }


}