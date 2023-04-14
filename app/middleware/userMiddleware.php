<?php

namespace App\middleware;

use Core\Application;
use Exception;

class userMiddleware extends \Core\Middleware
{
    private array $action = [];


    public function __construct()
    {
        $this->action = Application::$app->getForbiddenRoutes()->getForbiddenRoutes();
    }


    /**
 * @throws Exception
 */
    public function execute()
    {
        if (Application::$app->isGuest()) {
            throw new Exception("Only For Allowed Users", 405);
        }
        if(Application::$app->getForbiddenRoutes()->isForbidden()){
            throw new Exception("Only For Permitted User");
        }
    }
}