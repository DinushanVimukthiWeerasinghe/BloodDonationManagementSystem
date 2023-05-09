<link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" >
<?php

use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;

$navbar = new AuthNavbar('Take Donation', '/hospital', '/public/images/icons/user.png', true,false );
echo $navbar;
use App\view\components\WebComponent\Card\Card;

echo card::ImportJS();

use App\view\components\WebComponent\Card\NavigationCard;

$background = new BackGroundImage();


echo $background;

