<link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<?php
/* @var string $Hospital_Name */

use App\model\users\Hospital;
use App\view\components\ResponsiveComponent\Alert\FlashMessage;
use App\view\components\ResponsiveComponent\CardGroup\CardGroup;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;

$navbar = new AuthNavbar('Hospital Board', '/hospital', '/public/images/icons/user.png', true,false );
echo $navbar;

use App\view\components\WebComponent\Card\Card;

echo card::ImportJS();

/* @var Hospital $user */

use App\view\components\WebComponent\Card\NavigationCard;

$EmergencyRequestCard = new NavigationCard('/hospital/emergencyRequest', '/public/images/icons/manager/dashboard/requests.png', 'Emergency Blood Request');
$donorCard = new NavigationCard('/hospital/donors', '/public/images/icons/manager/dashboard/donor.png', 'Manage Donors');
$RequestCard = new NavigationCard('/hospital/bloodRequest', '/public/images/icons/manager/dashboard/requests.png','Blood Request');
$background = new BackGroundImage();

echo $background;
FlashMessage::RenderFlashMessages();
echo cardGroup::CardPanel();
echo $EmergencyRequestCard;
echo $donorCard;
echo $RequestCard;
echo CardGroup::CloseCardPanel();