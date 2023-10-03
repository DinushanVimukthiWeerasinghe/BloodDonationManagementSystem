<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="/public/scripts/customAlert.js"></script>
<link href="/public/styles/alert.css" rel="stylesheet">
<?php
///* @var string $firstName */
///* @var string $lastName */
//
///* @var MedicalOfficer $model */

use App\model\users\MedicalOfficer;
use App\view\components\ResponsiveComponent\Alert\FlashMessage;
use App\model\Requests\additional_sponsorship_request;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;
/* @var additional_sponsorship_request $req */

$background = new BackGroundImage();
$navbar = new AuthNavbar('Request Sponsorship', '#', '/public/images/icons/user.png');
//echo AuthNavbar::getNavbarCSS();
echo $navbar;
echo $background;
FlashMessage::RenderFlashMessages();
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
    <form action="request?id=<?php echo $_GET['id'] ?>" method="post" class="form-column p-3">
        <h1 class="form-title mt-0">Request Sponsorship</h1>
        <div class="first">
            <div class="form-entity mt-1">
                <label class="form-label">Expected Amount</label><br>

                <label class="form-label" style="color: red;font-size: 12pt;"></label><br>
                <input type="text" class="form-input" style="border-radius: 10px;" placeholder="Amount in LKR" name="Amount" required>
            </div>
            <div class="form-entity mt-1">
                <label class="form-label">Bank Name</label><br><br>
                <input type="text" class="form-input" style="border-radius: 10px;" name="Bank_Name" required>
            </div>
        </div>
        <div class="first">
            <div class="form-entity mt-1">
                <label class="form-label">Account Name</label><br><br>
                <input type="text" class="form-input" style="border-radius: 10px;" name="Account_Name" required>
            </div>
            <div class="form-entity mt-1">
                <label class="form-label">Account Number</label><br>
                <label class="form-label" style="color: red;"><?php echo $req->getFirstError('Account_Number')  ?></label><br>
                <input type="text" class="form-input" style="border-radius: 10px;" name="Account_Number" required>
            </div>
        </div>
        <div class="form-entity mt-1">
            <label class="form-label">Branch Name</label><br><br>
            <input type="text" class="form-input" style="border-radius: 10px;" name="Branch_Name" required>
        </div>
        <br><br>
        <div class="form-row">
            <input type="reset" class="btn btn-dark mr-2">
            <input type="submit" class="btn btn-success" value="Request">
        </div>
    </form>
</div>

