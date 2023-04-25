<?php

use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;

$navbar = new AuthNavbar('Manager Board', '/manager', '/public/images/icons/user.png', true,false );
$background = new BackGroundImage();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Be Positive</title>
    <meta charset="UTF-8">
    <meta content='width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;' name='viewport'/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="apple-touch-icon" sizes="180x180" href="/public/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/public/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/public/favicon/favicon-16x16.png">
    <link rel="manifest" href="/public/favicon/site.webmanifest">

    <link rel="stylesheet" href="/public/css/framework/utils.css">
    <link rel="stylesheet" href="/public/css/fontawesome/fa.css">
    <script src="/public/scripts/index.js"></script>
</head>
<body class="d-flex">
<?= $navbar;?>
<?= $background;?>
<div id="sidePanel" class="h-90 bg-white-0-3 d-flex align-items-center justify-content-center min-h-92vh absolute w-12vw left-0 bottom-0" style="z-index: 999">
    <div class="d-flex w-100 m-1 flex-column justify-content-center align-items-center gap-1" >
        <div class="d-flex p-1 border-radius-10 w-100 bg-primary text-white align-items-center justify-content-center text-xl font-bold cursor" onclick="Redirect('/manager/dashboard')">
            <img src="/public/icons/dashboard.png" class="mr-1" width="24px" alt="" style="filter: invert(100%)">
            Dashboard
        </div>
        <div class="d-flex p-1 w-100 bg-primary border-radius-10 text-white align-items-center justify-content-center text-xl font-bold cursor" onclick="Redirect('/manager/mngRequests')">
            <img src="/public/icons/requests.png" class="mr-1" width="24px" alt="" style="filter: invert(100%)">
            Requests
        </div>
        <div class="d-flex p-1 w-100 bg-primary border-radius-10 text-white align-items-center justify-content-center text-xl font-bold cursor" onclick="Redirect('/manager/mngDonors')">
            <img src="/public/icons/donor.png" class="mr-1" width="24px" alt="" style="filter: invert(100%)">
            Donors
        </div>
        <div class="d-flex p-1 w-100 bg-primary border-radius-10 text-white align-items-center justify-content-center text-xl font-bold cursor" onclick="Redirect('/manager/mngSponsorship')">
            <img src="/public/icons/sponsors.png" class="mr-1" width="24px" alt="" style="filter: invert(100%)">
            Sponsors
        </div>
        <div class="d-flex p-1 w-100 bg-primary border-radius-10 text-white align-items-center justify-content-center text-xl font-bold cursor" onclick="Redirect('/manager/mngMedicalOfficer')">
            <img src="/public/icons/MedicalOfficer.png" class="mr-1" width="24px" alt="" style="filter: invert(100%)">
            Officers
        </div>
        <div class="d-flex p-1 w-100 bg-primary border-radius-10 text-white align-items-center justify-content-center text-xl font-bold cursor" onclick="Redirect('/manager/mngCampaigns')">
            <img src="/public/icons/campaign.png" class="mr-1" width="24px" alt="" style="filter: invert(100%)">
            Campaigns
        </div>
        <div class="d-flex p-1 w-100 bg-primary border-radius-10 text-white align-items-center justify-content-center text-xl font-bold cursor" onclick="Redirect('/manager/mngReport')">
            <img src="/public/icons/dashboard.png" class="mr-1" width="24px" alt="" style="filter: invert(100%)">
            Reports
        </div>


    </div>
</div>
    <div class="absolute d-flex justify-content-center align-items-center" style="left: 12vw;top: 8vh;height: 92vh;width: 88vw;">
        {{content}}
    </div>
</body>
<script src="/public/js/components/navbar/navbar.js"></script>
<script src="/public/js/components/dialog-box/dialog-box.js"></script>
<script src="/public/js/components/toasts/toast.js"></script>

<script src="/public/js/components/accordion/accordion.js"></script>
</html>
