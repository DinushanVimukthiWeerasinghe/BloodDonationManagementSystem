<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" /> <?php
/* @var string $firstName */

/* @var string $lastName */

use App\view\components\ResponsiveComponent\Alert\FlashMessage;
use App\view\components\ResponsiveComponent\CardGroup\CardGroup;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;


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

?>

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



