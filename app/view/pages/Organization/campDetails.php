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
<div class="d-flex flex-column w-90  mt-3 p-5 scroll">
    <div class="d-flex text-xl w-100 align-items-center justify-content-center bg-dark px-2 py-0-5 text-white font-bold" style="font-size: 1.8rem"><?=$campaign->getCampaignName(); ?></div>
        <div class="d-flex bg-white-0-3 p-2 gap-2 details w-100 justify-content-between">
            <div class="text-xl d-flex flex-column justify-content-center align-items-center w-100 bg-white border-radius-10 gap-1 p-3" id="Campaign_Detail">
                <div class="d-flex justify-content-between w-100" id="Campaign_Name">
                    <div class="w-40">Campaign Name </div>
                    <div class="font-bold w-60 d-flex align-items-center justify-content-start text-right"><?=$campaign->getCampaignName(); ?></div>
                </div>
                <div class="d-flex w-100 justify-content-between" id="Campaign_Venue">
                    <div class="w-40">Venue </div>
                    <div class="font-bold w-60 d-flex align-items-center justify-content-start text-right"><?=$campaign->getVenue(); ?></div>
                </div>
                <div class="d-flex w-100 justify-content-between" id="Campaign_Date">
                    <div class="w-40">Date </div>
                    <div class="font-bold w-60 d-flex align-items-center justify-content-start text-right"><?=$campaign->getCampaignDate(); ?></div>
                </div>
                <div class="d-flex w-100 justify-content-between" id="Campaign_Status">
                    <div class="w-40">Status </div>
                    <div class="font-bold w-60 d-flex align-items-center justify-content-start text-right">
                    <?php
                    $CampaignStatus =$campaign->getCampaignStatus();
                    if($CampaignStatus === "Pending"): ?>
                        <div class="font-bold bg-yellow-10 py-0-5 px-1 border-radius-10 text-white " >Pending Approval</div>
                    <?php elseif($CampaignStatus === 'Approved'): ?>
                        <div class="font-bold bg-green-6 py-0-5 px-1 border-radius-10 text-white">Campaign Approved</div>
                    <?php elseif($CampaignStatus === 'Rejected'): ?>
                        <div class="font-bold bg-red-6 py-0-5 px-1 border-radius-10 text-white">Campaign Rejected</div>
                    <?php endif;
                    ?>
                    </div>
                </div>
                <div class="d-flex flex-column w-100 justify-content-between gap-1" id="Campaign_Date">
                    <div class="">Description </div>
                    <div class="font-bold px-1 ">
                        <?=$campaign->getCampaignDescription(); ?>
                        <?=$campaign->getCampaignDescription(); ?>
                        <?=$campaign->getCampaignDescription(); ?>
                        <?=$campaign->getCampaignDescription(); ?>
                        <?=$campaign->getCampaignDescription(); ?>
                            <?=$campaign->getCampaignDescription(); ?>
                    </div>
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
                <?php } ?>
                <?php if($disable == 1) {?>
                    <div style="text-align: center;display: flex;flex-direction: row;gap: 20px;margin-left: 30vh;">
                        <a href="/organization/campaign/updateCampaign?id=<?php echo $_GET['id']?>"><button class="btn btn-success w-100">Update Campaign</button></a>
                        <a href="" id="delete"><button class="btn btn-danger w-100" onclick="del()">Delete Campaign</button></a>
                    </div>
                <?php } ?>
            </div>
            <div id="Map" class="bg-red-1" style="width: 500px;height: 400px;"></div>
        </div>
    <?php if($campaign->getVerified()===Campaign::VERIFIED) { ?>
        <div class="d-flex cards justify-content-center bg-white-0-5 py-1 border-radius-10 mt-1">
            <div class="card nav-card bg-white text-dark" onclick="RequestSponsorship()">
        <div class="d-flex cards mt-2">
            <div class="card nav-card bg-white text-dark" onclick="Redirect('request?id=<?=$id ?>')">
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
    <?php }
    else{?>
        <div class="d-flex justify-content-center cards mt-2">
            <div class="card nav-card bg-white card-disabled text-dark">
                <div class="disable-text bg-white-0-7 py-2 px-1 font-bold absolute" >
                    Sponsorship Request is not available until the campaign is approved
                </div>
                <div class="card-header">
                    <div class="card-header-img">
                        <img src="/public/images/icons/organization/campaignDetails/request.png" alt="Request" width="100px">
                    </div>
                    <div class="card-title">
                        <h3>Request Sponsorship</h3>
                    </div>
                </div>
            </div>
            <div class="card nav-card bg-white card-disabled text-dark">
            <div class="disable-text bg-white-0-7 py-2 px-1 font-bold absolute" >
                Inform Donors is not available until the campaign is approved
            </div>
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
</div>
<script>
    const RequestSponsorship = ()=>{
        OpenDialogBox({
            id:'RequestSponsorship',
            title:'Request Sponsorship',
            titleClass:'text-center bg-dark text-white px-2 py-1',
            content :`<div class="d-flex flex-column gap-1">
                        <div class="d-flex flex-column gap-0-5">
                            <label for="SponsorshipAmount" class="form-label">Expected Amount</label>
                            <input type="number" class="form-control" id="SponsorshipAmount" placeholder="Sponsorship Amount">
                        </div>
                        <div class="d-flex flex-column gap-1">
                            <label for="SponsorshipDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="SponsorshipDescription" placeholder="Description" style="height: 150px"></textarea>
                        </div>
                    </div>
            `,
            successBtnText:'Request',
            successBtnAction:()=>{
                console.log('Requesting Sponsorship');
            }
        })
    }
    function initMap(){
        const Campaign = {lat: <?php echo $campaign->getLatitude()?>, lng: <?php echo $campaign->getLongitude()?>};
        const map = new google.maps.Map(document.getElementById("Map"), {
            zoom: 13,
            center: Campaign,
        });
        const marker = new google.maps.Marker({
            position: Campaign,
            map: map,
        });
        marker.addListener("click", () => {
            map.setZoom(16);
            map.setCenter(marker.getPosition());
        });
    }
    window.addEventListener('load', initMap);

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
