<?php

use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;
$navbar= new AuthNavbar('Manage Campaigns','/manager','/public/images/icons/user.png','$firstName'.' '.'$lastName');
echo $navbar;
$background=new BackGroundImage();
echo $background;
?>
<div class="class-pane bg-black-0-3 p-1 border-radius-6 flex-wrap min-w-40 max-w-55 w-85 d-flex justify-content-center ">
    <div class="card nav-card">
        <div class="card-header">
            <img src="/public/images/icons/manager/manageCampaigns/approveCampaign.png" alt="">
            <div class="header-title">Approve Campaign</div>
        </div>
    </div>
    <div class="card nav-card" onclick="fun()">
        <div class="card-header">
            <img src="/public/images/icons/manager/manageCampaigns/approveCampaign.png" alt="">
            <div class="header-title">View Ongoing Campaign</div>
        </div>
    </div>
    <div class="card nav-card">
        <div class="card-header nav">
            <img src="/public/images/icons/manager/manageCampaigns/groupDoctor.png" alt="">
            <div class="header-title">Assign Medical Team</div>
        </div>
    </div>
    <div class="card nav-card">
        <div class="card-header">
            <img src="/public/images/icons/manager/manageCampaigns/sposorCampaign.png" alt="">
            <div class="header-title">Campaign Sponsorship</div>
        </div>
    </div>
    <div class="card nav-card">
        <div class="card-header">
            <img src="/public/images/icons/manager/manageCampaigns/approveCampaign.png" alt="">
            <div class="header-title">Inform Donor</div>
        </div>
    </div>
    <div class="card nav-card">
        <div class="card-header">
            <img src="/public/images/icons/manager/manageCampaigns/previousCampaign.png" alt="">
            <div class="header-title">View Previous Campaigns</div>
        </div>
    </div>
</div>
<style>
    .class-pane{
        margin-top: 10%;
    }
    @media only screen and (max-width: 500px) {
        .class-pane{
            max-width: 100%;
            width: 98%;
            padding: 0.2rem;
        }

    }
</style>
