<?php

namespace App\middleware;

use Core\Application;
use Core\BaseMiddleware;
use Exception;

class donorMiddleware extends BaseMiddleware
{


    /**
     * @throws Exception
     */
    public function execute()
    {
        if (!Application::$app->isDonor()) {
            Application::Redirect('/login');
        }
        if(Application::$app->getForbiddenRoutes()->isForbidden()){
            throw new Exception("Only For Permitted User");
        }
    }
}