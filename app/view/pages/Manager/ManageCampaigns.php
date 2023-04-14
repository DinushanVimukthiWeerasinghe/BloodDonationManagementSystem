<?php

/* @var Campaign $value */

use App\model\Campaigns\Campaign;
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
        <div class="d-flex bg-white-0-7 p-1 text-dark justify-content-between align-items-center w-100 flex-row gap-0-5 justify-content-center ">
            <div></div>
            <div id="Search" class="d-flex gap-1 align-items-center">
                <label for="search" class="search">Search </label>
                <input class="form-control" name="search" style="width: 20vw" id="search" onkeyup="Search('/manager/mngCampaigns/search')">
            </div>
            <div id="Filters" class="d-flex gap-1">
                <div class="form-group">
                    <label for="FilterByStatus" class="search ">Status</label>
                    <select class="form-control" name="filter" id="FilterByStatus" onchange="FilterStatus()" style="width: 150px">
                        <option value="0">All</option>
                        <option selected value="1">Pending</option>
                        <option value="2">Approved</option>
                        <option value="3">Rejected</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex w-100 overflow-y-scroll">
        <table class="w-100">
            <thead class="sticky top-0">
            <tr>
                <th>No</th>
                <th>Campaign Date</th>
                <th>Campaign Name</th>
                <th>No Of Donors</th>
                <th>Venue</th>
                <th>Organization Name</th>
                <th>Request Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody id="content" class="">
            <div id="loader" class="bg-white absolute w-100 h-100 d-flex justify-content-center align-items-center" style="z-index: 999;height: 90%;margin-top: 35px;">
                <img src="/public/loading2.svg" alt="" width="100px">
            </div>
            <?php
            $i=1;
            if (!empty($data)):
            foreach ($data as $value):
                ?>
                <tr class="bg-white-0-7">
                    <td data-label="No"><?= $i++;?>.</td>
                    <td data-label="Date"><?php echo Date::GetProperDate($value->getCampaignDate());?></td>
                    <td data-label="Campaign Name"><?php echo $value->getCampaignName()?></td>
                    <td data-label="Campaign Date"><?php echo $value->getNoOfDonors()?></td>
                    <td data-label="Venue"><?php echo $value->getVenue()?></td>
                    <td data-label="Organization Name"><?php echo $value->getOrganizationName()?></td>
                    <td data-label="Campaign Status"><?php echo $value->getCampaignStatus()?></td>
                    <td>
                        <button class="btn btn-outline-info" onclick="ViewCampaignRequest('<?php echo $value->getCampaignID()?>')">View</button>
                        <?php
                        if (!$value->IsRejected()):
                        ?>
                        <?php
                            if ($value->isVerified()):
                        ?>
                            <button class="btn btn-outline-success" onclick="AssignTeam('<?php echo $value->getCampaignID()?>')">Assign Team</button>
                                    <?php
                            else:
                                    ?>
                                    <button class="btn btn-outline-success" onclick="AcceptCampaignRequest('<?php echo $value->getCampaignID()?>')">Accept</button>
                                    <button class="btn btn-outline-danger" onclick="RejectCampaignRequest('<?php echo $value->getCampaignID()?>')">Reject</button>
                                <?php
                            endif;
                        endif;
                        ?>
                    </td>
                </tr>
            <?php
            endforeach;
            else :?>
            <tr>
                <td colspan="9" class="text-center">No Data Found</td>
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
    const FilterStatus = ()=>{
        const FilterByStatus = document.getElementById('FilterByStatus');
        const status = FilterByStatus.value;
        const url = '/manager/mngCampaigns?status='+status;
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


