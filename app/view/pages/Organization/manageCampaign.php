<style>
    @media only screen and(max-width: 281px) {
        .changepanel{
            width: 50px;
        }
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" /> <?php
/* @var string $organization_Name */


use App\view\components\ResponsiveComponent\Alert\FlashMessage;
use App\view\components\ResponsiveComponent\CardGroup\CardGroup;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;

$navbar = new AuthNavbar('Manage Campaigns', '/organization/dashboard', '/public/images/icons/user.png', true,false );
echo $navbar;

use App\view\components\WebComponent\Card\Card;

echo Card::ImportJS();
//echo Card::ImportCSS();

/* @var Organization $user */

use App\model\users\Organization;

use App\view\components\WebComponent\Card\NavigationCard;


$NearByCampaigns = new NavigationCard('/organization/near', '/public/images/icons/organization/manage/nearby.png', 'Nearby Campaigns','near');
$CreateCampaigns = new NavigationCard('/organization/create', '/public/images/icons/organization/manage/create.png', 'Create Campaign','create');
$ViewCampaign = new NavigationCard('/organization/campDetails?id='.$identity, '/public/images/icons/organization/manage/donation.png', 'View Ongoing Campaigns','ongoing');
//$ViewApprovedCampaign = new NavigationCard('/organization/campaign/view', '/public/images/icons/organization/manage/create.png', 'View Campaign');
//$History = new NavigationCard('/organization/report', '/public/images/icons/Organization/dashboard/history.png', 'Donor Attendance');
$background = new BackGroundImage();

echo $background;
FlashMessage::RenderFlashMessages();
echo CardGroup::CardPanel();
echo $NearByCampaigns;
if (!$campaign_exist){
    echo $CreateCampaigns;
}else{
    echo $ViewCampaign;
}

//echo $History;
echo CardGroup::CloseCardPanel();

?>