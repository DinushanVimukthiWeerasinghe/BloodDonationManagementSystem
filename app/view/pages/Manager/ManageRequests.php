<?php

use App\view\components\ResponsiveComponent\ButtonComponent\DashBoardButton;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;
$navbar= new AuthNavbar('Manage Requests','/manager','/public/images/icons/user.png','$firstName'.' '.'$lastName');
echo $navbar;
$background=new BackGroundImage();
echo $background;
echo DashBoardButton::getDashBoardButtonCSS();
echo DashBoardButton::BackToDashBoard('/manager/dashboard');
?>



