<?php
/* @var string $firstName*/
/* @var string $lastName*/
/** @var organization $user */

use App\model\users\Manager;
use App\model\users\organization;
use App\model\users\Person;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;

$background=new BackGroundImage();
$navbar= new AuthNavbar('Manage Profile','/organization/profile','/public/images/icons/user.png',false);
echo $background;
echo $navbar;
?>
<style>
    @font-face {
        font-family: 'Popins';
        /*src: url("/public/fonts/Poppins/Poppins-Regular.ttf");*/
    }
    body{
        font-family: 'Popins', serif;
    }
    .profile-container{
        display:flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
    }
    .profile-container .profile-image{
        width: 300px;
        height: 300px;
        border-radius: 50%;

    }
    .profile-container .profile-image img{
        width:inherit;
        height: inherit;
        border-radius: 50%;
        /*object-position: 50% 50%;*/
        object-fit: cover;
    }
    .profile-container .profile-details{
        min-width: 60vw;
        margin: 1rem;
        padding: 1rem;
        border-radius: 10%;
        background: rgba(255,255,255,0.3);
    }
    .profile-container .profile-details{
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .profile-container .profile-details .basic-details{
        display: flex;
        align-items: flex-start;
        justify-content: space-around;
    }

    .profile-details .profile-entity{
        width: 100%;
        display: flex;
        align-content: center;
        align-items: center;
        justify-content: center;
    }
    .profile-details .entity-title{
        width: 60%;
        text-align: center;
        font-size: 1.5rem;
        font-weight: bolder;

    }
    .profile-details .personal-details{
        display: flex;
        flex-direction: column;
        margin: 1rem;
    }
    .profile-details .entity-value{
        width: 100%;
        font-size: 1.2rem;
        padding: 1rem;
        background: rgba(0,0,0,0.3);
        color: white;
        border-radius: 20px;
        margin: 0.5rem;
    }
    .profile-details{
        font-size: 1.2rem;
    }
    a{
        text-decoration: none;
        color: white;
    }
    .btn{
        padding: 1rem;
        background: darkred;
        color: white;
        margin: 1rem;
        border-radius: 20px;
        outline: none;
        border:none;
        box-shadow: 0 0 10px rgba(255,255,255,0.5);
        font-size: 1.2rem;
    }

    .profile-details .profile-title{
        font-size: 2rem;
        font-weight: bolder;
        text-align: center;
        margin: 1rem;
    }
    .profile-details .profile-action{
        margin: 1rem;
        display: flex;
        gap: 1rem;
        justify-content: center;

    }
</style>
<div class="profile-container">
    <div class="profile-image">
        <?php $profileImage= $user->getProfileImage() ?>
        <img src="<?php echo $profileImage ?>" alt="Image" width="400px">
    </div>
    <div class="profile-details">
        <div class="basic-details">
            <div class="personal-details">
                <div class="profile-title">Personal Details</div>
                <div class="profile-entity profile-name"><div class="entity-title"> Name : </div>  <div class="entity-value"><?php echo $user->getFullName()?></div></div>
                <div class="profile-entity profile-position"><div class="entity-title"> Address : </div>  <div class="entity-value"><?php echo $user->getAddress()?></div></div>
                <div class="profile-entity profile-nic"><div class="entity-title"> Email : </div>  <div class="entity-value"><?php echo $user->getEmail()?></div></div>
                <div class="profile-entity profile-nic"><div class="entity-title"> Contact No : </div>  <div class="entity-value"><?php echo $user->getContactNo()?></div></div>
                <div class="profile-entity profile-nic"><div class="entity-title"> NIC : </div>  <div class="entity-value"><?php echo $user->getNIC()?></div></div>
            </div>
            <div class="branch-details">
                <div class="profile-title">Branch Details</div>
                <div class="profile branch-name"><div class="entity-title"> Assigned Branch : </div>  <div class="entity-value"><?php echo $user->GetBranch()->getLocation(). " Branch" ?></div></div>
                <div class="profile branch-tp"><div class="entity-title"> Branch Contact No : </div>  <div class="entity-value"><?php echo $user->GetBranch()->getTelephoneNo() ?></div></div>
            </div>
        </div>
        <div class="profile-action">
            <a href="/manager/profile/change-password" class="btn ">Change Password</a>
            <a href="/manager/profile/reset-password" class="btn ">Reset Password</a>
        </div>
    </div>
</div>
<!--TODO Change Password -->
<!--TODO Reset Password -->



