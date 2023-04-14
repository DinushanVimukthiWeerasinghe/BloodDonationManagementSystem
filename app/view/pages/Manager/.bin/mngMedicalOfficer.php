<?php

/* @var string $firstName*/
/* @var string $lastName*/
use App\model\users\MedicalOfficer;
use App\view\components\Loader\Loader;
use App\view\components\ResponsiveComponent\Alert\FlashMessage;
use App\view\components\ResponsiveComponent\CardPane\CardPane;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;
//echo Loader::GetLoader();
$background=new BackGroundImage();
$navbar= new AuthNavbar('Manage Medical Officers','/manager/profile','/public/images/icons/user.png',false);


echo $navbar;
echo $background;
//echo new primaryTitle('Manage Medical Officers');
/* @var array $data*/
/* @var MedicalOfficer $value*/


function GetImage($imageURL){
    if($imageURL==null){
        return '/public/images/icons/user1.png';
    }
    else{
        return $imageURL;
    }
}
FlashMessage::RenderFlashMessages();
?>


<div class="add-card tooltip" onclick="Redirect('/manager/mngMedicalOfficer/add')">
    <div class="card-image" >
        <img src="/public/images/icons/manager/manageMedicalOfficer/doctor.png" alt="">
    </div>
    <span class="tooltipText">Add Medical Officer</span>
</div>
<div class="add-card-mb">
    <div class="card-image" >
        <img src="/public/images/icons/add-mo.png" alt="">
    </div>
</div>
<div id="detail-pane" class="detail-pane">

    <?php
    /** @var int $total_pages */
    /** @var int $current_page */
        echo CardPane::FilterPane($total_pages,$current_page);
        echo CardPane::CreateCardPane();
        echo CardPane::CreateCards($data,MedicalOfficer::class,"getID",['getFullName','getPosition','getNIC','getBranchLocation'],'getProfileImage');
        echo CardPane::CloseCardPane();
        echo CardPane::GetJS('/manager/mngMedicalOfficer/search');
    ?>
</div>

<script src="/public/scripts/manager/demo.js"></script>





