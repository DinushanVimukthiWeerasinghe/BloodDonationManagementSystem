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

$Date = date("Y-m-d");
$background = new BackGroundImage();
$navbar = new AuthNavbar('Create Campaign', '#', '/public/images/icons/navbar/bell.png');
//echo AuthNavbar::getNavbarCSS();
echo $navbar;
echo $background;
?>
<link rel="stylesheet" href="/public/css/components/form/index2.css">
<link rel="stylesheet" href="/public/css/framework/util/border/border-radius.css">
<div class="container p-1" style="margin-top: 5vh;">
    <form action="create" method="post" class="p-3 form form-column">
        <h1 class="form-title mt-0">Create Your Campaign</h1>
        <div class="">
            <div class="form-entity mt-1">
                <label class="form-label">Campaign Name</label><br><br>
                <input type="text" class="form-input" name="Campaign_Name" required>
            </div>
            <div class="form-entity mt-2">
                <label class="form-label">Campaign Date</label><br><br>
                <input type="date" class="form-input" name="Campaign_Date" min= "<?php echo date("Y-m-d", strtotime($Date.'+ 7days')) ?>" required>
            </div>
        </div><br>
        <div class="form-row">
            <div class="form-entity mt-2">
                <label class="form-label">Venue</label><br><br>
                <input type="text" class="form-input" name="Venue" required>
            </div>
            <div class="form-entity mt-2">
                <label class="form-label">Nearest City</label><br><br>
                <input type="text" class="form-input" name="Nearest_BloodBank"  required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-entity mt-2">
                <label class="form-label">Have You Read the Guidelines? </label><br><br>
                <select class="form-select" id="error" onchange="read()" required>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </div>

        </div>
        <div class="form-row">
            <div class="form-entity mt-2">
                <label class="form-label text-danger" id="errors" style="visibility: hidden;"><b>Please Agree to Our Guidelines First!&nbsp&nbsp<a href="guideline" target="_blank" style="text-decoration: underline;">Read Our Guidelines</a></b></label><br><br>
            </div>
        </div>
        <div>
            <input type="submit" class="btn btn-success mr-2" id="button">
            <input type="reset" class="btn btn-dark">
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

