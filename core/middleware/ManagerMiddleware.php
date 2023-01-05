<?php

namespace Core\middleware;

use Core\Application;

class ManagerMiddleware extends \Core\BaseMiddleware
{

    public function execute()
    {

        if (Application::$app->getUser()->getRole() !== 'Manager') {
            Application::$app->response->redirect('/');
        }

    }
}