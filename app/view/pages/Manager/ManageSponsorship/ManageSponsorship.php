<?php
/* @var $data array*/
/* @var $value SponsorshipRequest*/
/* @var $total_pages int*/
/* @var $current_page int*/
/* @var $rpp int*/

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
        <div class="d-flex bg-white-0-7 p-1 text-dark justify-content-between align-items-center w-100 flex-row gap-0-5 justify-content-center ">
            <div class="d-flex align-items-center gap-1 w-20">
            </div>
            <div id="Search" class="d-flex gap-1 align-items-center">
                <label for="search" class="search">Search </label>
                <input class="form-control" style="width: 20vw" name="search" id="search" onkeyup="Search('/manager/mngDonors/Search')">
            </div st>
            <div id="Filters" class="d-flex gap-1">
                <div class="form-group">
                    <label for="Status" class="search ">Status</label>
                    <select class="form-control w-20" name="Status" id="Status" onchange="FilterStatus()" style="width: 20vw">
                        <option value="0" >All</option>
                        <option selected value="1" >Pending</option>
                        <option value="2" >Approved</option>
                        <option value="3" >Rejected</option>
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
                <th scope="col">Organization Name</th>
                <th scope="col">Campaign Name</th>
                <th scope="col">Expected Amount</th>
                <th scope="col">Sponsored Date</th>
                <th scope="col">Sponsored Description</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody id="content">
            <div id="loader" class="bg-white absolute w-100 h-100 d-flex justify-content-center align-items-center" style="z-index: 999;height: 90%;margin-top: 35px;">
                <img src="/public/loading2.svg" alt="" width="100px">
            </div>
            <?php

            use App\model\Requests\SponsorshipRequest;

            if (empty($data)):
                ?>
                <tr>
                    <td colspan="8" class="text-center">No Data Found</td>
                </tr>
            <?php
            else:
                $i=1;
                foreach ($data as $value):
                    /** @var $value SponsorshipRequest*/
                    $id = $value->getSponsorshipID();
                    $Description = "";
                    if (strlen($value->getDescription()) > 50)
                        $Description = substr($value->getDescription(), 0, 50) . '<span class="d-flex cursor text-info" onclick="SeeMore(\''.$value->getDescription().'\')">...see More</span>';
                    else
                        $Description = $value->getDescription();
                    ?>
                    <tr>
                        <td data-label="No "><?= $i++;?></td>
                        <td data-label="Full Name " class="font-bold"><?php echo $value->getOrganizationName()?></td>
                        <td data-label="NIC "><?php echo $value->getCampaignName()?></td>
                        <td data-label="Contact No "><?php echo $value->getSponsorshipAmount()?></td>
                        <td data-label="Blood Group "><?php echo $value->getSponsorshipDate()?></td>
                        <td data-label="Address " class="text-left"><?php echo $Description ?></td>
                        <td data-label="Status ">
                            <?php
                            switch ($value->getSponsorshipStatus()):
                                case SponsorshipRequest::STATUS_PENDING:
                                    ?>
                                    <span class="badge bg-warning text-dark">Pending</span>
                                    <?php
                                    break;
                                case SponsorshipRequest::STATUS_APPROVED:
                                    ?>
                                    <span class="badge bg-success text-white">Approved</span>
                                    <?php
                                    break;
                                case SponsorshipRequest::STATUS_REJECTED:
                                    ?>
                                    <span class="badge bg-danger text-white">Rejected</span>
                                    <?php
                                    break;
                                case SponsorshipRequest::STATUS_COMPLETED:
                                    ?>
                                    <span class="badge bg-info text-white">Completed</span>
                                    <?php
                                    break;
                            endswitch;
                            ?>

                        </td>
                        <td class="d-flex justify-content-center gap-0-5 align-items-center">
                            <?php
                            if ($value->getSponsorshipStatus() == SponsorshipRequest::STATUS_PENDING):
                                ?>
                                <button class="text-dark btn gap-0-5 btn-outline-info d-flex align-items-center justify-content-center" onclick="ViewRequest('<?php echo $id ?>')" ><img src="/public/icons/view.svg" width="24px" alt="">View</button>
                            <?php
                            endif;
                            ?>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.5.141/pdf.min.js" integrity="sha512-BagCUdQjQ2Ncd42n5GGuXQn1qwkHL2jCSkxN5+ot9076d5wAI8bcciSooQaI3OG3YLj6L97dKAFaRvhSXVO0/Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    const mystate = {
        pdf: null,
        currentPage: 1,
        zoom: 1
    }
const ViewReport = (report)=>{
    pdfjsLib.getDocument(report).promise.then((pdf) => {
        mystate.pdf = pdf;
        render();
    });

    OpenDialogBox({
        id: 'ViewReport',
        title: 'View Report',
        titleClass : 'bg-dark text-white text-center px-2 py-1',
        popupOrder: 2,
        content: `<div id="pdf" class="w-100 h-100">
                    <div id="pdfLoader" class="bg-white w-100 h-100 d-flex justify-content-center align-items-center" style="z-index: 999;height: 90%;margin-top: 35px;">
                        <img src="/public/loading2.svg" alt="" width="100px">
                    </div>
                    <canvas id="canvasContainer" class="none w-100 h-80 max-h-80vh"></canvas>
                    <div id="navigation_controls" class="none d-flex justify-content-center">
                        <button id="go_previous" class="btn btn-info" onclick="prev()">Previous</button>
                        <div id="current_page" class="d-fle font-boldx flex-center" style="width: 100px">1</div>
                        <button id="go_next" class="btn btn-info" onclick="next()">Next</button>
                    </div>
                </div>`,
        showSuccessButton: false,
        cancelBtnText: 'Close',
    })

}
const prev = () => {
        if (mystate.currentPage <= 1) {
            return;
        }
        mystate.currentPage -= 1;
        document.getElementById('current_page').innerText = mystate.currentPage;
        render();
    }

const next = () => {
        if (mystate.currentPage >= mystate.pdf._pdfInfo.numPages) {
            return;
        }
        mystate.currentPage += 1;
        document.getElementById('current_page').innerText = mystate.currentPage;
        render();
    }

const render = () => {
    mystate.pdf.getPage(mystate.currentPage).then((page) => {
        const canvas = document.getElementById('canvasContainer');
        const ctx = canvas.getContext('2d');

        const viewport = page.getViewport({ scale: mystate.zoom });

        canvas.height = viewport.height;
        canvas.width = viewport.width;

        page.render({
            canvasContext: ctx,
            viewport: viewport
        });
        const pdfLoader = document.getElementById('pdfLoader');
        const canvasContainer = document.getElementById('canvasContainer');
        const navigation_controls = document.getElementById('navigation_controls');
        pdfLoader.classList.add('none');
        canvasContainer.classList.remove('none');
        navigation_controls.classList.remove('none');
    });
}

const ViewRequest = (id)=>{
        const url = '/manager/mngSponsorship/viewRequest';
        const formData = new FormData();
        formData.append('id',id);
        fetch(url,{
            method : 'POST',
            body : formData
        }).then(res=>res.json()).then(data=> {
            console.log(data.data)
            const {organizationName,campaignName,date,amount,report,campaignDate} = data.data;
            // TODO : Style This
            OpenDialogBox({
                id: 'ViewRequest',
                title: 'View Request',
                titleClass: 'bg-dark text-white text-center px-2 py-1',
                content: `
                    <div class="d-flex flex-column gap-1 w-100">
                        <div class="d-flex justify-content-center gap-2 w-100">
                            <div class="d-flex flex-column gap-1">
                            <div class="d-flex flex-center bg-dark text-white px-2 py-0-5">Campaign Requirements</div>
                            <div class="d-flex flex-column gap-1">
                                <div class="d-flex">Organization Name : <span class="font-bold ms-2">${organizationName}</span></div>
                                <div class="d-flex">Campaign Name : <span class="font-bold ms-2">${campaignName}</span></div>
                                <div class="d-flex">Date : <span class="font-bold ms-2">${campaignDate}</span></div>
                                <div class="d-flex">Amount : <span class="font-bold ms-2">LKR ${amount}</span></div>
                                <div class="d-flex align-items-center">Report &nbsp; <button class="btn btn-info" onclick="ViewReport('${report}')">View Report</button></div>
                            </div>
                        </div>
                        </div>
                        <div class="d-flex flex-center">

                        </div>
                    </div>
            `,
                successBtnText: 'Approve',
                cancelBtnText: 'Reject',
                secondaryBtnText: 'Cancel',
                secondaryBtnColor: 'btn-danger',
                successBtnAction: () => {
                    OpenDialogBox({
                        id: 'ApproveRequest',
                        title: 'Approve Request',
                        titleClass: 'bg-dark text-white text-center px-2 py-1',
                        popupOrder: 3,
                        content:`
                            <div class="d-flex">
                                <div>Are you sure you want to approve this request?</div>
                            </div>
                        `,
                        successBtnText: 'Approve',
                        cancelBtnText: 'Cancel',
                        successBtnAction : ()=>{
                            CloseDialogBox('ApproveRequest');
                            const url = '/manager/mngSponsorship/approveRequest';
                            const formData = new FormData();
                            formData.append('id',id);
                            fetch(url,{
                                method : 'POST',
                                body : formData
                            }).then(res=>res.json()).then(data=> {
                                if(data.status){
                                    CloseDialogBox('ViewRequest');
                                    ShowToast({
                                        type : 'success',
                                        message : data.message
                                    });
                                    setTimeout(()=>{
                                        location.reload();
                                    },1000)
                                }else{
                                    ShowToast({
                                        type : 'danger',
                                        message : data.message
                                    })
                                }
                            })
                        }
                    })
                },
                cancelBtnAction: () => {
                    OpenDialogBox({
                        id: 'RejectRequest',
                        title: 'Reject Request',
                        titleClass: 'bg-dark text-white text-center px-2 py-1',
                        popupOrder: 3,
                        content: `
                            <div class="d-flex">
                                <div>Are you sure you want to Reject this request?</div>
                            </div>
                        `,
                        successBtnText: 'Reject',
                        cancelBtnText: 'Cancel',
                        successBtnAction: () => {
                            const url = '/manager/mngSponsorship/rejectRequest';
                            const formData = new FormData();
                            formData.append('id', id);
                            fetch(url, {
                                method: 'POST',
                                body: formData
                            }).then(res => res.json()).then(data => {
                                if (data.status) {
                                    CloseDialogBox('RejectRequest');
                                    CloseDialogBox('ViewRequest');
                                    ShowToast({
                                        type: 'success',
                                        message: data.message
                                    });
                                    setTimeout(() => {
                                        location.reload();
                                    }, 1000)
                                } else {
                                    ShowToast({
                                        type: 'danger',
                                        message: data.message
                                    })
                                }
                            })
                        }

                    })
                },
                secondaryBtnAction: () => {
                    CloseDialogBox('ViewRequest');
                    CloseDialogBox('ViewReport');
                }
            })
        })
}

const SendEmail = (id)=>{
        OpenDialogBox({
            id:'sendEmail',
            title:'Send Email',
            titleClass:'bg-dark text-white text-center px-2 py-1',
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
                form.append('Sponsorship_ID',id);
                form.append('subject',document.getElementById('Subject').value);
                form.append('message',document.getElementById('Body').value);
                const Attachment = document.getElementById('attachment').files[0];
                if (Attachment){
                    form.append('attachment',Attachment);
                }
                fetch('/manager/mngSponsorship/sendEmail',{
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
const SeeMore = (text,entity="Description")=>{
        OpenDialogBox({
            id:'seemore',
            title:entity,
            titleClass:'bg-dark text-white text-center px-2 py-1',
            content:`
                <div class="d-flex">
                    <div>${text}</div>
                </div>
            `,
            showSuccessButton: false,
            cancelBtnText:'Close',
        })
    }

const FilterStatus = ()=>{
        const Status = document.getElementById('Status');
        const status = Status.value;
        const url = '/manager/mngSponsorship?status='+status;
        const loader = document.getElementById('loader');
        loader.classList.remove('none');
        fetch(url,{
            method: 'GET',
        })
            .then(response => response.text())
            .then(data => {
                const content = document.getElementById('content');
                const DParser = new DOMParser();
                const DHTML = DParser.parseFromString(data, 'text/html');
                const table = DHTML.getElementById('content');
                content.innerHTML = table.innerHTML;
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
        const status = document.getElementById('Status').value;
        const url = '/manager/mngSponsorship?status='+status+'&rpp='+RecordsPerPage+'&page='+(current_page+1);
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
        const status = document.getElementById('Status').value;
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
    const ChangeRecordsPerPage = ()=>{
        const RecordsPerPage=document.getElementById('rpp').value;
        // window.location.href="?rpp="+RecordsPerPage
        const status = document.getElementById('Status').value;
        const url = '/manager/mngSponsorship?status='+status+'&rpp='+RecordsPerPage;
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

</script>