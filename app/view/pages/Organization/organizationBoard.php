<?php
/* @var string $organization_Name */


use App\view\components\ResponsiveComponent\Alert\FlashMessage;
use App\view\components\ResponsiveComponent\CardGroup\CardGroup;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;

$navbar = new AuthNavbar('Dashboard', '/organization/profile', '/public/images/icons/user/organization.png', true,false );
echo $navbar;


/* @var Organization $user */

use App\model\users\Organization;

use App\view\components\WebComponent\Card\NavigationCard;

$CampaignGuidelines = new NavigationCard('/organization/guideline', '/public/images/icons/manager/dashboard/requests.png', 'Campaign Guidelines','guideline');
$ManageCampaigns = new NavigationCard('/organization/manage', '/public/images/icons/organization/dashboard/campaign.png', 'Manage Campaigns','campaign');
$History = new NavigationCard('/organization/history', '/public/images/icons/organization/dashboard/history.png', 'Campaign History','history');
$background = new BackGroundImage();

echo $background;
FlashMessage::RenderFlashMessages();
echo CardGroup::CardPanel();
echo $CampaignGuidelines;
echo $ManageCampaigns;
echo $History;
echo CardGroup::CloseCardPanel();

?>




