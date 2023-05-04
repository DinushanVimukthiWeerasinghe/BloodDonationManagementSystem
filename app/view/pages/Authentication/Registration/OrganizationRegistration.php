<?php
/* @var $role string*/

use App\model\users\User;
use App\view\components\ResponsiveComponent\Alert\FlashMessage;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;
use App\view\components\ResponsiveComponent\NavbarComponent\Navbar;

$navbar= new Navbar([
    'Home'=>'/home',
    'About'=>'/about',
    'Contact Us'=>'/contact',
    'Log In'=>'/login'
],'#','/public/images/icons/user.png','');
echo $navbar;
$background=new BackGroundImage();
echo $background;
FlashMessage::RenderFlashMessages();
?>

<style>

    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    .container{
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        width: 80%;
        height: 80vh;
        padding: 30px;
        margin: 0 15px;
        border-radius: 50px;
        /*box-shadow: 0 5px 10px rgba(0,0,0,0.1);*/
    }
    .container .form-outer{
        border-radius: 50px;
        position: relative;
        padding: 2rem;
        min-height: 70vh;
        min-width: 70vw;
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
    }
    .container .form-outer .form{
        position: absolute;
        background-color: rgba(255,255,255,0.7);
        border-radius: 50px;
        transition: 0.3s ease;
        padding: 2rem;
        min-width: 90%;
    }
    /* .container form .form.first{
        opacity: 0;
        pointer-events: none;
        transform: translateX(100%);
    } */
    .container .form-outer .form.second{
        opacity: 0;
        pointer-events: none;
        transform: translateX(100%);
    }
    .container .form-outer .form.third{
        opacity: 0;
        pointer-events: none;
        transform: translateX(100%);
    }
    .container .form-outer .form.forth{
        opacity: 0;
        pointer-events: none;
        transform: translateX(100%);
    }
    .container .form-outer .form.fifth{
        opacity: 0;
        pointer-events: none;
        transform: translateX(100%);
    }
    .form-outer.secActive .form.second{
        opacity: 1;
        pointer-events: auto;
        transform: translateX(0);
    }
    .form-outer.secActive .form.first{
        opacity: 0;
        pointer-events: none;
        transform: translateX(-100%);
    }
    .form-outer.sec2Active .form.third{
        opacity: 1;
        pointer-events: auto;
        transform: translateX(0);
    }
    .form-outer.sec2Active .form.second{
        opacity: 0;
        pointer-events: none;
        transform: translateX(-100%);
    }
    .form-outer.sec3Active .form.third{
        opacity: 0;
        pointer-events: none;
        transform: translateX(-100%);
    }
    .form-outer.sec3Active .form.forth{
        opacity: 1;
        pointer-events: auto;
        transform: translateX(0);
    }
    .form-outer.sec4Active .form.forth{
        opacity: 0;
        pointer-events: auto;
        transform: translateX(-100%);
    }
    .form-outer.sec4Active .form.fifth{
        opacity: 1;
        pointer-events: auto;
        transform: translateX(0);
    }
    .container .form-outer .title{
        display: block;
        margin-bottom: 8px;
        font-size: 16px;
        font-weight: 500;
        margin: 6px 0;
        color: #333;
    }
    .container .form-outer .fields{
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
    }
    .form-outer .fields .input-field{
        display: flex;
        width: calc(100% / 2 - 15px);
        flex-direction: column;
        margin: 4px 0;
    }
    .input-field label{
        font-size: 12px;
        font-weight: 500;
        color: #2e2e2e;
    }

    .input-field input, select{
        outline: none;
        font-size: 14px;
        font-weight: 400;
        color: #333;
        border-radius: 5px;
        border: 1px solid #aaa;
        padding: 0 15px;
        height: 42px;
        margin: 8px 0;
    }
    .form .buttons{
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        gap: 10px;
    }
    .container .form-outer button, .backBtn{
        display: flex;
        align-items: center;
        justify-content: center;
        height: 45px;
        max-width: 200px;
        width: 100%;
        border: none;
        outline: none;
        color: #fff;
        border-radius: 5px;
        margin: 25px 0;
        background-color: #4070f4;
        transition: all 0.3s linear;
        cursor: pointer;
    }
    .container .form-outer button, .back2Btn{
        display: flex;
        align-items: center;
        justify-content: center;
        height: 45px;
        max-width: 200px;
        width: 100%;
        border: none;
        outline: none;
        color: #fff;
        border-radius: 5px;
        margin: 25px 0;
        background-color: #4070f4;
        transition: all 0.3s linear;
        cursor: pointer;
    }
    .container .form-outer button, .back3Btn{
        display: flex;
        align-items: center;
        justify-content: center;
        height: 45px;
        max-width: 200px;
        width: 100%;
        border: none;
        outline: none;
        color: #fff;
        border-radius: 5px;
        margin: 25px 0;
        background-color: #4070f4;
        transition: all 0.3s linear;
        cursor: pointer;
    }
    .container .form-outer button, .back4Btn{
        display: flex;
        align-items: center;
        justify-content: center;
        height: 45px;
        max-width: 200px;
        width: 100%;
        border: none;
        outline: none;
        color: #fff;
        border-radius: 5px;
        margin: 25px 0;
        background-color: #4070f4;
        transition: all 0.3s linear;
        cursor: pointer;
    }
    .container .form-outer button, .back5Btn{
        display: flex;
        align-items: center;
        justify-content: center;
        height: 45px;
        max-width: 200px;
        width: 100%;
        border: none;
        outline: none;
        color: #fff;
        border-radius: 5px;
        margin: 25px 0;
        background-color: #4070f4;
        transition: all 0.3s linear;
        cursor: pointer;
    }
    .container form .btnText{
        font-size: 14px;
        font-weight: 400;
    }
    .form-outer button:hover{
        background-color: #265df2;
    }

    @media (max-width: 750px) {
        .container .form-outer{
            overflow-y: scroll;
        }
        .container .form-outer::-webkit-scrollbar{
            display: none;
        }
        .form-outer .fields .input-field{
            width: calc(100% / 1 - 15px);
        }
    }

    @media (max-width: 550px) {
        form .fields .input-field{
            width: 100%;
        }
    }

</style>
<div class="container">
    <div class="form-outer">
        <div class="form first w-90">
            <h1 style="font-size: 25pt;" class="bg-dark text-white px-2 py-1">Organization Registration</h1>
            <div class="d-flex flex-column gap-1">
                <h2 class=" my-1 font-bold" >Organization Details</h2>
                    <div class="d-flex flex-column gap-1 w-100 flex-center">
                        <div class="d-flex gap-1 w-100">
                            <div class="d-flex w-50 flex-center">
                                <label for="OrganizationName" class="w-50">Organization Name</label>
                                <input type="text" id="OrganizationName" class="text-center" placeholder="Organization Name">
                            </div>
                            <div class="d-flex d-flex w-50 flex-center">
                                <label for="OrganizationEmail" class="w-50">Organization Email</label>
                                <input type="email" id="OrganizationEmail" class="text-center" placeholder="Organization Email">
                            </div>
                        </div>
                        <div class="d-flex gap-1 w-100">
                            <div class="d-flex w-50 flex-center">
                                <label for="OrganizationPhone" class="w-50">Organization Phone</label>
                                <input type="text" id="OrganizationPhone" class="text-center" placeholder="Organization Phone">
                            </div>
                            <div class="d-flex d-flex w-50 flex-center">
                                <label for="OrganizationRegNo" class="w-50">Registration No</label>
                                <input type="text" id="OrganizationRegNo" class="text-center" placeholder="Organization Registration Number">
                            </div>
                        </div>
                        <div class="d-flex gap-1 w-100 mt-1">
                            <div class="d-flex flex-center gap-1 flex-column w-50 flex-center">
                                <label class="d-flex w-100 justify-content-center" for="OrgAddress">Organization Address</label>
                                <div class="d-flex gap-1 flex-column justify-content-start w-100">
                                    <div class="d-flex flex-center gap-1 w-100">
                                        <label for="OrganizationAddress1" class="w-50">Address Line 1</label>
                                        <input type="text" id="OrganizationAddress1" class="text-center" placeholder="Organization Address 1">
                                    </div>
                                    <div class="d-flex flex-center gap-1 w-100">
                                        <label for="OrganizationAddress2" class="w-50">Address Line 2</label>
                                        <input type="text" id="OrganizationAddress2" class="text-center" placeholder="Organization Address 2">
                                    </div>
                                    <div class="d-flex flex-center gap-1 w-100">
                                        <label for="OrganizationAddress3" class="w-50">Address Line 3</label>
                                        <input type="text" id="OrganizationAddress3" class="text-center" placeholder="Organization Address 3">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <label style="color: red;font-size: 15pt;font-weight: bolder;" id="warning1"></label><br><br>
            <div class="d-flex flex-center">
                <button class="btn nextBtn">
                    <span class="btnText">Next</span>
                </button>
            </div>

        </div>
        <div class="form second">
            <h1 style="font-size: 25pt;" class="bg-dark text-white px-2 py-1">Organization Registration</h1>
            <div class="d-flex flex-column gap-1">
                <h2 class=" my-1 font-bold" >Board Member Details - <b>President</b></h2>
                <div class="d-flex flex-column gap-1 w-100 flex-center">
                    <div class="d-flex gap-1 w-100">
                        <div class="d-flex w-50 flex-center">
                            <label for="PresidentName" class="w-50">Name</label>
                            <input type="text" id="PresidentName" class="text-center" placeholder="President Name">
                        </div>
                        <div class="d-flex d-flex w-50 flex-center">
                            <label for="PresidentEmail" class="w-50"> Email</label>
                            <input type="email" id="PresidentEmail" class="text-center" placeholder="President Email">
                        </div>
                    </div>
                    <div class="d-flex gap-1 w-100">
                        <div class="d-flex w-50 flex-center">
                            <label for="PresidentNIC" class="w-50">NIC</label>
                            <input type="text" id="PresidentNIC" class="text-center" placeholder="President NIC">
                        </div>
                        <div class="d-flex d-flex w-50 flex-center">
                            <label for="PresidentContactNo" class="w-50">Contact No</label>
                            <input type="text" id="PresidentContactNo" class="text-center" placeholder="President Contact No">
                        </div>
                    </div>
                </div>
            </div>
                <label style="color: red;font-size: 15pt;font-weight: bolder;" id="warning2"></label><br><br>
                <div class="buttons d-flex flex-center">
                    <div class="backBtn">
                        <span class="btnText">Back</span>
                    </div>
                    <button class="next2Btn">
                        <span class="btnText">Next</span>
                    </button>
                </div>
        </div>
        <div class="form third">
            <h1 style="font-size: 25pt;" class="bg-dark text-white px-2 py-1">Organization Registration</h1>
            <div class="d-flex flex-column gap-1">
                <h2 class=" my-1 font-bold" >Board Member Details - <b>Secretary</b></h2>
                <div class="d-flex flex-column gap-1 w-100 flex-center">
                    <div class="d-flex gap-1 w-100">
                        <div class="d-flex w-50 flex-center">
                            <label for="SecretaryName" class="w-50">Name</label>
                            <input type="text" id="SecretaryName" class="text-center" placeholder="Secretary Name">
                        </div>
                        <div class="d-flex d-flex w-50 flex-center">
                            <label for="SecretaryEmail" class="w-50"> Email</label>
                            <input type="email" id="SecretaryEmail" class="text-center" placeholder="Secretary Email">
                        </div>
                    </div>
                    <div class="d-flex gap-1 w-100">
                        <div class="d-flex w-50 flex-center">
                            <label for="SecretaryNIC" class="w-50">NIC</label>
                            <input type="text" id="SecretaryNIC" class="text-center" placeholder="Secretary NIC">
                        </div>
                        <div class="d-flex d-flex w-50 flex-center">
                            <label for="SecretaryContactNo" class="w-50">Contact No</label>
                            <input type="text" id="SecretaryContactNo" class="text-center" placeholder="Secretary Contact No">
                        </div>
                    </div>
                </div>
            </div>
                <label style="color: red;font-size: 15pt;font-weight: bolder;" id="warning3"></label><br><br>
                <div class="buttons d-flex flex-center">
                    <div class="back2Btn">
                        <span class="btnText">Back</span>
                    </div>
                    <button class="next3Btn">
                        <span class="btnText">Next</span>
                    </button>
                </div>
        </div>
        <div class="form forth">
            <h1 style="font-size: 25pt;" class="bg-dark text-white px-2 py-1">Organization Registration</h1>
            <div class="d-flex flex-column gap-1">
                <h2 class=" my-1 font-bold" >Board Member Details - <b>Treasurer</b></h2>
                <div class="d-flex flex-column gap-1 w-100 flex-center">
                    <div class="d-flex gap-1 w-100">
                        <div class="d-flex w-50 flex-center">
                            <label for="TreasurerName" class="w-50">Name</label>
                            <input type="text" id="TreasurerName" class="text-center" placeholder="Treasurer Name">
                        </div>
                        <div class="d-flex d-flex w-50 flex-center">
                            <label for="TreasurerEmail" class="w-50"> Email</label>
                            <input type="text" id="TreasurerEmail" class="text-center" placeholder="Treasurer Email">
                        </div>
                    </div>
                    <div class="d-flex gap-1 w-100">
                        <div class="d-flex w-50 flex-center">
                            <label for="TreasurerNIC" class="w-50">NIC</label>
                            <input type="text" id="TreasurerNIC" class="text-center" placeholder="Treasurer NIC">
                        </div>
                        <div class="d-flex d-flex w-50 flex-center">
                            <label for="TreasurerContactNo" class="w-50">Contact No</label>
                            <input type="text" id="TreasurerContactNo" class="text-center" placeholder="Treasurer Contact No">
                        </div>
                    </div>
                </div>
            </div>
                <label style="color: red;font-size: 15pt;font-weight: bolder;" id="warning4"></label><br><br>
                <div class="buttons d-flex flex-center">
                    <div class="back3Btn">
                        <span class="btnText">Back</span>
                    </div>
                    <button class="next4Btn">
                        <span class="btnText">Next</span>
                    </button>
                </div>
            <label style="color: red;font-size: 15pt;font-weight: bolder;" id="warning5"></label><br><br>
        </div>
        <div class="form fifth">
            <h1 style="font-size: 25pt;" class="bg-dark text-white px-2 py-1">Organization Registration</h1>
            <div class="d-flex flex-column gap-1">
                <h2 class=" my-1 font-bold" >Organization Bank Account Details (Optional)</h2>
                <div class="d-flex flex-column gap-1 w-100 flex-center">
                    <div class="d-flex gap-1 w-100">
                        <div class="d-flex w-50 flex-center">
                            <label for="BankName" class="w-50">Bank Name</label>
                            <input type="text" id="BankName" class="text-center" placeholder="Treasurer Name">
                        </div>
                        <div class="d-flex d-flex w-50 flex-center">
                            <label for="BankBranch" class="w-50"> Branch Name</label>
                            <input type="text" id="BankBranch" class="text-center" placeholder="Treasurer Email">
                        </div>
                    </div>
                    <div class="d-flex gap-1 w-100">
                        <div class="d-flex w-50 flex-center">
                            <label for="BankAccountNo" class="w-50">Account No</label>
                            <input type="text" id="BankAccountNo" class="text-center" placeholder="Bank Account No">
                        </div>
                        <div class="d-flex d-flex w-50 flex-center">
                            <label for="BankAccountHolderName" class="w-50">Account Holder Name</label>
                            <input type="text" id="BankAccountHolderName" class="text-center" placeholder="Account Holder Name">
                        </div>
                    </div>
                </div>
            </div>
                <label style="color: red;font-size: 15pt;font-weight: bolder;" id="warning6"></label><br><br>
                <div class="buttons d-flex flex-center">
                    <div class="back4Btn">
                        <span class="btnText">Back</span>
                    </div>
                    <button class="submitBtn" type="submit">
                        <span class="btnText">Register</span>
                    </button>
                </div>
        </div>
    </div>
</div>
<script>
    let Accepted = false;
    const form = document.querySelector(".form-outer"),
        nextBtn = form.querySelector(".nextBtn"),
        next2Btn = form.querySelector(".next2Btn"),
        next3Btn = form.querySelector(".next3Btn"),
        next4Btn = form.querySelector(".next4Btn"),
        submitBtn = form.querySelector(".submitBtn"),
        backBtn = form.querySelector(".backBtn"),
        back2Btn = form.querySelector(".back2Btn"),
        back3Btn = form.querySelector(".back3Btn"),
        back4Btn = form.querySelector(".back4Btn"),
        back5Btn = form.querySelector(".back5Btn"),
        all1Input = form.querySelectorAll(".first input");
        all2Input = form.querySelectorAll(".second input");
        all3Input = form.querySelectorAll(".third input");
        all4Input = form.querySelectorAll(".forth input");
        all5Input = form.querySelectorAll(".fifth input");
    const validateEmail = (email) => {
        const regEx = /\S+@\S+\.\S+/;
        return regEx.test(email);
    }

    nextBtn.addEventListener("click", ()=> {
        let count = 0;
        let error = false;
        let errorMessages = [];
        all1Input.forEach(input => {
            if(input.value.trim() === ""){
                count = count+1;
            }
        //     Check whether input is email or not
            if(input.type === "email"){
                if(!validateEmail(input.value)){
                    error = true;
                    errorMessages.push("Please enter a valid email address");
                }
            }
        })
        if (error){
            for (let i = 0; i < errorMessages.length; i++){
                ShowToast({
                    title: "Error",
                    message: errorMessages[i],
                    type: "danger",
                    duration: 3000
                })
            }
        }
        if(count === 0){
            if (!Accepted){
                OpenDialogBox({
                    id: "RulesAndRegulation",
                    title: "Rules And Regulation",
                    titleClass: "bg-dark text-white",
                    content:`
                <div class="d-flex flex-column">
                    <span>
                        The Details of President , Secretary and Treasurer of the Organization must be required to register in the system.
                    </span>
                    <span>
                    <ul>
                        <li> Board Members are responsible for the activities of the Organization.</li>
                        <li> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod, soluta.</li>
                    </span>
                </div>
            `,
                    successBtnText : "I Agree",
                    cancelBtnText : "I Disagree",
                    successBtnAction : ()=>{
                        CloseDialogBox("RulesAndRegulation");
                        form.classList.add('secActive');
                        Accepted = true;
                    },
                    cancelBtnAction : ()=>{
                        CloseDialogBox("RulesAndRegulation");
                        ShowToast({
                            type: "danger",
                            message: "You must agree to the rules and regulations to register in the system to continue."
                        })
                        setTimeout(()=>{
                            window.location.href = "/login";
                        }, 3000)
                    }
                })
            }else{
                form.classList.add('secActive');
            }

        }else{
            ShowToast({
                message: "All the Fields are Required.",
                type: "error",
                duration: 3000
            })
        }
    })
    next2Btn.addEventListener("click", ()=> {
        let count = 0;
        all2Input.forEach(input => {
            if(input.value.trim() === ""){
                count = count+1;
                // form.classList.add('sec2Active');
            }
        })
        console.log(count)
        if(count === 0 ){
            form.classList.add('sec2Active');
        }else{
            ShowToast({
                message: "All the Fields are Required.",
                type: "error",
                duration: 3000
            })
        }
    })
    next3Btn.addEventListener("click", ()=> {
        let count = 0;
        all3Input.forEach(input => {
            if(input.value === ""){
                count = count+1;
                // form.classList.add('sec2Active');
            }
        })
        if(count === 0){
            form.classList.add('sec3Active');
        }else{
            ShowToast({
                message: "All the Fields are Required.",
                type: "danger",
                duration: 3000
            })
        }
    })
    next4Btn.addEventListener("click", ()=> {
        let count = 0;
        all4Input.forEach(input => {
            if(input.value === ""){
                count = count+1;
            }
        })
        if(count === 0){
            form.classList.add('sec4Active');
        }else{
            ShowToast({
                message: "All the Fields are Required.",
                type: "danger",
                duration: 3000
            })
        }
    })
    submitBtn.addEventListener("click", ()=> {
        let count = 0;
        all5Input.forEach(input => {
            if(input.value == ""){
                count = count+1;
            }
        })
        // get parameters from url
        const urlParams = new URLSearchParams(window.location.search);
        const OrganizationID = urlParams.get('uid');
        if(count === 0 || count === 4){
            const data = {
                "OrganizationID" : OrganizationID,
                "OrganizationName": document.getElementById("OrganizationName").value,
                "OrganizationEmail": document.getElementById("OrganizationEmail").value,
                "OrganizationPhone": document.getElementById("OrganizationPhone").value,
                "OrganizationAddress1": document.getElementById("OrganizationAddress1").value,
                "OrganizationAddress2": document.getElementById("OrganizationAddress2").value,
                "OrganizationAddress3": document.getElementById("OrganizationAddress3").value,
                "PresidentName": document.getElementById("PresidentName").value,
                "PresidentEmail": document.getElementById("PresidentEmail").value,
                "PresidentPhone": document.getElementById("PresidentContactNo").value,
                "PresidentNIC": document.getElementById("PresidentNIC").value,
                "SecretaryName": document.getElementById("SecretaryName").value,
                "SecretaryEmail": document.getElementById("SecretaryEmail").value,
                "SecretaryPhone": document.getElementById("SecretaryContactNo").value,
                "SecretaryNIC": document.getElementById("SecretaryNIC").value,
                "TreasurerName": document.getElementById("TreasurerName").value,
                "TreasurerEmail": document.getElementById("TreasurerEmail").value,
                "TreasurerPhone": document.getElementById("TreasurerContactNo").value,
                "TreasurerNIC": document.getElementById("TreasurerNIC").value,
                "BankName": document.getElementById("BankName").value,
                "BankBranch": document.getElementById("BankBranch").value,
                "BankAccountNumber": document.getElementById("BankAccountNo").value,
                "BankAccountName": document.getElementById("BankAccountHolderName").value,
            }
            const form = new FormData();
            // Loop through each of object and append it to form data
            for (let key in data) {
                form.append(key, data[key]);
            }

            const url = '/organization/register';
            const options = {
                method: 'POST',
                body: form
            }
            fetch(url, options)
                .then(res => res.json())
                .then(data => {
                    if(data.status){
                        ShowToast({
                            message: "Organization Registered Successfully.",
                            type: "success",
                            duration: 3000
                        })
                        setTimeout(()=>{
                            window.location.href = "/login";
                        }, 3000)
                    }else{
                        ShowToast({
                            message: "Something went wrong.",
                            type: "danger",
                            duration: 3000
                        })
                        setTimeout(()=>{
                            window.location.href = "/login";
                        }, 3000)
                    }
                })
        }else{
            ShowToast({
                message: "All the Fields are Required.",
                type: "danger",
                duration: 3000
            })
        }
    })

    backBtn.addEventListener("click", () => form.classList.remove('secActive'));
    back2Btn.addEventListener("click", () => form.classList.remove('sec2Active'));
    back3Btn.addEventListener("click", () => form.classList.remove('sec3Active'));
    back4Btn.addEventListener("click", () => form.classList.remove('sec4Active'));
</script>
</html>
