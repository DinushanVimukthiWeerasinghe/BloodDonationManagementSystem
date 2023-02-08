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
$navbar = new AuthNavbar('Campaign Guidelines', '/organization/guidelines', '/public/images/icons/user.png', false);

echo $navbar;
echo $background;
FlashMessage::RenderFlashMessages();
?>

<div id="detail-pane" class="detail-pane">
    <div id="card-pane" class="card-pane">
        <div>
            <h1 class="text-info text-center fa-3x">Who Can Create Campaigns?</h1>
            <p class="mt-2 text-warning fa-intercom fa-2x">All of the registered Organizations can create Blood Donation Campaigns. Please be note that All of the created campaigns by the organizations must be apprroved by the <b class="bg-red-10">BDMS Admin.</b></p>
        </div>
        <div>
            <h1 class="text-info text-center fa-3x">Our Conditions</h1>
            <p class="mt-2 text-warning fa-intercom fa-2x">You can create campaigns 7 days after today onwards. As an example if you want to create a campaign and it will be held on tomorrow, You dont have permission for create the campaign today. You must create it at least 7 days before tomorrow.<b class="bg-red-10">We take at least 1 day for approve the campaigns.</b></p>
            <p class="mt-2 text-warning fa-intercom fa-2x">We will assign appropriate Medical teams for the particular campaigns.</p>
            <p class="mt-2 text-warning fa-intercom fa-2x">After the approval of a campaign Organizations can inform to donors and request sponsorships.</p>
        </div>
    </div>
</div>
