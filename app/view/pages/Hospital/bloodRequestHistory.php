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

$navbar = new AuthNavbar('Blood donation Request', '/hospital', '/public/images/icons/user.png', true,false );
echo $navbar;
$background=new BackGroundImage();
echo $background;
?>



<div class="card-pane" id="card-pane">
    <div class="card">
        Blood Type :O+<br>
        Type :Normla<br>
        Added By :Hospital 1<br>
        Added Date :2023-01-31<br>
        Status :Pending<br>
    </div>
    <div class="card">
        Blood Type :B-<br>
        Type :Normal<br>
        Added By :Hospital 1<br>
        Added Date :2023-01-14<br>
        Status :Pending<br>
    </div>
    <div class="card">
        Blood Type :A-<br>
        Type :Normal<br>
        Added By :Hospital 1<br>
        Added Date :2022-10-01<br>
        Status :Finished<br>
    </div>
    <div class="card">
        Blood Type :AB+<br>
        Type :Normal<br>
        Added By :Hospital 1<br>
        Added Date :2021-12-01<br>
        Status :Finished<br>
    </div>
    <div class="card">
        Blood Type :A+<br>
        Type :Normal<br>
        Added By :Hospital 1<br>
        Added Date :2021-05-01<br>
        Status :Finished<br>
    </div>
    <div class="card">
        Blood Type :A+<br>
        Type :Normal<br>
        Added By :Hospital 1<br>
        Added Date :2021-05-01<br>
        Status :Finished<br>
    </div>
    <div class="card">
        Blood Type :A+<br>
        Type :Normal<br>
        Added By :Hospital 1<br>
        Added Date :2021-05-01<br>
        Status :Finished<br>
    </div>
    <div class="card">
        Blood Type :A+<br>
        Type :Normal<br>
        Added By :Hospital 1<br>
        Added Date :2021-05-01<br>
        Status :Finished<br>
    </div>
    <div class="card">
        Blood Type :A+<br>
        Type :Normal<br>
        Added By :Hospital 1<br>
        Added Date :2021-05-01<br>
        Status :Finished<br>
    </div>
    <div class="card">
        Blood Type :A+<br>
        Type :Normal<br>
        Added By :Hospital 1<br>
        Added Date :2021-05-01<br>
        Status :Finished<br>
    </div>
</div>