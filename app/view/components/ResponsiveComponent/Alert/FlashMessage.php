<?php

namespace App\view\components\ResponsiveComponent\Alert;

use Core\Session;

class FlashMessage
{

    public static function GetCss()
    {
        return <<<HTML
            <link rel="stylesheet" href="/public/css/components/Alert/flash.css">
        HTML;

    }
    public static function IsAlerted(): bool
    {
        return isset($_SESSION['flash_messages']) && !empty($_SESSION['flash_messages']);
    }

    public static function SuccessAlert($message): string
    {
        return <<<HTML
            <div class="alert alert-success alert-white rounded">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="closeAlert()">×</button>
                <div class="icon"><i class="fa fa-check"></i></div>
                <strong>Success!</strong> $message
            </div>
        HTML;
    }

    public static function InfoAlert()
    {
        return <<<HTML
            <div class="alert alert-info rounded">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="closeAlert()>×</button>
                <div class="icon"><i class="fa fa-info-circle"></i></div>
                <strong>Info!</strong> You have 3 new messages in your inbox.
            </div>
        HTML;
    }

    public static function ErrorAlert()
    {
        return <<<HTML
            <div class="alert alert-danger rounded">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="closeAlert()">×</button>
                <div class="icon"><i class="fa fa-times-circle"></i></div>
                <strong>Error!</strong> The server is not responding, try again later.
            </div>
        HTML;
    }

    public static function RenderFlashMessages()
    {
        $output = self::GetCss();
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
                        $output.= self::ErrorAlert();
                        break;
                }
            }
           $js=self::DestroyAlert();
            unset($_SESSION['flash_messages']);
            $output.= "<script>{$js}</script>";
              echo $output;
        }
    }

    public static function DestroyAlert(){
        return <<<JS
            const Alert=document.getElementsByClassName('alert')[0]
            Alert.classList.add('fade-in')
            setTimeout(()=>{
                Alert.classList.remove('fade-in')
                Alert.classList.add('fade-out')
            },5000)
            
            const closeAlert=()=>{
                Alert.classList.remove('fade-in')
                Alert.classList.add('fade-out')
            }
        JS;

    }

}