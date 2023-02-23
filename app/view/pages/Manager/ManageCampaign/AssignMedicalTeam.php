<?php

/* @var string $firstName */

/* @var string $lastName */
/* @var array $bloodBanks */
/* @var BloodBank $bloodBank */

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

<div class="d-flex w-60 flex-column align-items-center bg-white p-1 border-radius-10 m-1">
    <div class="d-flex w-100 flex-row">
        <div class="d-flex bg-white-0-7 p-1 text-dark justify-content-between align-items-center w-100 flex-row gap-0-5 justify-content-center ">
            <div class="d-flex align-items-center gap-1 btn btn-outline-success" onclick="AddMedicalOfficer()">
                <img src="/public/icons/person-add.svg" width="24" alt=""/>
                <span class=" font-bold">Add Officer</span>
            </div>
            <div id="Search" class="d-flex gap-0-5 align-items-center">
                <label for="search" class="search">Search </label>
                <input class="form-control" name="search" id="search" onkeyup="SearchAssignOfficer('/manager/mngMedicalOfficer/search','assign')">
            </div>
            <div id="Filters" class="d-flex gap-1">
                <div class="form-group">
                    <label for="filter" class="search ">Position</label>
                    <select class="form-control" name="filter" id="filter">
                        <option value="All">All</option>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="filter" class="search ">Branch</label>
                    <select class="form-control" name="filter" id="filter">
                        <option value="All">All</option>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex w-100 overflow-y-scroll">
        <table class="w-100 ">
            <thead class="sticky top-0">
            <tr>
                <th>No</th>
                <th>Full Name</th>
                <th>NIC</th>
                <th>Email</th>
                <th>Contact No</th>
<!--                <th>Gender</th>-->
                <th>Position</th>
                <th>Nationality</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody id="content" class="">
            <div id="loader" class="none bg-white absolute w-100 h-100 d-flex justify-content-center align-items-center" style="z-index: 999;height: 90%;margin-top: 35px;">
                <img src="/public/loading2.svg" alt="" width="100px">
            </div>
            <?php
            $i=1;
            if (!empty($data)):
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
                        <td data-label="No "><?php echo $i ?>.</td>
                        <td data-label="Name" id="name-<?=$id?>" class="font-bold"><?php echo $name ?></td>
                        <td data-label="NIC" id="nic-<?=$id?>"><?php echo $NIC ?></td>
                        <td data-label="Email" id="email-<?=$id?>"><?php echo $email?></td>
                        <td data-label="Contact No" id="contact-no-<?=$id?>"><?php echo $contact?></td>
                        <td data-label="Position" id="position-<?=$id?>"><?php echo $position ?></td>
                        <td data-label="Nationality" id="nationality-<?=$id?>"><?php echo $nationality?></td>
                        <td class="d-flex justify-content-center gap-1 align-items-center">
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
    <div id="tableFooter" class="py-0-5 bg-white w-100 d-flex justify-content-end align-items-center">
        <div class="d-flex">
            <div class="d-flex align-items-center justify-content-center">
                <div class="d-flex gap-1 align-items-center">
                    <label for="rpp" class="search">Record Per Page</label>
                    <select class="px-2 py-0-5" name="page" id="rpp" onchange="ChangeRecordsPerPage()">
                        <?php
                        $i=5;
                        while ($i<20):
                            /** @var int $rpp */
                            if ((int)$rpp===$i):
                                ?>
                                <option selected value="<?=$i?>"><?=$i?></option>
                            <?php
                            else :
                                ?>
                                <option value="<?=$i?>"><?=$i?></option>
                            <?php
                            endif;
                            ?>
                            <?php
                            $i=$i+5;
                        endwhile;
                        ?>
                    </select>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-center bg-white border-radius-10 " style="padding: 0.3rem 0.6rem">
                <a href="<?=$getParams($_GET)?>page=<?=$current_page-1?>">
                    <img src="/public/icons/chevron-left.svg" width="20rem">
                </a>
            </div>
            <div class="d-flex align-items-center justify-content-center bg-white-0-5 border-radius-10 " style="padding: 0.3rem 0.6rem">
                <a href="<?=$getParams($_GET)?>page=<?=$current_page+1?>">
                    <img src="/public/icons/chevron-right.svg" width="20rem">
                </a>
            </div>
        </div>
    </div>
</div>
<div class="d-flex w-40 flex-column align-items-center bg-white p-1 gap-1 border-radius-10 m-1">
    <div class="font-bold text-2xl">Assign Team</div>
        <div class="d-flex flex-column overflow-y-scroll w-100">
            <table class="w-100">
                <thead class="sticky top-0">
                    <tr>
                        <th>NIC</th>
                        <th>Email</th>
                        <th>Position</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="AssignTeam-Content">
                <tr id="no-data">
                    <td colspan="6" class="text-center">No Data Found</td>
                </tr>
    <!--                <tr>-->
    <!--                    <td>1</td>-->
    <!--                    <td>Dr. A</td>-->
    <!--                    <td>123456789V</td>-->
    <!--                    <td>test@test.com</td>-->
    <!--                    <td>Doctor</td>-->
    <!--                    <td><button class="btn btn-danger d-flex align-items-center gap-1"><img src="/public/icons/remove.svg" class="invert-100" width="24px"/><span>Remove</span> </button> </td>-->
    <!--                </tr>-->
                </tbody>
            </table>
        </div>
    <button class="btn btn-success d-flex align-items-center gap-1 align-self-center my-1" disabled onclick="AssignTeam()">
        <img src="/public/icons/checkCircle.svg" class="invert-100 " width="24px"/>
        <span>Assign Team</span>
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
        // const AssignTeamContent =document.getElementById('AssignTeam-Content');
        // if (SelectedMedicalOfficer.includes(id)){
        //     SelectedMedicalOfficer=SelectedMedicalOfficer.filter((value)=>value!==id)
        // }else {
        //     if (SelectedMedicalOfficer.length===0){
        //         AssignTeamContent.children[0].remove()
        //     }
        //     const tr = document.createElement('tr');
        //     tr.id='Arow-'+id;
        //     tr.innerHTML=`
        //             <td>${document.getElementById('nic-'+id).innerText}</td>
        //             <td>${document.getElementById('email-'+id).innerText}</td>
        //             <td>${document.getElementById('position-'+id).innerText}</td>
        //             <td><button id="btn-${id}" class=" btn gap-0-5 btn-danger d-flex align-items-center justify-content-center" onclick="RemoveAssignedMedicalOfficer('${id}')" >
        //                         <img src="/public/icons/remove.svg" class="invert-100" width="24px" alt=""><span>Remove</span></button> </td>`
        //     AssignTeamContent.appendChild(tr)
        //     SelectedMedicalOfficer.push(id)
        //     document.getElementById('row-'+order).remove();
        //
        // }
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
                `
                    <div class="d-flex w-100">
                        <div class="form-control">
                            <select id="position" class="form-control">
                                <option value="Leader">Leader</option>
                                <option value="Member">Member</option>
                            </select>
                        </div>
                    </div>
                `,
            successBtnText: 'Assign',
            successBtnAction: ()=>{
                fetch(url,{
                    method : 'POST',
                    body : Form

                })
                    .then((res)=>res.text())
                    .then((data)=>{
                        console.log(data)

                    })
            }
        })

    }

    const RemoveAssignedMedicalOfficer = (id)=>{
        const AssignTeamContent =document.getElementById('AssignTeam-Content');
        SelectedMedicalOfficer=SelectedMedicalOfficer.filter((value)=>value!==id)
        document.getElementById('Arow-'+id).remove();
        if (SelectedMedicalOfficer.length===0){
            const tr = document.createElement('tr');
            tr.id="no-data";
            tr.innerHTML=`
                    <td colspan="6" class="text-center">No Data Found</td>
                `
            AssignTeamContent.appendChild(tr)
        }
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
</script>
<style>
    @media screen and (max-width: 920px) {
        #loader{
            margin-top: 0 !important;
        }
    }
</style>
