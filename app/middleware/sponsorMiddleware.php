<?php

namespace App\middleware;

use Core\Application;
use Core\BaseMiddleware;
use Exception;

class sponsorMiddleware extends BaseMiddleware
{


    /**
     * @throws Exception
     */
    public function execute()
    {
        if (!Application::$app->isSponsor()) {
            Application::Redirect('/login');
        }
        if(Application::$app->getForbiddenRoutes()->isForbidden()){
            throw new Exception("Only For Permitted User");
        }
    }
}