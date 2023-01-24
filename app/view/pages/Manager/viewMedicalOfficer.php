<script src="/public/scripts/customAlert.js"></script>
<link href="/public/styles/alert.css" rel="stylesheet">
<?php
/* @var string $firstName*/
/* @var string $lastName*/
/* @var MedicalOfficer $model*/
use App\model\users\MedicalOfficer;
use App\view\components\ResponsiveComponent\ButtonComponent\DashBoardButton;
use App\view\components\ResponsiveComponent\FormComponent\BasicForm;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;
use App\view\components\ResponsiveComponent\Title\primaryTitle;

$background=new \App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage();
$navbar= new AuthNavbar('View Medical Officer','#','/public/images/icons/user.png');
echo $navbar;
echo $background;
?>

<?php
echo DashBoardButton::BackToDashBoard('/manager/mngMedicalOfficer');
echo DashBoardButton::getDashBoardButtonCSS();
?>

<?php
// Make Form
echo BasicForm::CreateForm($model);
//echo BasicForm::CheckError($model);
?>

<?php
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
//echo BasicForm::CreateFileInput('image','Change Image');
//echo BasicForm::EndingRow();
echo BasicForm::CreateRow();
echo BasicForm::FormButton(BasicForm::SUBMIT_BUTTON, 'Update');
echo BasicForm::FormButton(BasicForm::REGULAR_BUTTON, 'Delete');
echo BasicForm::CloseForm();

?>





<script src="/public/scripts/demo.js"></script>

