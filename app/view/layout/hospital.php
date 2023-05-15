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

</script>
</html>