<?php
/* @var $data array*/
/* @var $value BloodRequest*/

use App\model\Requests\BloodRequest;
use App\model\users\Hospital;
use App\view\components\ResponsiveComponent\Alert\FlashMessage;
use App\view\components\ResponsiveComponent\CardGroup\CardGroup;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;
use App\view\components\WebComponent\Card\NavigationCard;

$navbar = new AuthNavbar('Blood donation request', '/hospital', '/public/images/icons/user.png', true,false );
echo $navbar;
$background=new BackGroundImage();
echo $background;
?>

<?php
$addRequestCard = new NavigationCard('/hospital/bloodRequest/addRequest', '/public/images/icons/manager/dashboard/requests.png', 'Add Request');
$historyCard = new NavigationCard('/hospital/bloodRequest/history', '/public/images/icons/manager/dashboard/requests.png', 'Show Requests');
FlashMessage::RenderFlashMessages();
echo cardGroup::CardPanel();
echo $addRequestCard;
echo $historyCard;
echo CardGroup::CloseCardPanel();