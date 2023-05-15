<style>
    .changepanel{
        width: 100vw;
    }
</style>
<?php
/* @var string $organization_Name */


use App\model\Utils\Security;
use App\view\components\ResponsiveComponent\Alert\FlashMessage;
use App\view\components\ResponsiveComponent\CardGroup\CardGroup;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;
use App\model\users\Organization;
use App\view\components\WebComponent\Card\NavigationCard;

$navbar = new AuthNavbar('Dashboard', '/organization/profile', '/public/images/icons/user/organization.png', true,false );
echo $navbar;


/* @var Organization $user */
$Campaign_encID = urlencode(Security::Encrypt($identity));


$CampaignGuidelines = new NavigationCard('/organization/guideline', '/public/images/icons/manager/dashboard/requests.png', 'Campaign Guidelines','guideline');
$CreateCampaigns = new NavigationCard('/organization/create', '/public/images/icons/organization/manage/create.png', 'Create Campaign','create');
$ViewCampaign = new NavigationCard("/organization/campDetails?id=".$Campaign_encID, '/public/images/icons/organization/manage/donation.png', 'View Ongoing Campaigns','ongoing');
$History = new NavigationCard('/organization/history', '/public/images/icons/organization/dashboard/history.png', 'Campaign History','history');
$NearByCampaigns = new NavigationCard('/organization/near', '/public/images/icons/organization/manage/nearby.png', 'Nearby Campaigns','near');
$background = new BackGroundImage();

echo $background;
FlashMessage::RenderFlashMessages();
echo CardGroup::CardPane    l();
echo $CampaignGuidelines;
echo $NearByCampaigns;
if (!$campaign_exist){
    echo $CreateCampaigns;
}else{
    echo $ViewCampaign;
}
echo $History;
echo CardGroup::CloseCardPanel();

?>




