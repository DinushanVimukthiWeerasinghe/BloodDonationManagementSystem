
<?php
/* @var $Donor Donor*/
/* @var $Campaign Campaign*/
/* @var $Task string*/

use App\model\Campaigns\Campaign;
use App\model\users\Donor;
use Core\Application;

?>
<div class="d-flex absolute align-items-start justify-content-center mt-2 w-100">
    <form action="" method="get">
        <div class="form-group">
            <input type="text" class="form-control w-60" id="search" name="NIC" placeholder="Search by NIC">
            <input type="submit" class="btn btn-outline-info w-60" id="searchBtn" value="Search">
        </div>
    </form>
</div>
<div class="d-flex absolute top-2 right-1 bg-white p-1 flex-column border-radius-10">
    <div class="d-flex"><b>Campaign Name</b> : <?=$Campaign->getCampaignName()?></div>
    <div class="d-flex"><b>Assigned Task</b> : <?=$Task?></div>
</div>
<?php
if(!empty($Donor)):
?>
<div id="info" class="d-flex w-100 m-1 border-radius-10 bg-white h-100 justify-content-center">
    <div class=" mt-4 d-flex flex-column justify-content-start align-items-center w-75 ">

        <div id="DonorDetails" class=" d-flex flex-column justify-content-center align-items-center w-100 my-2">
            <div class="d-flex align-items-center justify-content-center text-center mb-1 w-90 text-xl font-bold bg-dark py-1 text-white">Personal Details</div>
            <div id="PersonalDetails" class="d-flex flex-column gap-1 w-90">
                <div class="form-group">
                    <div class="d-flex justify-content-center align-items-center w-100">
                        <label for="FirstName" class="form-label w-40 w-40">First Name</label>
                        <input type="text" class="form-control w-60 w-60" id="FirstName" placeholder="First Name" value="<?=$Donor->getFirstName()?>" disabled>
                    </div>
                    <div class="d-flex w-100 justify-content-center align-items-center ">
                        <label for="LastName" class="form-label w-40">Last Name</label>
                        <input type="text" class="form-control w-60" id="LastName" placeholder="Last Name" value="<?=$Donor->getLastName()?>" disabled>
                    </div>
                </div>
                <div class="form-group">
                    <div class="d-flex w-100 justify-content-center align-items-center ">
                        <label for="NIC" class="form-label w-40">NIC</label>
                        <input type="text" class="form-control w-60" id="NIC" placeholder="National Identity Card No" value="<?=$Donor->getNIC()?>" disabled>
                    </div>
                    <div class="d-flex w-100 justify-content-center align-items-center ">
                        <label for="ContactNo" class="form-label w-40">Contact No</label>
                        <input type="tel" class="form-control w-60" id="ContactNo" placeholder="Contact No" value="<?=$Donor->getContactNo()?>" disabled>
                    </div>
                </div>
                <div class="form-group">
                    <div class="d-flex w-100 justify-content-center align-items-center ">
                        <label for="Email" class="form-label w-40">Email</label>
                        <input type="email" class=" form-date" id="Email" placeholder="example@mail.com" value="<?=$Donor->getEmail()?>" disabled>
                    </div>
                    <div class="d-flex w-100 justify-content-center align-items-center ">
                        <label for="Address1" class="form-label w-40">Address1</label>
                        <input type="text" class=" form-date" id="Address1" placeholder="No 01" value="<?=$Donor->getAddress1()?>" disabled>
                    </div>
                </div>
                <div class="form-group">
                    <div class="d-flex w-100 justify-content-center align-items-center ">
                        <label for="Email" class="form-label w-40">Address2</label>
                        <input type="text" class=" form-date" id="Email" placeholder="Village / Road" value="<?=$Donor->getAddress2()?>" disabled>
                    </div>
                    <div class="d-flex w-100 justify-content-center align-items-center ">
                        <label for="City" class="form-label w-40">City</label>
                        <input type="text" class=" form-date" id="City" placeholder="City" value="<?=$Donor->getCity()?>" disabled>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-center text-center mb-1 w-90 text-xl font-bold mt-2 bg-dark text-white py-1 px-2">Previous Donation Details</div>
            <div id="PreviousDonation" class="d-flex gap-1 w-90 justify-content-center align-items-center">
                <div class="card card-sm gap-1">
                    <div class="card-header">
                        <div class="text-md text-xl">
                            10
                        </div>
                    </div>
                    <div class="card-body">
                        <div>No Of Donation</div>
                    </div>
                </div>
                <div class="card card-sm gap-1">
                    <div class="card-header">
                        <div class="text-md text-xl">
                            2023 Feb 29
                        </div>
                    </div>
                    <div class="card-body">
                        <div>Last Donation Date</div>
                    </div>
                </div>
                <div class="card card-sm gap-1">
                    <div class="card-header">
                        <div class="text-md text-xl">
                            Colombo
                        </div>
                    </div>
                    <div class="card-body">
                        <div>Recently Donation Place</div>
                    </div>
                </div>
                <div class="card card-sm gap-1">
                    <div class="card-header">
                        <div class="text-md text-xl">
                            150 pints
                        </div>
                    </div>
                    <div class="card-body">
                        <div>Contributed Volume</div>
                    </div>
                </div>

            </div>
            <div class="d-flex mt-2">
                <?php
                if ($Donor->getDonationAvailability() === 1) :
                ?>
                <button class="btn btn-success m-1" style="padding: 0.5rem;font-size: 1rem" onclick="RegisterDonorForCampaign('<?=$Donor->getID()?>','<?=$Campaign->getCampaignID()?>')">Register</button>
                <?php
                endif;
                ?>
                <button class="btn btn-danger m-1" style="padding: 0.5rem;font-size: 1rem" onclick="Cancel()">Cancel</button>
            </div>

        </div>
    </div>
    <div class="d-flex flex-column justify-content-center align-items-center w-25 ">
        <div class="d-flex flex-center flex-column">
            <div class="d-flex bg-dark px-2 py-1 text-center text-white">Donation Availability</div>
            <div class="d-flex flex-column m-1 px-2 py-0-5 text-center text-white border-radius-10 <?=$Donor->getDonationAvailability()===1 ? "bg-success ": "bg-danger"?>">
                <?= $Donor->getDonationAvailability() === 1 ? "Available" : "Not Available"?>
            </div>
        </div>
        <div class="d-flex flex-column m-1">
            <img src="<?=$Donor->getProfileImage();?>" alt="Avatar" class="avatar" width="192px">
            <div class="text-md text-center my-1 font-bold bg-dark text-white py-1">Profile Picture</div>
        </div>
        <div class="d-flex gap-1">
            <div class="d-flex flex-column">
<!--                TODO Donor NIC FRONT AND BACK-->
                <?php
                if($Donor->getNICFront() == null):
                ?>
                <img src="<?=Donor::DEFAULT_NIC_FRONT?>" alt="Avatar" class="avatar" width="200px" height="280px">

                <div class="text-md text-center d-flex flex-center gap-1 cursor my-1 font-bold border-radius-5 bg-dark text-white py-1" onclick="UploadNICFront('<?=$Donor->getID()?>')">
                    <img src="/public/icons/camera.svg" class="invert-100">
                    Upload NIC <br> (Front)
                </div>
                <?php
                else:
                ?>
                <img src="<?=$Donor->getNICFront();?>" alt="Avatar" class="avatar" width="200px" height="280px">
                <div class="text-md text-center my-1 font-bold bg-dark text-white py-1">NIC (Front)</div>
                <?php
                endif;
                ?>
            </div>
            <div class="d-flex flex-column">
                <?php
                if($Donor->getNICBack() == null):
                ?>
                <img src="<?=Donor::DEFAULT_NIC_BACK?>" alt="Avatar" class="avatar" width="200px" height="280px">
                    <div class="text-md d-flex flex-center cursor gap-1 text-center my-1 font-bold bg-dark border-radius-5 text-white py-1" onclick="UploadNICBack('<?=$Donor->getID()?>')">
                    <img src="/public/icons/camera.svg" class="invert-100">
                    Upload NIC <br> (Back)
                </div>
                <?php
                else:
                ?>
                <img src="<?=$Donor->getNICBack();?>"  alt="Avatar" class="avatar" width="200px" height="280px">
                <div class="text-md text-center my-1 font-bold bg-dark text-white py-1">NIC (Back)</div>
                <?php
                endif;
                ?>
            </div>
        </div>
    </div>
</div>
<?php
else:

?>
<div class="d-flex h-100 justify-content-center align-items-center w-100 text-center">
    <div class="card">
        <div class="card-header flex-column gap-0-5">
            <img src="/public/icons/user-check.svg" alt="None"/>
            <div class="text-xl">Search For Donor</div>
            <div class="text-sm">Or</div>
            <button  class="btn btn-outline-success text-xl" onclick="RegisterNewDonor()">Register a New Donor</button>
        </div>
    </div>
</div>
<?php
endif;
?>
<script>
    const Cancel = () => {
        window.location.href = "/mofficer/take-donation";
    }
    const RegisterNewDonor = () =>{
        OpenDialogBox({
            id: "RegisterNewDonor",
            title: "Register New Donor",
            content: `
                 <div id="PersonalDetails" class="d-flex flex-column gap-1 w-100">
                    <div class="text-xl bg-dark py-1 text-white text-center">Personal Details</div>
                    <div class="form-group">
                        <div class="d-flex justify-content-center align-items-center w-100">
                            <label for="FirstName" class="form-label w-40 w-40">First Name</label>
                            <input type="text" class="form-control w-60 w-60" id="RFirstName" placeholder="First Name"  >
                        </div>
                        <div class="d-flex w-100 justify-content-center align-items-center ">
                            <label for="LastName" class="form-label w-40">Last Name</label>
                            <input type="text" class="form-control w-60" id="RLastName" placeholder="Last Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="d-flex w-100 justify-content-center align-items-center ">
                            <label for="NIC" class="form-label w-40">NIC</label>
                            <input type="text" class="form-control w-60" id="RNIC" placeholder="National Identity Card No">
                        </div>
                        <div class="d-flex w-100 justify-content-center align-items-center ">
                            <label for="ContactNo" class="form-label w-40">Contact No</label>
                            <input type="tel" class="form-control w-60" id="RContactNo" placeholder="Contact No" >
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="d-flex w-100 justify-content-center align-items-center ">
                            <label for="Email" class="form-label w-40">Email</label>
                            <input type="email" class=" form-date" id="REmail" placeholder="example@mail.com" >
                        </div>
                        <div class="d-flex w-100 justify-content-center align-items-center ">
                            <label for="Address1" class="form-label w-40">Address1</label>
                            <input type="text" class=" form-date" id="RAddress1" placeholder="No 01" >
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="d-flex w-100 justify-content-center align-items-center ">
                            <label for="Email" class="form-label w-40">Address2</label>
                            <input type="text" class=" form-date" id="RAddress2" placeholder="Village / Road" >
                        </div>
                        <div class="d-flex w-100 justify-content-center align-items-center ">
                            <label for="City" class="form-label w-40">City</label>
                            <input type="text" class=" form-date" id="RCity" placeholder="City" >
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="d-flex w-100 justify-content-center align-items-center ">
                            <label for="Nationality" class="form-label w-40">Nationality</label>
                            <select class="form-select" id="RNationality" name="Nationality">
                                 <option value="Sri Lankan">Sri Lankan</option>
                                 <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="d-flex w-100 justify-content-center align-items-center ">

                        </div>
                    </div>
                    <div class="text-xl bg-dark py-1 text-white text-center">Identity Card Images</div>
                    <div class="form-group">
                        <div class="d-flex w-100 justify-content-center align-items-center ">
                            <label for="NIC_Front" class="form-label w-40">NIC Front</label>
                            <input type="file" accept="image/*" class=" form-date" id="NIC_Front" placeholder="NIC Front" >
                        </div>
                        <div class="d-flex w-100 justify-content-center align-items-center ">
                            <label for="NIC_Back" class="form-label w-40">NIC Back</label>
                            <input type="file" accept="image/*" class=" form-date" id="NIC_Back" placeholder="NIC Back" >
                        </div>
                    </div>
                    <div class="text-xl bg-dark py-1 text-white text-center">Blood Donation Book</div>
                    <div class="form-group">
                        <div class="d-flex w-100 justify-content-center align-items-center ">
                            <label for="BloodDonation_Book_1" class="form-label w-40">1<sup>st</sup> Page</label>
                            <input type="file" accept="image/*" class=" form-date" id="BloodDonation_Book_1" placeholder="Book 1" >
                        </div>
                        <div class="d-flex w-100 justify-content-center align-items-center ">
                            <label for="BloodDonation_Book_2" class="form-label w-40">2<sup>nd</sup> Page </label>
                            <input type="file" accept="image/*" class=" form-date" id="BloodDonation_Book_2" placeholder="Book 2" >
                        </div>
                    </div>
                </div>
            `,
            successBtnText: "Register",
            successBtnAction: () => {
                const FirstName = document.getElementById("RFirstName").value;
                const LastName = document.getElementById("RLastName").value;
                const NIC = document.getElementById("RNIC").value;
                const ContactNo = document.getElementById("RContactNo").value;
                const Email = document.getElementById("REmail").value;
                const Address1 = document.getElementById("RAddress1").value;
                const Address2 = document.getElementById("RAddress2").value;
                const City = document.getElementById("RCity").value;
                // Get NIC Front Image
                const NIC_Front = document.getElementById("NIC_Front").files[0];
                const NIC_Back = document.getElementById("NIC_Back").files[0];
                const BloodDonation_Book_1 = document.getElementById("BloodDonation_Book_1").files[0];
                const BloodDonation_Book_2 = document.getElementById("BloodDonation_Book_2").files[0];
                // Check if all the fields are filled
                if (FirstName === "" || LastName === "" || NIC === "" || ContactNo === "" || Email === "" || Address1 === "" || Address2 === "" || City === "" || NIC_Front === undefined || NIC_Back === undefined ) {
                    ShowToast({
                        title: "Error",
                        message: "Please fill all the fields",
                        type: "danger"
                    })
                } else {
                    const formData = new FormData();
                    formData.append("First_Name", FirstName);
                    formData.append("Last_Name", LastName);
                    formData.append("NIC", NIC);
                    formData.append("Contact_No", ContactNo);
                    formData.append("Email", Email);
                    formData.append("Address1", Address1);
                    formData.append("Address2", Address2);
                    formData.append("City", City);
                    formData.append("NICFront", NIC_Front);
                    formData.append("NICBack", NIC_Back);
                    if (BloodDonation_Book_1 !== undefined) {
                        formData.append("BloodDonationBook_1", BloodDonation_Book_1);
                    }
                    if (BloodDonation_Book_2 !== undefined) {
                        formData.append("BloodDonationBook_2", BloodDonation_Book_2);
                    }
                    fetch("/mofficer/registerDonor", {
                        method: "POST",
                        body: formData
                    })
                        .then(res => res.json())
                        .then(data => {
                            if (data.status){
                                CloseDialogBox();
                                ShowToast({
                                    title: "Success",
                                    message: "Donor Registered Successfully",
                                    type: "success"
                                })
                                window.location.href = "/mofficer/take-donation?NIC="+NIC;
                            } else {
                                CloseDialogBox();
                                ShowToast({
                                    title: "Error",
                                    message: data.message,
                                    type: "danger"
                                })
                            }
                        })
                }
            }

            })
    }

    const RegisterDonorForCampaign = (DonorID,CampaignID)=>{
        const url = "/mofficer/registerDonorForCampaign";
        const formData = new FormData();
        formData.append("DonorID",DonorID);
        formData.append("CampaignID",CampaignID);
        formData.append("Status","1");
        fetch(url,{
            method:"POST",
            body:formData
        })
            .then(res=>res.json())
            .then(data=>{
                if (data.status){
                    window.location.href = "/mofficer/take-donation";
                } else {
                    ShowToast({
                        title:"Error",
                        message:data.message,
                        type:"danger"
                    })
                }
            })
    }

    <?php
        if (isset($Donor) && !$Donor->getNICFront()):
    ?>
    const UploadNICFront = (DonorID)=>{
        const input = document.createElement("input");
        input.type = "file";
        input.accept = "image/*";
        input.onchange = ()=>{
            const file = input.files[0];
            const formData = new FormData();
            formData.append("NICFront",file);
            formData.append("DonorID",DonorID);

            fetch("/mofficer/uploadNICFront",{
                method:"POST",
                body:formData
            })
                .then(res=>res.json())
                .then(data=>{
                    console.log(data)
                    if (data.status){
                        ShowToast({
                            title:"Success",
                            message:"NIC Front Uploaded Successfully",
                            type:"success"
                        })
                        window.location.reload();
                    } else {
                        ShowToast({
                            title:"Error",
                            message:data.message,
                            type:"danger"
                        })
                    }
                })
        }
        input.click();
    }
    <?php
        endif;
    ?>
    <?php
        if (isset($Donor) && !$Donor->getNICBack()):
    ?>
    const UploadNICBack = (DonorID)=>{
        const input = document.createElement("input");
        input.type = "file";
        input.accept = "image/*";
        input.onchange = ()=>{
            const file = input.files[0];
            const formData = new FormData();
            formData.append("NICBack",file);
            formData.append("DonorID",DonorID);

            fetch("/mofficer/uploadNICBack",{
                method:"POST",
                body:formData
            })
                .then(res=>res.json())
                .then(data=>{
                    console.log(data)
                    if (data.status){
                        ShowToast({
                            title:"Success",
                            message:"NIC Back Uploaded Successfully",
                            type:"success"
                        })
                        window.location.reload();
                    } else {
                        ShowToast({
                            title:"Error",
                            message:data.message,
                            type:"danger"
                        })
                    }
                })
        }
        input.click();
    }
    <?php
        endif;
    ?>

</script>
