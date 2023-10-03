<link rel="stylesheet" href="/public/css/framework/utils.css">
<link rel="stylesheet" href="/public/css/components/cardPane/index.css">
<link rel="stylesheet" href="/public/css/fontawesome/fa.css">
<!--<script src="/public/scripts/index.js"></script>-->
<?php

/* @var string $firstName */
/* @var Sponsor $sponsors */
/* @var string $lastName */

use App\model\users\Sponsor;
use App\view\components\ResponsiveComponent\Alert\FlashMessage;
use App\view\components\ResponsiveComponent\CardPane\CardPane;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;

//echo Loader::GetLoader();
$background = new BackGroundImage();
$navbar = new AuthNavbar('Received Sponsorships', '/organization/received', '/public/images/icons/user.png', false);

echo $navbar;
echo $background;
//echo new primaryTitle('Manage Medical Officers');
/* @var array $data */
/* @var Organization $value */


function GetImage($imageURL)
{
    if ($imageURL == null) {
        return '/public/images/icons/user1.png';
    } else {
        return $imageURL;
    }
}

FlashMessage::RenderFlashMessages();
?>
<?php if($reach) {?>
    <h1 class="bg-warning p-1">You have reached Your Expected Amount</h1><br>
<?php } ?>
<div class="card none detail-card p-2"  style="height: 40vh;cursor: default;width: 40vw;min-width: auto;background-size: cover">
    <div class="card-title">
        <h1 style="font-size: 2em;">Total Income:</h1>
    </div>
    <div class="card-body">
        <div class="card-title"><h2 style="font-size: 4em;background-color: red;color: #cccccc;border-radius: 5px;">LKR. <?=  $data ?></div>
    </div>
</div>
    <?php
    echo CardPane::GetJS('/organization/received/search');
    ?>







