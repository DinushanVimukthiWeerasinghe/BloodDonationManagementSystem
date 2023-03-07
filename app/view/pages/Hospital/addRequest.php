<script src="/public/scripts/customAlert.js"></script>
<link href="/public/styles/alert.css" rel="stylesheet">
<link href="/public/css/components/form/index2.css" rel="stylesheet">

<?php
/* @var $data array*/
/* @var $value BloodRequest*/

use App\model\Requests\BloodRequest;
use App\model\Utils\Date;
use App\view\components\ResponsiveComponent\Alert\FlashMessage;
use App\view\components\ResponsiveComponent\ButtonComponent\DashBoardButton;
use App\view\components\ResponsiveComponent\CardGroup\CardGroup;
use App\view\components\ResponsiveComponent\CardPane\CardPane;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;
use App\view\components\WebComponent\Card\NavigationCard;

$navbar= new AuthNavbar('Manage Requests','/manager','/public/images/icons/user.png',true,false);
echo $navbar;
$background=new BackGroundImage();
echo $background;
?>
<div class="outer-form">
    <form id="form" action="/hospital/bloodRequest" method="post" enctype="multipart/form-data">
        <div id="col-1" class="form-column">
            <div class="form-title">Add Blood Donation Request</div>
            <div class="form-row">
                <div class="form-entity">
                    <div class="valid">
                        <label for='BloodType' class="form-label">Blood Type</label>
                        <select id="BloodType" class="form-select" name="Blood Type">
                            <option value="" selected disabled hidden>Select Blood Type</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-entity">
                    <div class="valid">
                        <label for='remark' class="form-label">Remark</label>
                        <input id="remark" class="form-input" name="Remark" placeholder="Remark">
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-entity">
                    <input type="submit" class="btn">
                </div>
            </div>
        </div>
    </form>
</div>

<style>
    .class-pane{
        margin-top: 10%;
    }
    .form-column{
        width: 50%;
        margin: 0 auto;
        padding: 1rem
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
    const SubmitForm=()=>{
        if (ValidateForm(2))
        {
            document.getElementById('form').submit();
        }
    }
</script><?php
