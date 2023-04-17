<link rel="stylesheet" href="/public/css/framework/utils.css">
<link rel="stylesheet" href="/public/css/components/cardPane/index.css">
<!--<script src="/public/scripts/index.js"></script>-->
<style>
    .btn:hover{
        background-color: red;
        color: #0b0000;
    }
    /*.btn{*/
    /*    animation: blink .7s infinite;*/
    /*}*/

    @keyframes blink{
        0%{
            background-color: green;

        }
        100%{
            background-color: red;
        }

    }
</style>
<?php
/* @var string $firstName */

/* @var string $lastName */
/* @var string $campaigns */

use App\model\users\Organization;
use App\view\components\ResponsiveComponent\Alert\FlashMessage;
use App\view\components\ResponsiveComponent\CardPane\CardPane;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;

//echo Loader::GetLoader();
$background = new BackGroundImage();
$navbar = new AuthNavbar('Donation Campaigns', '/organization/near', '/public/images/icons/user.png', false);

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
        <div id="card-pane" class="card-pane">
            <?php
            if (empty($params)){
                ?>
                <div class="card detail-card">
                    <div class="card-image">
                        <img src="/public/images/icons/organization/dashboard/campaign.png" alt="">
                    </div>
                    <div class="card-body">
                        <div class="card-title">
                            No Campaigns Found
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php foreach ($params as $row){?>
            <div class="card none detail-card" style="height: 370px; width: 350px;">
                <div class="card-body">
                    <div class="card-image" style="text-align: center;margin-left: 100px;width: 100px;height: 100px;margin-top: -50px;"><img src="../../../../public/images/donation.png" alt="hello"></div>
                    <div class="card-title" style="font-size: 1.2em;font-weight: 900"><?php  echo $row['Campaign_Name']; ?></div>
                    <div class="card-description" style="font-size: 1.2em;font-weight: 900;"><?php echo $row['Campaign_Date']; ?></div>
                    <div class="card-description" style="font-size: 1.2em;font-weight: 900;"><?php echo $row['Requested_Package']; ?></div>
                    <div class="card-description bg-yellow-7 p-1" style="font-size: 1.2em;font-weight: 900;">LKR. <?php echo $row['Package_Price']; ?></div>
                    <button class="btn btn-success w-100 mt-1" href="#">Sponse</button>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    <?php
    echo CardPane::GetJS('/organization/received/search');
    ?>









