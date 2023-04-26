<?php
/* @var $Donor Donor*/
/* @var $Donation Donation*/

use App\model\Donations\Donation;
use App\model\users\Donor;

//print_r($Donor);
?>
<?php
if (isset($BloodRetrievingStarted)):
    ?>

<div class="bg-dark-0-5 fixed h-100 w-100 top-0 left-0 d-flex align-items-center justify-content-center" style="z-index: 999">
    <div class="d-flex bg-white p-2 flex-column min-h-50 min-w-50 border-radius-10 align-items-center justify-content-center gap-3">
        <div class="w-100 text-center text-xl bg-dark text-white py-1 px-1">Blood Retrieving Started</div>
        <div class="d-flex w-100 justify-content-around gap-2">
            <div class="d-flex flex-column align-items-center justify-content-center gap-2">
                <img src="/public/icons/bloodDonation.gif" alt="bloodDonation" class="" width="400px">
                <div class="d-flex font-bold justify-content-center none" style="font-size: 4rem;" id="timer"> 00 : 00 : 00 </div>
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
<div class="d-flex flex-column bg-white m-1 h-100 w-100">
    <div class="d-flex flex-column align-items-center ">
        <div class="d-flex flex-column  w-100 justify-content-center align-items-center">
            <div class="text-xl w-95 mt-1 text-white bg-dark text-center py-1 px-1">Donor Details - <?=$Donor->getNIC()?></div>
        </div>
        <div class="d-flex w-90 mt-1 justify-content-between gap-1">
            <div class="d-flex flex-column justify-content-center align-items-center w-50" id="PersonalDetails">
                <div class="d-flex bg-dark px-2 text-white text-center justify-content-center align-items-center py-1 text-white w-100">Personal Details</div>
                <div class="d-flex w-90 justify-content-center mt-1 align-items-center">
                    <label for="FullName" class="form-label w-40">Full Name</label>
                    <input type="text" class="form-control w-60" id="FullName" value="<?=$Donor->getFullName()?>" disabled>
                </div>
                <div class="d-flex w-90 justify-content-center mt-1 align-items-center">
                    <label for="NIC" class="form-label w-40">NIC</label>
                    <input type="text" class="form-control w-60" id="NIC" value="<?=$Donor->getNIC()?>" disabled>
                </div>
                <div class="d-flex w-90 justify-content-center mt-1 align-items-center">
                    <label for="DOB" class="form-label w-40">Gender</label>
                    <input type="text" class="form-control w-60" id="DOB" value="<?=$Donor->getGender()?>" disabled>
                </div>
            </div>
            <div class="d-flex flex-column justify-content-center align-items-center w-50" id="MedicalDetails">
                <div class="d-flex bg-dark px-2 text-white text-center justify-content-center align-items-center py-1 text-white w-100">Medical Details</div>
                <div class="d-flex w-90 justify-content-center mt-1 align-items-center">
                    <div class="card card-sm">
                        <div class="card-header flex-column gap-1">
                            <img src="/public/images/icons/verify.png" alt="A+" class="border-radius-10">
                            <div class="text-center text-xl">Verified User</div>
                        </div>
                    </div>
                    <div class="card card-sm">
                        <div class="card-header flex-column gap-1">
                            <img src="/public/images/icons/BloodType/A+.png" alt="A+" class="border-radius-10">
                            <div class="text-center text-xl">Blood Type</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex h-100 align-items-center justify-content-center m-2">
       <div class="card cursor" onclick="StartBloodDonation('<?=$Donor->getID()?>')">
           <div class="card-header flex-column">
               <img src="/public/icons/timer.svg" alt="A+" class="border-radius-10">
               <div class="card-title" >Start Blood Retrieving</div>
           </div>
       </div>
       <div class="card">
           <div class="card-header flex-column">
               <img src="/public/icons/cancel.svg" alt="A+" class="border-radius-10">
               <div class="card-title">Reject Blood Donation</div>
           </div>
       </div>

    </div>
</div>
<?php
endif;
?>

<script>
    <?php
    if (isset($BloodRetrievingStarted)):
        ?>

    const TimeCounter = ()=>{
        const startTime= new Date('<?=$Donation->getStartAt()?>');
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
            content: `

                <div class="d-flex flex-column gap-1">
                    <div class="bg-dark w-100 p-1 text-white text-center">Donation Completed Successfully!</div>
                    <div class="form-group">
                        <label for="PacketID" class="form-label w-40">Packet ID</label>
                        <input type="text" class="form-control w-60" id="PacketID" placeholder="Packet ID" style="border-radius: 0;border-color: black">
                    </div>
                    <div class="form-group">
                        <label for="BloodGroup" class="form-label w-40">Remarks</label>
                        <textarea class="form-control w-60" id="Remarks" placeholder="Remarks" style="height: 100px" maxlength="100"></textarea>
                    </div>
                </div>
        `,
            successBtnAction : ()=>{
                const url = "/mofficer/CompleteDonation";
                const formData = new FormData();
                formData.append("DonorID", "<?=$Donor->getDonorID()?>");
                formData.append("Donation_ID", "<?=$Donation->getDonationID()?>");
                formData.append("Packet_ID", document.getElementById("PacketID").value);
                const Remarks = document.getElementById("Remarks").value;
                if (Remarks !== ""){
                    formData.append("Remarks", Remarks);
                }
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
                            window.location.reload();
                        },3000)
                    } else {
                        ShowToast({
                            message: data.message,
                            type: "error",
                            duration: 3000
                        })
                    }
                }).catch((error) => {
                    console.log(error)
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
            successBtnAction : ()=>{
                const AbortDonationReason = document.getElementById("AbortDonationReason");
                const AbortDonationReasonOther = document.getElementById("AbortDonationReasonOther");
                const url = "/mofficer/AbortDonation";
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
                    return response.text();
                }).then((data) => {
                    if (data.status === "success") {
                        window.location.reload();
                    } else {
                        alert(data.message);
                    }
                }).catch((error) => {
                    console.log(error)
                })
            }
        })
    }
    <?php
    endif;
    ?>
    const StartBloodDonation = (id) =>{
        const url = "/mofficer/startBloodDonation";
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
