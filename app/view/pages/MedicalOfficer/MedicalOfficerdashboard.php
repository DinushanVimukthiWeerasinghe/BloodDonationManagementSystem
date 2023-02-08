<?php
/* @var string $firstName */

/* @var string $lastName */

use App\view\components\ResponsiveComponent\Alert\FlashMessage;
use App\view\components\ResponsiveComponent\CardGroup\CardGroup;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;

$navbar = new AuthNavbar('Medical Officer Board', '/manager', '/public/images/icons/user.png', true,false );
echo $navbar;

use App\view\components\WebComponent\Card\Card;

echo Card::ImportJS();
//echo Card::ImportCSS();

/* @var Manager $user */

use App\model\users\Manager;

use App\view\components\WebComponent\Card\NavigationCard;

$ManageRequestCard = new NavigationCard('/medicalofficer/viewhistory', '/public/images/icons/manager/dashboard/requests.png', 'View History');
$ManageDonorsCard = new NavigationCard('/medicalofficer/assignedCampaign', '/public/images/icons/manager/dashboard/donor.png', 'Assign Campaigns');
$background = new BackGroundImage();

echo $background;
FlashMessage::RenderFlashMessages();
echo CardGroup::CardPanel();
echo $ManageRequestCard;
echo $ManageDonorsCard;
echo CardGroup::CloseCardPanel();

?>



