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
<link rel="stylesheet" href="/public/css/components/flexbox/flex-box.css">
<style>
    @media only screen and (max-width: 1263px) {
        .cards{
            flex-direction: column;
            justify-content: center;
            /*margin-top: 50vh;*/
        }
        .scroll{
            overflow-y: scroll;
        }
        .details{
            margin-top: 10vh;
        }
    }
</style>

<div class="d-flex flex-column w-80 p-5 scroll" style="margin-top: 10vh;">
        <div class="d-flex bg-white-0-3 p-3 flex-column details">
            <div class="text-xl bg-white border-radius-10 p-3" id="Campaign_Detail">
                <div class="d-flex gap-1" id="Campaign_Name">
                    <div class="">Campaign Name </div>
                    <div class="font-bold"><?=$campaign->getCampaignName(); ?></div>
                </div>
                <div class="d-flex gap-8" id="Campaign_Venue">
                    <div class="">Venue </div>
                    <div class="font-bold"><?=$campaign->getVenue(); ?></div>
                </div>
                <div class="d-flex gap-8" id="Campaign_Date">
                    <div class="">Date </div>
                    <div class="font-bold"><?=$campaign->getCampaignDate(); ?></div>
                </div>
                <div class="d-flex gap-6" id="Campaign_Status">
                    <div class="">Status </div>
                    <div class="font-bold bg-green-4" style="padding: 0 5px "><?=$campaign->getCampaignStatus(); ?></div>
                </div>
                <?php if($expired == 1) { ?>
                <div class="d-flex gap-6" id="Campaign_Status">
                    <div class="">Received Income</div>
                    <div class="font-bold" style="padding: 0 5px "></div>
                </div>
                <div class="d-flex gap-6" id="Campaign_Status">
                    <div class="">Donor Participation</div>
                    <div class="font-bold" style="padding: 0 5px "></div>
                </div>
                <?php } ?><br><br>
                <?php if($disable == 1) {?>
                    <div style="text-align: center;display: flex;flex-direction: row;gap: 20px;margin-left: 30vh;">
                        <a href="/organization/campaign/updateCampaign?id=<?php echo $_GET['id']?>"><button class="btn btn-success w-100">Update Campaign</button></a>
                        <a href="" id="delete"><button class="btn btn-danger w-100" onclick="del()">Delete Campaign</button></a>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php if(!$disable == 1) {?>
       <?php if(!$expired == 1) { ?>
        <div class="d-flex cards mt-2">
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
           <?php } ?>

    <?php } ?>
</div>
<script>
    const del = (event)=>{
     event.preventDefault();
    OpenDialogBox({
    // id:'sendEmail',
    title:'Delete Confirmation',
    content :`Are You Sure You Want to Delete Details? This Action Cannot be Undone.`,
    successBtnText:'Yes',
    successBtnAction : ()=>{
        window.location.href = "/organization/campaign/deleteCampaign?id=<?php echo $_GET['id']?>"
    },

    });
    }
    document.getElementById('delete').addEventListener('click', del);
</script>
