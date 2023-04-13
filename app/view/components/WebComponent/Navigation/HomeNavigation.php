<?php

namespace App\view\components\WebComponent\Navigation;

class HomeNavigation extends BaseNavigation
{
    public function __construct()
    {
        parent::__construct([
            [
                'title'=>'Home',
                'url'=>'/'
            ],
            [
                'title'=>'Login',
                'url'=>'/manager/login'
            ],
            [
                'title'=>'Register',
                'url'=>'/manager/register'
            ]
        ]);
    }

}