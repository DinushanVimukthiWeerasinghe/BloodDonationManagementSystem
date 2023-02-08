<?php

use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;

$background = new BackGroundImage();
$navbar = new AuthNavbar('Inform Donors', '/manager/profile', '/public/images/icons/user.png', false,false);


echo $navbar;
echo $background;
?>
<div class="d-flex min-h-70">
    <div class="d-flex bg-white-0-3 p-3 border-radius-10">
        <form action="/manager/mngDonors/informDonor" class="gap-0-5 d-flex flex-column" method="post">
            <div class="form-group">
                <label class="w-30" for="title">Title</label>
                <input id="title" class="w-70" name="title" type="text" required>
            </div>
            <div class="form-group">
                <label class="w-10" for="message">Message</label>
                <textarea class="w-75" id="message" name="message" cols="50" maxlength="100"></textarea>
            </div>
            <div class="form-group d-flex align-items-center flex-row" style="justify-content: flex-start" onclick="CustomExpiration()">
                <label class="w-35" for="custom_date"  style="margin-bottom: 0;">Custom Expiration Date</label>
                <input id="custom_date" type="checkbox" class="form-checkbox">
            </div>
            <div class="form-group hidden" id="valid_until">
                <label class="w-30" for="valid_until">Valid Until</label>
                <input id="valid_until" name="valid_until" class="form-date w-70" type="date">
            </div>
            <div class="form-group">
                <label class="w-30" for="selectDonor">Select Donor</label>
                <select id="selectDonor" name="group" class="form-select w-70" onchange="TriggerCustomSelect()">
                    <option value="all">All</option>
                    <option value="reported">Reported</option>
                    <option value="custom">Custom</option>
                </select>
            </div>
            <div class="form-group hidden" id="BloodType">
                <label for="custom_BloodType">Blood Type</label>
                <select id="custom_BloodType" name="TargetBloodType" class="form-select">
                    <option value="AB+">AB+</option>
                </select>
            </div>
            <div class="form-buttons gap-1">
                <input class="btn btn-success w-30" type="submit" value="Inform">
                <input class="btn btn-danger w-30" type="reset" value="Reset">
            </div>

        </form>
    </div>
</div>
<script>
    const TriggerCustomSelect = ()=>{
        const DonorSelect = document.getElementById('selectDonor').value.trim()
        const BloodType = document.getElementById("BloodType");
        if (DonorSelect.toLowerCase()==='custom'){
            BloodType.classList.remove('hidden');
        }
        else{
            BloodType.classList.add('hidden');
        }
    }
    const CustomExpiration = ()=>{
        const CustomDate = document.getElementById('custom_date');
        const  CustomDateSetter = document.getElementById('valid_until');
        if (CustomDate.checked){
            CustomDateSetter.classList.toggle('hidden');
        }else{
            CustomDateSetter.classList.toggle('hidden')
        }
    }
</script>
