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
$navbar = new AuthNavbar('Request Sponsorship', '#', '/public/images/icons/user.png');
//echo AuthNavbar::getNavbarCSS();
echo $navbar;
echo $background;
?>
<link rel="stylesheet" href="/public/css/components/form/index2.css">
<link rel="stylesheet" href="/public/css/framework/util/border/border-radius.css">
<style>
    .first{
        display: flex;
        flex-direction: row;
        gap: 2rem;
    }
    @media only screen and (max-width: 582px) {
        .first{
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }
    }
</style>
<div class="container p-5 mt-5">
    <form action="request" method="post" class="form-column p-3">
        <h1 class="form-title mt-0">Request Sponsorship</h1>
        <div class="first">
            <div class="form-entity mt-1">
                <label class="form-label">Expected Amount</label><br><br>
                <input type="text" class="form-input" style="border-radius: 10px;">
            </div>
            <div class="form-entity mt-1">
                <label class="form-label">Bank Name</label><br><br>
                <input type="text" class="form-input" style="border-radius: 10px;">
            </div>
        </div>
        <div class="form-entity mt-1">
            <label class="form-label">Account Name</label><br><br>
            <input type="text" class="form-input" style="border-radius: 10px;">
        </div>
        <div class="form-entity mt-1">
            <label class="form-label">Branch Name</label><br><br>
            <input type="text" class="form-input" style="border-radius: 10px;">
        </div>
        <br><br>
        <div class="form-row">
            <input type="reset" class="btn btn-dark mr-2">
            <input type="submit" class="btn btn-success" value="Request">
        </div>
    </form>
</div>

