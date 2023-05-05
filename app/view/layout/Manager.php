<?php

use App\model\BloodBankBranch\BloodBank;
use App\model\users\Manager;
use App\view\components\ResponsiveComponent\Alert\FlashMessage;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;
use Core\Application;

$navbar = new AuthNavbar('Manager Board', '/manager', '/public/images/icons/user.png', true,false );
$background = new BackGroundImage();
/** @var Manager $User */
$User = Application::$app->getUser();
$Sidelnk = function () {
    $RequestURI = $_SERVER['REQUEST_URI'];
    if (str_contains($RequestURI, '/manager/mngDonors')) {
        return 'mngDonors';
    } elseif (str_contains($RequestURI, '/manager/mngSponsorship')) {
        return 'mngSponsorship';
    } elseif (str_contains($RequestURI, '/manager/mngMedicalOfficer')) {
        return 'mngMedicalOfficer';
    } elseif (str_contains($RequestURI, '/manager/mngCampaigns')) {
        return 'mngCampaigns';
    } elseif (str_contains($RequestURI, '/manager/mngRequests')) {
        return 'mngRequests';
    }elseif (str_contains($RequestURI,'/manager/dashboard')){
        return 'dashboard';
    }elseif (str_contains($RequestURI,'/manager/mngReport')) {
        return 'mngReport';
    }elseif (str_contains($RequestURI,'/manager/mngSponsors')) {
        return 'mngSponsors';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Be Positive</title>
    <meta charset="UTF-8">
    <meta content='width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;' name='viewport'/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="apple-touch-icon" sizes="180x180" href="/public/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/public/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/public/favicon/favicon-16x16.png">
    <link rel="manifest" href="/public/favicon/site.webmanifest">
    <script
            src="https://maps.googleapis.com/maps/api/js?key=<?=$_ENV['MAP_API_KEY'];?>&callback=initMap&v=weekly&libraries=places"
            defer
    ></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.min.js"></script>
    <link rel="stylesheet" href="/public/css/framework/utils.css">
    <link rel="stylesheet" href="/public/css/fontawesome/fa.css">
    <link rel="stylesheet" href="https://printjs-4de6.kxcdn.com/print.min.css">
    <script src="  https://printjs-4de6.kxcdn.com/print.min.js"></script>
    <script src="/public/scripts/index.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.5.141/pdf.min.js" integrity="sha512-BagCUdQjQ2Ncd42n5GGuXQn1qwkHL2jCSkxN5+ot9076d5wAI8bcciSooQaI3OG3YLj6L97dKAFaRvhSXVO0/Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</head>
<body class="d-flex">
<?= $navbar;?>
<?php FlashMessage::RenderFlashMessages();?>
<!--BreadCrumbs-->

<div id="sidePanel" class="h-90 p-0-5 bg-white-0-3 d-flex align-items-center min-h-92vh absolute w-200px left-0 bottom-0" style="z-index: 989">
    <div class="breadcrumb">
        <div class="breadcrumb-item">
            <a href="/manager/dashboard"><img src="/public/icons/home.svg"> </a>
        </div>
        <div class="breadcrumb-item">
            <a href="/manager/mngRequests" class="d-flex align-items-center justify-content-center font-bold active"><img src="/public/icons/request.svg"><span>Requests</span></a>
        </div>
    </div>
    <div id="SideBarLinks" class="d-flex w-100 flex-column justify-content-center align-items-center gap-1" >
        <?php
        if ($page==='dashboard'):
        ?>
        <div class="d-flex p-1 w-100 align-items-center text-xl cursor bg-primary border-radius-10 text-white font-bold" id="dashboard" onclick="Redirect('/manager/dashboard')">
            <img src="/public/icons/dashboard.svg" class="mr-1 invert-100" width="24px" alt="" data-tooltip="Dashboard" data-tooltip-position="top">
            <span>Dashboard</span>
        </div>
        <?php
            else :
        ?>
        <div class="d-flex p-1 w-100 align-items-center text-xl cursor" id="dashboard" onclick="Redirect('/manager/dashboard')">
            <img src="/public/icons/dashboard.svg" class="mr-1" width="24px" alt="" data-tooltip="Dashboard" data-tooltip-position="top">
            <span>Dashboard</span>
        </div>
        <?php
        endif;
        ?>

        <?php
        if ($page==='mngCampaign'):
        ?>
        <div class="d-flex p-1 w-100 align-items-center text-xl cursor  bg-primary border-radius-10 text-white font-bold" id="mngCampaigns" onclick="Redirect('/manager/mngCampaigns')">
            <img src="/public/icons/campaign.png" class="mr-1 invert-100" width="24px" alt="">
            <span>Campaigns</span>
        </div>
        <?php
        else :
        ?>
        <div class="d-flex p-1 w-100 align-items-center text-xl cursor" id="mngCampaigns" onclick="Redirect('/manager/mngCampaigns')">
            <img src="/public/icons/campaign.png" class="mr-1 " width="24px" alt="">
            <span>Campaigns</span>
        </div>
        <?php
        endif;
        ?>


        <?php
        if ($page==='mngSponsorship'):
        ?>
        <div class="d-flex p-1 w-100 align-items-center text-xl cursor  bg-primary border-radius-10 text-white font-bold " id="mngSponsorship" onclick="Redirect('/manager/mngSponsorship')">
            <img src="/public/icons/sponsorship.png" class="mr-1 invert-100" width="24px" alt="">
            <span>Sponsorship</span>
        </div>
        <?php
        else :
        ?>
        <div class="d-flex p-1 w-100 align-items-center text-xl cursor " id="mngSponsorship" onclick="Redirect('/manager/mngSponsorship')">
            <img src="/public/icons/sponsorship.png" class="mr-1 " width="24px" alt="">
            <span>Sponsorship</span>
        </div>
        <?php
        endif;
        ?>
        <?php
        if ($page==='mngRequest'):
        ?>
        <div class="d-flex w-100 p-1 align-items-center text-xl cursor bg-primary border-radius-10 text-white font-bold" id="mngRequests" onclick="Redirect('/manager/mngRequests')">
            <img src="/public/icons/requests.png" class="mr-1 invert-100" width="24px" alt="">
            <span>Requests</span>
        </div>
        <?php
        else :
        ?>
        <div class="d-flex w-100 p-1 align-items-center text-xl cursor" id="mngRequests" onclick="Redirect('/manager/mngRequests')">
            <img src="/public/icons/requests.png" class="mr-1" width="24px" alt="">
            <span>Requests</span>
        </div>
        <?php
        endif;
        ?>
        <?php
        if ($page==='mngDonor'):
        ?>
        <div class="d-flex p-1 w-100 align-items-center text-xl cursor   bg-primary border-radius-10 text-white font-bold" id="mngDonors" onclick="Redirect('/manager/mngDonors')">
            <img src="/public/icons/donor.png" class="mr-1 invert-100" width="24px" alt="">
            <span>Donors</span>
        </div>
        <?php
        else :
        ?>
        <div class="d-flex p-1 w-100 align-items-center text-xl cursor" id="mngDonors" onclick="Redirect('/manager/mngDonors')">
            <img src="/public/icons/donor.png" class="mr-1" width="24px" alt="">
            <span>Donors</span>
        </div>
        <?php
        endif;
        ?>

        <?php
        if ($page==='mngSponsor'):
        ?>
        <div class="d-flex p-1 w-100  align-items-center text-xl cursor   bg-primary border-radius-10 text-white font-bold" id="mngSponsors" onclick="Redirect('/manager/mngSponsors')">
            <img src="/public/icons/sponsors.png" class="mr-1 invert-100" width="24px" alt="">
            <span>Sponsors</span>
        </div>
        <?php
        else :
        ?>
        <div class="d-flex p-1 w-100  align-items-center text-xl cursor " id="mngSponsors" onclick="Redirect('/manager/mngSponsors')">
            <img src="/public/icons/sponsors.png" class="mr-1" width="24px" alt="">
            <span>Sponsors</span>
        </div>
        <?php
        endif;
        ?>

        <?php
        if ($page==='mngOfficer'):
        ?>
        <div class="d-flex p-1 w-100  align-items-center text-xl cursor  bg-primary border-radius-10 text-white font-bold" id="mngMedicalOfficer" onclick="Redirect('/manager/mngMedicalOfficer')">
            <img src="/public/icons/MedicalOfficer.png" class="mr-1 invert-100" width="24px" alt="">
            <span>Officers</span>
        </div>
        <?php
        else :
        ?>
        <div class="d-flex p-1 w-100  align-items-center text-xl cursor" id="mngMedicalOfficer" onclick="Redirect('/manager/mngMedicalOfficer')">
            <img src="/public/icons/MedicalOfficer.png" class="mr-1" width="24px" alt="">
            <span>Officers</span>
        </div>
        <?php
        endif;
        ?>


        <?php
        if ($page==='mngReport'):
        ?>
        <div class="d-flex p-1 w-100 align-items-center text-xl cursor  bg-primary border-radius-10 text-white font-bold" id="mngReport" onclick="Redirect('/manager/mngReport')">
            <img src="/public/icons/file-text.svg" class="mr-1 invert-100" width="24px" alt="">
            <span>Reports</span>
        </div>
        <?php
        else :
        ?>
        <div class="d-flex p-1 w-100 align-items-center text-xl cursor" id="mngReport" onclick="Redirect('/manager/mngReport')">
            <img src="/public/icons/file-text.svg" class="mr-1" width="24px" alt="">
            <span>Reports</span>
        </div>
        <?php
        endif;
        ?>





    </div>
</div>

    <div class="absolute d-flex justify-content-center" style="top: 8vh;height: 92vh;width: calc(100vw - 200px);max-width: calc(100vw - 200px);left: 200px;background: #f2f2f2" id="Content">
        {{content}}
    </div>
</body>
<script src="/public/js/components/navbar/navbar.js"></script>
<script src="/public/js/components/dialog-box/dialog-box.js"></script>
<script src="/public/js/components/toasts/toast.js"></script>

<script src="/public/js/components/accordion/accordion.js"></script>
<script src="/public/js/manager.js"></script>
<script>
    const getNotification = ()=>{
        const url = '/manager/notification';
        fetch(url,{
            method: 'POST',
        }).then(res=>res.json())
            .then(data=>{
                console.log(data)
                if(data.status){
                        OpenDialogBox({
                            id: 'notification',
                            title: 'Notification',
                            titleClass: 'text-center bg-dark text-white',
                            content: `
                            <div class="d-flex flex-column gap-1">
                                   <div id="notification" class="d-flex flex-column gap-1">
                                        <div class="d-flex flex-column gap-1 overflow-y-scroll max-h-80vh">
                                            ${data.notifications.length>0 ? data.notifications.map(notification=>`
                                                        <div class="d-flex flex-column gap-1 border-2 px-2 py-0-5">
                                                            <div class="d-flex justify-content-between border-bottom-2 py-0-5">
                                                                <img src="/public/icons/${notification.Notification_Type==="1" ?"CampaignAssign.svg":(notification.Notification_Type==="2" ? "TaskComplete.svg" :"TaskAssign.svg")}" alt="" width="24px">
                                                                <div class="text-sm font-bold">${notification.Notification_Title}</div>
                                                                <div class="text-sm">${notification.Notification_Date}</div>
                                                            </div>
                                                            <div class="d-flex justify-content-centerpy-1 text-center   ">
                                                                <div class="text-sm">${notification.Notification_Message}</div>
                                                            </div>
                                                        </div>

                                            `).join('') : `<div class="d-flex justify-content-center align-items-center text-center text-sm">No New Notification</div>`}
                                        </div>
                                   </div>
                            </div>
                        `,
                            showSuccessButton: false,
                            cancelBtnText: 'Close',
                        })
                    }
                }
            )

    }
    const getProfile = ()=>{
        OpenDialogBox({
            id: 'profile',
            title: 'Profile',
            titleClass: 'text-center bg-dark text-white',
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
                                            <div class="d-flex font-bold"> Full Name : </div>
                                            <div class="d-flex "> <?= $User->getFullName() ?></div>
                                        </div>
                                         <div class="d-flex w-50 justify-content-center">
                                            <div class="d-flex font-bold">City : </div>
                                            <div class="d-flex "> <?= $User->getCity() ?></div>
                                        </div>
                                    </div>
                                    <div class="d-flex w-100 align-items-center justify-content-evenly gap-1">
                                         <div class="d-flex w-50 justify-content-center">
                                            <div class="d-flex font-bold">Email : </div>
                                            <div class="d-flex "><?= $User->getEmail() ?></div>
                                        </div>
                                        <div class="d-flex w-50 justify-content-center">
                                            <div class="d-flex font-bold">Contact Number : </div>
                                            <div class="d-flex "><?= $User->getContactNo() ?></div>
                                        </div>

                                    </div>
                                    <div class="d-flex w-100 align-items-center justify-content-evenly gap-1">
                                        <div class="d-flex w-50 justify-content-center">
                                            <div class="d-flex "><button class="btn btn-outline-danger" onclick="ChangePassword()">Change Password</button></div>
                                        </div>

                                    </div>
                                <div class="bg-dark w-100 text-center text-white py-0-5 px-1"> Assigned Blood Bank Details</div>
                                <?php
            /** @var $BloodBank BloodBank*/
            $BloodBank= $User->getBloodBank();
            ?>
                                <div class="d-flex w-100 align-items-center justify-content-evenly gap-1">
                                    <div class="d-flex w-50 justify-content-center">
                                        <div class="d-flex font-bold"> Bank Name : </div>
                                        <div class="d-flex "><?= $BloodBank->getBankName() ?></div>
                                    </div>
                                    <div class="d-flex w-50 justify-content-center">
                                        <div class="d-flex font-bold">City : </div>
                                        <div class="d-flex "><?= $BloodBank->getLocation() ?></div>
                                    </div>
                                </div>
                            </div>
                       </div>
                </div>
            `,
            showSuccessButton: false,
            cancelBtnText: 'Close',
            cancelBtnAction: () => {
                window.location.reload();
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
            const url="/manager/changeProfile";
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
                    }
                })
        };
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
                const url ='/manager/changePassword';
                const oldPassword = document.querySelector('#oldPassword').value;
                const newPassword = document.querySelector('#newPassword').value;
                const confirmPassword = document.querySelector('#confirmPassword').value;
                if (oldPassword.length === 0){
                    document.querySelector('#CurrentPasswordError').innerText = 'Old Password is Required';
                    return;
                }
                if (newPassword.length === 0){
                    document.querySelector('#NewPasswordError').innerText = 'New Password is Required';
                    return;
                }
                if (confirmPassword.length === 0){
                    document.querySelector('#ConfirmPasswordError').innerText = 'Confirm Password is Required';
                    return;
                }
                if (newPassword.length < 8){
                    document.querySelector('#NewPasswordError').innerText = 'Password must be at least 8 characters';
                    return;
                }
                if (newPassword.length > 30){
                    document.querySelector('#NewPasswordError').innerText = 'Password must be at most 30 characters';
                    return;
                }
                if (confirmPassword.length < 8){
                    document.querySelector('#ConfirmPasswordError').innerText = 'Password must be at least 8 characters';
                    return;
                }
                if (confirmPassword.length > 30){
                    document.querySelector('#ConfirmPasswordError').innerText = 'Password must be at most 30 characters';
                    return;
                }
                if (newPassword !== confirmPassword){
                    document.querySelector('#ConfirmPasswordError').innerText = 'Confirm Password is not Matched';
                    return;
                }

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
