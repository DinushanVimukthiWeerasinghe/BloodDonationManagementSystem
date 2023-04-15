<?php

/* @var string $firstName */

/* @var string $lastName */

use App\model\sponsor\SponsorshipPackages;
use App\model\users\MedicalOfficer;
use App\model\users\Sponsor;
use App\view\components\ResponsiveComponent\Alert\FlashMessage;
use App\view\components\ResponsiveComponent\CardPane\CardPane;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;

//echo Loader::GetLoader();
//echo new primaryTitle('Manage Medical Officers');
/* @var array $data */
/* @var Sponsor $value */


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

<div class="d-flex w-100 flex-column align-items-center bg-white p-1 border-radius-10 m-1">
    <div class="d-flex w-100 flex-row">
        <div class="d-flex bg-white-0-7 p-1 text-dark justify-content-between align-items-center w-100 flex-row gap-0-5 justify-content-center ">
            <div></div>
            <div id="Search" class="d-flex gap-0-5 align-items-center">
                <label for="search" class="search">Search </label>
                <input class="form-control" style="width: 300px" name="search" id="search" onkeyup="Search('/manager/mngSponsors/search')">
            </div>
            <div id="Filters" class="d-flex gap-1">
                <div class="form-group">
                    <label for="filter" class="search ">Package</label>
                    <select class="form-control" style="width: 200px" name="filter" id="filter">
                        <?php
                        /* @var $packages array*/
                        /* @var $package SponsorshipPackages*/
                            foreach ($packages as $package):
                                $packageID=$package->getPackageID();
                                $packageName=$package->getPackageName();
                                $packagePrice=$package->getPackagePrice();
                        ?>
                        <option value="<?php echo $packageID?>"><?php echo $packageName?> - LKR <?= number_format(intval($packagePrice),0,'.',",")?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex w-100 overflow-y-scroll" style="margin-left: 50px">
        <table class="w-100">
            <thead class="sticky top-0">
            <tr>
                <th scope="col">No</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">No of Sponsored</th>
                <th scope="col">Package</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody id="content">
            <div id="loader" class="bg-white absolute w-100 h-100 d-flex justify-content-center align-items-center" style="z-index: 999;height: 90%;margin-top: 35px;">
                <img src="/public/loading2.svg" alt="" width="100px">
            </div>
            <?php
            $i=1;
            foreach ($data as $value):
                $id=$value->getID();
                $image=$value->getProfileImage();
                $name=$value->getSponsorName();
                $email=$value->getEmail();
//                $noOfSponsored=$value->getNoOfSponsored();
                $noOfSponsored=4;
                $status=$value->getStatus();
//                $package=$value->getPackage();
                $package="Gold";
                ?>
                <tr>
                    <td data-label="No "><?php echo $i++?></td>
                    <td data-label="Name " class="font-bold"><?php echo $name?></td>
                    <td data-label="Email "><?php echo $email?></td>
                    <td data-label="No Of Sponsors "><?php echo $noOfSponsored?></td>
                    <td data-label="Obtained Package "><?php echo $package?></td>
                    <td data-label="Status "><?php echo $status?></td>
                    <td class="d-flex justify-content-center gap-0-5 align-items-center">
                        <button class="text-dark btn gap-0-5 btn-outline-success d-flex align-items-center justify-content-center" onclick="ViewSponsor('<?php echo $id ?>')" ><img src="/public/icons/eye.svg" width="24px" alt="">View</button>
                        <button class="text-dark btn gap-0-5 btn-outline-info d-flex align-items-center justify-content-center" onclick="SendEmail('<?php echo $id ?>')" ><img src="/public/icons/mail.png" width="24px" alt="">Send Email</button>
                    </td>
                </tr>
            <?php
            endforeach;
            ?>

            </tbody>
        </table>
    </div>
    <div id="tableFooter" class="py-0-5 bg-white w-100 d-flex justify-content-end align-items-center">
        <div class="d-flex">
            <div class="d-flex align-items-center justify-content-center">
                <div class="d-flex gap-1 align-items-center">
                    <label for="page" class="search">Record Per Page</label>
                    <div class="none">
                        <span id="total_pages"><?=$total_pages?></span>
                        <span id="current_page"><?=$current_page?></span>
                    </div>
                    <select class="px-2 py-0-5" name="page" id="rpp" onchange="ChangeRecordsPerPage()">
                        <?php
                        $i = 5;
                        while ($i < 20):
                            /** @var int $rpp */
                            if ((int)$rpp === $i):
                                ?>
                                <option selected value="<?= $i ?>"><?= $i ?></option>
                            <?php
                            else :
                                ?>
                                <option value="<?= $i ?>"><?= $i ?></option>
                            <?php
                            endif;
                            ?>
                            <?php
                            $i = $i + 5;
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

    const ViewSponsor = (id)=>{
        console.log("View Sponsor")
    }

    const ChangeRecordsPerPage = ()=>{
        const RecordsPerPage=document.getElementById('rpp').value;
        // window.location.href="?rpp="+RecordsPerPage
        const status = document.getElementById('FilterByStatus').value;
        const url = '/manager/mngSponsors?status='+status+'&rpp='+RecordsPerPage;
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
        console.log(current_page)
        console.log(total_pages)
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
        const url = '/manager/mngCampaigns?status='+status+'&rpp='+RecordsPerPage+'&page='+(current_page+1);
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
        console.log(current_page)
        console.log(total_pages)
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
        const url = '/manager/mngCampaigns?status='+status+'&rpp='+RecordsPerPage+'&page='+(current_page-1);
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
</script>

