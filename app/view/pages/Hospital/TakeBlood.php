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


/* @var $Donor Donor*/
/* @var $Donation Donation*/

use App\model\Donations\Donation;
use App\model\users\Donor;

//print_r($Donor);
//exit();
?>
<?php
if (isset($BloodRetrievingStarted)):
    ?>

    <div class="bg-dark-0-5 fixed h-100 w-100 top-0 left-0 d-flex align-items-center justify-content-center" style="z-index: 999">
        <!--    <div id="loader" class=" absolute d-flex justify-content-center align-items-center bg-white w-50 h-50" style="z-index: 999;margin-top: 35px;">-->
        <!--        <img src="/public/loading2.svg" alt="" width="100px">-->
        <!--    </div>-->
        <div class="d-flex bg-white p-2 flex-column min-h-50 min-w-50 border-radius-10 align-items-center justify-content-center gap-3">
            <div class="w-100 text-center text-xl bg-dark text-white py-1 px-1">Blood Retrieving Started</div>
            <div class="d-flex w-100 justify-content-around gap-2">
                <div class="d-flex flex-column align-items-center justify-content-center gap-2">
                    <img src="/public/icons/bloodDonation.gif" alt="bloodDonation" class="" width="400px" >
                    <div class="d-flex font-bold justify-content-center " style="font-size: 4rem;" id="timer"> 00 : 00 : 00 </div>

                </div>
                <div class="d-flex flex-column align-items-center justify-content-center gap-2">
                    <img src="<?=$Donor->getProfileImage()?>" alt="<?=$Donor->getFullName()?>" width="200px"/>
                    <div class="d-flex flex-column align-items-center justify-content-center gap-2">
                        <div class="text-xl text-center"><b>Name : </b><?=$Donor->getFullName()?></div>
                        <div class="text-xl text-center"><b>NIC : </b><?=$Donor->getNIC()?></div>
                        <div class="text-xl text-center"><b>Blood Group : </b><?=$Donor->getBloodGroup()?></div>
                    </div>
                </div>
            </div>
            <div class="d-flex gap-1" style="height: 100px;font-size: larger">
                <button class="btn btn-outline-success text-uppercase" style="font-size: larger;font-weight: bolder" onclick="CompleteDonation()">Complete Donation</button>
                <button class="btn btn-outline-danger text-uppercase" style="font-size: larger;font-weight: bolder" onclick="AbortDonation()">Abort Donation</button>
            </div>
        </div>
    </div>
<?php
else:
    ?>
    <div class="d-flex flex-column justify-content-start bg-white m-1 h-100 w-100">
        <div class="d-flex flex-column align-items-center ">
            <div class="d-flex flex-column  w-100 justify-content-center align-items-center">
                <div class="text-xl w-95 mt-1 text-white bg-dark text-center py-1 px-1">Donor Details - <?=$Donor->getNIC()?></div>
            </div>
            <div class="d-flex w-90 mt-1 justify-content-center align-items-baseline gap-1">
                <div class="d-flex flex-column justify-content-center align-items-center w-40" id="PersonalDetails">
                    <div class="d-flex bg-dark px-2 text-white text-center justify-content-center align-items-center py-1 text-white w-100">Personal Details</div>
                    <div class="d-flex w-90 justify-content-center mt-1 align-items-center">
                        <label for="FullName" class="form-label w-40">Full Name</label>
                        <input type="text" class="form-control border-dark w-60" style="border: 2px solid" id="FullName" value="<?=$Donor->getFullName()?>" disabled>
                    </div>
                    <div class="d-flex w-90 justify-content-center mt-1 align-items-center">
                        <label for="NIC" class="form-label w-40">NIC</label>
                        <input type="text" class="form-control border-dark w-60" style="border: 2px solid" id="NIC" value="<?=$Donor->getNIC()?>" disabled>
                    </div>
                    <div class="d-flex w-90 justify-content-center mt-1 align-items-center">
                        <label for="Age" class="form-label w-40">Age</label>
                        <input type="text" class="form-control border-dark w-60" style="border: 2px solid" id="NIC" value="<?=$Donor->getAge()?> Years" disabled>
                    </div>
                    <div class="d-flex w-90 justify-content-center mt-1 align-items-center">
                        <label for="DOB" class="form-label w-40">Gender</label>
                        <input type="text" class="form-control border-dark w-60" style="border: 2px solid" id="DOB" value="<?=$Donor->getGender()?>" disabled>
                    </div>
                    <div class="d-flex w-90 justify-content-center mt-1 align-items-center">
                        <label for="Address" class="form-label w-40">Address</label>
                        <input type="text" class="form-control border-dark w-60" style="border: 2px solid" id="Address" value="<?=$Donor->getAddress()?>" disabled>
                    </div>

                </div>
                <div class="d-flex flex-column justify-content-center align-items-center w-60" id="MedicalDetails">
                    <div class="d-flex bg-dark px-2 text-white text-center justify-content-center align-items-center py-1 text-white w-100">Medical Details</div>
                    <div class="d-flex w-90 justify-content-center mt-1 align-items-center">
                        <div class="card card-sm">
                            <div class="card-header flex-column gap-1">
                                <i class="fa-solid fa-circle-check fa-3x"></i>
                                <div class="text-center text-xl">Verified User</div>
                            </div>
                        </div>
                        <div class="card card-sm">
                            <div class="card-header flex-column gap-1">
                                <img src="/public/images/icons/BloodType/A+.png" width="52" alt="A+" class="border-radius-10">
                                <div class="text-center text-xl">Blood Type</div>
                            </div>
                        </div>
                        <div class="card card-sm">
                            <div class="card-header flex-column gap-1">
                                <div class="single-chart" style="width: 60%">
                                    <svg viewBox="0 0 36 36" class="circular-chart blue">
                                        <path class="circle-bg"
                                              d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831"
                                        />
                                        <path class="circle"
                                              stroke-dasharray="100, 100"
                                              d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831"
                                        />
                                        <text x="18" y="20.35" class="percentage"><?=$Donor->getTotalSuccessfulDonations()?></text>
                                    </svg>
                                </div>
                                <div class="text-center text-xl">Donations</div>
                            </div>
                        </div>
                        <div class="card card-sm">
                            <div class="card-header flex-column ">
                                <div class="single-chart" style="width: 60%">
                                    <svg viewBox="0 0 36 36" class="circular-chart green">
                                        <path class="circle-bg"
                                              d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831"
                                        />
                                        <path class="circle"
                                              stroke-dasharray="<?=$Donor->getSuccessRate()?>, 100"
                                              d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831"
                                        />
                                        <text x="18" y="20.35" class="percentage"><?=$Donor->getSuccessRate()?>%</text>
                                    </svg>
                                </div>
                                <div class="text-center text-xl">Success Rate</div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex w-90 justify-content-center mt-1 align-items-center">
                        <label for="MedicalCondition" class="form-label w-40">Last Donation Date</label>
                        <input type="text" class="form-control border-dark w-60" style="border: 2px solid" id="MedicalCondition" value="<?=$Donor->getLastDonation()?>" disabled>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex h-100 align-items-center justify-content-center m-2">
            <div class="card card-hover-success cursor border-success" style="border: 3px solid" onclick="StartDonation('<?=$Donor->getID()?>')">
                <div class="card-header flex-column">
                    <img src="/public/icons/timer.svg" alt="A+" class="border-radius-10">
                    <div class="card-title" >Start Blood Retrieving</div>
                </div>
            </div>
            <div class="card card-hover-danger border-danger" style="border: 3px solid"" onclick="RejectDonation('<?=$Donor->getID()?>')">
            <div class="card-header flex-column">
                <img src="/public/icons/cancel.svg" alt="A+" class="border-radius-10">
                <div class="card-title" >Reject Blood Donation</div>
            </div>
        </div>
        <?php
        ?>

    </div>
<?php
endif;
?>

<script>
    <?php

    if (isset($BloodRetrievingStarted)):
    ?>

    const TimeCounter = ()=>{
        const startTime= new Date('<?=/** @var \App\model\Donations\HospitalBloodDonations $Donation */
            $Donation->getDonationAt()?>');
        const CurrentTime = new Date();
        const time = document.querySelector("#timer");
        let seconds = 0;
        let minutes = 0;
        let hours = 0;
        seconds = Math.floor((CurrentTime.getTime() - startTime.getTime())/1000);
        minutes = Math.floor(seconds/60);
        hours = Math.floor(minutes/60);
        seconds = seconds%60;
        minutes = minutes%60;
        hours = hours%60;

        const timeCounter = setInterval(() => {
            seconds++;
            if (seconds === 60){
                seconds = 0;
                minutes++;
            }
            if (minutes === 60){
                minutes = 0;
                hours++;
            }
            time.classList.remove("none");
            time.innerHTML = `${hours<10?`0${hours}`:hours} : ${minutes<10?`0${minutes}`:minutes} : ${seconds<10?`0${seconds}`:seconds}`
        }, 1000);

    }
    window.addEventListener("load",TimeCounter)

    const CompleteDonation = () =>{
        OpenDialogBox({
            id: "CompleteDonation",
            title: "Complete Donation & Store Blood",
            order: 1001,
            titleClass: "bg-success text-white bg-dark",
            content: `
                <div class="d-flex flex-column gap-1">
                    <div class="bg-dark w-100 px-1 py-0-5 text-white text-center">Enter the Blood Packet ID on Packet</div>
                    <div class="form-group">
                        <label for="PacketID" class="form-label w-40">Packet ID</label>
                        <input type="text" class="form-control w-60" id="PacketID" placeholder="Packet ID" style="border-radius: 0;border-color: black">
                    </div>
                    <div class="form-group">
                        <label for="Volume" class="form-label w-40">Volume</label>
                        <input type="number" class="form-control w-60" id="Volume" placeholder="Volume" style="border-radius: 0;border-color: black">
                    </div>
                    <div class="form-group">
                        <label for="BloodGroup" class="form-label w-40">Remarks</label>
                        <textarea class="form-control w-60" id="Remarks" placeholder="Remarks" style="height: 100px" maxlength="100"></textarea>
                    </div>
                </div>
        `,
            successBtnAction : ()=>{
                const url = "/hospital/CompleteDonation";
                const formData = new FormData();
                formData.append("DonorID", "<?=$Donor->getDonorID()?>");
                formData.append("Donation_ID", "<?=$Donation->getDonationID()?>");
                formData.append("Packet_ID", document.getElementById("PacketID").value);
                const Remarks = document.getElementById("Remarks").value;
                let Volume = document.getElementById("Volume").value;
                if (Remarks !== ""){
                    formData.append("Remarks", Remarks);
                }
                // Convert Volume to Float
                Volume = parseFloat(Volume);
                if(isNaN(Volume)){
                    ShowToast({
                        message: "Volume must be a number",
                        type: "error",
                        duration: 3000
                    })
                    return;
                }
                if (Volume <= 0){
                    ShowToast({
                        message: "Volume must be greater than 0",
                        type: "error",
                        duration: 3000
                    })
                    return;
                }
                formData.append("Volume", document.getElementById("Volume").value);

                fetch(url, {
                    method: "POST",
                    body: formData
                })
                    .then((res) => res.json())
                    .then((data) => {
                        console.log(data)
                        if (data.status) {
                            CloseDialogBox("CompleteDonation");
                            ShowToast({
                                message: data.message,
                                type: "success",
                                duration: 3000
                            })
                            setTimeout(()=>{
                                window.location.href='/hospital/dashboard';
                            },3000)
                        } else {
                            ShowToast({
                                message: data.message,
                                type: "error",
                                duration: 3000
                            })
                        }
                    })
            }
        })
    }

    const AbortDonation = () => {
        OpenDialogBox({
            id: "AbortDonation",
            title: "Abort Donation",
            order: 1001,
            content: `
                <div class="d-flex">
                    <div class="d-flex flex-column w-100">
                        <div class="d-flex flex-column w-100 justify-content-center align-items-center gap-1">
                            <div class="form-group">
                                <label for="AbortDonationReason" class="form-label w-40">Reason</label>
                                <select class="form-select w-60" id="AbortDonationReason" style="border-radius: 0;border-color: black" onchange="OtherReason()">
                                    <option value="1">Fits / Seizure</option>
                                    <option value="2">Low blood pressure</option>
                                    <option value="3">High blood pressure</option>
                                    <option value="4">Other</option>
                                </select>
                            </div>
                            <div class="form-group none" id="AbortDonationReasonOtherDiv">
                                <label for="AbortDonationReason" class="form-label w-40">Other Reason</label>
                                <textarea class="form-control w-60" id="AbortDonationReasonOther" placeholder="Other Reason" style="height: 100px" maxlength="100"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            `,

        })
    }
    <?php
    endif;
    ?>
    const StartDonation = (id)=>{
        OpenDialogBox({
            id: "StartDonation",
            title: "Start Blood Retrieving",
            titleClass: "bg-dark text-white px-2 py-1",
            content:`
                <div class="d-flex flex-center gap-1 flex-column">
                    <div class="d-flex"> Are you sure you want to start donation?</div>
                </div>
            `,
            successBtnText: "Start",
            successBtnAction: ()=>{
                StartBloodDonation(id);
            },
            cancelBtnText: "Cancel",
            cancelBtnAction: ()=>{
                CloseDialogBox("StartDonation");
            }
        })
    }
    const StartBloodDonation = (id) =>{
        const url = "/hospital/startBloodDonation";
        const form = new FormData();
        form.append("DonorID",id);
        fetch(url,{
            method: "POST",
            body: form
        }).then(res => res.json())
            .then(data => {
                console.log(data)
                if (data.status === true){
                    window.location.reload();
                }else{

                    ShowToast({
                        title: "Error",
                        message: data.message,
                        type: "danger"
                    })
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                }
            })
    }

    // TODO : Add More select options
    const RejectDonation = (id)=>{
        OpenDialogBox({
            id: "RejectDonation",
            title: "Reject Donation",
            titleClass: "bg-dark text-white px-2 py-1",
            content : `
                <div class="d-flex">
                    <div class="d-flex flex-column w-100">
                        <div class="d-flex flex-column w-100 justify-content-center align-items-center gap-1">
                            <div class="form-group">
                                <label for="AbortDonationReason" class="form-label w-40">Reason</label>
                                <select class="form-select w-60" id="AbortDonationReason" style="border-radius: 0;border-color: black" onchange="OtherReason()">
                                    <option value="1">Fear of Needles</option>
                                    <option value="2">Fainting</option>
                                    <option value="3">High blood pressure</option>
                                    <option value="4">Other</option>
                                </select>
                            </div>
                            <div class="form-group none" id="AbortDonationReasonOtherDiv">
                                <label for="AbortDonationReason" class="form-label w-40">Other Reason</label>
                                <textarea class="form-control w-60" id="AbortDonationReasonOther" placeholder="Other Reason" style="height: 100px" maxlength="100"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
             `,
            successBtnAction : ()=>{
                const AbortDonationReason = document.getElementById("AbortDonationReason");
                const AbortDonationReasonOther = document.getElementById("AbortDonationReasonOther");
                const url = "/hospital/rejectBloodDonation";
                const formData = new FormData();
                formData.append("AbortDonationReason", AbortDonationReason.value);
                if (AbortDonationReason.value === "4") {
                    formData.append("AbortDonationReasonOther", AbortDonationReasonOther.value);
                }
                formData.append("DonorID", "<?=$Donor->getDonorID()?>");
                //formData.append("DonationID", "<?php //=$Donation->getDonationID()?>//");
                fetch(url, {
                    method: "POST",
                    body: formData
                }).then((response) => {
                    return response.json();
                }).then((data) => {
                    if (data.status) {
                        ShowToast({
                            type : 'success',
                            message: data.message
                        })
                        setTimeout(()=>{
                            window.location.href = "/mofficer/take-donation";
                        },2000);
                    } else {
                        ShowToast({
                            type : 'danger',
                            message: data.message
                        })
                    }
                }).catch((error) => {
                    console.log(error)
                })
            }
        })
    }

    const OtherReason = () => {
        const AbortDonationReason = document.getElementById("AbortDonationReason");
        const AbortDonationReasonOther = document.getElementById("AbortDonationReasonOtherDiv");
        if (AbortDonationReason.value === "4") {
            console.log(AbortDonationReason.value)
            AbortDonationReasonOther.classList.remove("none");
        } else {
            AbortDonationReasonOther.classList.add("none");
        }
    }
</script>
