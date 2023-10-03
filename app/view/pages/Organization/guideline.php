
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
<div id="detail-pane" class="text-xl detail-pane">
    <div id="card-pane" class="card-pane">
        <img src="/public/images/doublearrow.png" style="height: 80px;margin-right: 85vw;position: fixed;cursor: pointer;margin-top: 20px;" onclick="history.back()"/><br>
        <div class="d-flex flex-column justify-content-center align-items-center text-white">
            <div class="text-center text-3xl bg-white text-dark p-1 border-radius-10 font-bold mt-2">Who Can Create Campaigns?</div>
            <div class="p-3 mx-4 bg-white text-dark m-1 border-radius-10">
                All of the Registered Organizations have facility for create campaigns.<span class="text-danger">Please be note that you can create only one Campaign at a particular time.</span>
            </div>
        </div>
        <div class="d-flex flex-column justify-content-center align-items-center text-white p-3 text-center">
            <div class="text-center text-3xl bg-white text-dark p-1 border-radius-10 font-bold">Our Rules & Regulations</div>
            <div class="d-flex flex-column gap-1 mt-1">
                <div class="d-flex flex-column  bg-white text-dark m-1 border-radius-10 p-2">
                    <div class="d-flex">
                       If you are a registered organization, You have full facility for create campaigns and request sponsorships with the
                       Admin Approval.
                    </div>
                    <ul class="mt-1 d-flex flex-column gap-0-5 justify-content-center align-items-center">
                        <li>Your created campaign will be available as a registered campaign after the BDMS adminstrator Approval.</li>
                        <li>You can request sponsorships from the Sponsors after the Administrator Approval.</li>
                        <li>If you create a campaign and it is still on the pending review state you cannot create another campaign until it is on the approved State.</li>
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
