<script src="/public/scripts/customAlert.js"></script>
<link href="/public/styles/alert.css" rel="stylesheet">
<?php
/* @var string $firstName*/
/* @var string $lastName*/
/* @var MedicalOfficer $model*/

use App\model\users\MedicalOfficer;
use App\view\components\ResponsiveComponent\FormComponent\BasicForm;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;


$background=new \App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage();
$navbar= new AuthNavbar('Add Medical Officer','#','/public/images/icons/user.png');
echo AuthNavbar::getNavbarCSS();
echo $navbar;
echo $background;
?>
<style>
    .panel{
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .branch-details{
        min-width: 300px;
        background: #3a8ace;
        min-height: 300px;
        max-height: 300px;
    }
    .branch-details img{
        min-height: 300px;
        max-height: 300px;
        min-width: 300px;
        max-width: 300px;
        object-fit: cover;
    }
</style>
<div class="panel">
    <div class="branch-details">
        <img id="blah" src="/public/upload/MO63a7ff622b8c8.jpg" alt="">
    </div>

<?php
// Make Form
echo BasicForm::CreateForm($model);
?>
    <div class="form-title">Personal Details</div>
    <?php
//echo BasicForm::CheckError($model);
echo BasicForm::CreateRow();
echo BasicForm::CreateTextInput('First_Name');
echo BasicForm::CreateTextInput('Last_Name');
echo BasicForm::EndingRow();
echo BasicForm::CreateRow();
echo BasicForm::CreateTextInput('NIC');
echo BasicForm::CreateTextInput('Contact_No');
echo BasicForm::EndingRow();
echo BasicForm::CreateRow();
echo BasicForm::CreateTextInput('Email');
echo BasicForm::CreateTextInput('Address1');
echo BasicForm::EndingRow();
echo BasicForm::CreateRow();
echo BasicForm::CreateTextInput('Address2');
echo BasicForm::CreateTextInput('City');
echo BasicForm::EndingRow();
echo BasicForm::CreateRow();
echo BasicForm::CreateSelectInput('Position', ['Medical Officer', 'Doctor', 'Nurse', 'Assistant Nurse']);
echo BasicForm::CreateDateInput('Joined_Date');
echo BasicForm::EndingRow();
//echo BasicForm::CreateRow();
//echo BasicForm::CreateFileInput('image');
//echo BasicForm::EndingRow();
echo BasicForm::CreateRow();
echo BasicForm::FormButton(BasicForm::SUBMIT_BUTTON, 'Submit');
echo BasicForm::FormButton(BasicForm::RESET_BUTTON, 'Reset');
echo BasicForm::CloseForm();
?>
</div>

<script src="/public/scripts/demo.js"></script>
<script>
    function PreviewImage(input){
        console.log(input)
        if (input.files && input.files[0]) {
            const reader = new FileReader();

            `reader.onload = function (e) {
                const Image = document.getElementById('blah');
                Image.src = e.target.result;
                // $('#blah').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);`
        }
    }
</script>
