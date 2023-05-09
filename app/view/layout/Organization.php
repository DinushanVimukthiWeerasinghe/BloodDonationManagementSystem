<?php

use App\model\users\Organization;
use Core\Application;
/* @var $User Organization*/
$User = Application::$app->getUser();
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
    <script
            src="https://maps.googleapis.com/maps/api/js?key=<?=$_ENV['MAP_API_KEY'];?>&callback=initMap&v=weekly&libraries=places"
            defer
    ></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="https://kit.fontawesome.com/185eb0391e.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.min.js"></script>

    <!--    <link rel="stylesheet" href="/public/css/components/navbar/navbar.css">-->
    <link rel="stylesheet" href="/public/css/framework/utils.css">
<!--    <link rel="stylesheet" href="/public/css/components/cardPane/index.css">-->
    <script src="/public/scripts/index.js"></script>
</head>
<body>
{{content}}
</body>
<script src="/public/js/components/navbar/navbar.js"></script>
<script src="/public/js/components/dialog-box/dialog-box.js"></script>
<script src="/public/js/components/toasts/toast.js"></script>

<script>
    const getNotification = () => {
        const url = '/organization/notification';
        fetch(url, {
            method: 'POST',
        }).then(res => res.json())
            .then(data => {
                    if (data.status) {
                        OpenDialogBox({
                            id: 'notification',
                            title: 'Notification',
                            titleClass:'bg-dark text-white px-1 py-0-5',
                            content: `
                            <div class="d-flex flex-column gap-1">
                                   <div id="notification" class="d-flex flex-center flex-column gap-1">
                                        <div class="d-flex flex-column gap-1 w-100 overflow-y-scroll max-h-80vh">
                                            ${data.notifications.map(notification => `
                                                        <div class="d-flex flex-column gap-1 border-2 px-1 w-100 py-0-5">
                                                            <div class="d-flex justify-content-between w-100">
                                                                <img src="/public/icons/${notification.Notification_Type === "1" ? "CampaignAssign.svg" : (notification.Notification_Type === "2" ? "TaskComplete.svg" : "TaskAssign.svg")}" alt="" width="24px">
                                                                <div class="text-sm font-bold">${notification.Notification_Title}</div>
                                                                <div class="text-sm">${notification.Notification_Date}</div>
                                                            </div>
                                                            <div class="d-flex justify-content-centerpy-1 text-center   ">
                                                                <div class="text-sm">${notification.Notification_Message}</div>
                                                            </div>
                                                        </div>



                                            `).join('')}
                                            <!--If data.notification is empty - Show no Notification-->
                                            ${data.notifications.length === 0 ? `
                                                <div class="d-flex flex-column px-1 py-0-5">
                                                    <div class="d-flex flex-center text-center">
                                                        <div class="text-sm font-bold">No Notification to Show!</div>
                                                    </div>
                                                </div>
                                            ` : ''}
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

    const getProfile = () => {
        OpenDialogBox({
            id: 'profile',
            title: 'Profile',
            content: `
                <div class="d-flex flex-column gap-1 w-100">
                     <div id="profile" class="d-flex flex-column w-100">
                            <div class="d-flex flex-column flex-center gap-1 max-h-80vh w-100">
                                <div class="d-flex w-100 justify-content-center">
                                    <img id="profileImage" src="<?= $User->getProfileImage()?>" alt="" width=200px height=200px class="border-1 border-radius-50 " style="object-fit:cover"/>

                                 </div>
                                 <button class="btn btn-success d-flex align-items-center font-bold" onclick="ChangeProfileImage()"><span><img src="/public/icons/camera.svg" alt="" width="24px" class="cursor invert-100" onclick="EditProfile()"></span> &nbsp;Change Profile Image</button>
                                <div class="bg-dark w-100 text-center text-white py-0-5 px-1"> Profile Details</div>
                                    <div class="d-flex w-100 align-items-center justify-content-evenly gap-1">
                                         <div class="d-flex w-50 justify-content-center">
                                            <div class="d-flex font-bold"> Organization Name : </div>
                                            <div class="d-flex "><?= $User->getOrganizationName(); ?></div>
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
                                <div class="d-flex align-items-center bg-dark w-100 text-center justify-content-between text-white py-0-5 px-1">
                                    <?php
                                        if ($User->getBankAccount()):
                                    ?>
                                    <div></div>
                                    <?php
                                        endif;
                                    ?>
                                    <div>Bank Details</div>
                                    <?php
                                        if ($User->getBankAccount()):
                                    ?>
                                    <div class="d-flex flex-center cursor" onclick="AddBankDetails(true)"><img src="/public/icons/edit.png" class="invert-100" width=20></div>
                                    <?php
                                        endif;
                                    ?>
                                </div>
                                    <?php
                                        if ($User->getBankAccount()):
                                    ?>
                                    <div class="d-flex w-100 align-items-center justify-content-evenly gap-1">
                                         <div class="d-flex w-50 justify-content-center">
                                            <div class="d-flex font-bold">Bank Name : </div>
                                            <div class="d-flex "> <?= $User->getBankName() ?></div>
                                        </div>
                                        <div class="d-flex w-50 justify-content-center">
                                            <div class="d-flex font-bold">Branch : </div>
                                            <div class="d-flex "> <?= $User->getBranchName() ?></div>
                                        </div>
                                    </div>
                                    <div class="d-flex w-100 align-items-center justify-content-evenly gap-1">
                                         <div class="d-flex w-50 justify-content-center">
                                            <div class="d-flex font-bold">Account Number : </div>
                                            <div class="d-flex "> <?= $User->getBankAccountNo() ?></div>
                                        </div>
                                         <div class="d-flex w-50 justify-content-center">
                                            <div class="d-flex font-bold">Account Holder : </div>
                                            <div class="d-flex "> <?= $User->getBankAccountName() ?></div>
                                        </div>
                                    </div>

                                    <?php
                                        else:
                                    ?>
                                    <div class="d-flex">No Bank Details Found</div>
                                    <div class="d-flex"><button class="btn btn-outline-success" onclick="AddBankDetails()">Add Bank Details</button></div>
                                    <?php
                                        endif;
                                    ?>
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
    const AddBankDetails = (edit=false)=>{
        let BankName ="";
        let BranchName ="";
        let AccountNo ="";
        let AccountName ="";
        <?php
            if ($User->getBankAccount()):
        ?>
        if (edit){
            BankName = "value='<?= $User->getBankName() ?>'";
            BranchName = "value='<?= $User->getBranchName() ?>'";
            AccountNo = "value='<?= $User->getBankAccountNo() ?>'";
            AccountName = "value='<?= $User->getBankAccountName() ?>'";
        }
        <?php
            endif;
        ?>
        OpenDialogBox({
            id: 'addBankDetails',
            title: (edit ? 'Edit' : 'Add') + ' Bank Details',
            titleClass: 'bg-dark text-white py-0-5 px-1 text-center',
            popupOrder: 2,
            content: `
                <div class="d-flex flex-column gap-1 w-100">
                     <div id="addBankDetails" class="d-flex flex-column w-100">
                            <div class="d-flex flex-column flex-center gap-1 max-h-80vh w-100">
                                         <div class="d-flex w-80 align-items-center justify-content-center">
                                            <div class="d-flex font-bold w-40">Bank Name : </div>
                                            <div class="d-flex w-60"><input type="text" id="bankName" ${BankName} class="form-control"></div>
                                        </div>
                                        <div class="d-flex w-80 align-items-center justify-content-center">
                                            <div class="d-flex font-bold w-40">Branch : </div>
                                            <div class="d-flex w-60"><input type="text" id="branchName" ${BranchName} class="form-control"></div>
                                        </div>
                                         <div class="d-flex w-80 align-items-center justify-content-center">
                                            <div class="d-flex font-bold w-40">Account Number : </div>
                                            <div class="d-flex w-60"><input type="text" id="bankAccountNo" ${AccountNo} class="form-control"></div>
                                        </div>
                                         <div class="d-flex w-80 align-items-center justify-content-center">
                                            <div class="d-flex font-bold w-40">Account Holder Name : </div>
                                            <div class="d-flex w-60"><input type="text" id="bankAccountName" ${AccountName} class="form-control"></div>
                                        </div>
                            </div>
                       </div>
                </div>
            `,
            showSuccessButton: true,
            successBtnText: (edit ? 'Update' : 'Add') + ' Bank Details' ,
            successBtnAction: () => {
                const bankName = document.querySelector('#bankName').value;
                const branchName = document.querySelector('#branchName').value;
                const bankAccountNo = document.querySelector('#bankAccountNo').value;
                const bankAccountName = document.querySelector('#bankAccountName').value;

            //     Validate Form
                if (bankName === '' || branchName === '' || bankAccountNo === '' || bankAccountName === ''){
                    ShowToast({
                        title: 'Error',
                        message: 'Please Fill All The Fields',
                        type: 'error'
                    })
                    return;
                }
                const url = '/organization/addBankDetails';
                const formData = new FormData();
                formData.append('bankName',bankName);
                formData.append('branchName',branchName);
                formData.append('bankAccountNo',bankAccountNo);
                formData.append('bankAccountName',bankAccountName);
                fetch(url, {
                    method: 'POST',
                    body: formData
                }).then(response => response.json())
                    .then(data => {
                        console.log(data)
                        if (data.status){
                            ShowToast({
                                title: 'Success',
                                message: 'Bank Details '+ (edit ? 'Update' :'Added') +' Successfully',
                                type: 'success'
                            })
                            setTimeout(()=>{
                                window.location.reload();
                            },1000)
                            CloseDialogBox('addBankDetails');
                            CloseDialogBox('profile');
                        }else{
                            ShowToast({
                                title: 'Error',
                                message: data.message,
                                type: 'error'
                            })
                        }
                    })
            },
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
            const url="/organization/changeProfile";
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