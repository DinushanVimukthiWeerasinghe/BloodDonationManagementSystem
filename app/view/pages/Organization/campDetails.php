<?php
/* @var string $Campaign_Name */
/* @var Campaign $campaign */
/* @var string $Venue */

use App\model\Campaigns\Campaign;
use App\view\components\ResponsiveComponent\Alert\FlashMessage;
use App\view\components\ResponsiveComponent\CardGroup\CardGroup;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;

$navbar = new AuthNavbar('Campaign Details', '/organization', '/public/images/icons/user.png', true,false );
echo $navbar;

use App\view\components\WebComponent\Card\Card;

echo Card::ImportJS();
//echo Card::ImportCSS();

/* @var Organization $user */

use App\model\users\Organization;
use App\view\components\WebComponent\Card\NavigationCard;
$background = new BackGroundImage();
echo $background;
FlashMessage::RenderFlashMessages();
?>
<div class="d-flex flex-column w-80 p-3">
        <div class="d-flex bg-white-0-3 p-3 flex-column">
            <div class="text-xl bg-white border-radius-10" id="Campaign_Detail">
                <div class="d-flex gap-1" id="Campaign_Name">
                    <div class="">Campaign Name </div>
                    <div class="font-bold"><?=$campaign->getCampaignName(); ?></div>
                </div>
                <div class="d-flex gap-1" id="Campaign_Venue">
                    <div class="">Venue </div>
                    <div class="font-bold"><?=$campaign->getVenue(); ?></div>
                </div>
                <div class="d-flex gap-1" id="Campaign_Date">
                    <div class="">Date </div>
                    <div class="font-bold"><?=$campaign->getCampaignDate(); ?></div>
                </div>
                <div class="d-flex gap-1" id="Campaign_Status">
                    <div class="">Time </div>
                    <div class="font-bold"><?=$campaign->getCampaignStatus(); ?></div>
                </div>
            </div>
        </div>
        <div class="d-flex">
            <div class="card nav-card bg-white text-dark" onclick="Redirect('request?id=<?php echo $_GET['id'] ?>')">
                <div class="card-header">
                    <div class="card-header-img">
                        <img src="/public/images/icons/organization/campaignDetails/request.png" alt="Request" width="100px">
                    </div>
                    <div class="card-title">
                        <h3>Request Sponsorship</h3>
                    </div>
                </div>
            </div>
            <div class="card nav-card bg-white text-dark" onclick="Redirect('received?id=<?php echo $_GET['id'] ?>')">
                <div class="card-header">
                    <div class="card-header-img">
                        <img src="/public/images/icons/organization/campaignDetails/received.png" alt="Received" width="100px">
                    </div>
                    <div class="card-title">
                        <h3>Received Sponsorships</h3>
                    </div>
                </div>
            </div>
            <div class="card nav-card bg-white text-dark" onclick="Redirect('accepted?id=<?php echo $_GET['id'] ?>')">
                <div class="card-header">
                    <div class="card-header-img">
                        <img src="/public/images/icons/organization/campaignDetails/accepted.png" alt="Accepted" width="100px">
                    </div>
                    <div class="card-title">
                        <h3>Accepted Donors</h3>
                    </div>
                </div>
            </div>
            <div class="card nav-card bg-white text-dark" onclick="Redirect('inform?id=<?php echo $_GET['id'] ?>')">
                <div class="card-header">
                    <div class="card-header-img">
                        <img src="/public/images/icons/organization/campaignDetails/inform.png" alt="Inform" width="100px">
                    </div>
                    <div class="card-title">
                        <h3>Inform Donors</h3>
                    </div>
                </div>
            </div>
        </div>
</div>