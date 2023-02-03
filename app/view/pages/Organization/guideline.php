<script src="/public/scripts/customAlert.js"></script>
<link href="/public/styles/alert.css" rel="stylesheet">
<?php
///* @var string $firstName */
///* @var string $lastName */
//
///* @var MedicalOfficer $model */

use App\model\users\MedicalOfficer;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;


$background = new BackGroundImage();
$navbar = new AuthNavbar('OUR GUIDELINES', '#', '/public/images/icons/user.png');
//echo AuthNavbar::getNavbarCSS();
echo $navbar;
echo $background;
?>
