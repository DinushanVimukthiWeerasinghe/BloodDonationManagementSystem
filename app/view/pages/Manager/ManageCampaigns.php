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
            .catch(danger => {
                console.danger('Error:', danger);
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
            .catch(danger => {
                console.danger('Error:', danger);
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
                type: 'danger',
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

    const ViewCampaignRequest = (id) =>{
        const url = '/manager/mngCampaign/view?id='+id;
        const form = new FormData();
        form.append('id',id);
        fetch(url,{
            method : 'POST',
            body : form
        })
            .then((res)=>res.json())
            .then((data)=>{
                if (data.status) {
                    let VerificationDetails = 'Not Verified';
                    console.log(data.data)
                    if (data.approved) {
                        const date = new Date(data.approved.Approved_At);
                        const year = date.getFullYear();
                        const month = Months[date.getMonth()];
                        const day = date.getDate();
                        const hours = date.getHours();
                        const minutes = date.getMinutes();
                        data.approved.Approved_At = `${year} - ${month} - ${day} ${hours}:${minutes}`;

                        VerificationDetails = `
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <div class="d-flex">
                                Verified At : ${data.approved.Approved_At}
                            </div>
                            <div class="d-flex">
                                Remarks : ${data.approved.Remarks}
                            </div>
                        </div>
                    `
                    }else if (data.rejected){
                        const date = new Date(data.rejected.Rejected_At);
                        const year = date.getFullYear();
                        const month = Months[date.getMonth()];
                        const day = date.getDate();
                        const hours = date.getHours();
                        const minutes = date.getMinutes();
                        data.rejected.Rejected_At = `${year} - ${month} - ${day} ${hours}:${minutes}`;

                        VerificationDetails = `
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <div class="d-flex">
                                Rejected At : ${data.rejected.Rejected_At}
                            </div>
                            <div class="d-flex">
                                Remarks : ${data.rejected.Remarks}
                            </div>
                        </div>
                    `
                    }
                    console.log(data)
                    OpenDialogBox({
                        id: 'viewCampaignRequest',
                        title: 'Campaign Request',
                        content: `
                    <div class="d-flex flex-column">
                        <div class="d-flex flex-column w-100 justify-content-center align-items-center">
                            <div class="d-flex font-bold my-1 w-100 text-center justify-content-center align-items-center bg-dark py-1 px-2 text-center text-white">Campaign Details</div>
                            <div class="d-flex justify-content-center w-100 gap-1">
                                <div class="d-flex flex-column w-50 flex-center gap-0-5 bg-dark text-white border-radius-10">
                                    <div class="d-flex gap-0-5"><span class="font-bold">Campaign Name </span>: <span>${data.data.Campaign_Name}</span></div>
                                    <div class="d-flex gap-0-5"><span class="font-bold"> </span> Campaign Date: <span>${data.data.Campaign_Date}</div>
                                    <div class="d-flex gap-0-5"><span class="font-bold"> </span>Venue : <span>${data.data.Venue}</div>
                                    <div class="d-flex flex-column gap-0-5">
                                        <div class="font-bold">Description  </div> <div class="px-1" style="max-width: 400px">${data.data.Campaign_Description} Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore, non.</div>
                                    </div>
                                </div>
                                <div class="d-flex w-50 flex-center">
                                    <div id="map" style="height: 300px;width: 300px"></div>
                                    <div id="infowindow-content">

                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="d-flex flex-column w-100 justify-content-center align-items-center">
                            <div class="d-flex w-100 font-bold my-1 text-center justify-content-center align-items-center bg-dark py-1 px-2 text-center text-white">Organization Details</div>
                            <div class="d-flex">
                                        <span class="font-bold">Organization Name </span> : <span>${data.org.Organization_Name}</span>
                            </div>
                            <div class="d-flex">
                                        City : ${data.org.City}
                            </div>
                            <div class="d-flex">
                                        Contact : ${data.org.Contact_No}
                            </div>
                            <div class="d-flex">
                                        Email : ${data.org.Organization_Email}
                            </div>
                        </div>
                        <div class="d-flex flex-column w-100">
                            <div class="d-flex w-100 font-bold my-1 text-center justify-content-center align-items-center bg-dark py-1 px-2 text-center text-white">Verification Details</div>
                            `+VerificationDetails+`
                        </div>
                `,
                        showSuccessButton: false,
                        cancelBtnText: 'Close',
                    })
                    initMap(parseFloat(data.data.Latitude),parseFloat(data.data.Longitude));
                }
            })
    }

    const initMap=(latitude,longitude)=> {
        const place = { lat: 6.8781340776734385, lng: 79.8833214428759 };
        if (latitude && longitude){
            place.lat = latitude;
            place.lng = longitude;
        }
        console.log(place)
        const mylating = { lat: 6.8781340776734385, lng: 79.8833214428759 };

        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 13,
            minZoom: 8,
            maxZoom: 16,
            center: place,
            restriction: {
                latLngBounds: {
                    north: 9.9,
                    south: 5.8,
                    west: 79.8,
                    east: 81.9,
                }
            },
        });
        const infowindow = new google.maps.InfoWindow();

        new google.maps.Marker({
            position: place,
            map,
            title: "Campaign Location",

        })
        // Create the initial InfoWindow.
        let infoWindow = new google.maps.InfoWindow({
            position: place,
            content: "Campaign Location",
        });
        const infowindowContent = document.getElementById("infowindow-content");
        let marker = new google.maps.Marker({
            map,
            anchorPoint: new google.maps.Point(0, -29),

        });
        infoWindow.open({
            anchor:marker,
            map
        });
    }
    const AssignTeam=(id) =>{
        window.location.href = "/manager/mngCampaign/assign-team?campId="+id;
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

    const AcceptCampaignRequest = (id) =>{
        OpenDialogBox({
            id: 'acceptCampaignRequest',
            title: 'Accept Campaign Request',
            titleClass: 'bg-dark text-white',
            content: `
            <div class="d-flex flex-column justify-content-center align-items-center">
            <div class="form-group">
                <label for="remarks">Remarks</label>
                <textarea style="height: 150px" class="form-control" id="remarks" rows="3"></textarea>
            </div>
            `,
            successBtnText: 'Accept',
            successBtnClass: 'btn-success',
            successBtnAction: () => {
                const url = '/manager/mngCampaign/accept';
                const form = new FormData();
                form.append('id',id);
                form.append('remarks',document.getElementById('remarks').value);
                fetch(url,{
                    method : 'POST',
                    body : form
                })
                    .then((res)=>res.json())
                    .then((data)=>{
                        console.log(data)
                        if (data.status){
                            CloseDialogBox('acceptCampaignRequest');
                            ShowToast({
                                title: 'success',
                                message: data.message,
                            })
                            setTimeout(()=>{
                                window.location.reload();
                            },2000)
                        }else{
                            CloseDialogBox('acceptCampaignRequest');
                            ShowToast({
                                title: 'danger',
                                message: data.message,
                            });
                        }
                    })
            }
        })
    }
    const RejectCampaignRequest = (id) =>{
        OpenDialogBox({
            id: 'rejectCampaignRequest',
            title: 'Reject Campaign Request',
            content: `
            <div class="d-flex flex-column justify-content-center align-items-center">
                <div class="form-group">
                    <label for="remarks">Remarks</label>
                    <textarea style="height: 150px" class="form-control" id="remarks" rows="3"></textarea>
                </div>
            </div>
            `,
            successBtnText: 'Reject',
            successBtnClass: 'btn-danger',
            successBtnAction: () => {
                const url = '/manager/mngCampaign/reject?id='+id;
                const form = new FormData();
                form.append('id',id);
                form.append('remarks',document.getElementById('remarks').value);
                fetch(url,{
                    method : 'POST',
                    body : form
                })
                    .then((res)=>res.json())
                    .then((data)=>{
                        if (data.status) {
                            CloseDialogBox('rejectCampaignRequest');
                            ShowToast({
                                title: 'success',
                                message: data.message,
                            })
                            setTimeout(()=>{
                                window.location.reload();
                            },2000)
                        }
                    })
            }
        })
    }

</script>


