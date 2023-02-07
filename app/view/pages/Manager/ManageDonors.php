<?php

use App\view\components\ResponsiveComponent\Alert\FlashMessage;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;

$navbar= new AuthNavbar('Manage Donors','/manager','/public/images/icons/user.png',true,false);
echo $navbar;
$background=new BackGroundImage();
echo $background;
FlashMessage::RenderFlashMessages();
?>
<div class="class-pane bg-black-0-3 p-1 border-radius-6 flex-wrap min-w-40 max-w-55 w-85 d-flex justify-content-center ">
    <div class="card nav-card" onclick="SearchDonorByNIC()">
        <div class="card-header">
            <img src="/public/images/icons/SearchUser.png" alt="">
            <div class="header-title">Search Donor</div>
        </div>
    </div>
    <div class="card nav-card" onclick="DeactivateDonorByNIC()">
        <div class="card-header nav">
            <img src="/public/images/icons/UnavailableUser.png" alt="">
            <div class="header-title">Deactivate Donors</div>
        </div>
    </div>
    <div class="card nav-card" onclick="DisabledDonor()">
        <div class="card-header">
            <img src="/public/images/icons/QuestionedUser.png" alt="">
            <div class="header-title">Disable Donor</div>
        </div>
    </div>
    <div class="card nav-card" onclick="ReportedDonors()">
        <div class="card-header">
            <img src="/public/images/icons/ReportUser.png" alt="">
            <div class="header-title">Reported Donor</div>
        </div>
    </div>
    <div class="card nav-card" onclick="InformDonors()">
        <div class="card-header">
            <img src="/public/images/icons/InformUser.png" alt="">
            <div class="header-title">Inform Donor</div>
        </div>
    </div>
<!--    TODO Remove IF not needed Verify Donor-->
    <div class="card nav-card" onclick="VerifyDonors()">
        <div class="card-header">
            <img src="/public/images/icons/VerifiedUser.png" alt="">
            <div class="header-title">Verify Donor</div>
        </div>
    </div>
</div>
<style>
    .class-pane {
        margin-top: 10%;
    }

    @media only screen and (max-width: 500px) {
        .class-pane {
            max-width: 100%;
            width: 98%;
            padding: 0.2rem;
        }

    }
</style>
<script>
    function SearchDonorByNIC() {
        OpenDialogBox({
            id: 'find-donor',
            title: 'Find Donor',
            content: "<label for='Search'>Enter NIC </label><input class='text-center border-radius-6' id='Search' type='text' name='Search'>",
            successBtnAction: () => {
                // Todo : Check whether Donor exist on the particular NIC number
                const SearchText = document.getElementsByName('Search')[0].value;
                if (SearchText.trim() !== '') {
                    const form = new FormData();
                    form.append('nic', SearchText);
                    fetch("/manager/mngDonors/isExist",{
                        method: 'POST',
                        body: form
                    }).then(res => res.json())
                        .then(data => {
                            if(data.status === true){
                                window.location.href = "/manager/mngDonors/find?nic=" + SearchText
                                CloseDialogBox('find-donor');
                            }else{
                                ShowToast({
                                    message : 'Donor Not Found!',
                                    type : 'danger',
                                    timeout :3000
                                })
                                const searchBox = document.getElementById('Search');
                                searchBox.classList.add('border-danger')
                                searchBox.focus();
                            }
                    })
                } else {
                    const searchBox = document.getElementById('Search');
                    searchBox.classList.add('border-danger')
                    searchBox.focus();
                }
            }
        })
    }

    function DeactivateDonorByNIC() {
        OpenDialogBox({
            id: 'deactivate-donor',
            title: 'Deactivate Donor',
            content: "<label for='Search'>Enter NIC </label><input class='text-center border-radius-6' id='Search' type='text' name='Search'>",
            successBtnAction: () => {
                // Todo : Check whether Donor exist on the particular NIC number
                const SearchText = document.getElementsByName('Search')[0].value;
                if (SearchText.trim() !== '') {
                    // window.location.href="/manager/mngDonors/deactivate?nic="+SearchText
                    // View the donor details and ask for confirmation
                    const form = new FormData();
                    form.append('format','json');
                    form.append('nic',SearchText);
                    fetch('/manager/mngDonors/find',{
                        method:'POST',
                        body:form
                    }).then(res=>res.json())
                        .then((data)=>{
                            if (data.status===200){
                                CloseDialogBox('deactivate-donor');
                                OpenDialogBox({
                                    id: 'deactivate-donor-confirm',
                                    popupOrder: 2,
                                    title: 'Deactivate Donor',
                                    content: "<div class='d-flex flex-column'>" +
                                        "<div class='text-center'>Donor Name : "+data.name+"</div>" +
                                        "<div class='text-center'>Donor NIC : "+SearchText+"</div>" +
                                        "<div class='text-center'>Are you sure you want to deactivate this donor?</div>" +
                                        "</div>"
                                    ,
                                    successBtnAction: () => {
                                        // Todo : Check whether Donor exist on the particular NIC number
                                        const SearchText = document.getElementsByName('Search')[0].value;
                                        if (SearchText.trim() !== '') {

                                            window.location.href = "/manager/mngDonors/deactivate?nic=" + SearchText
                                            CloseDialogBox('deactivate-donor-confirm');
                                        } else {
                                            const searchBox = document.getElementById('Search');
                                            searchBox.classList.add(' border-danger')
                                            searchBox.focus();
                                        }
                                        CloseDialogBox('deactivate-donor-confirm');
                                        CloseDialogBox('find-donor');
                                    },
                                    cancelBTNAction: () => {
                                        CloseDialogBox('deactivate-donor-confirm');
                                    }
                                })
                            }
                            else{
                                ShowToast({
                                    message: data.message,
                                    type: 'danger',
                                    timeout: 2000
                                })
                                const searchBox = document.getElementById('Search');
                                searchBox.classList.add('border-danger')
                                searchBox.focus();
                            }
                        })


                } else {
                    const searchBox = document.getElementById('Search');
                    searchBox.classList.add('border-danger')
                    searchBox.focus();
                }
            }
        })

    }

    function DisabledDonor() {
        OpenDialogBox({
            id: 'disabled-donor',
            title: 'Disabled Donor',
            content: "<label for='Search'>Enter NIC </label><input class='text-center border-radius-6' id='Search' type='text' name='Search'>",
            successBtnAction: () => {
                // Todo : Check whether Donor exist on the particular NIC number
                const SearchText = document.getElementsByName('Search')[0].value;
                if (SearchText.trim() !== '') {
                    // window.location.href="/manager/mngDonors/deactivate?nic="+SearchText
                    // View the donor details and ask for confirmation
                    const form = new FormData();
                    form.append('format', 'json');
                    form.append('nic', SearchText);
                    fetch('/manager/mngDonors/find', {
                        method: 'POST',
                        body: form
                    }).then(res => res.json())
                        .then((data) => {
                            if (data.status === 200) {
                                CloseDialogBox('disabled-donor');
                                OpenDialogBox({
                                    id: 'disabled-donor-confirm',
                                    popupOrder: 2,
                                    title: 'Disabled Donor',
                                    content: "<div class='d-flex flex-column'>" +
                                        "<div class='text-center'>Donor Name : " + data.name + "</div>" +
                                        "<div class='text-center'>Donor NIC : " + SearchText + "</div>" +
                                        "<div class='text-center'>Are you sure you want to disabled this donor?</div>" +
                                        "</div>"
                                    ,
                                    successBtnAction: () => {
                                        // Todo : Check whether Donor exist on the particular NIC number
                                        if (SearchText.trim() !== '') {

                                            window.location.href = "/manager/mngDonors/disabled?nic=" + SearchText
                                            CloseDialogBox('disabled-donor-confirm');
                                        } else {
                                            const searchBox = document.getElementById('Search');
                                            searchBox.classList.add(' border-danger')
                                            searchBox.focus();
                                        }
                                        CloseDialogBox('disabled-donor-confirm');
                                        CloseDialogBox('find-donor');
                                    },
                                    cancelBTNAction: () => {
                                        CloseDialogBox('disabled-donor-confirm');
                                    }
                                })
                            } else {
                                ShowToast({
                                    message: data.message,
                                    type: 'danger',
                                    timeout: 2000
                                })
                                const searchBox = document.getElementById('Search');
                                searchBox.classList.add('border-danger')
                                searchBox.focus();
                            }
                        })
                } else {
                    const searchBox = document.getElementById('Search');
                    searchBox.classList.add('border-danger')
                    searchBox.focus();
                }
            }
        })

    }

    function ReportedDonors() {
        window.location.href = "/manager/mngDonors/reportedDonor"
    }

    function InformDonors() {
        window.location.href = "/manager/mngDonors/informDonor"
    }

    function VerifyDonors() {
        window.location.href = "/manager/mngDonors/verify"
    }

</script>

