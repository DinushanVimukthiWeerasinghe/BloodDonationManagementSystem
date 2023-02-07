<script src="/public/scripts/customAlert.js"></script>
<link href="/public/styles/alert.css" rel="stylesheet">
<?php
/* @var string $firstName */
/* @var string $lastName */

/* @var MedicalOfficer $model */

use App\model\users\MedicalOfficer;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;


$background = new BackGroundImage();
$navbar = new AuthNavbar('Add Medical Officer', '#', '/public/images/icons/user.png');
echo $navbar;
echo $background;
?>
<style>

    .panel {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .profile-picture {
        min-width: 300px;
        /*background: #3a8ace;*/
        min-height: 300px;
        max-height: 300px;
    }
    .profile-picture:hover{
        cursor: pointer;
    }

    .profile-picture img {
        min-height: 300px;
        max-height: 300px;
        min-width: 300px;
        max-width: 300px;
        object-fit: cover;
        border-radius: 50%;
    }
    .centered {
        width: 300px;
        height: 150px;
        border-radius: 0 0 200px 200px;
        background: rgba(0, 0, 0, 0.5);
        color: white;
        /*position: absolute;*/
        top: 50%;
        left: 50%;
        transform: translate(0,-150px);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .centered img{
        min-width: 80px;
        min-height: 80px;
    }

    .upload-text {
        transform: translate(0, -10px);
    }

    .error {
        border: 2px solid #ff0000;
    }
</style>
<link href="/public/css/components/form/index2.css" rel="stylesheet">
<div class="panel">
    <div class="profile-picture" onclick="UploadImage()">
        <img id="blah" src="/public/upload/sample.jpg" alt="">
        <div class="centered">
            <img src="/public/images/icons/camera.png" alt="">
            <div id="uploadText" class="upload-text"
            ">Upload Picture
        </div>
    </div>

</div>

<div class="outer-form">

    <form id="form" action="" method="post" enctype="multipart/form-data">
        <div id="col-1" class="form-column">
            <div class="form-title">Personal Details</div>
            <div class="form-row">
                    <div class="form-entity">
                        <div class="valid">
                            <label for="first name" class="form-label">First Name</label>
                            <input id="first name" class="form-input" required type="text" name="First_Name" value=""
                                   oninvalid="this.setCustomValidity('Enter First Name Name Here')"
                                   oninput="this.setCustomValidity('')">
                            <span class="error-text"></span>
                        </div>
                    </div>
                    <div class="form-entity">
                        <div class="valid">
                            <label for="last name" class="form-label">Last Name</label>
                            <input id="last name" class="form-input" required type="text" name="Last_Name" value=""
                                   oninvalid="this.setCustomValidity('Enter Last Name Name Here')"
                                   oninput="this.setCustomValidity('')">
                            <span class="error-text"></span>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-entity">
                        <div class="valid">
                            <label for="nic" class="form-label">NIC</label>
                            <input id="nic" class="form-input" required type="text" name="NIC" value=""
                                   oninvalid="this.setCustomValidity('Enter NIC Name Here')"
                                   oninput="this.setCustomValidity('')" onchange="DetectGender(this)">
                            <span class="error-text"></span>
                        </div>
                    </div>
                    <div class="form-entity">
                        <div class="valid">
                            <label for="contact no" class="form-label">Mobile No</label>
                            <input id="contact no" class="form-input" required type="text" name="Contact_No" value=""
                                   oninvalid="this.setCustomValidity('Enter Contact No Name Here')"
                                   oninput="this.setCustomValidity('')">
                            <span class="error-text"></span>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-entity">
                        <div class="valid">
                            <label for="gender" class="form-label">Gender</label>
                            <select id="gender" class="form-select " name='Gender'>
                                <option value="" selected disabled hidden>Select Gender</option>>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                            <span class="error-text"></span>
                        </div>
                    </div>
                    <div class="form-entity">
                        <div class="valid">
                            <label for="last name" class="form-label">Nationality</label>
                            <select id="position" class="form-select " name='Nationality'>
                                <option value="" selected disabled hidden>Select Nationality</option>>
                                <option value="Sinhala">Sinhala</option>
                                <option value="English">English</option>
                                <option value="Tamil">Tamil</option>
                            </select>
                            <span class="error-text"></span>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-entity">
                        <div class="valid">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" class="form-input" required type="text" name="Email" value=""
                                   oninvalid="this.setCustomValidity('Enter Email Name Here')"
                                   oninput="this.setCustomValidity('')">
                            <span class="error-text"></span>
                        </div>
                    </div>
                    <div class="form-entity">
                        <div class="valid">
                            <label for="address1" class="form-label">Address 1</label>
                            <input id="address1" class="form-input" required type="text" name="Address1" value=""
                                   oninvalid="this.setCustomValidity('Enter Address1 Name Here')"
                                   oninput="this.setCustomValidity('')">
                            <span class="error-text"></span>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-entity">
                        <div class="valid">
                            <label for="address2" class="form-label">Address 2</label>
                            <input id="address2" class="form-input" required type="text" name="Address2" value=""
                                   oninvalid="this.setCustomValidity('Enter Address2 Name Here')"
                                   oninput="this.setCustomValidity('')">
                            <span class="error-text"></span>
                        </div>
                    </div>
                    <div class="form-entity">
                        <div class="valid">
                            <label for="city" class="form-label">City</label>
                            <input id="city" class="form-input" required type="text" name="City" value=""
                                   oninvalid="this.setCustomValidity('Enter City Name Here')"
                                   oninput="this.setCustomValidity('')">
                            <span class="error-text"></span>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-entity">
                        <a onclick="NextForm()" class="btn">Next</a>
                    </div>
                </div>
                <input type="file" required name="image" id="profImage" style="display:none" onchange="PreviewImage(this)"/>
            </div>
            <div id="col-2" class="hidden form-column">
                <div class="form-title">Branch Details</div>
                <div class="form-row">
                    <div class="form-entity">
                        <div class="valid">
                            <label for="position" class="form-label">Select District</label>
                            <select id="position" class="form-select " name='District'>
                                <option value="" selected disabled hidden>Select District</option>
                                <option value="Colombo">Colombo</option>
                                <option value="Gampaha">Gampaha</option>
                                <option value="Kandy">Kandy</option>
                                <option value="Matara">Matara</option>
                            </select>
                            <span class="error-text"></span>
                        </div>
                    </div>
                    <div class="form-entity">
                        <div class="valid">
                            <!--                            Medical officers, Nursing officers, Public Health Inspectors, Medical Laboratory technologists, junior staff members-->
                            <label for="position" class="form-label">Select Branch</label>
                            <select id="position" class="form-select " name='Branch_ID'>
                                <option value="" selected disabled hidden>Select Branch</option>
                                <option value="BB_01">Nugegoda</option>
                                <option value="BB_01">Kirulapona</option>
                                <option value="BB_01">Kohuwala</option>
                                <option value="BB_01">Maharagama</option>
                                <option value="BB_01">Piliyandala</option>
                            </select>
                            <span class="error-text"></span>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-entity">
                        <div class="valid">
                            <label for="position" class="form-label">Select Position</label>
                            <select id="position" class="form-select " name='Position'>
                                <option value="" selected disabled hidden>Select Position</option>
                                <option value="Medical Officer">Nursing Officer</option>
                                <option value="Doctor">Medical officer</option>
                                <option value="Nurse">Public Health Inspector</option>
                                <option value="Nurse">Medical Laboratory Technologist</option>
                                <option value="Nurse">Junior Staff Member</option>
                            </select>
                            <span class="error-text"></span>
                        </div>
                    </div>
                    <div class="form-entity">
                        <div class="valid">
                            <label for="joined date" class="form-label">Joined Date</label>
                            <input id="joined date" class="form-input select-date form-date" required type="date"
                                   name="Joined_At"
                                   value=>
                            <span class="error-text"></span>
                        </div>
                    </div>
                </div>
                <div class="form-title">Officer Details</div>
                <div class="form-row">
                    <div class="form-entity">
                        <div class="valid">
                            <label for="first name" class="form-label">Registration Number</label>
                            <input id="first name" class="form-input" required type="text" name="Registration_Number" value=""
                                   oninvalid="this.setCustomValidity('Enter First Name Name Here')"
                                   oninput="this.setCustomValidity('')">
                            <span class="error-text"></span>
                        </div>
                    </div>

                    <div class="form-entity">
                        <div class="valid">
                            <label for="joined date" class="form-label">Registration Date</label>
                            <input id="joined date" class="form-input select-date form-date" required type="date" name="Registration_Date"
                                   value=>
                            <span class="error-text"></span>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-entity">
                        <a onclick="PreviousForm()" class="btn">Previous</a>
                    </div>
                    <div class="form-entity">
                        <a class="btn" onclick="SubmitForm()">Submit</a>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

<script src="/public/scripts/demo.js"></script>
<script>
    function DetectGender(input) {
        if (input.value.trim()!==""){
            if(input.value.match(/^([0-9]{9}[x|X|v|V]|[0-9]{12})$/)){
                if (input.value.trim().length===10){
                    if (input.value.trim().charAt(2)<='4') {
                        document.getElementById("gender").selectedIndex = 1
                    }else{
                        document.getElementById("gender").selectedIndex = 2
                    }
                }else{
                    if (input.value.trim().charAt(4)<='4') {
                        document.getElementById("gender").selectedIndex = 1
                    }else{
                        document.getElementById("gender").selectedIndex = 2
                    }
                }
            }
        }
    }

    const SubmitForm=()=>{
        if (ValidateForm(2))
        {
            document.getElementById('form').submit();
        }
    }
    const ValidateForm=(id=1)=>{
        let valid=true;
        let form=document.getElementById('col-'+id);
        let inputs=form.getElementsByTagName('input');
        let selects=form.getElementsByTagName('select');
        for(let i=0;i<inputs.length;i++){
            if(inputs[i].value===''){
                valid=false;
                if (inputs[i].name==='image'){
                    const profImage=document.getElementById('blah');
                    profImage.classList.add('error');
                }
                else{
                    inputs[i].parentElement.getElementsByClassName('error-text')[0].innerHTML='This field is required';
                }

            }else{
                const regexphone=/^(?:0|94|\+94)?(?:(0|2|3|4|5|7|9)|7(0|1|2|4|5|6|7|8)\d)\d{6}$/;
                if (inputs[i].name==='image'){
                    const profImage=document.getElementById('blah');
                    profImage.classList.remove('error');
                }else if (inputs[i].name==='NIC' && !inputs[i].value.match(/^([0-9]{9}[x|X|v|V]|[0-9]{12})$/)){
                        valid=false;
                        console.log("NIC error")
                        inputs[i].parentElement.getElementsByClassName('error-text')[0].innerHTML='NIC is invalid';
                }else if (inputs[i].name==='Contact_No' && !inputs[i].value.match(regexphone)){
                        valid=false;
                        console.log("Contact_No error")
                        inputs[i].parentElement.getElementsByClassName('error-text')[0].innerHTML='Enter valid Mobile No';
                }else{
                    inputs[i].parentElement.getElementsByClassName('error-text')[0].innerHTML='';
                }

            }
        }
        for(let i=0;i<selects.length;i++){
            if(selects[i].value===''){
                valid=false;
                selects[i].parentElement.getElementsByClassName('error-text')[0].innerHTML='This field is required';
            }else{
                selects[i].parentElement.getElementsByClassName('error-text')[0].innerHTML='';
            }
        }
        return valid;
    }
    function UploadImage(){
        const InputFile = document.getElementById('profImage');
        InputFile.click();
    }
    col=1;
    function NextForm(){
        if (ValidateForm(col))
        {
            const Column = document.getElementById("col-"+col);
            const NextColumn = document.getElementById("col-"+(col+1));
            if(NextColumn){
                Column.classList.add("hidden");
                NextColumn.classList.remove("hidden");
                col++;
            }
        }




    }
    function PreviousForm(){
        const Column = document.getElementById("col-"+col);
        const PreviousColumn = document.getElementById("col-"+(col-1));
        if(PreviousColumn){
            Column.classList.add("hidden");
            PreviousColumn.classList.remove("hidden");
            col--;
        }
    }
    function PreviewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                const Image = document.getElementById('blah');
                Image.src = e.target.result;
                const UploadText = document.getElementById('uploadText');
                UploadText.innerHTML = "Change Image";
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

</body>
</html>
