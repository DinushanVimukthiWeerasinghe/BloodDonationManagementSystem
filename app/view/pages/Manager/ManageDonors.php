<?php
/* @var Donor $value*/
/* @var BloodGroup $BloodType*/
/* @var array $BloodTypes*/
/* @var array $data*/
/* @var string $rpp*/
/* @var string $current_page*/

use App\model\Blood\BloodGroup;
use App\model\users\Donor;
use App\model\Utils\Date;

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
?>

<div class="d-flex w-100 flex-column align-items-center bg-white p-1 border-radius-10 m-1">
    <div class="d-flex w-100 flex-row">
        <div class="d-flex bg-white-0-7 p-1 text-dark justify-content-between align-items-center w-100 flex-row gap-0-5 justify-content-center border-bottom-2 mb-1">
            <div></div>
            <div id="Search" class="d-flex gap-1 align-items-center">
                <label for="search" class="search">Search </label>
                <input class="form-control" style="width: 20vw" name="search" id="search" onkeyup="Search('/manager/mngDonors/Search')">
            </div>
            <div id="Filters" class="d-flex gap-1">
                <div class="form-group">
                    <label for="BloodFilter" class="search">Blood Group</label>
                    <select class="form-control" style="width: 20vw" name="BloodFilter" id="BloodFilter" onchange="FilterFromBloodGroup()">
                        <option value="All" >All</option>
                        <?php
                        foreach($BloodTypes as $BloodType):
                        if ($BloodGroup===$BloodType->getBloodGroupName()):
                        ?>
                        <option value="<?php echo $BloodType->getBloodGroupIDForGET()?>" selected><?php echo $BloodType->getBloodGroupName()?></option>
                        <?php
                        continue;
                        endif;
                        ?>
                            <option value="<?php echo $BloodType->getBloodGroupIDForGET()?>"><?php echo $BloodType->getBloodGroupName()?></option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex w-100 overflow-y-scroll" style="margin-left: 50px">
        <table class="w-100 ">
            <thead class="sticky top-0">
            <tr>
                <th scope="col">No</th>
                <th scope="col">Full Name</th>
                <th scope="col">NIC</th>
                <th scope="col">Contact No</th>
                <th scope="col">Blood Group</th>
                <th scope="col">Address</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody id="content">
            <div id="loader" class="none bg-white absolute w-100 h-100 d-flex justify-content-center align-items-center" style="z-index: 999;height: 90%;margin-top: 35px;">
                <img src="/public/loading2.svg" alt="" width="100px">
            </div>
            <?php
            if (empty($data)):
                ?>
                <tr>
                    <td colspan="8" class="text-center">No Data Found</td>
                </tr>
                <?php
            else:
            $i=1;
            foreach ($data as $value):
                $id = $value->getID();
                ?>
                <tr>
                    <td data-label="No "><?= $i++;?></td>
                    <td data-label="Full Name " class="font-bold"><?php echo $value->getFullName()?></td>
                    <td data-label="NIC "><?php echo $value->getNIC()?></td>
                    <td data-label="Contact No "><?php echo $value->getContactNo()?></td>
                    <td data-label="Blood Group "><?php echo $value->getBloodGroup()?></td>
                    <td data-label="Address "><?php echo $value->getAddress()?></td>
                    <td data-label="Status "><?php echo $value->getVerificationStatus()?></td>
                    <td class="d-flex justify-content-center gap-0-5 align-items-center">
                        <button class="text-dark btn gap-0-5 btn-outline-info d-flex align-items-center justify-content-center" onclick="ViewDonor('<?php echo $id ?>')" ><img src="/public/icons/view.svg" width="24px" alt="">View</button>
                        <button class="text-dark btn gap-0-5 btn-outline-info d-flex align-items-center justify-content-center" onclick="SendEmail('<?php echo $id ?>')" ><img src="/public/icons/mail.png" width="24px" alt="">Send Email</button>
                    </td>
                </tr>
            <?php
            endforeach;
            endif;
            ?>

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
            <div onclick="prevData()" id="paginationleft" class="d-flex align-items-center justify-content-center bg-white border-radius-10 <?= ($current_page <= 1)? 'disabled':''?>" style="padding: 0.3rem 0.6rem">
                <span>
                    <img src="/public/icons/chevron-left.svg" width="20rem">
                </span>
            </div>
            <div onclick="nextData()" id="paginationright" class="d-flex align-items-center justify-content-center bg-white-0-5 border-radius-10 <?= ($total_pages<=$current_page)? 'disabled':''?>" style="padding: 0.3rem 0.6rem">
                <span>

                    <img src="/public/icons/chevron-right.svg" width="20rem">
                </span>
            </div>
        </div>
    </div>
</div>

<script>

    const FilterFromBloodGroup = ()=>{
        const BloodGroup=document.getElementById('BloodFilter').value;
        const url = "/manager/mngDonors?BloodGroup="+BloodGroup;
        fetch(url,{
            method:'GET',
        }).then(response=>response.text()).then(data=>{
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
        }).catch(error=>{
            console.log(error);
        })
    }

    const ViewDonor = (id)=>{
        const url = "/manager/mngDonors/find"
        const data = new FormData();
        data.append('ID',id);
        data.append('format','json');
        fetch(url,{
            method:'POST',
            body:data
        }).then(response=>response.json()).then(data=>{
            console.log(data)
            if (data.status){
                const donor = data.data;

                const Donations = donor.Donations;
                let tbody = '';
                if (Donations){
                    Donations.forEach((donation)=>{
                        tbody += `
                        <tr>
                            <td data-label="Donation Date">${donation.Date}</td>
                            <td data-label="Donation Venue">${donation.Venue}</td>
                            <td data-label="Donation Status">${donation.Status}</td>
                            <td data-label="Donation PackageID">${donation.PackageID}</td>
                        </tr>
                        `
                    })
                }else{
                    tbody = `
                    <tr>
                        <td colspan="4" class="text-center">No Donations Found</td>
                    </tr>
                    `
                }
                OpenDialogBox({
                    id:'viewDonor',
                    title:'View Donor',
                    titleClass:'text-white bg-dark',
                    content: `
                        <div class="d-flex flex-column">
                            <div class="d-flex flex-column flex-center gap-1">
                                <div class="d-flex flex-column gap-1 w-100">
                                    <div class="font-bold bg-dark px-2 py-1 text-white">Personal Details</div>
                                    <div class="d-flex justify-content-center gap-1">
                                        <div class="d-flex flex-column gap-0-5 w-50">
                                            <div class="d-flex gap-1">
                                                <div class="font-bold">Full Name</div>
                                                <div class="font-thin">${donor.FullName}</div>
                                            </div>
                                            <div class="d-flex gap-1">
                                                <div class="font-bold">Age</div>
                                                <div class="font-thin">${donor.Age}</div>
                                            </div>
                                            <div class="d-flex gap-1">
                                                <div class="font-bold">Address</div>
                                                <div class="font-thin">${donor.Address}</div>
                                            </div>
                                            <div class="d-flex gap-1">
                                                <div class="font-bold">Contact No</div>
                                                <div class="font-thin">${donor.ContactNo}</div>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column gap-0-5 w-50">
                                            <div class="d-flex gap-1">
                                                <div class="font-bold">Email</div>
                                                <div class="font-thin">${donor.Email}</div>
                                            </div>
                                            <div class="d-flex gap-1">
                                                <div class="font-bold">Nationality</div>
                                                <div class="font-thin">${donor.Nationality}</div>
                                            </div>
                                            <div class="d-flex gap-1">
                                                <div class="font-bold">NIC</div>
                                                <div class="font-thin">${donor.NIC}</div>
                                            </div>
                                            <div class="d-flex align-items-center gap-1">
                                                <div class="font-bold">Availability</div>
                                                <div class="font-thin text-white border-radius-5 px-1 py-0-5 ${donor.Availability===1?'bg-success':'bg-danger'}">${donor.Availability ===1 ? 'Available ' :'Not Available'}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-column gap-1 w-100">
                                    <div class="font-bold bg-dark px-2 py-1 text-white">Sponsor Details</div>
                                    <div class="d-flex overflow-y-overlay" style="max-height: 50vh">
                                        <table class="table">
                                            <thead class="sticky top-0">
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Venue</th>
                                                    <th>Donation Status</th>
                                                    <th>Blood Packet ID</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            ${tbody}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `,
                    showSuccessButton:false,
                    cancelBtnText:'Close',
                })
            }
        }).catch(error=>{
            console.log(error);
        })

    }

    const ChangeRecordsPerPage = ()=>{
        const RecordsPerPage=document.getElementById('rpp').value;
        const BloodGroup=document.getElementById('BloodFilter').value;
        const url = '/manager/mngDonors?BloodGroup='+BloodGroup+'&rpp='+RecordsPerPage;
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
    const nextData = ()=>{
        const current_page = parseInt(document.getElementById('current_page').innerText)
        const total_pages = parseInt(document.getElementById('total_pages').innerText)
        if (current_page>=total_pages){
            ShowToast({
                message: 'No More Data',
                type: 'danger',
            })
            return;
        }
        const RecordsPerPage=document.getElementById('rpp').value;
        const BloodGroup=document.getElementById('BloodFilter').value;
        const url = '/manager/mngDonors?BloodGroup='+BloodGroup+'&rpp='+RecordsPerPage+'&page='+(current_page+1);
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
    const prevData = ()=>{
        const current_page = parseInt(document.getElementById('current_page').innerText)
        const total_pages = parseInt(document.getElementById('total_pages').innerText)
        if (current_page<=1){
            ShowToast({
                message: 'You are on First Page',
                type: 'danger',
            })
            return;
        }
        const RecordsPerPage=document.getElementById('rpp').value;
        const BloodGroup=document.getElementById('BloodFilter').value;
        const url = '/manager/mngDonors?BloodGroup='+BloodGroup+'&rpp='+RecordsPerPage+'&page='+(current_page-1);
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



    const SendEmail = (id)=>{
        OpenDialogBox({
            id:'sendEmail',
            title:'Send Email',
            titleClass: 'text-center text-white bg-dark',
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