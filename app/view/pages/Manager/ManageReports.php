<?php

use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;
$navbar= new AuthNavbar('Manage Reports','/manager','/public/images/icons/user.png','$firstName'.' '.'$lastName');
echo $navbar;
$background=new BackGroundImage();
echo $background;
?>
<div class="class-pane bg-black-0-3 p-1 border-radius-6 flex-wrap min-w-40 max-w-55 w-85 d-flex justify-content-center ">
    <div class="card nav-card">
        <div class="card-header">
            <img src="/public/images/icons/manager/manageReport/generateReport2.png" alt="">
            <div class="header-title">Generate Branch Report</div>
        </div>
    </div>
    <div class="card nav-card">
        <div class="card-header">
            <img src="/public/images/icons/manager/manageReport/health-report.png" alt="">
            <div class="header-title">Generate Donation Report</div>
        </div>
    </div>
    <div class="card nav-card">
        <div class="card-header">
            <img src="/public/images/icons/manager/manageReport/health-report.png" alt="">
            <div class="header-title">Previous Reports</div>
        </div>
    </div>
    <div class="card nav-card">
        <div class="card-header">
            <img src="/public/images/icons/manager/manageReport/health-report.png" alt="">
            <div class="header-title">Campaign Reports</div>
        </div>
    </div>
   <div class="card nav-card">
        <div class="card-header">
            <img src="/public/images/icons/manager/manageReport/health-report.png" alt="">
            <div class="header-title">Transaction Reports</div>
        </div>
    </div>
</div>
