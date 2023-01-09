<?php

use App\view\components\ResponsiveComponent\ButtonComponent\DashBoardButton;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;
use App\view\components\WebComponent\Card\NavigationCard;

$navbar= new AuthNavbar('Manage Donors','/manager','/public/images/icons/user.png','$firstName'.' '.'$lastName');
echo $navbar;
$background=new BackGroundImage();
echo $background;
?>
<div class="class-pane bg-black-0-3 p-1 border-radius-6 flex-wrap min-w-40 max-w-55 w-85 d-flex justify-content-center ">
    <div class="card nav-card" onclick="fun()">
        <div class="card-header">
                <img src="/public/images/icons/SearchUser.png" alt="">
            <div class="header-title">Search Donor</div>
        </div>
    </div>
    <div class="card nav-card">
        <div class="card-header nav">
                <img src="/public/images/icons/UnavailableUser.png" alt="">
            <div class="header-title">Deactivate Donors</div>
        </div>
    </div>
    <div class="card nav-card">
        <div class="card-header">
                <img src="/public/images/icons/QuestionedUser.png" alt="">
            <div class="header-title">Disable Donor</div>
        </div>
    </div>
    <div class="card nav-card">
        <div class="card-header">
                <img src="/public/images/icons/ReportUser.png" alt="">
            <div class="header-title">Reported Donor</div>
        </div>
    </div>
    <div class="card nav-card">
            <div class="card-header">
                    <img src="/public/images/icons/InformUser.png" alt="">
                <div class="header-title">Inform Donor</div>
            </div>
    </div>
    <div class="card nav-card">
            <div class="card-header">
                    <img src="/public/images/icons/VerifiedUser.png" alt="">
                <div class="header-title">Verify Donor</div>
            </div>
    </div>
</div>
<style>
    .class-pane{
        margin-top: 10%;
    }
    @media only screen and (max-width: 500px) {
        .class-pane{
            max-width: 100%;
            width: 98%;
            padding: 0.2rem;
        }

    }
</style>
<script>
    function fun(){
        OpenDialogBox({
            id:'find-donor',
            title:'Find Donor',
            content:"<label for='Search'>Enter NIC </label><input class='text-center border-radius-6' id='Search' type='text' name='Search'>",
            successBtnAction:()=>{
                // Todo : Check whether Donor exist on the particular NIC number
                const SearchText=document.getElementsByName('Search')[0].value;
                if (SearchText.trim()!==''){
                    window.location.href="/manager/manageDonors/find?nic="+SearchText
                    CloseDialogBox('find-donor');
                }
                else{
                    const searchBox=document.getElementById('Search');
                    searchBox.classList.add(' border-danger')
                    searchBox.focus();
                }
            }
        })
    }
</script>

