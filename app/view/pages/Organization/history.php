<!--<script src="/public/scripts/customAlert.js"></script>-->
<!--<link href="/public/styles/alert.css" rel="stylesheet">-->
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
$navbar = new AuthNavbar('Campaign History', '#', '/public/images/icons/user.png');
//echo AuthNavbar::getNavbarCSS();
echo $navbar;
echo $background;
?>
<style>
    .btn:hover{
        background-color: red;
    }
</style>
<!--<link rel="stylesheet" href="/public/styles/index2.css">-->
<!--<link rel="stylesheet" href="/public/css/components/cardGroup/index.css">-->
<!--<link rel="stylesheet" href="/public/css/fontawesome/fa.css">-->
<!--<link rel="stylesheet" href="/public/framework/components/button/button.css">-->
<!--<style>-->
<!--    .btn:hover{-->
<!--        background-color: red;-->
<!--    }-->
<!--    .card:hover{-->
<!--        box-shadow: 0 1px 0 rgba(9,30,66,.25), 0 0 60px rgba(0,0,0,.08);-->
<!--        transform: scale(1.1) translate(0, -5px);-->
<!--        cursor: pointer;-->
<!--    }-->
<!--    @media only screen and (max-width: 1325px) {-->
<!--        .cards{-->
<!--            align-items: center;-->
<!--            display: flex;-->
<!--            flex-direction: column;-->
<!--        }-->
<!--    }-->
<!--    @media only screen and (max-width: 1312px) {-->
<!--        .container{-->
<!--            margin-top: 200px;-->
<!--        }-->
<!---->
<!--    }-->
<!--</style>-->
<div class="container p-5" style="background-color: rgba(0,0,0,0.3);margin-top: 10vh;border-radius: 80px;">
    <?php

    if (empty($params)): ?>
    <div class="card detail-card">
        <div class="card-image">
            <img src="/public/images/icons/organization/history/notfound.png" alt="">
        </div>
        <div class="card-body">
            <div class="card-title fa fa-2x" style="color: red">
                No Campaigns.
            </div>
        </div>
    </div>
    <?php
    else:
    ?>
    <div id="card-pane" class="card-pane" >
                <?php foreach ($params as $key=>$row){ ?>
                    <div class="card" style="width: 300px;height: 300px;">
                        <div class="card-image">
                            <img src='/public/images/icons/bloodDrop.png'alt="Image Not Available">
                        </div>
                        <div class="card-body">
                            <div class="card-title fa fa-1x" style="margin-top: -2px;"><?= $row['Campaign_Name']; ?></div><br><br>
                            <div class="card-description fa fa-1x" style="margin-top: -30px;"><?= $row['Campaign_Date']; ?></div><br><br>
                            <a href="campDetails?id=<?php echo $row['Campaign_ID'];?>"><button class="btn btn-success w-100" id="details">Campaign Details</button></a>
                        </div>
                    </div>
                <?php
                }
                ?>
    </div>
    <?php
    endif;
    ?>
<!--         </div>-->
<!--</div>-->





