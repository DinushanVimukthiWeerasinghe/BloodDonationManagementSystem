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


    <link rel="apple-touch-icon" sizes="180x180" href="/public/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/public/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/public/favicon/favicon-16x16.png">
    <link rel="manifest" href="/public/favicon/site.webmanifest">

    <link rel="stylesheet" href="/public/css/framework/utils.css">
    <link rel="stylesheet" href="/public/css/fontawesome/fa.css">

    <link rel="stylesheet" href="/public/css/framework/utils.css">
    <!--    <link rel="stylesheet" href="/public/css/components/cardPane/index.css">-->
    <script src="/public/scripts/index.js"></script>
</head>
<body class="d-flex">

{{content}}
</body>
<script src="/public/js/components/navbar/navbar.js"></script>
<script src="/public/js/components/dialog-box/dialog-box.js"></script>
<script src="/public/js/components/accordion/accordion.js"></script>

<script src="/public/js/components/toasts/toast.js"></script>

<script>
    const getNotification = ()=>{
        const url = '/hospital/notification';
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
            title: 'Hospital Profile',
            titleClass: 'text-center text-white bg-dark px-2 py-1',
            content: `
                <div class="d-flex flex-column gap-1 w-100">
                     <div id="profile" class="d-flex flex-column w-100">
                            <div class="d-flex flex-column flex-center gap-1 max-h-80vh w-100">
                                <div class="d-flex w-100 justify-content-center">
                                    <img id="profileImage" src="<?= $User->getProfileImage()?>" alt="" width=300px height=300px class="border-1 border-radius-50 " style="object-fit:cover"/>
                                 </div>
                                 
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
                                            <div class="d-flex "><?= $User->getEmail() ?></i></div>
                                        </div>
                                         <div class="d-flex w-50 justify-content-center">
                                            <div class="d-flex "><button class="btn btn-outline-danger" onclick="ChangePassword()">Change Password</button></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                       </div>
                </div>
            `,
        })
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
                const url ='/hospital/changePassword';
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