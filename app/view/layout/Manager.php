<?php

use App\view\components\ResponsiveComponent\Alert\FlashMessage;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;

$navbar = new AuthNavbar('Manager Board', '/manager', '/public/images/icons/user.png', true,false );
$background = new BackGroundImage();
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
    <script src="/public/scripts/index.js"></script>
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
        <div class="d-flex p-1 w-100 align-items-center text-xl cursor" id="dashboard" onclick="Redirect('/manager/dashboard')">
            <img src="/public/icons/dashboard.svg" class="mr-1" width="24px" alt="" data-tooltip="Dashboard" data-tooltip-position="top">
            <span>Dashboard</span>
        </div>
        <div class="d-flex p-1 w-100 align-items-center text-xl cursor" id="mngCampaigns" onclick="Redirect('/manager/mngCampaigns')">
            <img src="/public/icons/campaign.png" class="mr-1" width="24px" alt="">
            <span>Campaigns</span>
        </div>
        <div class="d-flex p-1 w-100 align-items-center text-xl cursor" id="mngSponsorship" onclick="Redirect('/manager/mngSponsorship')">
            <img src="/public/icons/dollar-sign.svg" class="mr-1" width="24px" alt="">
            <span>Sponsorship</span>
        </div>
        <div class="d-flex w-100 p-1 align-items-center text-xl cursor" id="mngRequests" onclick="Redirect('/manager/mngRequests')">
            <img src="/public/icons/requests.png" class="mr-1" width="24px" alt="">
            <span>Requests</span>
        </div>
        <div class="d-flex p-1 w-100 align-items-center text-xl cursor" id="mngDonors" onclick="Redirect('/manager/mngDonors')">
            <img src="/public/icons/donor.png" class="mr-1" width="24px" alt="">
            <span>Donors</span>
        </div>
        <div class="d-flex p-1 w-100  align-items-center text-xl cursor" id="mngSponsors" onclick="Redirect('/manager/mngSponsors')">
            <img src="/public/icons/sponsors.png" class="mr-1" width="24px" alt="">
            <span>Sponsors</span>
        </div>
        <div class="d-flex p-1 w-100  align-items-center text-xl cursor" id="mngMedicalOfficer" onclick="Redirect('/manager/mngMedicalOfficer')">
            <img src="/public/icons/MedicalOfficer.png" class="mr-1" width="24px" alt="">
            <span>Officers</span>
        </div>

        <div class="d-flex p-1 w-100 align-items-center text-xl cursor" id="mngReport" onclick="Redirect('/manager/mngReport')">
            <img src="/public/icons/file-text.svg" class="mr-1" width="24px" alt="">
            <span>Reports</span>
        </div>


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
    window.addEventListener('load',()=>{
        const path=window.location.href.toString();
        const action = '<?=$Sidelnk();?>';
        const element =document.getElementById(action);
        element.classList.add('bg-primary','border-radius-10','text-white','font-bold','justify-content-center')
        element.getElementsByTagName('img')[0].classList.add('invert-100')
    })
    const getNotification = ()=>{
        const url = '/manager/notification';
        fetch(url,{
            method: 'GET',
        }).then(res=>res.json())
            .then(data=>{
                if(data.status){
                        OpenDialogBox({
                            id: 'notification',
                            title: 'Notification',
                            content: `
                            <div class="d-flex flex-column gap-1">
                                   <div id="notification" class="d-flex flex-column gap-1">
                                        <div class="d-flex flex-column gap-1 overflow-y-scroll max-h-80vh">
                                            ${data.notifications.map(notification=>`
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

                                            `).join('')}
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
</script>
</html>
