<?php
/* @var string $firstName */
/* @var string $lastName */

/* @var MedicalOfficer $model */

use App\model\users\MedicalOfficer;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;

$background = new BackGroundImage();
$navbar = new AuthNavbar('View Medical Officer', '#', '/public/images/icons/user.png');
echo $navbar;
echo $background;
// Make Form
//echo BasicForm::CreateForm($model);
//echo BasicForm::CheckError($model);
?>

<?php
//echo BasicForm::CreateRow();
//echo BasicForm::CreateTextInput('First_Name');
//echo BasicForm::CreateTextInput('Last_Name');
//echo BasicForm::EndingRow();
//echo BasicForm::CreateRow();
//echo BasicForm::CreateTextInput('NIC');
//echo BasicForm::CreateTextInput('Contact_No');
//echo BasicForm::EndingRow();
//echo BasicForm::CreateRow();
//echo BasicForm::CreateTextInput('Email');
//echo BasicForm::CreateTextInput('Address1');
//echo BasicForm::EndingRow();
//echo BasicForm::CreateRow();
//echo BasicForm::CreateTextInput('Address2');
//echo BasicForm::CreateTextInput('City');
//echo BasicForm::EndingRow();
//echo BasicForm::CreateRow();
//echo BasicForm::CreateSelectInput('Position', ['Medical Officer', 'Doctor', 'Nurse', 'Assistant Nurse']);
//echo BasicForm::CreateDateInput('Joined_Date');
//echo BasicForm::EndingRow();
////echo BasicForm::CreateRow();
////echo BasicForm::CreateFileInput('image','Change Image');
////echo BasicForm::EndingRow();
//echo BasicForm::CreateRow();
//echo BasicForm::FormButton(BasicForm::SUBMIT_BUTTON, 'Update');
//echo BasicForm::FormButton(BasicForm::REGULAR_BUTTON, 'Delete');
//echo BasicForm::CloseForm();
//
//?>

<div class="d-flex w-100 justify-content-center align-items-center">
    <div class="d-flex gap-1 flex-column bg-white-0-3 p-2 w-80 border-radius-10">

        <form action="" method="post" class="w-70 d-flex text-center flex-column bg-white-0-5 border-radius-10 justify-content-center w-100">
            <div class="w-100 d-flex justify-content-end p-1" >
                <div id="edit-btn" class="btn btn-primary" onclick="EditOfficer('<?php echo $model->getID(); ?>')">
                    Edit
                </div>
            </div>
            <div class="d-flex">
                <div class="d-flex align-items-center m-3">
                    <div class="d-flex justify-content-center">
                        <div class="d-flex justify-content-center align-items-center"
                             style="width: 150px;height:150px;border-radius: 50px">
                            <img src="<?= $model->getProfileImage() ?>" alt="user"
                                 style="border-radius:50px;object-fit: cover;margin:0.1rem;width: inherit;height: inherit">
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-column gap-1 justify-content-center m-3 w-80">
                    <div class="d-flex justify-content-between align-items-center gap-2">
                        <div class="d-flex w-100 align-items-center">
                            <label for="First_Name" class="w-40">First Name</label>
                            <input type="text" class="text-center" name="First_Name" id="First_Name" disabled
                                   value="<?php echo $model->getFirstName() ?>">
                        </div>
                        <div class="d-flex w-100 align-items-center">
                            <label for="Last_Name" class="w-40">Last Name</label>
                            <input type="text" class="text-center" name="Last_Name" id="Last_Name" disabled value="<?php echo $model->getLastName() ?>">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center gap-2">
                        <div class="d-flex w-100 align-items-center">
                            <label for="NIC" class="w-40">NIC</label>
                            <input type="text" class="text-center" name="NIC" id="NIC" disabled  value="<?php echo $model->getNIC() ?>">
                        </div>
                        <div class="d-flex w-100 align-items-center">
                            <label for="Contact_No" class="w-40">Contact No</label>
                            <input type="text" name="Contact_No" id="Contact_No"  disabled   class="text-center"
                                   value="<?php echo $model->getContactNo() ?>">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center gap-2">
                        <div class="d-flex w-100 align-items-center">
                            <label for="Email" class="w-40">Email</label>
                            <input type="text"  class="text-center"  disabled   name="Email" id="Email" value="<?php echo $model->getEmail() ?>">
                        </div>
                        <div class="d-flex w-100 align-items-center">
                            <label for="Address1" class="w-40">Address 1</label>
                            <input type="text" class="text-center" disabled   name="Address1" id="Address1" value="<?php echo $model->getAddress1() ?>">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center gap-2">
                        <div class="d-flex w-100 align-items-center">
                            <label for="Address2" class="w-40">Address 2</label>
                            <input type="text" class="text-center" disabled   name="Address2" id="Address2" value="<?php echo $model->getAddress2() ?>">
                        </div>
                        <div class="d-flex w-100 align-items-center">
                            <label for="City" class="w-40">City</label>
                            <input type="text" name="City" class="text-center" disabled   id="City" value="<?php echo $model->getCity() ?>">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center gap-2">
                        <div class="d-flex w-100 align-items-center">
                            <label for="Position" class="w-40">Position</label>
                            <select name="Position" id="Position" class="w-60 form-select" disabled  >
                                <option value="Medical Officer" <?php if ($model->getPosition() == 'Medical Officer') echo 'selected' ?>>
                                    Medical Officer
                                </option>
                                <option value="Doctor" <?php if ($model->getPosition() == 'Doctor') echo 'selected' ?>>
                                    Doctor
                                </option>
                                <option value="Nurse" <?php if ($model->getPosition() == 'Nurse') echo 'selected' ?>>Nurse
                                </option>
                                <option value="Assistant Nurse" <?php if ($model->getPosition() == 'Assistant Nurse') echo 'selected' ?>>
                                    Assistant Nurse
                                </option>
                            </select>
                        </div>
                        <div class="d-flex w-100 align-items-center">
                            <label for="Joined_Date" class="w-40">Joined Date</label>
                            <input type="date" disabled   name="Joined_Date" id="Joined_Date" class="form-date text-center"
                                   value="<?php echo $model->getJoinedAt(true) ?>">
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="d-flex  gap-2 align-items-center justify-content-center">
            <div class="d-flex bg-white-0-7 p-1 py-2 flex-column justify-content-center align-items-center gap-1 border-radius-10">
                <div class="d-flex font-bold bg-white py-0-5 p-1 border-radius-10">Career Details</div>
                <div class="d-flex">Registration No : 2000/CS/345 </div>
                <div class="d-flex">Registration Date : 2000/12/04 </div>
            </div>

            <div class="d-flex max-w-50 flex-column justify-content-center align-items-center bg-white-0-5 p-1 border-radius-10">
                <div class="text-xl py-0-5 px-1 bg-white font-bold border-radius-10 text-dark">
                    Recent Campaigns
                </div>
                <div class="d-flex flex-wrap">
                    <div class="card card-sm">
                        <div class="card-header flex-column ">
                            <div id="date">
                                Date : 2020 / 12 /10
                            </div>
                            <div id="venue">
                                Venue : Colombo
                            </div>
                            <div id="role">
                                Role : Leader
                            </div>
                        </div>
                    </div>
                    <div class="card card-sm">
                        <div class="card-header flex-column ">
                            <div id="date">
                                Date : 2020 / 12 /10
                            </div>
                            <div id="venue">
                                Venue : Colombo
                            </div>
                            <div id="role">
                                Role : Leader
                            </div>
                        </div>
                    </div>
                    <div class="card card-sm">
                        <div class="card-header flex-column ">
                            <div id="date">
                                Date : 2020 / 12 /10
                            </div>
                            <div id="venue">
                                Venue : Colombo
                            </div>
                            <div id="role">
                                Role : Leader
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex max-w-50 flex-column justify-content-center align-items-center bg-white-0-5 p-1 border-radius-10">
                <div class="text-xl py-0-5 px-1 bg-white font-bold border-radius-10 text-dark">
                    Actions
                </div>
                <div class="d-flex flex-wrap">
                    <div class="card card-xs bg-success text-white cursor" onclick="SendEmail()" style="width: 150px">
                        <div class="card-header flex-column ">
                            <div class="">Send Email</div>
                        </div>
                    </div>
                    <div class="card card-xs bg-danger cursor text-white" onclick="DeleteOfficer('<?php echo $model->getID(); ?>')" style="width: 150px">
                        <div class="card-header flex-column ">
                            <div id="date">
                                Delete Medical Officer
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<script src="/public/scripts/demo.js"></script>
<script src="/public/js/mofficer/index.js"></script>

