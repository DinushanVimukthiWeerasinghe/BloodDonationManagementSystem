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


<div class="d-flex flex-column w-60 bg-white border-radius-5 gap-1 m-1 p-2">
    <div class="bg-dark py-1 px-2 text-center text-white font-bold text-xl">
        Donor Registration
    </div>
    <form action="" class="d-flex flex-column gap-1" method="post" enctype="multipart/form-data">
        <div class="d-flex flex-center border-radius-10">
            <img id="imgPreview" src="" class="none border-radius-50" width="300px" height="300px" style="object-fit: cover" alt="">
            <div id="UploadThumbnail" class="d-flex flex-column gap-1 flex-center border-radius-10 bg-dark text-white font-bold text-xl cursor" style="width: 300px; height: 300px" onclick="UploadImage()">
                <i class="fa-regular fa-image" style="font-size: 4.5rem"></i>
                Upload Profile Picture
            </div>
            <input type="file" accept="image/*" id="profile-image" name="ProfileImage" hidden>
            <input type="hidden" id="userID" name="uid" value="<?=$uid?>" hidden>
        </div>
        <div class="d-flex gap-2 w-100 flex-center">
            <div class="d-flex flex-center w-50">
                <label for="firstName" class="w-40">First Name</label>
                <input type="text" name="First_Name" id="FirstName" class="w-60 border-2 border-dark text-center" placeholder="First Name" required/>
            </div>
            <div class="d-flex flex-center w-50">
                <label for="lastName" class="w-40">Last Name</label>
                <input type="text" name="Last_Name" id="lastName" class="w-60 border-2 border-dark text-center" placeholder="Last Name" required/>
            </div>
        </div>
        <div class="d-flex gap-2 w-100 flex-center">
            <div class="d-flex flex-center w-50">
                <label for="NIC" class="w-40">NIC</label>
                <input type="text" name="NIC" id="NIC" class="w-60 border-2 border-dark text-center" placeholder="NIC" required/>
            </div>
            <div class="d-flex flex-center w-50">
                <label for="email" class="w-40">Email</label>
                <input type="text" name="Email" id="email" class="w-60 border-2 border-dark text-center" value="<?=$email?>" placeholder="Email" disabled/>
            </div>
        </div>
        <div class="d-flex gap-2 w-100 flex-center">
            <div class="d-flex flex-center w-50">
                <label for="address1" class="w-40">Address Line 1</label>
                <input type="text" name="Address1" id="address1" class="w-60 border-2 border-dark text-center" placeholder="Address Line 1" required/>
            </div>
            <div class="d-flex flex-center w-50">
                <label for="address2" class="w-40">Address Line 2</label>
                <input type="text" name="Address2" id="address2" class="w-60 border-2 border-dark text-center" placeholder="Address Line 2" required/>
            </div>
        </div>
        <div class="d-flex gap-2 w-100 flex-center">
            <div class="d-flex flex-center w-50">
                <label for="city" class="w-40">City</label>
                <input type="text" name="City" id="city" class="w-60 border-2 border-dark text-center" placeholder="City" required/>
            </div>
            <div class="d-flex flex-center w-50">
                <label for="Nearest_Bank" class="w-40">Nearest Blood Bank</label>
                <select id="Nearest_Bank" name="Nearest_Bank" class="w-60 border-2 border-dark text-center form-select" required>
                    <option value="BB_01">Bank 1</option>
                    <option value="BB_02">Bank 2</option>
                    <option value="BB_03">Bank 3</option>
                    <option value="BB_04">Bank 4</option>
                </select>
            </div>
        </div>
        <div class="d-flex gap-2 w-100 flex-center">
            <div class="d-flex flex-center w-50">
                <label for="contactNumber" class="w-40">Contact Number</label>
                <input type="text" name="Contact_No" id="contactNumber" class="w-60 border-2 border-dark text-center" placeholder="Contact Number" required/>
            </div>
            <div class="d-flex flex-center w-50">
                <label for="nationality" class="w-40">Nationality </label>
                <select id="nationality" name="Nationality" class="w-60 border-2 border-dark text-center form-select" required>
                    <option value="Sinhala">Sinhala</option>
                    <option value="Tamil">Tamil</option>
                    <option value="Muslim">Muslim</option>
                    <option value="Other">Other</option>
                </select>
            </div>
        </div>
        <div class="d-flex gap-2 w-100 flex-center">
            <button type="submit" class="btn btn-success d-flex gap-1 flex-center" style="font-size: 1.5rem;padding: 0.5rem 2rem">
                <i class="fa-solid fa-check"></i>
                <span>Complete Profile</span>
            </button>
        </div>
    </form>
</div>

<script>
    const UploadImage = ()=>{
        const inputImage = document.getElementById("profile-image");
        inputImage.click();
        inputImage.addEventListener("change",()=>{
            const imagePreview = document.getElementById("imgPreview");
            const UploadThumbnail = document.getElementById("UploadThumbnail");
            const image = inputImage.files[0];
            const reader = new FileReader();
            reader.onload = function (e) {
                imagePreview.src = e.target.result;
                imagePreview.classList.remove("none");
                UploadThumbnail.classList.add("none");
                // Refresh the image preview
                // $('#blah').attr('src', e.target.result);
            }

            reader.readAsDataURL(image);
        })
    }
</script>