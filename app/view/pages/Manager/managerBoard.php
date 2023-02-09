<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" /> <?php
/* @var string $firstName */

/* @var string $lastName */

use App\view\components\ResponsiveComponent\Alert\FlashMessage;
use App\view\components\ResponsiveComponent\CardGroup\CardGroup;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;

$navbar = new AuthNavbar('Manager Board', '/manager', '/public/images/icons/user.png', true,false );
echo $navbar;

use App\view\components\WebComponent\Card\Card;

echo Card::ImportJS();
//echo Card::ImportCSS();

/* @var Manager $user */

use App\model\users\Manager;

use App\view\components\WebComponent\Card\NavigationCard;

$ManageRequestCard = new NavigationCard('/manager/mngRequests', '/public/images/icons/manager/dashboard/requests.png', 'Manage Request');
$ManageDonorsCard = new NavigationCard('/manager/mngDonors', '/public/images/icons/manager/dashboard/donor.png', 'Manage Donors');
$ManageSponsorshipCard = new NavigationCard('/manager/mngSponsorship', '/public/images/icons/manager/dashboard/sponsors.png', 'Manage Sponsors');
$ManageMedicalOfficerCard = new NavigationCard('/manager/mngMedicalOfficer', '/public/images/icons/manager/dashboard/MedicalOfficer.png', 'Manage Medical Officer');
$ManageCampaignCard = new NavigationCard('/manager/mngCampaigns', '/public/images/icons/manager/dashboard/camp.png', 'Manage Campaigns');
$ManageReportCard = new NavigationCard('/manager/mngReport', '/public/images/icons/manager/dashboard/report.png', 'Manage Report');
$background = new BackGroundImage();

echo $background;
?>
<div class="h-90 bg-white-0-5 d-flex align-items-center justify-content-center min-h-92vh absolute w-12vw left-0 bottom-0" style="z-index: 999">
    <div class="d-flex w-100 m-1 flex-column justify-content-center align-items-center gap-1">
        <div class="d-flex p-1 border-radius-10 w-100 bg-primary text-white align-items-center justify-content-center text-xl font-bold">
            <img src="/public/icons/dashboard.png" class="mr-1" width="24px" alt="" style="filter: invert(100%)">
            Dashboard
        </div>
        <div class="d-flex p-1 w-100 bg-primary border-radius-10 text-white align-items-center justify-content-center text-xl font-bold">
            <img src="/public/icons/requests.png" class="mr-1" width="24px" alt="" style="filter: invert(100%)">
            Requests
        </div>
        <div class="d-flex p-1 w-100 bg-primary border-radius-10 text-white align-items-center justify-content-center text-xl font-bold">
            <img src="/public/icons/donor.png" class="mr-1" width="24px" alt="" style="filter: invert(100%)">
            Donors
        </div>
        <div class="d-flex p-1 w-100 bg-primary border-radius-10 text-white align-items-center justify-content-center text-xl font-bold">
            <img src="/public/icons/sponsors.png" class="mr-1" width="24px" alt="" style="filter: invert(100%)">
            Sponsors
        </div>
        <div class="d-flex p-1 w-100 bg-primary border-radius-10 text-white align-items-center justify-content-center text-xl font-bold">
            <img src="/public/icons/MedicalOfficer.png" class="mr-1" width="24px" alt="" style="filter: invert(100%)">
            Officers
        </div>
        <div class="d-flex p-1 w-100 bg-primary border-radius-10 text-white align-items-center justify-content-center text-xl font-bold">
            <img src="/public/icons/campaign.png" class="mr-1" width="24px" alt="" style="filter: invert(100%)">
            Campaigns
        </div>
        <div class="d-flex p-1 w-100 bg-primary border-radius-10 text-white align-items-center justify-content-center text-xl font-bold">
            <img src="/public/icons/dashboard.png" class="mr-1" width="24px" alt="" style="filter: invert(100%)">
            Reports
        </div>


    </div>
</div>
<?php
FlashMessage::RenderFlashMessages();
echo CardGroup::CardPanel();
echo $ManageRequestCard;
echo $ManageDonorsCard;
echo $ManageSponsorshipCard;
echo $ManageMedicalOfficerCard;
echo $ManageCampaignCard;
echo $ManageReportCard;
echo CardGroup::CloseCardPanel();

?>



