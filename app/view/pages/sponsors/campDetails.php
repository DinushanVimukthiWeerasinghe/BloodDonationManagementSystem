<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" /> <?php
/* @var string $Campaign_Name */
/* @var string $Campaign_Date */
/* @var string $Venue */
/* @var string $id */

use App\view\components\ResponsiveComponent\Alert\FlashMessage;
use App\view\components\ResponsiveComponent\CardGroup\CardGroup;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;

$navbar = new AuthNavbar('Campaign Details', '/organization', '/public/images/icons/user.png', true,false );
echo $navbar;

use App\view\components\WebComponent\Card\Card;

echo Card::ImportJS();
//echo Card::ImportCSS();

/* @var Organization $user */

use App\model\users\Organization;
use App\view\components\WebComponent\Card\NavigationCard;
//$background = new BackGroundImage();
//echo $background;
FlashMessage::RenderFlashMessages();
?>
<style>
    body{
        background-image: url("/public/images/homebg.png");
        background-position: center;
    }
    input{
        color: red;
        font-weight: 900;
    }
    .container{
        margin-top: 140px ;
    }
    .cards{
        margin-top: 10px;
        display: flex;
        flex-direction: row;
    }
    h3{
        line-height: 25px;
    }
    .cards{
        align-items: center;
    }
    .form-entity{
        font-size: 2em;
    }
    @media only screen and (max-width: 320px) {
        .form-entity{
            font-size: 1em;
        }
    }
    @media only screen and (max-width: 500px) {
        .container{
            margin-top: 120px;
        }
    }
    @media only screen and (max-width: 1325px) {
        .cards{
            align-items: center;
            display: flex;
            flex-direction: column;
        }
    }

    @media only screen and (max-width: 1312px) {
        .container{
            margin-top: 900px;
        }
        body{
            overflow-y: scroll;
        }

    }
</style>
<link rel="stylesheet" href="/public/css/components/form/index2.css">
<link rel="stylesheet" href="/public/css/framework/util/border/border-radius.css">
<link rel="stylesheet" href="/public/css/fontawesome/fa.css">
<div style="background-size: cover; background-color: rgba(0,0,0,0.3);border-radius: 30px;min-width: fit-content" class="container p-3">
        <div class="form-entity">
            <label class="form-label fa-brands text-light" style="">Name</label><br><br>
            <input type="text" value="<?php echo $Campaign_Name?>" style="border-radius: 50px;height: 50px;background-color: rgba(255, 255, 255, 0.3);" disabled>
        </div>
        <div class="form-entity mt-1">
            <label class="form-label fa-brands text-light">Date</label><br><br>
            <input type="text" value="<?php echo $Campaign_Date ?>" style="border-radius: 50px;height: 50px;background-color: rgba(255, 255, 255, 0.3);" disabled>
        </div>
        <div class="form-entity mt-1">
            <label class="form-label fa-brands text-light" >Location</label><br><br>
            <input type="text" value="<?php echo $Venue ?>" style="border-radius: 50px;height: 50px;background-color: rgba(255, 255, 255, 0.3);" disabled>
        </div>
        <div class="cards">
            <div class="card nav-card bg-white text-dark" onclick="Redirect('request?id=<?php echo $id ?>')">
                <div class="card-header">
                    <div class="card-header-img">
                        <img src="/public/images/icons/organization/campaignDetails/request.png" alt="Request" width="100px">
                    </div>
                    <div class="card-title">
                        <h3>Request Sponsorship</h3>
                    </div>
                </div>
            </div>
            <div class="card nav-card bg-white text-dark" onclick="Redirect('received?id=<?php echo $id ?>')">
                <div class="card-header">
                    <div class="card-header-img">
                        <img src="/public/images/icons/organization/campaignDetails/received.png" alt="Received" width="100px">
                    </div>
                    <div class="card-title">
                        <h3>Received Sponsorships</h3>
                    </div>
                </div>
            </div>
            <div class="card nav-card bg-white text-dark" onclick="Redirect('accepted?id=<?php echo $id ?>')">
                <div class="card-header">
                    <div class="card-header-img">
                        <img src="/public/images/icons/organization/campaignDetails/accepted.png" alt="Accepted" width="100px">
                    </div>
                    <div class="card-title">
                        <h3>Accepted Donors</h3>
                    </div>
                </div>
            </div>
            <div class="card nav-card bg-white text-dark" onclick="Redirect('inform?id=<?php echo $id ?>')">
                <div class="card-header">
                    <div class="card-header-img">
                        <img src="/public/images/icons/organization/campaignDetails/inform.png" alt="Inform" width="100px">
                    </div>
                    <div class="card-title">
                        <h3>Inform Donors</h3>
                    </div>
                </div>
            </div>
        </div>
</div>
