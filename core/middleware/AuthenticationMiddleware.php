<?php

namespace Core\middleware;

use Core\Application;
use Core\BaseMiddleware;
use Exception;

class AuthenticationMiddleware extends BaseMiddleware
{
    private array $action = [];
    private int $Type = 2;


    public function __construct($action=[],$type=2)
    {
        $this->action = $action;
        $this->Type = $type;
    }


    /**
 * @throws Exception
 */
    public function execute()
    {
        if($this->Type===1)
        {

            if (Application::$app->isGuest()) {
                if(empty($this->action) || !in_array(Application::$app->controller->action,$this->action)) {
                    Application::Redirect('/');
//                throw new Exception("Only For Allowed Users", 405);
                }
            }
        }else{
            if (Application::$app->isGuest()) {
                if(empty($this->action) || in_array(Application::$app->controller->action,$this->action)) {
                    Application::Redirect('/');
//                throw new Exception("Only For Allowed Users", 405);
                }
            }
        }

    }
}