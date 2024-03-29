<?php

namespace App\view\components\ResponsiveComponent\Alert;

use Core\Session;

class FlashMessage
{

    public static function IsAlerted(): bool
    {
        return isset($_SESSION['flash_messages']) && !empty($_SESSION['flash_messages']);
    }

    public static function SuccessAlert($message): string
    {
        return <<<HTML
            <div class="alert alert-success alert-white rounded">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="closeAlert()">×</button>
                <div class="d-flex flex-row gap-1">
                    <div class="icon"><i class="fa fa-check"></i></div>
                    <strong>Success!</strong> 
                    <span>$message</span>
                </div>
            </div>
        HTML;
    }

    public static function InfoAlert(): string
    {
        return <<<HTML
            <div class="alert alert-info rounded">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="closeAlert()">×</button>
                <div class="d-flex flex-row gap-1">
                    <div class="icon"><i class="fa fa-info-circle"></i></div>
                    <strong>Info!</strong> You have 3 new messages in your inbox.
                </div>
            </div>
        HTML;
    }

    public static function ErrorAlert(string $errMsg): string
    {
        return <<<HTML
            <div class="alert alert-danger rounded">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="closeAlert()">×</button>
                <div class="d-flex flex-row gap-1">
                    <div class="icon"><i class="fa fa-times-circle"></i></div>
                    <span>$errMsg</span>
                </div>
            </div>
        HTML;
    }

    public static function RenderFlashMessages(): void
    {
        $output = '';
        if (self::IsAlerted()) {
            foreach ($_SESSION['flash_messages'] as $key=>$message) {

                switch ($key){
                    case 'success':
                        $output.= self::SuccessAlert($message['value']);
                        break;
                    case 'info':
                        $output.= self::InfoAlert();
                        break;
                    case 'error':
                        $output.= self::ErrorAlert($message['value']);
                        break;
                }
            }
            $js=self::DestroyAlert();
            unset($_SESSION['flash_messages']);
            $output.= "<script>{$js}</script>";
            echo $output;

        }
    }

    public static function DestroyAlert(): string
    {
        return <<<JS
            const alert=document.getElementsByClassName('alert')[0]
            alert.classList.add('fade-in')
            setTimeout(()=>{
                alert.classList.remove('fade-in')
                alert.classList.add('fade-out')
                alert.remove() ;
            },5000)

            const closeAlert=()=>{
                alert.classList.remove('fade-in')
                alert.classList.add('fade-out')
                alert.remove() 
            }
        JS;

    }

}