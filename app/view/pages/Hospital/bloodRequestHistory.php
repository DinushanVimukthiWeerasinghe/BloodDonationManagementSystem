<link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<?php
/* @var string $data */

use App\model\Requests\BloodRequest;
use App\model\users\Hospital;
use App\view\components\ResponsiveComponent\Alert\FlashMessage;
use App\view\components\ResponsiveComponent\CardGroup\CardGroup;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;


$navbar = new AuthNavbar('Take Donation', '/hospital', '/public/images/icons/user.png', true,false );
echo $navbar;
use App\view\components\WebComponent\Card\Card;

echo card::ImportJS();


FlashMessage::RenderFlashMessages();
$navbar = new AuthNavbar('Hospital Board', '/hospital', '/public/images/icons/user.png', true,false );
echo $navbar;

echo card::ImportJS();

/* @var Hospital $user */

use App\view\components\WebComponent\Card\NavigationCard;

$background = new BackGroundImage();

echo $background;

$table = new \App\view\components\Table\DetailTable(['Request ID', 'Blood Group', 'Requested At', 'Type', 'Status','Quantity (In Pints)','Remarks'], $data);
echo $table->render("table");
/** @var int $total_pages */
/** @var int $current_page */
if ($data != null){

    echo BloodRequest::NavigationFooter($total_pages,$current_page);

}

?>