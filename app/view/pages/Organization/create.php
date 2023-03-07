<!--<script src="/public/scripts/customAlert.js"></script>-->
<!--<link href="/public/styles/alert.css" rel="stylesheet">-->
<?php
///* @var string $firstName */
///* @var string $lastName */
//
///* @var MedicalOfficer $model */

use App\model\users\MedicalOfficer;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;

$Date = date("Y-m-d");
$background = new BackGroundImage();
$navbar = new AuthNavbar('Create Campaign', '#', '/public/images/icons/navbar/bell.png');
//echo AuthNavbar::getNavbarCSS();
echo $navbar;
echo $background;
?>
<style>
    .direction{
        display: flex;
        flex-direction: row;
    }
</style>
<!--<link rel="stylesheet" href="/public/css/components/form/index2.css">-->
<!--<link rel="stylesheet" href="/public/css/framework/util/border/border-radius.css">-->
<div class="container p-1" style="margin-top: 10vh;">
    <form action="create" method="post" class="p-3 bg-white-0-7  border-radius-10 text-xl">
        <div class="d-flex text-center flex-column">
            <div class="form-group">
                <label class="w-40">Campaign Name</label><br><br>
                <input type="text" class="form-control" name="Campaign_Name" required>
            </div>
<!--            <div class="form-group">-->
<!--                <label class="w-40">Campaign Description</label><br><br>-->
<!--                <textarea class="form-textarea" name="Campaign_Description" required></textarea>-->
<!--            </div>-->
            <div class="form-group">
                <label class="w-40">Campaign Date</label><br><br>
                <input type="date" class="form-date form-control" name="Campaign_Date" min= "<?php echo date("Y-m-d", strtotime($Date.'+ 8days')) ?>" required>
            </div>
            <div class="form-group">
                <label class="w-40">Venue</label><br><br>
                <input type="text" class="form-control" name="Venue" required>
            </div>
            <div class="form-group">
                <label class="w-40">Nearest City</label><br><br>
                <input type="text" class="form-control" name="Nearest_City"  required>
            </div>
            <div class="form-group">
                <label class="w-40">Nearest Blood Bank</label><br><br>
                <select class="form-select w-40" style="height: 50px;" name="Nearest_BloodBank">
                    <?php foreach ($banks as $bank){ ?>
                    <option value="<?= $bank->getBloodBankID() ?>"><?= $bank->getBankName() ?></option>
                    <?php } ?>
                </select>
            </div>

                <div class="form-group">
                    <label class="w-40">Expected Amount</label><br><br>
                    <label class="bg-white">LKR.</label>
                    <input type="text" class="form-control" name="Expected_Amount"  required>
                </div>

            <div class="form-group" style="justify-content: flex-start">
                <label class="w-60">Have You Read the Guidelines? </label>
                <input type="checkbox" class="form-checkbox" id="error" onchange="read()" required>
            </div>

        </div>
            <div class="form-entity mt-2 hidden">
                <label class="form-label text-danger" id="errors" style="visibility: hidden;">
                    <b>Please Agree to Our Guidelines First!&nbsp&nbsp<a href="guideline" target="_blank" style="text-decoration: underline;">Read Our Guidelines</a></b>
                </label><br><br>
            </div>
        <div class="d-flex align-items-center justify-content-center gap-2">
            <input type="submit" class="btn btn-primary w-30" id="button" value="Create">
            <input type="reset" class="btn btn-secondary w-30">
        </div>
    </form>
</div>
<script>
    function read(){
        let select = document.getElementById('error');
        if(select.selectedIndex === 1){
            document.getElementById('errors').style.visibility = 'visible';
            document.getElementById('button').disabled = true;
            document.getElementById('button').style.backgroundColor = '#F5F5F5';
            document.getElementById('button').style.color = 'black';
        }else{
            document.getElementById('errors').style.visibility = 'hidden';
            document.getElementById('button').disabled = false;
            document.getElementById('button').style.backgroundColor = 'rgba(251, 0, 0, 0.7)';
            document.getElementById('button').style.color = 'white';
        }
    }
</script>

