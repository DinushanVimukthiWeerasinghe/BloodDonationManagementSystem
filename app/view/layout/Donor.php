
<?php

use App\model\BloodBankBranch\BloodBank;
use App\model\users\Donor;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;

$PageTitle = $BrandTitle ?? "Donor Dashboard";

$navbar = new AuthNavbar($PageTitle, '/mofficer', '/public/images/icons/user.png', true, false);
$background = new BackGroundImage();

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

<!--    <link rel="stylesheet" href="/public/css/components/navbar/navbar.css">-->

    <script
        src="https://maps.googleapis.com/maps/api/js?key=<?=$_ENV['MAP_API_KEY'];?>&callback=initMap&v=weekly&libraries=places"
        defer
    ></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.min.js"></script>
    <link rel="stylesheet" href="/public/css/framework/utils.css">
<!--    <link rel="stylesheet" href="/public/css/components/cardPane/index.css">-->
    <link rel="stylesheet" href="/public/styles/home.css">
    <link rel="stylesheet" href="/public/css/fontawesome/fa.css">
    <script src="/public/scripts/index.js"></script>
</head>
<body>
<?php
echo $navbar;
echo $background;
?>
<!--    <div class="dark-bg"></div>-->

    <?php
    /* @var string $firstName */
    /* @var string $lastName */
    /* @var Donor $User */

//    $background = new BackGroundImage();

//    echo $background;

    ?>
    {{content}}
</body>
<script>
    const getProfile = ()=>{
        OpenDialogBox({
            id: 'profile',
            title: 'Donor Profile',
            titleClass: 'text-center text-white bg-dark px-2 py-1',
            content: `
                <div class="d-flex flex-column gap-1 w-100">
                     <div id="profile" class="d-flex flex-column w-100">
                            <div class="d-flex flex-column flex-center gap-1 max-h-80vh w-100">
                                <div class="d-flex w-100 justify-content-center">
                                    <img id="profileImage" src="<?= $User->getProfileImage()?>" alt="" width=300px height=300px class="border-1 border-radius-50 " style="object-fit:cover"/>
                                 </div>
                                 <button class="btn btn-success d-flex align-items-center font-bold" onclick="ChangeProfileImage()"><span><img src="/public/icons/camera.svg" alt="" width="24px" class="cursor invert-100" onclick="EditProfile()"></span> &nbsp;Change Profile Image</button>

                                <div class="bg-dark d-flex justify-content-center w-100 text-center text-white py-0-5 px-1 relative">
                                    <div class="d-flex flex-center py-0-5"> Profile Details</div>
                                </div>
                                    <div class="d-flex w-100 align-items-center justify-content-evenly gap-1">
                                         <div class="d-flex w-50 justify-content-center">
                                            <div class="d-flex font-bold"> First Name : </div>
                                            <div class="d-flex "><?= $User->getFirstName() ?></div>
                                        </div>
                                         <div class="d-flex w-50 justify-content-center">
                                            <div class="d-flex font-bold">Last Name : </div>
                                            <div class="d-flex "><?= $User->getLastName() ?></div>
                                        </div>
                                    </div>
                                    <div class="d-flex w-100 align-items-center justify-content-evenly gap-1">
                                         <div class="d-flex w-50 justify-content-center">
                                            <div class="d-flex font-bold">Email : </div>
                                            <div class="d-flex "><?= $User->getEmail() ?><i class="ml-1 cursor fa-solid fa-pen" onclick="EditEmail()"></i></div>
                                        </div>
                                         <div class="d-flex w-50 justify-content-center">
                                            <div class="d-flex "><button class="btn btn-outline-danger" onclick="ChangePassword()">Change Password</button></div>
                                        </div>
                                    </div>
                                    <div class="d-flex w-100 align-items-center justify-content-evenly gap-1">
                                         <div class="d-flex w-50 justify-content-center">
                                            <div class="d-flex font-bold">NIC : </div>
                                            <div class="d-flex "><?= $User->getNIC() ?></div>
                                        </div>
                                         <div class="d-flex w-50 justify-content-center">
                                            <div class="d-flex font-bold">Contact Number : </div>
                                            <div class="d-flex "><?= $User->getContactNo() ?><i class="ml-1 cursor fa-solid fa-pen"  onclick="EditContactNo()"></i></div>
                                        </div>
                                    </div>
                                <div class="bg-dark w-100 text-center text-white py-0-5 px-1"> Medical Details</div>
                                <div class="d-flex w-100">
                                    <div class="d-flex flex-column gap-1 w-100">
                                        <div class="d-flex flex-center gap-2 w-100">
                                            <div class="d-flex flex-center w-50 gap-1">
                                                <div class="font-bold"> Blood Group : </div>
                                                <div> A+ </div>
                                            </div>
                                            <div class="d-flex flex-center w-50 gap-1">
                                                <div class="font-bold"> Weight : </div>
                                                <div> 55Kg </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-dark w-100 text-center text-white py-0-5 px-1"> Donation Availability Details</div>
                                <div class="d-flex w-100">
                                    <div class="d-flex flex-column gap-1 w-100">
                                        <div class="d-flex flex-center gap-2 w-100">
                                            <div class="d-flex flex-center w-50 gap-1">
                                                <div class="font-bold"> Availability  : </div>
                                                <div class="bg-success text-sm text-white text-center px-1 py-0-5 border-radius-10"> Available </div>
                                            </div>
                                            <div class="d-flex flex-center w-50 gap-1">
                                                <div class="font-bold"> Available On : </div>
                                                <div class="bg-success w-60text-sm text-white text-center px-1 py-0-5 border-radius-10"> 2023 Jul 4 </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                       </div>
                </div>
            `,
        })
    }

    const EditEmail = ()=>{
        OpenDialogBox({
            id: 'editEmail',
            title: 'Edit Email',
            titleClass: 'text-center text-white bg-dark px-2 py-1',
            popupOrder: 1,
            successBtnText: 'Save',
            content: `
                <div class="d-flex flex-center flex-column gap-1 w-90">
                    <div class="d-flex flex-center w-100">
                        <label for="email" class="font-bold w-40">Previous Email : </label>
                        <input type="email" name="email" id="email" class="border-1 border-radius-10 px-1 w-60" value="<?= $User->getEmail() ?>" disabled>
                    </div>
                    <div class="d-flex flex-center w-100">
                        <label for="email" class="font-bold w-40">New Email : </label>
                        <input type="email" name="email" id="newEmail" class="border-1 border-radius-10 px-1 w-60" value="<?= $User->getEmail() ?>">
                    </div>


                </div>
            `,
            successBtnAction: ()=> {
                // SendEmailChangeOTP
                const url = '/donor/sendEmailChangeOTP'
                const userID = '<?= $User->getID() ?>'
                const newEmail = document.getElementById('newEmail').value
                const formData = new FormData()
                formData.append('Email', newEmail)
                fetch(url,{
                    method: 'POST',
                    body: formData,
                }).then(res=>res.json())
                    .then((data)=>{
                        if (data.status){
                            OpenDialogBox({
                                id: 'otpVerification',
                                title: 'OTP Verification',
                                titleClass: 'text-center text-white bg-dark px-2 py-1',
                                popupOrder: 2,
                                content: `
                        <div class="d-flex flex-center flex-column gap-1 w-90">
                            <div class="d-flex flex-center w-100">
                                <label for="otp" class="font-bold w-40">OTP : </label>
                                <input type="text" name="otp" id="otp" class="border-1 border-radius-10 px-1 w-60">
                            </div>
                        </div>
                    `,
                                successBtnText: 'Verify',
                                successBtnAction: () => {
                                    const url = '/donor/changeEmail'
                                    const otp = document.getElementById('otp').value
                                    const form = new FormData()
                                    form.append('OTP', otp)
                                    fetch(url,{
                                        method: 'POST',
                                        body: form,
                                    }).then(res=>res.json())
                                        .then(data=>{
                                            if (data.success){
                                                ShowToast({
                                                    title: 'Success',
                                                    message: 'Email Changed Successfully',
                                                    type: 'success',
                                                })
                                            }
                                        })
                                }
                            })
                        }

                    })
            }
        })
    }

    const EditContactNo = ()=>{
        console.log('Edit Contact No')
    }

</script>
<script src="/public/js/components/navbar/navbar.js"></script>
<script src="/public/js/components/dialog-box/dialog-box.js"></script>
<script src="/public/js/components/toasts/toast.js"></script>
</html>
