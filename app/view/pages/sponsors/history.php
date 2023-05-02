<link rel="stylesheet" href="/public/css/framework/utils.css">
<link rel="stylesheet" href="/public/css/components/cardPane/index.css">
<!--<script src="/public/scripts/index.js"></script>-->
<?php
/* @var string $firstName */

/* @var string $lastName */
/* @var Campaign $campaign */

use App\model\Campaigns\Campaign;
use App\model\users\Organization;
use App\view\components\ResponsiveComponent\Alert\FlashMessage;
use App\view\components\ResponsiveComponent\CardPane\CardPane;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;

//echo Loader::GetLoader();
$background = new BackGroundImage();
$navbar = new AuthNavbar('Sponsorship History', '/sponsors/history', '/public/images/icons/user.png', true,false);

echo $navbar;
echo $background;
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

<div id="detail-pane" class="detail-pane">
    <div id="detail-pane" class="detail-pane">
        <div id="card-pane" class="card-pane">
            <?php
            if (empty($para)){
                ?>
                <div class="card detail-card">
                    <div class="card-image">
                        <img src="/public/images/icons/organization/dashboard/campaign.png" alt="">
                    </div>
                    <div class="card-body">
                        <div class="card-title">
                            No Sponsorships Found
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php foreach ($para as $key=>$row){?>
                <div class="card none detail-card"  style="height: 370px; width: 350px;">
                    <div class="card-image">
                        <img src='/public/images/campaign.png' alt="hello">
                    </div>
                    <div class="card-body">
                        <div class="card-title"><?= $row['Campaign_Name']?></div>
                        <div class="card-description"><?= $row['Sponsored_At'] ?></div>
                        <div class="form-label bg-red-8 p-1 border-radius-10" style="font-size: 20pt;color: whitesmoke;font-weight: bolder">LKR. <?= $row['Sponsored_Amount'] ?></div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php
    echo CardPane::GetJS('/organization/received/search');
    ?>

