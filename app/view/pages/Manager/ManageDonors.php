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
            <div class="d-flex align-items-center gap-1 w-20">
            </div>
            <div id="Search" class="d-flex gap-0-5 align-items-center w-30">
                <label for="search" class="search">Search </label>
                <input class="form-control" name="search" id="search" onkeyup="Search('/manager/mngDonors/Search')">
            </div st>
            <div id="Filters" class="d-flex gap-1 w-40 justify-content-end">
                <div class="form-group w-80 jus">
                    <label for="BloodFilter" class="search w-80 text-right">Blood Group</label>
                    <select class="form-control w-20" name="BloodFilter" id="BloodFilter" onchange="FilterFromBloodGroup()">
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
            <div class="d-flex align-items-center justify-content-center bg-white border-radius-10 <?= ($current_page <= 1)? 'disabled':''?>" style="padding: 0.3rem 0.6rem">
                <a href="<?=$getParams($_GET)?>page=<?=$current_page-1?>">
                    <img src="/public/icons/chevron-left.svg" width="20rem">
                </a>
            </div>
            <div class="d-flex align-items-center justify-content-center bg-white-0-5 border-radius-10 <?= ($total_pages<=$current_page)? 'disabled':''?>" style="padding: 0.3rem 0.6rem">
                <a href="<?=$getParams($_GET)?>page=<?=$current_page+1?>">

                    <img src="/public/icons/chevron-right.svg" width="20rem">
                </a>
            </div>
        </div>
    </div>
</div>

<script>

    const FilterFromBloodGroup = ()=>{
        const BloodGroup=document.getElementById('BloodFilter').value;
        window.location.href = "?BloodGroup="+BloodGroup
    }

    const ViewDonor = (id)=>{
        OpenDialogBox({
            id:'viewDonor',
            title:'View Donor',
            content: `
                <div class="d-flex flex-column">
                    <div class="bg-dark d-flex flex-center text-center text-white py-0-5 px-2">Donor Details</div>
                </div>
            `
        })
    }

    const ChangeRecordsPerPage = ()=>{
        const RecordsPerPage=document.getElementById('rpp').value;
        window.location.href="?rpp="+RecordsPerPage
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