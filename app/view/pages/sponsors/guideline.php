<link rel="stylesheet" href="/public/css/framework/utils.css">
<link rel="stylesheet" href="/public/css/components/cardPane/index.css">
<link rel="stylesheet" href="/public/css/fontawesome/fa.css">
<!--<script src="/public/scripts/index.js"></script>-->
<?php
/* @var string $firstName */

/* @var string $lastName */

use App\model\users\organization;
use App\view\components\ResponsiveComponent\Alert\FlashMessage;
use App\view\components\ResponsiveComponent\CardPane\CardPane;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;

//echo Loader::GetLoader();
$background = new BackGroundImage();
$navbar = new AuthNavbar('Sponsorship Guidelines', '/sponsor/guidelines', '/public/images/icons/user.png', false);

echo $navbar;
echo $background;
FlashMessage::RenderFlashMessages();
?>

<div id="detail-pane" class="detail-pane">
    <div id="card-pane" class="card-pane">
        <div>
            <h1 class="text-info text-center fa-3x">Who Can Sponsor Campaigns?</h1><p class="mt-2 text-warning fa-intercom fa-2x">All of the registered Sponsors can sponse for campaigns.<b class="bg-red-10">All the Sponsors must use a package for sponse to campaigns.</b></p><p class="mt-2 text-warning fa-intercom fa-2x">We have 3 types of sponsorship Packages as&nbsp<b class="bg-red-10">Gold,Platinum and Silver.</b></p>
        </div>
        <div>
            <h1 class="text-info text-center fa-3x">Our Conditions</h1>
            <p class="mt-2 text-warning fa-intercom fa-2x">We have 3 types of sponsorship packages as <b class="bg-red-10">Gold,Silver and Platinum.</b></p>
            <p class="mt-2 text-warning fa-intercom fa-2x">You can change your current sponsorship package anytime.</p>
        </div>
    </div>
</div>
