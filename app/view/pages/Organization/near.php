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
$navbar = new AuthNavbar('Nearby Campaigns', '/organization/near', '/public/images/icons/user.png', true,false);

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
        <div id="filter-pane" class="filter-pane">
            <div class="search-input">
                <label class="search">Search
                    <input class="search-box" name="search" id="search" onkeyup="SearchFunction()">
                </label>
                <div class="search-icon" id="search-btn" onclick="SearchFunction()">
                    <img src="/public/images/icons/search.png" alt="">
                </div>
            </div>

        </div>
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
            <div class="pane-loader">
                <img src="/public/loading4.svg" alt="" width="200px">
            </div>
            <?php
                        if (empty($data)){
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
            <?php foreach ($data as $campaign){?>
            <div class="card none detail-card">
                <div class="card-image">
                    <img src='/public/images/campaign.png' alt="hello">
                </div>
                <div class="card-body">
                    <div class="card-title"><?= $campaign->getCampaignName()?></div>
                    <div class="card-description"><?= $campaign->getCampaignDate() ?></div>
                    <div class="card-description"><?= $campaign->getCampaignDescription() ?></div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    <?php
    echo CardPane::GetJS('/organization/received/search');
    ?>









