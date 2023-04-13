<?php

use App\model\Campaigns\Campaign;
use App\view\components\ResponsiveComponent\Alert\FlashMessage;
FlashMessage::RenderFlashMessages();
///* @var string $firstName */
///* @var string $lastName */
/* @var string $Campaign_Name */
/* @var string $Campaign_Date */
/* @var Campaign $campaign */
//
///* @var MedicalOfficer $model */

use App\view\components\WebComponent\Card\Card;
use App\model\Campaigns\campaigns;
use App\view\components\ResponsiveComponent\CardGroup\CardGroup;
use App\view\components\ResponsiveComponent\CardPane\CardPane;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;

$background = new BackGroundImage();
$navbar = new AuthNavbar('Ongoing Campaigns', '#', '/public/images/icons/user.png');
//echo AuthNavbar::getNavbarCSS();
echo $navbar;
echo $background;
?>
<div class="container p-5" style="background-color: rgba(0,0,0,0.3);margin-top: 10vh;border-radius: 80px;">
    <?php

    if (empty($params)): ?>
        <div class="card detail-card">
            <div class="card-image">
                <img src="/public/images/icons/organization/history/notfound.png" alt="">
            </div>
            <div class="card-body">
                <div class="card-title fa fa-2x" style="color: red">
                    No Ongoing Campaigns.
                </div>
            </div>
        </div>
    <?php
    else:
        ?>
        <div id="card-pane" class="card-pane" >
            <?php foreach ($params as $key=>$row){?>
                <div class="card">
                    <div class="card-image">
                        <img src='/public/images/icons/bloodDrop.png'alt="">
                    </div>
                    <div class="card-body">
                        <div class="card-title fa fa-2x"><?= $row['Campaign_Name']; ?></div>
                        <div class="card-description"><?= $row['Campaign_Date']; ?></div>
                        <div class="card-description"><?= $row['Status']; ?></div>
                        <a href="../campDetails?id=<?php echo $row['Campaign_ID'];?>"><button class="btn btn-success">Campaign Details</button></a>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    <?php
    endif;
    ?>
