<?php

use App\view\components\ResponsiveComponent\ButtonComponent\DashBoardButton;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;
$navbar= new AuthNavbar('Manage Requests','/manager','/public/images/icons/user.png','$firstName'.' '.'$lastName');
echo $navbar;
$background=new BackGroundImage();
echo $background;
?>

<div class="class-pane d-flex ">
    <div class="card nav-card">
        <div class="card-header">
            <img src="/public/images/icons/search.png" style="filter: invert(100%)" alt="">
            <div class="header-title">Emergency Request</div>
        </div>
    </div>
    <div class="card nav-card">
        <div class="card-header nav">
            <img src="/public/images/icons/camera.png" style="filter: invert(100%)" alt="">
            <div class="header-title">Blood Request</div>
        </div>
    </div>
    <div class="card nav-card">
        <div class="card-header">
            <img src="/public/images/icons/search.png" style="filter: invert(100%)" alt="">
            <div class="header-title">Disable Donor</div>
        </div>
    </div>
</div>

