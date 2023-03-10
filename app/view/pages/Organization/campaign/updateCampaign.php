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
$navbar = new AuthNavbar('Update Campaign', '#', '/public/images/icons/navbar/bell.png');
//echo AuthNavbar::getNavbarCSS();
echo $navbar;
echo $background;
?>
<style>
    .direction{
        display: flex;
        flex-direction: row;
    }
    #exp{
        position: relative;
        animation-name: trans;
        animation-duration: 2s;
    }
    @keyframes trans {
        0%{
            margin-left: -2000px;
        }
        100%{
            margin-left: -50px;
        }

    }
    /*#expec{*/
    /*    visibility: hidden;*/
    /*}*/
</style>
<!--<link rel="stylesheet" href="/public/css/components/form/index2.css">-->
<!--<link rel="stylesheet" href="/public/css/framework/util/border/border-radius.css">-->
<div class="container" id="exp" style="margin-left: -50px;">
<!--<div class="form-group" style="margin-top: 15vh;" >-->
<!--    <label style="color: whitesmoke;font-size: 15pt;">Do you expect Sponsorships?</label><br><br>-->
<!--    <select class="form-select" id="expect" style="height: 50px;" name="expect" onchange="expect()"  required>-->
<!--        <option value="1">Yes</option>-->
<!--        <option value="2" selected>No</option>-->
<!--    </select>-->
<!--</div>-->
<!--</div><br><br>-->
<div class="container p-1">
    <form action="updateCampaign?id=<?php echo $camp->getCampaignID() ?>" method="post" class="p-3 bg-white-0-7  border-radius-10 text-xl" autocomplete="off">
        <div class="d-flex text-center flex-column">
            <div class="form-group">
                <label class="w-40">Campaign Name</label><br><br>
                <input type="text" class="form-control" name="Campaign_Name" value="<?=  $camp->getCampaignName() ?>" required>
            </div>
<!--            <div class="form-group">-->
<!--                <label class="w-40">Campaign Description</label><br><br>-->
<!--                <textarea class="form-textarea" name="Campaign_Description" required></textarea>-->
<!--            </div>-->
            <div class="form-group">
                <label class="w-40">Campaign Date</label><br><br>
                <input type="date" class="form-date form-control" name="Campaign_Date" min= "<?php echo date("Y-m-d", strtotime($Date.'+ 8days')) ?>" value="<?=  $camp->getCampaignDate() ?>" required>
            </div>
            <div class="form-group">
                <label class="w-40">Venue</label><br><br>
                <input type="text" class="form-control" name="Venue" value="<?=  $camp->getVenue() ?>" required>
            </div>
            <div class="form-group">
                <label class="w-40">Nearest City</label><br><br>
                <input type="text" class="form-control" name="Nearest_City" value="<?=  $camp->getNearestCity() ?>"  required>
            </div>
<!--            <div class="form-group">-->
<!--                <label class="w-40">Nearest Blood Bank</label><br><br>-->
<!--                <select class="form-select w-40" style="height: 50px;" name="Nearest_BloodBank" value="--><?php //=  $camp->getNearestBloodBank() ?><!--">-->
<!--                    --><?php //foreach ($banks as $bank){ ?>
<!--                    <option value="--><?php //= $bank->getBloodBankID() ?><!--">--><?php //= $bank->getBankName() ?><!--</option>-->
<!--                    --><?php //} ?>
<!--                </select>-->
<!--            </div>-->
            <div class="form-group"  style="margin-top: 4px;margin-left: 5px;">
                <label class="w-40">Expected Amount</label>
                <label class="bg-white">LKR.</label>
                <input type="text" class="form-control" name="Expected_Amount" id="amount" value="<?=  $camp->getExpectedAmount() ?>">
            </div>
            <br>
<!--            <div class="form-group" style="justify-content: flex-start">-->
<!--                <label class="w-60">Have You Read the Guidelines? </label>-->
<!--                <input type="checkbox" class="form-checkbox" id="error" onchange="read()" required>-->
<!--            </div>-->

        </div>
        <br>

        <div class="d-flex align-items-center justify-content-center gap-2">
            <input type="submit" class="btn btn-primary w-30" id="button" value="Update">
            <input type="reset" class="btn btn-secondary w-30">
        </div>
    </form>
<!--    <div class="form-group" style="margin-top: 4px;">-->
<!--        <label class="w-40">Do you expect Sponsorships?</label><br><br>-->
<!--        <select class="form-select w-40" id="expect" style="height: 50px;" name="expect" onchange="expect()"  required>-->
<!--            <option value="1">Yes</option>-->
<!--            <option value="2" selected>No</option>-->
<!--        </select>-->
<!---->
<!--    </div>-->

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
    function expect(){
        let val = document.getElementById('expect').value;
        if(val === "1") {
            document.getElementById('expec').style.visibility = 'visible';
        }else{
            document.getElementById('amount').value = "";
            document.getElementById('expec').style.visibility = 'hidden';
        }
    }
    const SendEmail = (id)=>{
        OpenDialogBox({
            id:'sendEmail',
            title:'Send Email',
            content :`
                <div class="d-flex gap-1 flex-column">
                    <div class="form-group">
                        <label for="Subject" class="w-40">Subject</label>
                        <div class="d-flex flex-column w-100 gap-0-5">
                            <input type="text" class="w-60 form-control" id="Subject" placeholder="Enter Subject">
                            <span class="text-danger none" id="Subject-error"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Body" class="w-40">Message</label>
                        <div class="d-flex flex-column w-100 gap-0-5">
                            <textarea class="border-radius-5" id="Body" rows="3"></textarea>
                            <span class="text-danger none" id="Body-error"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="attachment" class="w-40">Attachment</label>
                        <input type="file" class="w-60 form-control" id="attachment">
                </div>
            `,
            successBtnText:'Send',
            successBtnAction : ()=>{
                const form = new FormData();
                form.append('Officer_ID',id);
                form.append('subject',document.getElementById('Subject').value);
                form.append('message',document.getElementById('Body').value);
                const Attachment = document.getElementById('attachment').files[0];
                if (Attachment){
                    form.append('attachment',Attachment);
                }
                fetch('/manager/mngMedicalOfficer/sendEmail',{
                    method:'POST',
                    body:form
                }).then(res=>res.json())
                    .then((data)=>{
                        if (data.status) {
                            CloseDialogBox();
                            ShowToast({
                                title:'Success',
                                message:data.message,
                                type:'success'
                            })
                        }else{
                            if (data.errors){
                                for (const [key, value] of Object.entries(data.errors)) {
                                    console.log(key,value)
                                    const element = document.getElementById(key+'-error');
                                    element.innerText=value;
                                    element.classList.remove('none');

                                }
                            }
                            ShowToast({
                                title:'Error',
                                message:data.message,
                                type:'danger'
                            })
                        }
                    })
            }
        })
    }
</script>

