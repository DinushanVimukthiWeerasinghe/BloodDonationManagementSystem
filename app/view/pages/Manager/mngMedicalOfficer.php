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
        if ($key == 'page')
            continue;
        $str .= $key . '=' . $value . '&';
    }
    return $str;
};


FlashMessage::RenderFlashMessages();
?>

<!--<div id="loader" class="none bg-white absolute w-100 h-100 d-flex justify-content-center align-items-center" style="z-index: 999">-->
<!--    <img src="/public/loading2.svg" alt="" width="100px">-->
<!--</div>-->

<div class="d-flex w-100 flex-column align-items-center bg-white p-1 border-radius-10 m-1">
    <div class="d-flex w-100 flex-row">
        <div class="d-flex bg-white-0-7 p-1 text-dark justify-content-between align-items-center w-100 flex-row gap-0-5 justify-content-center ">
            <div class="d-flex align-items-center gap-1 btn btn-outline-success" onclick="AddMedicalOfficer()">
                <img src="/public/icons/person-add.svg" width="24" alt=""/>
                <span class=" font-bold">Add Officer</span>
            </div>
            <div id="Search" class="d-flex gap-0-5 align-items-center">
                <label for="search" class="search">Search </label>
                <input class="form-control" name="search" id="search" onkeyup="Search('/manager/mngMedicalOfficer/search')">
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
    <div class="d-flex w-100 overflow-y-scroll" style="margin-left: 50px">
        <table class="w-100 ">

            <thead class="sticky top-0">
            <tr>
                <th>No</th>
                <th>Full Name</th>
                <th>NIC</th>
                <th>Email</th>
                <th>Contact No</th>
                <th>Gender</th>
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
                <tr class="bg-white-0-7">
                    <td data-label="No "><?php echo $i++ ?>.</td>
                    <td data-label="Name" class="font-bold"><?php echo $name ?></td>
                    <td data-label="NIC"><?php echo $NIC ?></td>
                    <td data-label="Email"><?php echo $email?></td>
                    <td data-label="Contact No"><?php echo $contact?></td>
                    <td data-label="Gender"><?php echo $gender?></td>
                    <td data-label="Position"><?php echo $position ?></td>
                    <td data-label="Nationality"><?php echo $nationality?></td>
                    <td class="d-flex justify-content-center gap-1 align-items-center">
                        <button class="text-dark btn gap-0-5 btn-outline-success d-flex align-items-center justify-content-center" onclick="EditMedicalOfficer('<?php echo $id ?>')" ><img src="/public/icons/edit.png" width="24px" alt="">Edit</button>
                        <button class="text-dark btn gap-0-5 btn-outline-info d-flex align-items-center justify-content-center" onclick="SendEmail('<?php echo $id ?>')" ><img src="/public/icons/mail.png" width="24px" alt="">Send Email</button>
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
                    <div class="none">
                        <span id="total_pages"><?=$total_pages?></span>
                        <span id="current_page"><?=$current_page?></span>
                    </div>
                    <label for="page" class="search">Record Per Page</label>
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
            <div id="paginationleft" class="d-flex align-items-center justify-content-center bg-white border-radius-10 " onclick="prevData()"
                 style="padding: 0.3rem 0.6rem">
                <span>
                    <img src="/public/icons/chevron-left.svg" width="20rem">
                </span>
            </div>
            <div id="paginationright" class="d-flex align-items-center justify-content-center bg-white-0-5 border-radius-10 " onclick="nextData()"
                 style="padding: 0.3rem 0.6rem">
                <span>
                    <img src="/public/icons/chevron-right.svg" width="20rem">
                </span>
            </div>
        </div>
    </div>
</div>
<script>
    const ChangeRecordsPerPage = ()=>{
        const RecordsPerPage=document.getElementById('rpp').value;
        // window.location.href="?rpp="+RecordsPerPage
        const status = document.getElementById('FilterByStatus').value;
        const url = '/manager/mngMedicalOfficer?status='+status+'&rpp='+RecordsPerPage;
        const loader = document.getElementById('loader');
        loader.classList.remove('none');
        fetch(url,{
            method: 'GET',
        })
            .then(response => response.text())
            .then(data => {
                const content = document.getElementById('content');
                const Tpaginationleft = document.getElementById('paginationleft');
                const Tpaginationright = document.getElementById('paginationright');
                const tf = document.getElementById('tableFooter');
                const DParser = new DOMParser();
                const DHTML = DParser.parseFromString(data, 'text/html');
                const table = DHTML.getElementById('content');
                const tableFooter = DHTML.getElementById('tableFooter');
                const paginationl = DHTML.getElementById('paginationleft');
                const paginationr = DHTML.getElementById('paginationright');
                content.innerHTML = table.innerHTML;
                tf.innerHTML = tableFooter.innerHTML;
                Tpaginationleft.innerHTML = paginationl.innerHTML;
                Tpaginationright.innerHTML = paginationr.innerHTML;
                setTimeout(()=>{
                    loader.classList.add('none');
                },1000)
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
    const nextData=()=>{
        const current_page = parseInt(document.getElementById('current_page').innerText)
        const total_pages = parseInt(document.getElementById('total_pages').innerText)
        const current_get = <?php echo json_encode($_GET)?>;
        if (current_page>=total_pages){
            ShowToast({
                message: 'No More Data',
                type: 'danger',
            })
            return;
        }

        const RecordsPerPage=document.getElementById('rpp').value;
        const status = document.getElementById('FilterByStatus').value;
        const url = '/manager/mngMedicalOfficer?status='+status+'&rpp='+RecordsPerPage+'&page='+(current_page+1);
        const loader = document.getElementById('loader');
        loader.classList.remove('none');
        fetch(url).then(res=>res.text())
            .then((data)=>{
                const content = document.getElementById('content');
                const Tpaginationleft = document.getElementById('paginationleft');
                const Tpaginationright = document.getElementById('paginationright');
                const tf = document.getElementById('tableFooter');
                const DParser = new DOMParser();
                const DHTML = DParser.parseFromString(data, 'text/html');
                const table = DHTML.getElementById('content');
                const tableFooter = DHTML.getElementById('tableFooter');
                const paginationl = DHTML.getElementById('paginationleft');
                const paginationr = DHTML.getElementById('paginationright');
                content.innerHTML = table.innerHTML;
                tf.innerHTML = tableFooter.innerHTML;
                Tpaginationleft.innerHTML = paginationl.innerHTML;
                Tpaginationright.innerHTML = paginationr.innerHTML;
                setTimeout(()=>{
                    loader.classList.add('none');
                },1000)
            })


    }
    const prevData=()=>{
        const current_page = parseInt(document.getElementById('current_page').innerText)
        const total_pages = parseInt(document.getElementById('total_pages').innerText)
        const current_get = <?php echo json_encode($_GET)?>;
        if (current_page<=1){
            ShowToast({
                type: 'error',
                message: 'You are on the first page'
            })
            return;
        }

        const RecordsPerPage=document.getElementById('rpp').value;
        const status = document.getElementById('FilterByStatus').value;
        const url = '/manager/mngMedicalOfficer?status='+status+'&rpp='+RecordsPerPage+'&page='+(current_page-1);
        const loader = document.getElementById('loader');
        loader.classList.remove('none');
        fetch(url).then(res=>res.text())
            .then((data)=>{
                const content = document.getElementById('content');
                const Tpaginationleft = document.getElementById('paginationleft');
                const Tpaginationright = document.getElementById('paginationright');
                const tf = document.getElementById('tableFooter');
                const DParser = new DOMParser();
                const DHTML = DParser.parseFromString(data, 'text/html');
                const table = DHTML.getElementById('content');
                const tableFooter = DHTML.getElementById('tableFooter');
                const paginationl = DHTML.getElementById('paginationleft');
                const paginationr = DHTML.getElementById('paginationright');
                content.innerHTML = table.innerHTML;
                tf.innerHTML = tableFooter.innerHTML;
                Tpaginationleft.innerHTML = paginationl.innerHTML;
                Tpaginationright.innerHTML = paginationr.innerHTML;
                setTimeout(()=>{
                    loader.classList.add('none');
                },1000)
            })


    }
    const AddMedicalOfficer = ()=>{
        OpenDialogBox({
            id:'AddMedicalOfficer',
            title:'Add Medical Officer',
            content :`
                <div class="d-flex flex-column gap-1">
                    <div class="d-flex gap-1">
                        <div class="form-group">
                                <label for="name" class="w-40">First Name</label>
                                <input type="text" class="form-control w-60" name="First_Name" id="FirstName" placeholder="Enter First Name">
                        </div>
                        <div class="form-group">
                                <label for="name" class="w-40">Last Name</label>
                                <input type="text" class="form-control w-60" name="Last_Name" id="LastName" placeholder="Enter Last Name">
                        </div>


                    </div>
                    <div class="d-flex gap-1">
                        <div class="form-group">
                            <label for="email" class="w-40">Email</label>
                            <input type="text" class="form-control w-60" name="Email" id="email" placeholder="Enter Email">
                        </div>
                        <div class="form-group">
                            <label for="contact" class="w-40">Contact No</label>
                            <input type="text" class="form-control w-60 " id="contact" name="Contact_No" placeholder="Enter Contact No">
                        </div>
                    </div>
                    <div class="d-flex gap-1">
                            <div class="form-group">
                                <label for="nic" class="w-40">NIC</label>
                                <input type="text" class="form-control w-60" name="NIC" id="nic" placeholder="Enter NIC">
                            </div>
                            <div class="form-group">
                                <label for="nic" class="w-40">Nationality</label>
                                <select id="Nationality" name="Nationality" class="w-60 form-select bg-white">
                                    <option value="Sinhala">Sinhala</option>
                                    <option value="Tamil">Tamil</option>
                                    <option value="English">English</option>
                                </select>
                            </div>
                    </div>
                    <div class="d-flex gap-1">
                           <div class="form-group">
                                <label for="gender" class="w-40">Registration No</label>
                                <input type="text" class="form-control w-60" name="Registration_Number" id="RegNo" placeholder="Enter Registration No">
                            </div>
                            <div class="form-group">
                                <label for="nic" class="w-40">Registration Date</label>
                                <input type="date" class="form-control w-60" name="Registration_Date" id="RegDate" placeholder="Enter Registration Date">
                            </div>
                    </div>
                        <div class="d-flex gap-1">
                           <div class="form-group">
                                <label for="gender" class="w-40">Address 1</label>
                                <input type="text" name="Address1" class="form-control w-60" id="Address1" placeholder="Enter Address 1">
                            </div>
                            <div class="form-group">
                                <label for="nic" class="w-40">Address 2</label>
                                <input type="text" name="Address2" class="form-control w-60" id="Address2" placeholder="Enter Address 2">
                            </div>
                        </div>
                        <div class="d-flex gap-1">
                           <div class="form-group">
                                <label for="gender" class="w-40">City</label>
                                <input type="text" name="City" class="form-control w-60" id="City" placeholder="Enter City">
                            </div>
                            <div class="form-group">
                                <label for="nic" class="w-40">Photo</label>
                                <input type="file" id="image" class="form-control w-60" id="joined_date" name='image'>
                            </div>
                        </div>
                        <div class="d-flex gap-1">
                           <div class="form-group">
                                <label for="gender" class="w-40">Blood Bank </label>
                                <select name="Branch_ID" id="Branch_ID" class="w-60 form-select bg-white">
                                    <?php
                                        foreach ($bloodBanks as $bloodBank):
                                            ?>
                                            <option value='<?=$bloodBank->getBloodBankID()?>'><?=$bloodBank->getBankName()?></option>
                                            <?php
                                        endforeach;
                                    ?>
                                </select>
                           </div>
                           <div class="form-group">
                                <label for="Position" class="w-40">Position</label>
                                <select name="Position" id="Position" class="w-60 form-select bg-white">
                                    <option value="Doctor">Doctor</option>
                                    <option value="Nurse">Nurse</option>
                                    <option value="Assistant">Assistant</option>
                                </select>
                            </div>

                        </div>


                </div>

            `,
            footer : `<div id="error" class="text-sm none text-danger"> Hello </div>`,
            successBtnText:'Add',
            successBtnAction : ()=>{
                 const error=document.getElementById('error');
                 const form = new FormData();
                    form.append('First_Name',document.getElementById('FirstName').value);
                    form.append('Last_Name',document.getElementById('LastName').value);
                    form.append('Email',document.getElementById('email').value);
                    form.append('Contact_No',document.getElementById('contact').value);
                    form.append('NIC',document.getElementById('nic').value);
                    form.append('Registration_Number',document.getElementById('RegNo').value);
                    form.append('Registration_Date',document.getElementById('RegDate').value);
                    form.append('Address1',document.getElementById('Address1').value);
                    form.append('Address2',document.getElementById('Address2').value);
                    form.append('City',document.getElementById('City').value);
                    form.append('image',document.getElementById('image').files[0]);
                    form.append('Branch_ID',document.getElementById('Branch_ID').value);
                    form.append('Position',document.getElementById('Position').value);
                    form.append('Nationality',document.getElementById('Nationality').value);

                    fetch('/manager/mngMedicalOfficer/add',{
                        method:'POST',
                        body:form
                    }).then(res=>res.json())
                        .then((data)=>{

                            if (data.status) {
                                CloseDialogBox();
                                location.reload();
                            }else{
                                if (data.errors){
                                    console.log(data.errors)
                                    for (const [key, value] of Object.entries(data.errors)) {
                                        console.log(key,value)
                                        const element = document.getElementsByName(key)[0];
                                        element.classList.add('border-danger');
                                        element.classList.add('text-danger');
                                    }
                                }
                                ShowToast({
                                    title:'Error',
                                    message:data.message,
                                    type:'danger'
                                })
                            }
                        })

            }
        })
    }

    const EditMedicalOfficer = async (id)=>{
        const form = new FormData();
        form.append('Medical_Officer_ID',id);
            const response = await fetch('/manager/mngMedicalOfficer/get',{
                method:'POST',
                body:form
            });
            const res = await response.json();
            if (res){
                if (res.status){
                    const RegistrationDate = new Date(res.data.Registration_Date);
                    const RD_Y = RegistrationDate.getFullYear();
                    const RD_M = (RegistrationDate.getMonth()+1).toString().padStart(2,'0');
                    const RD_D = RegistrationDate.getDate().toString().padStart(2,'0');
                    const RegistrationDateStr = RD_Y+'-'+RD_M+'-'+RD_D;
                    const data =res.data;
                    OpenDialogBox({
                        id:'AddMedicalOfficer',
                        title:'Add Medical Officer',
                        content :`
                <div class="d-flex flex-column gap-1">
                    <div class="d-flex gap-1">
                        <div class="form-group">
                                <label for="name" class="w-40">First Name</label>
                                <input type="text" class="form-control w-60" name="First_Name" id="FirstName" value="`+data.First_Name+`" placeholder="Enter First Name">
                        </div>
                        <div class="form-group">
                                <label for="name" class="w-40">Last Name</label>
                                <input type="text" class="form-control w-60" name="Last_Name" id="LastName" value="`+data.Last_Name+`" placeholder="Enter Last Name">
                        </div>


                    </div>
                    <div class="d-flex gap-1">
                        <div class="form-group">
                            <label for="email" class="w-40">Email</label>
                            <input type="text" class="form-control w-60" name="Email" value="`+data.Email+`" id="email" placeholder="Enter Email">
                        </div>
                        <div class="form-group">
                            <label for="contact" class="w-40">Contact No</label>
                            <input type="text" class="form-control w-60 " id="contact" value="`+data.Contact_No+`" name="Contact_No" placeholder="Enter Contact No">
                        </div>
                    </div>
                    <div class="d-flex gap-1">
                            <div class="form-group">
                                <label for="nic" class="w-40">NIC</label>
                                <input type="text" class="form-control w-60" name="NIC" id="nic" value="`+data.NIC+`" placeholder="Enter NIC">
                            </div>
                            <div class="form-group">
                                <label for="nic" class="w-40">Nationality</label>
                                <select id="Nationality" name="Nationality"  value="`+data.Nationality+`" class="w-60 form-select bg-white">
                                    <option value="Sinhala">Sinhala</option>
                                    <option value="Tamil">Tamil</option>
                                    <option value="English">English</option>
                                </select>
                            </div>
                    </div>
                    <div class="d-flex gap-1">
                           <div class="form-group">
                                <label for="gender" class="w-40">Registration No</label>
                                <input type="text" class="form-control w-60" name="Registration_Number"  value="`+data.Registration_Number+`" id="RegNo" placeholder="Enter Registration No">
                            </div>
                            <div class="form-group">
                                <label for="nic" class="w-40">Registration Date</label>
                                <input type="date" class="form-control w-60" name="Registration_Date"  value="`+RegistrationDateStr+`" id="RegDate" placeholder="Enter Registration Date">
                            </div>
                    </div>
                        <div class="d-flex gap-1">
                           <div class="form-group">
                                <label for="gender" class="w-40">Address 1</label>
                                <input type="text" name="Address1" class="form-control w-60"  value="`+data.Address1+`" id="Address1" placeholder="Enter Address 1">
                            </div>
                            <div class="form-group">
                                <label for="nic" class="w-40">Address 2</label>
                                <input type="text" name="Address2" class="form-control w-60" value="`+data.Address2+`" id="Address2" placeholder="Enter Address 2">
                            </div>
                        </div>
                        <div class="d-flex gap-1">
                           <div class="form-group">
                                <label for="gender" class="w-40">City</label>
                                <input type="text" name="City" class="form-control w-60"  value="`+data.City+`" id="City" placeholder="Enter City">
                            </div>
                            <div class="form-group">
                                <label for="nic" class="w-40">Photo</label>
                                <input type="file" id="image"  value="`+data.First_Name+`"  class="form-control w-60" id="image" name='image'>
                            </div>
                        </div>
                        <div class="d-flex gap-1">
                           <div class="form-group">
                                <label for="gender" class="w-40">Blood Bank </label>
                                <select name="Branch_ID"  value="`+data.Branch_ID+`" id="Branch_ID" class="w-60 form-select bg-white">
                                    <?php
                        foreach ($bloodBanks as $bloodBank):
                        ?>
                                            <option value='<?=$bloodBank->getBloodBankID()?>'><?=$bloodBank->getBankName()?></option>
                                            <?php
                        endforeach;
                        ?>
                                </select>
                           </div>
                           <div class="form-group">
                                <label for="Position" class="w-40">Position</label>
                                <select name="Position"  value="`+data.Position+`" id="Position" class="w-60 form-select bg-white">
                                    <option value="Doctor">Doctor</option>
                                    <option value="Nurse">Nurse</option>
                                    <option value="Assistant">Assistant</option>
                                </select>
                            </div>

                        </div>


                </div>

            `,
                        footer : `<div id="error" class="text-sm none text-danger"> Hello </div>`,
                        successBtnText:'Update',
                        successBtnAction : ()=>{
                            const error=document.getElementById('error');
                            const form = new FormData();
                            form.append('Officer_ID',id);
                            form.append('First_Name',document.getElementById('FirstName').value);
                            form.append('Last_Name',document.getElementById('LastName').value);
                            form.append('Email',document.getElementById('email').value);
                            form.append('Contact_No',document.getElementById('contact').value);
                            form.append('NIC',document.getElementById('nic').value);
                            form.append('Registration_Number',document.getElementById('RegNo').value);
                            form.append('Registration_Date',document.getElementById('RegDate').value);
                            form.append('Address1',document.getElementById('Address1').value);
                            form.append('Address2',document.getElementById('Address2').value);
                            form.append('City',document.getElementById('City').value);
                            form.append('image',document.getElementById('image').files[0]);
                            form.append('Branch_ID',document.getElementById('Branch_ID').value);
                            form.append('Position',document.getElementById('Position').value);
                            form.append('Nationality',document.getElementById('Nationality').value);

                            fetch('/manager/mngMedicalOfficer/update',{
                                method:'POST',
                                body:form
                            }).then(res=>res.json())
                                .then((data)=>{

                                    if (data.status) {
                                        CloseDialogBox();
                                        location.reload();
                                    }else{
                                        if (data.errors){
                                            for (const [key, value] of Object.entries(data.errors)) {
                                                console.log(key,value)
                                                const element = document.getElementsByName(key)[0];
                                                element.classList.add('border-danger');
                                                element.classList.add('text-danger');
                                            }
                                        }
                                        ShowToast({
                                            title:'Error',
                                            message:data.message,
                                            type:'danger'
                                        })
                                    }
                                })

                        }
                    })
                }
            }
    }

    const SendEmail = (id)=>{
        OpenDialogBox({
            id:'sendEmail',
            title:'Send Email',
            content :`
                <div class="d-flex gap-1 flex-column">
                    <div class="form-group">
                        <label for="Subject" class="w-40">Subject</label>
                        <div class="d-flex flex-column w-100 gap-0-5">
                            <input type="text" class="w-60 form-control" id="Subject" placeholder="Enter Subject">
                            <span class="text-danger none" id="Subject-error"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Body" class="w-40">Message</label>
                        <div class="d-flex flex-column w-100 gap-0-5">
                            <textarea class="border-radius-5" id="Body" rows="3"></textarea>
                            <span class="text-danger none" id="Body-error"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="attachment" class="w-40">Attachment</label>
                        <input type="file" class="w-60 form-control" id="attachment">
                </div>
            `,
            successBtnText:'Send',
            successBtnAction : ()=>{
                const form = new FormData();
                form.append('Officer_ID',id);
                form.append('subject',document.getElementById('Subject').value);
                form.append('message',document.getElementById('Body').value);
                const Attachment = document.getElementById('attachment').files[0];
                if (Attachment){
                    form.append('attachment',Attachment);
                }
                fetch('/manager/mngMedicalOfficer/sendEmail',{
                    method:'POST',
                    body:form
                }).then(res=>res.json())
                    .then((data)=>{
                        if (data.status) {
                            CloseDialogBox();
                            ShowToast({
                                title:'Success',
                                message:data.message,
                                type:'success'
                            })
                        }else{
                            if (data.errors){
                                for (const [key, value] of Object.entries(data.errors)) {
                                    console.log(key,value)
                                    const element = document.getElementById(key+'-error');
                                    element.innerText=value;
                                    element.classList.remove('none');

                                }
                            }
                            ShowToast({
                                title:'Error',
                                message:data.message,
                                type:'danger'
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