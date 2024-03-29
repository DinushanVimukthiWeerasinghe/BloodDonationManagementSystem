<?php

use App\model\users\Sponsor;
use Core\Application;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;
/* @var $User Sponsor*/
$User = Application::$app->getUser();
$navbar = new AuthNavbar(strtoupper($User->getSponsorName()).' '.'SPONSOR BOARD', '/public/images/icons/user.png', true,false );
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Be Positive</title>
    <meta charset="UTF-8">
    <meta content='width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;' name='viewport' />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="apple-touch-icon" sizes="180x180" href="/public/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/public/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/public/favicon/favicon-16x16.png">
    <link rel="manifest" href="/public/favicon/site.webmanifest">

    <link rel="stylesheet" href="/public/css/framework/utils.css">
    <link rel="stylesheet" href="/public/css/components/cardPane/index.css">
    <script src="/public/scripts/index.js"></script>
</head>
<body>
{{content}}
</body>
<script src="/public/js/components/navbar/navbar.js"></script>
<script src="/public/js/components/dialog-box/dialog-box.js"></script>
<script>
    const getProfile = () => {
    OpenDialogBox({
    id: 'profile',
    title: 'Profile',
    content: `
    <div class="d-flex flex-column gap-1 w-100">
        <div id="profile" class="d-flex flex-column w-100">
            <div class="d-flex flex-column flex-center gap-1 max-h-80vh w-100">
                <div class="d-flex w-100 justify-content-center">
                    <img id="profileImage" src="<?= $User->getProfileImage()?>" alt="" width=300px height=300px class="border-1 border-radius-50 " style="object-fit:cover"/>

                </div>
                <button class="btn btn-success d-flex align-items-center font-bold" onclick="ChangeProfileImage()"><span><img src="/public/icons/camera.svg" alt="" width="24px" class="cursor invert-100" onclick="EditProfile()"></span> &nbsp;Change Profile Image</button>
                <div class="bg-dark w-100 text-center text-white py-0-5 px-1"> Profile Details</div>
                <div class="d-flex w-100 align-items-center justify-content-evenly gap-1">
                    <div class="d-flex w-50 justify-content-center">
                        <div class="d-flex font-bold"> Organization Name : </div>
                        <div class="d-flex "><?= $User->getSponsorName(); ?></div>
                    </div>
                    <div class="d-flex w-50 justify-content-center">
                        <div class="d-flex font-bold">Type : </div>
                        <div class="d-flex "> <?= "NGO" ?></div>
                    </div>
                </div>
                <div class="d-flex w-100 align-items-center justify-content-evenly gap-1">
                    <div class="d-flex w-50 justify-content-center">
                        <div class="d-flex font-bold">Email : </div>
                        <div class="d-flex "> <?= $User->getEmail() ?></div>
                    </div>
                    <div class="d-flex w-50 justify-content-center">
                        <div class="d-flex "><button class="btn btn-outline-danger" onclick="ChangePassword()">Change Password</button></div>
                    </div>
                </div>
                <div class="d-flex w-100 align-items-center justify-content-evenly gap-1">
                    <div class="d-flex w-50 justify-content-center">
                        <div class="d-flex font-bold">Address : </div>
                        <div class="d-flex "> <?= $User->getAddress() ?></div>
                    </div>
                    <div class="d-flex w-50 justify-content-center">
                        <div class="d-flex font-bold">Contact Number : </div>
                        <div class="d-flex "> <?= $User->getContactNo() ?></div>
                    </div>
                </div>

                </div>
            </div>
        </div>
    </div>
    `,
    showSuccessButton: false,
    cancelBtnText: 'Close',
    cancelBtnAction: () => {
    CloseDialogBox('profile');
    }
    })
    }
    const ChangeProfileImage = ()=>{
    const input = document.createElement('input');
    input.type = 'file';
    input.accept = 'image/*';
    input.onchange = _ => {
    // you can use this method to get file and perform respective operations
    let files =   Array.from(input.files);
    console.log(files);
    const url="/sponsor/changeProfile";
    const formData = new FormData();
    formData.append('profileImage',files[0]);
    fetch(url, {
    method: 'POST',
    body: formData
    }).then(response => response.json())
    .then(data => {
    console.log(data)
    if (data.status){
    const profileImage = document.querySelector('#profileImage');
    const NavProfileImage = document.querySelector('#NavProfileImage');
    profileImage.src = data.filename;
    NavProfileImage.src = data.filename;
    ShowToast({
    title: 'Success',
    message: 'Profile Image Changed Successfully',
    type: 'success',
    duration: 3000
    });

    }else{
    ShowToast({
    title: 'Error',
    message: 'Profile Image Change Failed',
    type: 'error',
    duration: 3000
    });
    input.click();
    }

    const ChangePassword = ()=>{
    OpenDialogBox({
    id: 'changePassword',
    title: 'Change Password',
    popupOrder: 1,
    content: `
    <div class="d-flex flex-column gap-1 w-100">
        <div id="changePassword" class="d-flex flex-column gap-1">
            <div class="form-group">
                <label for="oldPassword" class="w-50">Old Password</label>
                <div class="d-flex flex-column w-50">
                    <input type="password" class="form-control w-100" min="8" max="30" id="oldPassword" placeholder="Enter Old Password">
                    <span class="text-danger" style="margin-top: 0.5rem" id="CurrentPasswordError"> </span>
                </div>
            </div>
            <div class="form-group">
                <label for="newPassword" class="w-50">New Password</label>
                <div class="d-flex flex-column w-50">
                    <input type="password" class="form-control w-100" min="8" max="30" id="newPassword" placeholder="Enter New Password">
                    <span class="text-danger" style="margin-top: 0.5rem" id="NewPasswordError"> </span>
                </div>
            </div>
            <div class="form-group">
                <label for="confirmPassword" class="w-50">Confirm Password</label>
                <div class="d-flex flex-column w-50">
                    <input type="password" class="form-control w-100" min="8" max="30" id="confirmPassword" placeholder="Enter Confirm Password">
                    <span class="text-danger" style="margin-top: 0.5rem" id="ConfirmPasswordError"> </span>
                </div>
            </div>
        </div>
    </div>`,
    successBtnText: 'Change Password',
    successBtnAction: ()=>{
    const url ='/user/change-password';
    const oldPassword = document.querySelector('#oldPassword').value;
    const newPassword = document.querySelector('#newPassword').value;
    const confirmPassword = document.querySelector('#confirmPassword').value;
    const formData = new FormData();
    formData.append('CurrentPassword',oldPassword);
    formData.append('NewPassword',newPassword);
    formData.append('ConfirmPassword',confirmPassword);
    fetch(url, {
    method: 'POST',
    body: formData
    }).then(response => response.json())
    .then(data => {
    console.log(data)
    if (data.status){
    ShowToast({
    title: 'Success',
    message: 'Password Changed Successfully',
    type: 'success',
    duration: 3000
    });
    CloseDialogBox('changePassword');
    }else{
    ShowToast({
    title: 'Error',
    message: data.message,
    type: 'danger',
    duration: 3000
    });
    const Filed = data.field;
    const CurrentPasswordInput = document.querySelector('#oldPassword');
    const NewPasswordInput = document.querySelector('#newPassword');
    const ConfirmPasswordInput = document.querySelector('#confirmPassword');

    if (Filed === 'CurrentPassword'){
    CurrentPasswordInput.classList.add('border-danger');
    document.querySelector('#CurrentPasswordError').innerHTML = data.message;
    }else if (Filed === 'NewPassword'){
    NewPasswordInput.classList.add('border-danger');
    document.querySelector('#NewPasswordError').innerHTML = data.message;
    }else if (Filed === 'ConfirmPassword'){
    ConfirmPasswordInput.classList.add('border-danger');
    document.querySelector('#ConfirmPasswordError').innerHTML = data.message;
    }
    }
    })
    }
    })
    }
</script>
</html>