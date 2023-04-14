<?php
/* @var $data array*/
/* @var $value BloodRequest*/
/* @var $total_pages int*/
/* @var $current_page int*/
use App\model\Requests\BloodRequest;
use App\model\Utils\Date;
use App\view\components\ResponsiveComponent\CardPane\CardPane;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;

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


<!--TODO Implement Emergency Request and Normal Request Filter-->


<div class="d-flex w-100 flex-column align-items-center bg-white p-1 border-radius-10 m-1">
    <div class="d-flex w-100 flex-row">
        <div class="d-flex bg-white-0-7 p-1 text-dark justify-content-between align-items-center w-100 flex-row gap-0-5 justify-content-center ">
            <div></div>
            <div id="Search" class="d-flex gap-1 align-items-center">
                <label for="search" class="search">Search </label>
                <input class="form-control" name="search" style="width: 20vw" id="search" onkeyup="Search('/manager/mngRequest/search')">
            </div>
            <div id="Filters" class="d-flex gap-1">
                <div class="form-group">
                    <label for="FilterByStatus" class="search ">Status</label>
                    <select class="form-control" name="filter" id="FilterByStatus" onchange="FilterStatus()">
                        <option value="0">All</option>
                        <option selected value="1">Pending</option>
                        <option value="2">Supplied</option>
                        <option value="3">Inform to Donor</option>
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
                <th scope="col">Request By</th>
                <th scope="col">Current Status</th>
                <th scope="col">Date</th>
                <th scope="col">Type</th>
                <th scope="col">Blood Group</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody id="content">
            <div id="loader" class="bg-white absolute w-100 h-100 d-flex justify-content-center align-items-center" style="z-index: 999;height: 90%;margin-top: 35px;">
                <img src="/public/loading2.svg" alt="" width="100px">
            </div>
            <?php
            if (!empty($data)):
            $i=1;
            foreach ($data as $value):
                $id = $value->getRequestID();
            ?>
            <tr>
                <td><?= $i++;?></td>
                <td><?php echo $value->getRequestedBy()?></td>
                <?php
                if ($value->getAction()===BloodRequest::REQUEST_STATUS_PENDING):
                ?>
                <td><?php echo $value->getActionText()?></td>
                <?php
                elseif ($value->getAction()===BloodRequest::REQUEST_STATUS_FULFILLED):
                ?>
                <td class="text-success font-bold"><?php echo $value->getActionText()?></td>
                <?php
                elseif ($value->getAction()===BloodRequest::REQUEST_STATUS_SENT_TO_DONOR):
                ?>
                <td class="text-danger font-bold"><?php echo $value->getActionText()?></td>
                <?php
                endif;
                ?>
                <td><?php echo Date::GetProperDate($value->getRequestedAt())?></td>
                <td><?php echo $value->getType()?></td>
                <td><?php echo $value->getBloodGroup()?></td>
                <?php
                if ($value->getAction()===BloodRequest::REQUEST_STATUS_PENDING):
                ?>
                <td class="d-flex justify-content-center gap-0-5 align-items-center sticky right-0 bg-white">
                    <button class="text-dark btn gap-0-5 btn-outline-success d-flex align-items-center justify-content-center" onclick="ViewBloodRequest('<?php echo $id ?>')" ><img src="/public/icons/eye.svg" width="24px" alt="">View</button>
                    <button class="text-dark btn gap-0-5 btn-outline-info d-flex align-items-center justify-content-center" onclick="SupplyRequest('<?php echo $id ?>')" ><img src="/public/icons/checkCircle.svg" width="24px" alt="">Supply</button>
                </td>
                <?php
                else:
                ?>
                <td class="d-flex justify-content-center gap-0-5 align-items-center sticky right-0 bg-white">
                    <button class="text-dark btn gap-0-5 btn-outline-success d-flex align-items-center justify-content-center" onclick="ViewOnlyBloodRequest('<?php echo $id ?>')" ><img src="/public/icons/eye.svg" width="24px" alt="">View</button>
                </td>
                <?php
                endif;
                ?>
            </tr>
            <?php
            endforeach;
            else :?>
                <tr>
                    <td colspan="7" class=" text-center"><b>No Data Found</b></td>
                </tr>
            <?php
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

<script>
    const ChangeRecordsPerPage = ()=>{
        const RecordsPerPage=document.getElementById('rpp').value;
        // window.location.href="?rpp="+RecordsPerPage
        const status = document.getElementById('FilterByStatus').value;
        const url = '/manager/mngCampaigns?status='+status+'&rpp='+RecordsPerPage;
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

    const  ViewBloodRequest = (id) => {
        const url = `/manager/mngRequests/find`;
        const formData = new FormData();
        formData.append('id', id);
        fetch(url, {
            method: 'POST',
            body: formData
        }).then(response => response.json())
            .then(data => {
                if (data.data){
                    const Type = data.data.Type;
                    OpenDialogBox({
                        id: 'ViewBloodRequest',
                        title: 'View Blood Request',
                        titleClass: 'text-center bg-dark py-1 text-white font-bold px-2',
                        content:`
                        <div class="d-flex justify-content-around align-items-center">
                            <div class="d-flex">
                                <img src="/public/images/icons/BloodType/${data.data.BloodGroup}.png" width="80px" alt="">
                            </div>
                            <div class="d-flex flex-column justify-content-center gap-1 align-items-center">
                                <div class="d-flex">
                                    <div  class="font-bold">Requested By</div>
                                    <div class="px-1"><b>:</b></div>
                                    <div>${data.data.Requested_By}</div>
                                </div>
                                <div class="d-flex">
                                    <div class="font-bold">Requested At</div>
                                    <div class="px-1">:</div>
                                    <div>${data.data.Requested_At}</div>
                                </div>
                                <div class="d-flex">
                                    <div  class="font-bold">Request Type</div>
                                    <div class="px-1">:</div>
                                    <div>${Type}</div>
                                </div>
                                <div class="d-flex">
                                    <div  class="font-bold">Volume</div>
                                    <div class="px-1">:</div>
                                    <div>${data.data.Volume} ml</div>
                                </div>
                                <div class="d-flex">
                                    <div  class="font-bold">Remarks</div>
                                    <div class="px-1">:</div>
                                    <div>${data.data.Remarks ?? "No Remarks"}</div>
                                </div>
                            </div>
                        </div>
                        `,
                        successBtnText: 'Supply',
                        successBtnAction: () => {
                            CloseDialogBox('ViewBloodRequest')
                            SupplyRequest(id)
                        },
                        secondaryBtnText: 'Inform to Donor',
                        secondaryBtnColor: 'btn-outline-info',
                        secondaryBtnAction: () => {

                            CloseDialogBox('ViewBloodRequest')
                            OpenDialogBox({
                                id: 'InformToDonor',
                                title: 'Inform to Donor',
                                titleClass: 'text-center bg-dark py-1 text-white font-bold px-2',
                                content: `
                                <div class="d-flex flex-column">
                                    <div>The Donor will be informed about the request</div>
                                    <div>Are you sure?</div>
                                </div>
                                `,
                                successBtnText: 'Yes',
                                successBtnAction: ()=>{
                                    const url='/manager/mngRequests/send-to-donor';
                                    const formData = new FormData();
                                    formData.append('Request_ID', id);
                                    fetch(url, {
                                        method: 'POST',
                                        body: formData
                                    }).then(response => response.json())
                                        .then(data => {
                                            console.log(data)
                                            if (data.status){
                                                CloseDialogBox('InformToDonor')
                                                ShowToast({
                                                    title: 'Success',
                                                    message: 'Donor is informed',
                                                    type: 'success',
                                                    duration: 3000
                                                })
                                                setTimeout(()=>{
                                                    window.location.reload()
                                                }, 3000)
                                            }
                                        })
                                },
                                cancelBtnText: 'No',
                            })
                        },
                    })
                }
            })
    }
    const  ViewOnlyBloodRequest = (id) => {
        const url = `/manager/mngRequests/find`;
        const formData = new FormData();
        formData.append('id', id);
        fetch(url, {
            method: 'POST',
            body: formData
        }).then(response => response.json())
            .then(data => {
                console.log(data)
                if (data.data){
                    const Type = data.data.Type;
                    let Action = '';
                    if (data.data.Action === 1){
                        Action = "Request Pending"
                    }else if (data.data.Action === 2){
                        Action = "Request Fulfilled"
                    }else if (data.data.Action === 3){
                        Action = "Request Sent to Donor"
                    }
                    OpenDialogBox({
                        id: 'ViewBloodRequest',
                        title: 'View Blood Request',
                        titleClass: 'text-center bg-dark py-1 text-white font-bold px-2',
                        content:`
                        <div class="d-flex justify-content-around align-items-center">
                            <div class="d-flex">
                                <img src="/public/images/icons/BloodType/${data.data.BloodGroup}.png" width="80px" alt="">
                            </div>
                            <div class="d-flex flex-column justify-content-center gap-1 align-items-center">
                                <div class="d-flex">
                                    <div  class="font-bold">Requested By</div>
                                    <div class="px-1"><b>:</b></div>
                                    <div>${data.data.Requested_By}</div>
                                </div>
                                <div class="d-flex">
                                    <div class="font-bold">Requested At</div>
                                    <div class="px-1">:</div>
                                    <div>${data.data.Requested_At}</div>
                                </div>
                                <div class="d-flex">
                                    <div  class="font-bold">Request Type</div>
                                    <div class="px-1">:</div>
                                    <div>${Type}</div>
                                </div>
                                <div class="d-flex">
                                    <div  class="font-bold">Volume</div>
                                    <div class="px-1">:</div>
                                    <div>${data.data.Volume} ml</div>
                                </div>
                                <div class="d-flex">
                                    <div  class="font-bold">Remarks</div>
                                    <div class="px-1">:</div>
                                    <div>${data.data.Remarks ?? "No Remarks"}</div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex px-2 my-2 justify-content-center align-items-center py-0-5 bg-dark-0-7 text-white">
                                    <div  class="font-bold">Taken Action</div>
                                    <div class="px-1">:</div>
                                    <div>${Action}</div>
                        </div>
                        `,
                        showSuccessButton: false,
                        cancelBtnText: 'Close',
                    })
                }
            })
    }

    const  SupplyRequest = (id) => {
        const url = `/manager/mngRequests/find`;
        const formData = new FormData();
        formData.append('id', id);
        fetch(url, {
            method: 'POST',
            body: formData
        }).then(response => response.json())
            .then(data => {
                if (data.data) {
                    OpenDialogBox({
                        id: 'SupplyRequest',
                        title: 'Supply Blood Request',
                        titleClass: 'text-center bg-dark py-1 text-white font-bold px-2',
                        content: `
                        <div class="d-flex justify-content-around align-items-center gap-1">
                            <div class="d-flex">
                                <img src="/public/images/icons/BloodType/${data.data.BloodGroup}.png" width="80px" alt="">
                            </div>
                            <div class="d-flex flex-column gap-1 justify-content-center align-items-center">
                                <div class="d-flex w-100 align-items-center">
                                    <div>Remarks</div>
                                    <div class="px-1">:</div>
                                    <div><textarea name="" id="SupplyRemarks" cols="30" style="resize: none;min-height: 100px" maxlength="100"
                                                    rows="10" class="form-control"></textarea></div>
                                </div>
                            </div>

                        </div>
                        `,
                        successBtnText: 'Supply',
                        successBtnAction: () => {
                            const url = '/manager/mngRequests/supply';
                            const formData = new FormData();
                            formData.append('Request_ID', id);
                            formData.append('Remarks', document.getElementById('SupplyRemarks').value);
                            fetch(url, {
                                method: 'POST',
                                body: formData
                            }).then(response => response.json())
                                .then(data => {
                                    console.log(data)
                                    if (data.status) {
                                        CloseDialogBox('SupplyRequest')
                                        ShowToast({
                                            title: 'Success',
                                            message: 'Request is fulfilled',
                                            type: 'success',
                                            duration: 3000
                                        })
                                        setTimeout(() => {
                                            window.location.reload()
                                        }, 3000)
                                    }
                                })
                        },
                    })
                }
                })
    }
    const FilterStatus = ()=>{
        const FilterByStatus = document.getElementById('FilterByStatus');
        const status = FilterByStatus.value;
        const url = '/manager/mngRequests?status='+status;
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








