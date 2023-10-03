<!--<link rel="stylesheet" href="/public/css/framework/utils.css">-->
<!--<link rel="stylesheet" href="/public/css/components/cardPane/index.css">-->
<!--<link rel="stylesheet" href="/public/css/fontawesome/fa.css">-->
<!--<!--<script src="/public/scripts/index.js"></script>-->-->
<?php
///* @var string $firstName */
//
///* @var string $lastName */
//
//use App\model\users\organization;
//use App\view\components\ResponsiveComponent\Alert\FlashMessage;
//use App\view\components\ResponsiveComponent\CardPane\CardPane;
//use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
//use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;
//
////echo Loader::GetLoader();
//$background = new BackGroundImage();
//$navbar = new AuthNavbar('Campaign Guidelines', '/organization/guidelines', '/public/images/icons/user.png', false);
//
//echo $navbar;
//echo $background;
//FlashMessage::RenderFlashMessages();
//?>
<!---->
<!--<div id="detail-pane" class="detail-pane">-->
<!--    <div id="card-pane" class="card-pane">-->
<!--        <div>-->
<!--            <h1 class="text-info text-center fa-3x">Who Can Create Campaigns?</h1>-->
<!--            <p class="mt-2 text-warning fa-intercom fa-2x">All of the registered Organizations can create Blood Donation Campaigns. Please be note that All of the created campaigns by the organizations must be apprroved by the <b class="bg-red-10">BDMS Admin.</b></p>-->
<!--        </div>-->
<!--        <div>-->
<!--            <h1 class="text-info text-center fa-3x">Our Conditions</h1>-->
<!--            <p class="mt-2 text-warning fa-intercom fa-2x">You can create campaigns 7 days after today onwards. As an example if you want to create a campaign and it will be held on tomorrow, You dont have permission for create the campaign today. You must create it at least 7 days before tomorrow.<b class="bg-red-10">We take at least 1 day for approve the campaigns.</b></p>-->
<!--            <p class="mt-2 text-warning fa-intercom fa-2x">We will assign appropriate Medical teams for the particular campaigns.</p>-->
<!--            <p class="mt-2 text-warning fa-intercom fa-2x">After the approval of a campaign Organizations can inform to donors and request sponsorships.</p>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
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
$navbar = new AuthNavbar('Sponsor Guidelines', '/organization/guidelines', '/public/images/icons/user.png', false);

echo $navbar;
echo $background;
FlashMessage::RenderFlashMessages();
?>

<div id="detail-pane" class="text-xl detail-pane">
    <div id="card-pane" class="card-pane">
        <div class="d-flex flex-column justify-content-center align-items-center text-white">
            <div class="text-center text-3xl bg-white text-dark p-1 border-radius-10 font-bold">Who Can Sponse for Campaigns?</div>
            <div class="p-3 mx-4 bg-white text-dark m-1 border-radius-10">
                All of the Registered Sponsors have facility for sponse campaigns.<span class="text-danger">Please be note that You must have a particular package for sponse Campaign.</span>
            </div>
        </div>
        <div class="d-flex flex-column justify-content-center align-items-center text-white p-3 text-center">
            <div class="text-center text-3xl bg-white text-dark p-1 border-radius-10 font-bold">Our Rules & Regulations</div>
            <div class="d-flex flex-column gap-1 mt-1">
                <div class="d-flex flex-column  bg-white text-dark m-1 border-radius-10 p-2">
                    <div class="d-flex">
                       If you are a registered Sponsor, You have full facility for sponse campaigns and obtain Sponsorship Packages after an authorized Payment Verification.
                    </div>
                    <ul class="mt-1 d-flex flex-column gap-0-5 justify-content-center align-items-center">
                        <li>We have 3 Sponsorship Packages like Gold ,Silver and Platinum. You can see price of them in Your Profile Page.</li>
                        <li>You can advance or demote your Sponsorship Package and all of the Sponsors must have a Sponsorship Package for sponse Campaign.</li>
                        <li>Additional Sponsorship Requests must pay into the given Bank Accounts.</li>
                    </ul>
                </div>
            </div>
        </div>

        <!--        <div>-->
        <!--            <h1 class="text-info text-center fa-3x">Our Conditions</h1>-->
        <!--            <p class="mt-2 text-warning fa-intercom fa-2x">You can create campaigns 7 days after today onwards. As an example if you want to create a campaign and it will be held on tomorrow, You dont have permission for create the campaign today. You must create it at least 7 days before tomorrow.<b class="bg-red-10">We take at least 1 day for approve the campaigns.</b></p>-->
        <!--            <p class="mt-2 text-warning fa-intercom fa-2x">We will assign appropriate Medical teams for the particular campaigns.</p>-->
        <!--            <p class="mt-2 text-warning fa-intercom fa-2x">After the approval of a campaign Organizations can inform to donors and request sponsorships.</p>-->
        <!--        </div>-->
    </div>
</div>
