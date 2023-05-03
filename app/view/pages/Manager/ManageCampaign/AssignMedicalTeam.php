<?php

/* @var string $firstName */

/* @var string $lastName */
/* @var array $bloodBanks */
/* @var BloodBank $bloodBank */
/* @var MedicalOfficer $AssignedMedicalOfficer */

use App\model\BloodBankBranch\BloodBank;
use App\model\users\MedicalOfficer;
use App\view\components\ResponsiveComponent\Alert\FlashMessage;

//echo new primaryTitle('Manage Medical Officers');
/* @var array $data */
/* @var MedicalOfficer $value */
$getParams = function ($params) {
    $str = '?';
    if (empty($params)) return $str;
    foreach ($params as $key => $value) {
        $str .= $key . '=' . $value . '&';
    }
    return $str;
};


FlashMessage::RenderFlashMessages();
?>

<!--<div id="loader" class="none bg-white absolute w-100 h-100 d-flex justify-content-center align-items-center" style="z-index: 999">-->
<!--    <img src="/public/loading2.svg" alt="" width="100px">-->
<!--</div>-->
<div id="loader" class="bg-white absolute w-100 h-100 d-flex justify-content-center align-items-center m-1 border-radius-10" style="z-index: 999;height: 97%;width: 98%">
    <img src="/public/loading2.svg" alt="" width="100px">
</div>
<div id="MedOfficers" class="d-flex w-60 flex-column align-items-center bg-white p-1 border-radius-10 m-1">
    <div class="d-flex w-100 flex-row">
        <div class="d-flex bg-white-0-7 p-1 text-dark align-items-center w-100 flex-row gap-0-5 justify-content-center flex-center">
            <div id="Search" class="d-flex gap-0-5 align-items-center flex-center">
                <label for="search" class="search">Search </label>
                <input class="form-control" name="search" id="search" onkeyup="SearchAssignOfficer('/manager/mngMedicalOfficer/search-for-team','assign')">
            </div>
        </div>
    </div>
    <div class="d-flex w-100 overflow-y-scroll">
        <table class="w-100 ">
            <thead class="sticky top-0">
            <tr>
                <th class=" bg-white  top-0 sticky left-0">No</th>
                <th class=" bg-white sticky top-0 left-2" style="z-index: 2">Full Name</th>
                <th>NIC</th>
                <th>Email</th>
                <th>Contact No</th>
<!--                <th>Gender</th>-->
                <th>Position</th>
                <th>Nationality</th>
                <th class=" bg-white sticky right-0">Action</th>
            </tr>
            </thead>
            <tbody id="content" class="">

            <?php
            $i=1;
            if (!empty($data)):
//                Create copy of array 100 times and make a new array
                foreach ($data as $value) :
                    $id=$value->getID();
                    $image=$value->getProfileImage();
                    $name=$value->getFullName();
                    $position=$value->getPosition();
                    $NIC=$value->getNIC();
                    $contact=$value->getContactNo();
                    $email=$value->getEmail();
                    $gender=$value->getGender();
                    $nationality=$value->getNationality();
                    ?>
                    <tr class="bg-white-0-7" id="row-<?=$i?>">
                        <td data-label="No " class="bg-white sticky left-0"><?php echo $i ?>.</td>
                        <td data-label="Name" id="name-<?=$id?>" class="font-bold bg-white sticky left-2"><?php echo $name ?></td>
                        <td data-label="NIC" id="nic-<?=$id?>"><?php echo $NIC ?></td>
                        <td data-label="Email" id="email-<?=$id?>"><?php echo $email?></td>
                        <td data-label="Contact No" id="contact-no-<?=$id?>"><?php echo $contact?></td>
                        <td data-label="Position" id="position-<?=$id?>"><?php echo $position ?></td>
                        <td data-label="Nationality" id="nationality-<?=$id?>"><?php echo $nationality?></td>
                        <td class="d-flex justify-content-center gap-1 align-items-center  bg-white sticky right-0">
                            <button id="btn-<?= $id?>" class="text-dark btn gap-0-5 btn-outline-success d-flex align-items-center justify-content-center" onclick="AssignMedicalOfficer('<?php echo $id ?>','<?=$i++?>')" >
                                <img src="/public/icons/checkCircle.svg" width="24px" alt="">
                                <span>Assign</span>
                            </button>
                        </td>
                    </tr>
                <?php endforeach;
            else :?>
                <tr>
                    <td colspan="9" class="text-center">No Data Found</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<div id="AssignTeam-Content" class="d-flex w-40 flex-column align-items-center bg-white p-1 gap-1 border-radius-10 m-1">
    <div class="font-bold text-2xl">Assign Team</div>
        <div class="d-flex flex-column overflow-y-overlay w-100">
            <table class="w-100">
                <thead class="sticky top-0">
                    <tr>
                        <th>Name</th>
                        <th>NIC</th>
                        <th>Position</th>

                        <th class="sticky right-0 bg-white">Action</th>
                    </tr>
                </thead>
                <tbody id="AssignTeam-Content">
                <?php
                if (empty($AssignedMedicalOfficers)):
                ?>
                <tr id="no-data">
                    <td colspan="6" class="text-center">No Data Found</td>
                </tr>
                <?php
                else:
                    foreach ($AssignedMedicalOfficers as $AssignedMedicalOfficer):
                    $NIC=$AssignedMedicalOfficer->getNIC();
                    $email=$AssignedMedicalOfficer->getEmail();
                    $position=$AssignedMedicalOfficer->getPositionOfTeamByCampaignID($Campaign_ID);
                    $Id=$AssignedMedicalOfficer->getID();
                    $name=$AssignedMedicalOfficer->getFullName();

                ?>
                    <tr>

                        <td><?=$name?></td>
                        <td><?=$NIC?></td>
                        <td><?=$position?></td>
                        <td class="d-flex bg-white sticky right-0">
                            <button class="border-radius-10 btn-outline-danger btn d-flex align-items-center gap-1" onclick="RemoveAssignedMedicalOfficer('<?=$Id?>')"><img src="/public/icons/remove.svg" class="invert-0" width="24px"/><span>Remove</span> </button>
                        </td>
                    </tr>
                <?php
                    endforeach;
                endif;
                ?>
                </tbody>
            </table>
        </div>
    <button class="btn btn-success d-flex align-items-center gap-1 align-self-center my-1" onclick="AssignTeamLeader('<?=$Campaign_ID?>')">
        <img src="/public/icons/checkCircle.svg" class="invert-100 " width="24px" alt=""/>
        <span>Assign Team Leader</span>
    </button>
    </div>

</div>
<script>
    let SelectedMedicalOfficer =[];
    const ChangeRecordsPerPage = ()=>{
        const RecordsPerPage=document.getElementById('rpp').value;
        window.location.href="?rpp="+RecordsPerPage
    }
    const AssignMedicalOfficer = (id,order)=>{
        const url='/manager/mngCampaign/assignTeam/assign';
        // Get Campaign ID from URL GET Parameter
        const urlParams = new URLSearchParams(window.location.search);
        const campId = urlParams.get('campId');
        const Form = new FormData();
        Form.append('Campaign_ID',campId)
        Form.append('Member_ID',id)
        OpenDialogBox({
            id : 'Assign',
            title : 'Assign Team',
            content :
                ` <div class="d-flex font-bold text-2xl">Confirm The Assignment ?</div>
               `,
            successBtnText: 'Assign',
            successBtnAction: ()=>{
                CloseDialogBox('Assign');
                ShowLoader();
                fetch(url,{
                    method : 'POST',
                    body : Form

                })
                    .then((res)=>res.json())
                    .then((data)=>{
                        console.log(data)
                        if (data.status){
                            ShowToast({
                                type : 'success',
                                message : 'Successfully Assigned'
                            })
                            ShowLoader();
                        //     Get current URL
                            const url = '/manager/mngCampaign/assignTeam?campId='+campId;
                            fetch(url).then((res)=>res.text()).then((data)=>{
                                if (data){
                                    const DParsed = new DOMParser();
                                    const DHTML = DParsed.parseFromString(data,'text/html');
                                    const AssignTeamContent =document.getElementById('AssignTeam-Content');
                                    const MedOfficersContent =document.getElementById('MedOfficers');
                                    const AssignTeam = DHTML.getElementById('AssignTeam-Content');
                                    const MedOfficers = DHTML.getElementById('MedOfficers');
                                    AssignTeamContent.innerHTML=AssignTeam.innerHTML;
                                    MedOfficersContent.innerHTML=MedOfficers.innerHTML;
                                }else{
                                    ShowToast({
                                        type : 'error',
                                        message : 'Failed to Assign'
                                    })
                                }
                                setTimeout(()=>{
                                    HideLoader();
                                },200)
                            })

                        }else{
                            ShowToast({
                                type : 'error',
                                message : 'Failed to Assign'
                            })
                        }

                    })
            }
        })

    }

    const RemoveAssignedMedicalOfficer = (id)=>{
        const url='/manager/mngCampaign/assignTeam/remove';
        // Get Campaign ID from URL GET Parameter
        const urlParams = new URLSearchParams(window.location.search);
        const campId = urlParams.get('campId');
        const Form = new FormData();
        Form.append('Campaign_ID',campId)
        Form.append('Member_ID',id)
        OpenDialogBox({
            id : 'Remove',
            title : 'Remove Team',
            content :
                ` <div class="d-flex font-bold text-2xl">Confirm The Removal ?</div>
               `,
            successBtnText: 'Remove',
            successBtnAction: ()=>{
                CloseDialogBox('Remove');
                ShowLoader();
                fetch(url,{
                    method : 'POST',
                    body : Form

                })
                    .then((res)=>res.json())
                    .then((data)=>{
                        console.log(data)
                        if (data.status){
                            ShowToast({
                                type : 'success',
                                message : 'Successfully Removed'
                            })
                            ShowLoader();
                        //     Get current URL
                            const url = '/manager/mngCampaign/assignTeam?campId='+campId;
                            fetch(url).then((res)=>res.text()).then((data)=>{
                                if (data){
                                    const DParsed = new DOMParser();
                                    const DHTML = DParsed.parseFromString(data,'text/html');
                                    const AssignTeamContent =document.getElementById('AssignTeam-Content');
                                    const MedOfficersContent =document.getElementById('MedOfficers');
                                    const AssignTeam = DHTML.getElementById('AssignTeam-Content');
                                    const MedOfficers = DHTML.getElementById('MedOfficers');
                                    AssignTeamContent.innerHTML=AssignTeam.innerHTML;
                                    MedOfficersContent.innerHTML=MedOfficers.innerHTML;
                                }else{
                                    ShowToast({
                                        type : 'error',
                                        message : 'Failed to Remove'
                                    })
                                }
                                setTimeout(()=>{
                                    HideLoader();
                                },200)
                            })

                        }else{
                            ShowToast({
                                type : 'error',
                                message : 'Failed to Remove'
                            })
                        }

                    })
            }
        })
    }
    const SearchAssignOfficer = (path,type='')=>{
        const url=path;
        const q=document.getElementById('search').value;
        const Form = new FormData();
        Form.append('q',q)
        Form.append('type',type)
        fetch(path,{
            method : 'POST',
            body : Form

        })
            .then((res)=>res.text())
            .then((data)=>{
                console.log(data)
                Loader.classList.remove('none');
                const DP = new DOMParser();
                const Doc = DP.parseFromString(data,'text/html');
                document.getElementById('content').innerHTML=Doc.getElementById('content').innerHTML;
                if (type ==='assign'){
                    console.log(SelectedMedicalOfficer);
                    SelectedMedicalOfficer.forEach((value)=>{
                        const btn=document.getElementById('btn-'+value)
                        if (btn){
                            btn.classList.remove('btn-outline-success')
                            btn.classList.add('btn-danger')
                            btn.classList.add('text-white')
                            btn.getElementsByTagName('span')[0].innerText="Remove"
                            btn.getElementsByTagName('img')[0].src="/public/icons/remove.svg"
                            btn.getElementsByTagName('img')[0].classList.add('invert-100')
                        }
                    })

                }
                setTimeout(()=>{
                    Loader.classList.add('none')
                },500)
            })

    }

    const AssignTeamLeader = (id) =>{
        const url = "/manager/mngCampaign/assign-team/get-members";
        const formData = new FormData();
        formData.append('campId', id);
        fetch(url, {
            method: 'POST',
            body: formData
        }).then(response => response.json())
            .then(data => {
                if (data.status) {
                    console.log(data)
                    let options = '';
                    data.data.forEach((member) => {
                        options += `<option value="${member.Member_ID}">${member.Name} - ${member.NIC}</option>`
                    })
                    OpenDialogBox({
                        id: 'assignTeamLeader',
                        title: 'Assign Team Leader',
                        titleClass: 'bg-dark text-white',
                        content: `
            <div class="d-flex flex-column justify-content-center align-items-center">
            <div class="form-group">
                <label for="teamLeader" class="w-40">Team Leader</label>
                <select class="form-control w-60" id="teamLeader">
                    ${options}
                </select>
            </div>
            `,
                        successBtnText: 'Assign',
                        successBtnClass: 'btn-success',
                        successBtnAction: () => {
                            const url = '/manager/mngCampaign/assign-team/assign-leader';
                            const form = new FormData();
                            form.append('campId', id);
                            form.append('teamLeaderId', document.getElementById('teamLeader').value);
                            fetch(url, {
                                method: 'POST',
                                body: form
                            }).then(response => response.json())
                                .then(data => {
                                    CloseDialogBox('assignTeamLeader');
                                    if (data.status){
                                        ShowToast({
                                            type: 'success',
                                            message: data.message
                                        })
                                    }else{
                                        ShowToast({
                                            type: 'danger',
                                            message: data.message
                                        })
                                    }
                                })
                        }
                    })
                }
            })

    }
</script>
<style>
    @media screen and (max-width: 920px) {
        #loader{
            margin-top: 0 !important;
        }
    }
</style>
