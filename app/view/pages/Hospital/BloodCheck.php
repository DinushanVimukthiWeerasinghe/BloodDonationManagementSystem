<link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<?php
/* @var string $data */

use App\model\BloodBankBranch\BloodBank;
use App\model\Requests\BloodRequest;
use App\model\users\Hospital;
use App\view\components\ResponsiveComponent\Alert\FlashMessage;
use App\view\components\ResponsiveComponent\CardGroup\CardGroup;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;

FlashMessage::RenderFlashMessages();
$navbar = new AuthNavbar('Hospital Board', '/hospital', '/public/images/icons/user.png', true,false );
echo $navbar;

use App\view\components\WebComponent\Card\Card;

echo card::ImportJS();

/* @var Hospital $user */

use App\view\components\WebComponent\Card\NavigationCard;

$background = new BackGroundImage();

echo $background;


/* @var BloodGroup $BloodT*/
/* @var Donor $Donor*/
/* @var array $BloodType*/



use App\model\Blood\BloodGroup;
//use App\model\MedicalTeam\TeamMembers;
use App\model\users\Donor;
//use App\view\components\ResponsiveComponent\Alert\FlashMessage;

//print_r($BloodCheck->errors);
//var_dump($Donor);
//exit();
//print_r($BloodType);
//exit();
?>

<div class="d-flex flex-column bg-white m-1 h-100 w-100 justify-content-center align-items-center border-radius-10">
    <div class="bg-dark mt-1 px-1 py-1 text-white text-center w-95 border-radius-10">
        Blood Check - <?=$Donor->getFullName()?> (<?=$Donor->getNIC()?>)
    </div>
    <div class="d-flex d-flex flex-column w-100 justify-content-center h-100 align-items-center justify-content-center">
        <div class="d-flex w-100 flex-center">
            <img src="<?=$Donor->getProfileImage()?>" alt="" class="w-20 border-1 p-0-5 m-1 border-dark border-radius-50 " style="height: 15rem;width: 15rem;" width="50rem">
        </div>
        <form action="/hospital/take-donation?id=<?= $Donor->getDonorID() ?>" method="POST" class=" d-flex flex-column gap-1 h-80 w-60 p-1">
<!--            <input type="hidden" name="Task" value=--><?php //=TeamMembers::TASK_BLOOD_CHECK?><!-->
            <input type="hidden" name="Donor_ID" value="<?=$Donor->getDonorID()?>">
            <div class="d-flex flex-center gap-1">
                <div class="form-group border-bottom-1">
                    <label for="BloodGroup" class="w-60 ">Blood type</label>
                    <select name="BloodGroup" id="BloodGroup" required class="w-40 form-select" style="border-radius: 40px;border: 2px solid black">
                        <?php
                        foreach ($BloodType as $BloodT):
                            ?>
                            <option value="<?= $BloodT->getBloodGroupID() ?>"><?= $BloodT->getBloodGroupName() ?></option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="form-group border-bottom-1">
                    <label for="Hemoglobin_Level" class="w-60 ">Hemoglobin (g/dL)</label>
                    <div class="d-flex flex-column w-100">
                        <input type="number" name="Hemoglobin_Level" step="0.01" placeholder="Eg:- (12-20) g/dL" required id="Hemoglobin_Level" class="w-40 form-control" style="border-radius: 40px;border: 2px solid black">
                    </div>
                </div>
            </div>
            <div class="d-flex flex-center gap-1">
                <div class="form-group border-bottom-1">
                    <label for="Blood_Pressure" class="w-60 ">Blood Pressure (mmHg)</label>
                    <input type="text" name="Blood_Pressure" placeholder=" Eg:- 90/60 or 120/80" pattern="\d{1,3}/\d{1,3}" required  id="Blood_Pressure" class="w-40 form-control" style="border-radius: 40px;border: 2px solid black">
                </div>
                <div class="form-group border-bottom-1">
                    <label for="Pulse_Rate" class="w-60 ">Pulse Rate (BPM)</label>
                    <input type="number" name="Pulse_Rate" step="0.01" placeholder="Eg:- (60-100)BPM"  required  id="Pulse_Rate" class="w-40 form-control" style="border-radius: 40px;border: 2px solid black">
                </div>
            </div>
            <div class="d-flex flex-center gap-1">
                <div class="form-group border-bottom-1">
                    <label for="Temperature" class="w-60 ">Temperature (°C)</label>
                    <input type="number" name="Temperature" placeholder="Eg:- (30-40) &deg;C" step="0.01" required  id="Temperature" class="w-40 form-control" style="border-radius: 40px;border: 2px solid black">
                </div>
                <div class="form-group border-bottom-1">
                    <label for="Weight" class="w-60 ">Weight (kg)</label>
                    <input type="number" name="Weight" step="0.01" required placeholder="Eg:- ( 50 - 200 ) Kg" id="Weight" class="w-40 form-control" style="border-radius: 40px;border: 2px solid black">
                </div>
            </div>
            <div class="d-flex flex-center gap-1">
                <div class="form-group border-bottom-1">
                    <label for="Blood_Sugar" class="w-60 ">Blood Sugar (mg/dL)</label>
                    <input type="number" name="Blood_Sugar" step="0.01" placeholder="Eg:- (70 - 100 ) mg/dL" required  id="Blood_Sugar" class="w-40 form-control" style="border-radius: 40px;border: 2px solid black">
                </div>
                <div class="form-group border-bottom-1">
                    <label for="Iron_Level" class="w-60 ">Iron Level</label>
                    <input type="number" name="Iron_Level" step="0.01" required placeholder="Eg:- (135-175) mg/dL"  id="Iron_Level" class="w-40 form-control" style="border-radius: 40px;border: 2px solid black">
                </div>
            </div>
            <div class="d-flex flex-center gap-1">
                <div class="form-group d-flex flex-center w-100">
                    <label for="Remarks" class="align-self-baseline d-flex flex-center">Remarks</label>
                    <textarea name="Remarks" placeholder="Special Remark of Blood Check" id="Remarks" cols="30" rows="10" class="w-90" style="border-radius: 20px;border: 2px solid black"></textarea>
                </div>
            </div>
            <div class="d-flex gap-1 w-100 justify-content-center align-items-center mt-2">
                <button type="submit" class="btn btn-success d-flex gap-1 flex-center btn-lg">
                    <i class="fas fa-check-circle"></i>
                    Check
                </button>
                <button type="reset" onclick="Back()" class="btn btn-danger d-flex gap-1 flex-center btn-lg">
                    <i class="fas fa-times-circle"></i>
                    Reset
                </button>
            </div>


        </form>
    </div>
</div>
<script>
    const Back = () => {
        window.location.href = "/hospital/bloodCheck";
    }
    const input = document.getElementById('Blood_Pressure');

    input.addEventListener('input', function() {
        const inputValue = input.value;
        const inputLength = inputValue.length;

        if (inputLength === 2 && !inputValue.includes('/')) {
            const inputValue = parseFloat(input.value);
            if (inputValue >= 90 && inputValue <= 99) {
                input.value += '/';
            }
        }else if (inputLength === 3 && !inputValue.includes('/')) {
            const inputValue = parseFloat(input.value);
            if (inputValue >= 100 && inputValue <= 120) {
                input.value += '/';
            }else{
                ShowToast({
                    type: 'error',
                    title: 'Invalid Blood Pressure',
                    message: 'Please enter a valid blood pressure',
                    duration: 5000
                })

            }
        }
    });
    input.addEventListener('keypress', function(e) {
        if (e.key === '/') {
            e.preventDefault();
        }
        if (input.value.length === 6) {
            e.preventDefault();
            const inputValue1 = parseFloat(input.value.split('/')[0]);
            const inputValue2 = parseFloat(input.value.split('/')[1]);
            if (inputValue1 < 90 || inputValue1 > 120 || inputValue2 < 60 || inputValue2 > 80) {
                ShowToast({
                    type: 'error',
                    title: 'Invalid Blood Pressure',
                    message: 'Please enter a valid blood pressure',
                    duration: 5000
                })
            }
        }

    });
</script>
