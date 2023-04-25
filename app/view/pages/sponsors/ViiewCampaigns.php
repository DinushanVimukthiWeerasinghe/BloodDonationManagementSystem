<!--<link rel="stylesheet" href="/public/css/framework/utils.css">-->
<!--<link rel="stylesheet" href="/public/css/components/cardPane/index.css">-->
<!--<script src="/public/scripts/index.js"></script>-->
<?php
/* @var string $firstName */
/* @var array $SponsorshipRequests */
/* @var SponsorshipRequest $SponsorshipRequest */

/* @var string $lastName */
/* @var string $campaigns */

use App\model\Requests\SponsorshipRequest;
use App\model\users\Organization;
use App\model\Utils\Date;
use App\view\components\ResponsiveComponent\Alert\FlashMessage;
use App\view\components\ResponsiveComponent\CardPane\CardPane;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;

//echo Loader::GetLoader();
$background = new BackGroundImage();
$navbar = new AuthNavbar('Donation Campaigns', '/organization/near', '/public/images/icons/user.png', false);

echo $navbar;
echo $background;


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
            if (empty($SponsorshipRequests)){
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
            <?php foreach ($SponsorshipRequests as $SponsorshipRequest){
                $SuggestedPackage=SponsorshipRequest::getSuggestedPackage($SponsorshipRequest->getSponsorshipAmount())
                ?>
            <div class="card ">
                <div class="card-body d-flex flex-column gap-0-5 flex-center">
<!--                    <div class="card-image" style="text-align: center;margin-left: 100px;width: 100px;height: 100px;margin-top: -50px;"><img src="/public/images/donation.png" alt="hello"></div>-->
                    <div class="font-bold text-xl"> <?php  echo $SponsorshipRequest->getCampaignName(); ?></div>
                    <div class="card-description"><?= Date::GetProperDate($SponsorshipRequest->getCampaignDate()); ?></div>
                    <div class="card-description bg-yellow-7 border-radius-10 p-1" style="font-size: 1.2em;font-weight: bolder;">LKR. <?= $SuggestedPackage?->getPackagePriceFormatted(); ?></div>
                    <div class="d-flex gap-0-5">
                        <form action="/sponsor/makePayment" method="post">
                            <input type="hidden" name="Request" value="<?=$SponsorshipRequest->getSponsorshipID(); ?>">
                            <input type="hidden" name="Package" value="<?= $SuggestedPackage?->getPackagePriceID(); ?>">
                            <button class="btn btn-success w-100 mt-1" type="submit">Sponsor</button>
                        </form>
                        <button class="btn btn-outline-info w-100 mt-1">View Campaign</button>
                    </div>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
    <?php
    echo CardPane::GetJS('/organization/received/search');
    ?>









