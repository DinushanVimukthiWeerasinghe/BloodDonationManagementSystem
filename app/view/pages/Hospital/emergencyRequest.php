<?php
/* @var $data array*/
/* @var $value BloodRequest*/

use App\model\Requests\BloodRequest;
use App\model\Utils\Date;
use App\view\components\ResponsiveComponent\Alert\FlashMessage;
use App\view\components\ResponsiveComponent\ButtonComponent\DashBoardButton;
use App\view\components\ResponsiveComponent\CardGroup\CardGroup;
use App\view\components\ResponsiveComponent\CardPane\CardPane;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;
use App\view\components\WebComponent\Card\NavigationCard;

$navbar= new AuthNavbar('Manage Requests','/manager','/public/images/icons/user.png',true,false);
echo $navbar;
$background=new BackGroundImage();
echo $background;




$addRequestCard = new NavigationCard('/hospital/emergencyRequest/addRequest', '/public/images/icons/manager/dashboard/requests.png', 'Add Emergency Request');
$historyCard = new NavigationCard('/hospital/emergencyRequest/history', '/public/images/icons/manager/dashboard/requests.png', 'Show Requests');
FlashMessage::RenderFlashMessages();
echo cardGroup::CardPanel();
echo $addRequestCard;
echo $historyCard;
echo CardGroup::CloseCardPanel();
?>