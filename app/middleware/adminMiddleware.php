<?php

namespace App\middleware;

use Core\Application;
use Core\BaseMiddleware;
use Exception;

class adminMiddleware extends BaseMiddleware
{


    /**
     * @throws Exception
     */
    public function execute()
    {
        if (!Application::$app->isAdmin()) {
            Application::Redirect('/login');
        }
        if(Application::$app->getForbiddenRoutes()->isForbidden()){
            throw new Exception("Only For Permitted User");
        }
    }
}