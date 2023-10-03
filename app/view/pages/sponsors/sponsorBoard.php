<style>
    .changepanel{
        width: 100vw;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" /> <?php
/* @var string $sponsor_Name */


use App\view\components\ResponsiveComponent\Alert\FlashMessage;
use App\view\components\ResponsiveComponent\CardGroup\CardGroup;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;

$navbar = new AuthNavbar(strtoupper($sponsor_Name).' '.'SPONSOR BOARD', '/sponsors', 'bell.png', false,false );
echo $navbar;

use App\view\components\WebComponent\Card\Card;

echo Card::ImportJS();
//echo Card::ImportCSS();

/* @var organization $user */

use App\model\users\organization;

use App\view\components\WebComponent\Card\NavigationCard;

$CampaignGuidelines = new NavigationCard('/sponsor/guideline', '/public/images/icons/manager/dashboard/requests.png', 'Sponsor Guidelines','guideline');
$ManageCampaigns = new NavigationCard('/sponsor/sponsor', '/public/images/icons/organization/dashboard/campaign.png', 'Sponsor for Campaigns','sponse');
$History = new NavigationCard('/sponsor/history', '/public/images/icons/organization/dashboard/history.png', 'Sponsorships History','history');
$background = new BackGroundImage();

echo $background;
FlashMessage::RenderFlashMessages();
echo CardGroup::CardPanel();
echo $CampaignGuidelines;
echo $ManageCampaigns;
echo $History;
echo CardGroup::CloseCardPanel();

?>