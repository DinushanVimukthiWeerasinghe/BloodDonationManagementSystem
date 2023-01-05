<?php

use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;
$navbar= new AuthNavbar('Manage Campaigns','/manager','/public/images/icons/user.png','$firstName'.' '.'$lastName');
echo $navbar;
$background=new BackGroundImage();
echo $background;
echo \App\view\components\ResponsiveComponent\ButtonComponent\DashBoardButton::getDashBoardButtonCSS();
echo \App\view\components\ResponsiveComponent\ButtonComponent\DashBoardButton::BackToDashBoard('/manager/dashboard');