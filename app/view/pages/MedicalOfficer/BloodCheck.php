<?php

/* @var BloodGroup $BloodT*/
/* @var Donor $Donor*/
/* @var array $BloodType*/

use App\model\Blood\BloodGroup;
use App\model\MedicalTeam\TeamMembers;
use App\model\users\Donor;
use App\view\components\ResponsiveComponent\Alert\FlashMessage;

//print_r($BloodCheck->errors);
?>

<div class="d-flex bg-white m-1 h-100 w-100 justify-content-center align-items-center border-radius-10">
    <div class="d-flex w-100 justify-content-center h-100 align-items-center justify-content-center">
        <form action="/mofficer/take-donation" method="POST" class=" d-flex flex-column gap-1 h-80 w-60 p-1">
            <input type="hidden" name="Task" value=<?=TeamMembers::TASK_BLOOD_CHECK?>>
            <input type="hidden" name="Donor_ID" value="<?=$Donor->getDonorID()?>">
            <div class="form-group border-bottom-1">
                <label for="BloodGroup" class="w-60 ">Blood type</label>
                <select name="BloodGroup" id="BloodGroup" required class="w-40 form-select" style="border-radius: 0">
                    <?php
                    foreach ($BloodType as $BloodT):
                        print_r($BloodT)
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
                    <input type="number" name="Hemoglobin_Level" step="0.01" required id="Hemoglobin_Level" class="w-40 form-control">
                    <span class="text-danger px-1 py-0-5"><?="Hi"?></span>
                </div>
            </div>
            <div class="form-group border-bottom-1">
                <label for="Blood_Pressure" class="w-60 ">Blood Pressure (mmHg)</label>

                <input type="number" name="Blood_Pressure" step="0.01" required  id="Blood_Pressure" class="w-40 form-control">

            </div>
            <div class="form-group border-bottom-1">
                <label for="Pulse_Rate" class="w-60 ">Pulse Rate (bpm)</label>
                <input type="number" name="Pulse_Rate" step="0.01" required  id="Pulse_Rate" class="w-40 form-control">
            </div>
            <div class="form-group border-bottom-1">
                <label for="Temperature" class="w-60 ">Temperature (°C)</label>
                <input type="number" name="Temperature" step="0.01" required  id="Temperature" class="w-40 form-control">
            </div>
            <div class="form-group border-bottom-1">
                <label for="Weight" class="w-60 ">Weight (kg)</label>
                <input type="number" name="Weight" step="0.01" required  id="Weight" class="w-40 form-control">
            </div>
            <div class="form-group border-bottom-1">
                <label for="Blood_Sugar" class="w-60 ">Blood Sugar (mg/dL)</label>
                <input type="number" name="Blood_Sugar" step="0.01" required  id="Blood_Sugar" class="w-40 form-control">
            </div>
            <div class="form-group border-bottom-1">
                <label for="Iron_Level" class="w-60 ">Iron Level</label>
                <input type="number" name="Iron_Level" step="0.01" required  id="Iron_Level" class="w-40 form-control">
            </div>
<!--            <div class="form-group w-100">-->
<!--                <label for="Disease" class="align-self-baseline w-40">Infected Diseases</label>-->
<!--                <div class="d-flex flex-column flex-wrap w-50 gap-1">-->
<!--                    <div class="d-flex w-100 gap-1">-->
<!--                        <div class="w-50 d-flex align-items-center">-->
<!--                            <input type="checkbox" name="Disease[]" id="Disease" value="HIV" class="form-checkbox">-->
<!--                            <label for="Disease" class="ml-2">HIV</label>-->
<!--                        </div>-->
<!--                        <div class="w-50 d-flex align-items-center">-->
<!--                            <input type="checkbox" name="Disease[]" id="Disease" value="Syphilis" class="form-checkbox">-->
<!--                            <label for="Disease" class="ml-2">Syphilis</label>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="d-flex w-100 gap-1">-->
<!--                        <div class="w-50 d-flex align-items-center">-->
<!--                            <input type="checkbox" name="Disease[]" id="Disease" value="Hepatitis_B" class="form-checkbox">-->
<!--                            <label for="Disease" class="ml-2">Hepatitis_B</label>-->
<!--                        </div>-->
<!--                        <div class="w-50 d-flex align-items-center">-->
<!--                            <input type="checkbox" name="Disease[]" id="Disease" value="Hepatitis_C" class="form-checkbox">-->
<!--                            <label for="Disease" class="ml-2">Hepatitis_C</label>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="d-flex w-100 gap-1">-->
<!--                        <div class="w-50 d-flex align-items-center">-->
<!--                            <input type="checkbox" name="Disease[]" id="Disease" value="Malaria" class="form-checkbox">-->
<!--                            <label for="Disease" class="ml-2">Malaria</label>-->
<!--                        </div>-->
<!--                        <div class="w-50 d-flex align-items-center">-->
<!--                            <input type="checkbox" name="Disease[]" id="Disease" value="Virus" class="form-checkbox">-->
<!--                            <label for="Disease" class="ml-2">Virus</label>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
            <div class="form-group w-100">
                <label for="Remarks" class="align-self-baseline w-40">Remarks</label>
                <textarea name="Remarks" id="Remarks" cols="30" rows="10" class="w-50 form-control"></textarea>
            </div>
            <div class="d-flex w-100 justify-content-center align-items-center mt-2">
                <input type="submit" class="btn btn-success" value="Submit">
            </div>


        </form>
    </div>
</div>
