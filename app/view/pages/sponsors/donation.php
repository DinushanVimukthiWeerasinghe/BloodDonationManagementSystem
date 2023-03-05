<link rel="stylesheet" href="/public/css/framework/utils.css">
<link rel="stylesheet" href="/public/css/components/cardPane/index.css">
<!--<script src="/public/scripts/index.js"></script>-->
<?php
/* @var string $firstName */

/* @var string $lastName */

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
        <div class="filter-card">
            <div class="card-navigation">
                <a class="disabled" href="?page=1"><img class="nav-btn" src="/public/images/icons/previous.png"
                                                        alt=""></a>
                <div class="page-numbers">
                    <a href='?page=1' class='disabled'>
                        <div class='page-number active'>1</div>
                    </a>
                </div>
                <a class="disabled" href="?page=1"><img class="nav-btn" src="/public/images/icons/next.png" alt=""></a>
            </div>
        </div>
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
            <?php foreach ($params as $key=>$row){?>
            <?php if($row['Status'] == 2) {?>
            <div class="card none detail-card" style="height: 300px;">
                <div class="card-body">
                    <div class="card-title" style="font-size: 2em;"><?php echo $row['Campaign_Name'] ?></div>
                    <div class="card-description" style="font-size: 1.2em;font-weight: 900;"><?php echo $row['Venue'] ?></div>
                    <div class="card-description" style="font-size: 1.2em;font-weight: 900;"><?php echo $row['Campaign_Date'] ?></div><br>
                    <div class="card-description bg-yellow-6 p-1" style="font-size: 1.5em;font-weight: 900;"><?php echo $row['Package_Name'] ?></div><br>
                    <button class="btn btn-success" href="">Sponse</button>
                </div>
            </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
    <?php
    echo CardPane::GetJS('/organization/received/search');
    ?>









