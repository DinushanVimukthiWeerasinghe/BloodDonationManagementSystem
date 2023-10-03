<!--<pre>-->
<?php
/* @var  $Campaign Campaign */
/* @var  $MedicalTeam MedicalTeam */
/* @var  $MedicalOfficer MedicalOfficer */
/* @var  $Organization Organization */
/** @var string $MAP_API_KEY */
/** @var string $Position */

use App\model\Campaigns\Campaign;
use App\model\MedicalTeam\MedicalTeam;
use App\model\MedicalTeam\TeamMembers;
use App\model\users\MedicalOfficer;
use App\model\users\Organization;

//
//print_r($MedicalTeam->getTeamMembers());
//exit();
?>
<div class="d-flex w-100 m-1 border-radius-10 bg-white justify-content-center gap-1 ">

    <?php
        if (!empty($Campaign) && !empty($MedicalTeam) && !empty($Organization)):
            $Description = strlen($Campaign->getCampaignDescription()) > 100 ? substr($Campaign->getCampaignDescription(), 0, 100) . '... <button class="btn btn-info" onclick="SeeMore(\''.$Campaign->getCampaignDescription().'\')" style="font-size: 0.8rem;padding: 0.3rem">See more</button>' : $Campaign->getCampaignDescription();
    ?>
    <div id="campaign-information" class="d-flex flex-column align-items-center w-70 m-1 ">
        <div class="d-flex flex-column w-100 p-1 align-items-center">
            <div class="d-flex text-4xl font-bold mb-1 bg-dark py-0-5 px-2 text-center text-white w-80 justify-content-center"> <span class="ml-1"><?= $Campaign->getCampaignName();?></span></div>
            <div class="d-flex w-80 justify-content-center align-items-start gap-1">
                <div class="d-flex w-60 flex-column align-items-start justify-content-center gap-0-5">
                    <div class="d-flex flex-center"> <span class="font-bold text-md">Venue:</span>  <span class="ml-1"><?= $Campaign->getVenue();?></span></div>
                    <div class="d-flex flex-center"> <span class="font-bold text-md">Date:</span>  <span class="ml-1"><?= $Campaign->getCampaignDate();?></span></div>
                    <div class="d-flex flex-center"> <span class="font-bold text-md">Description:</span>  <span class="ml-1"><?= $Description?></span></div>
                    <?php
                    if ($Campaign->IsReported()):
                    ?>
                    <div class="bg-danger d-flex text-white text-center px-1 py-0-5 font-bold text-xl border-radius-10 gap-1 justify-content-center"> <i class="fa-solid fa-circle-exclamation"></i><span class="font-bold text-xl">Campaign Reported</span></div>
                    <?php
                    endif;
                    ?>

                </div>
                <?php
                    if ($Campaign->IsReported()):
                ?>
                <div class="d-flex flex-column w-40 justify-content-center align-items-center gap-0-5">
                    <div class="d-flex flex-center"> <span class="font-bold text-md">Reported By:</span>  <span class="ml-1"><?= $Campaign->getReportedBy()->getFullName();?></span></div>
                    <div class="d-flex flex-center"> <span class="font-bold text-md">Reported Date:</span>  <span class="ml-1"><?= $Campaign->getReportedDate();?></span></div>
                    <div class="d-flex flex-center"> <span class="font-bold text-md">Reported Reason:</span>  <span class="ml-1"><?= $Campaign->getReportedReason();?></span></div>
                    <?php
                    if ($Campaign->IsReportedByMe()):
//                    Add Undo Report Button
                        ?>
                        <div class="d-flex flex-center">
                            <button class="btn btn-outline-danger d-flex gap-1 flex-center" onclick="UndoReportCampaign('<?=$Campaign->getCampaignID()?>')">
                                <i class=" font-bold text-md fa-solid fa-rotate-left"></i>
                                <span class=" font-bold text-md"> Undo Report Campaign</span>
                            </button>
                        </div>
                    <?php
                    endif;
                    ?>
                </div>
                <?php
                else:
                ?>
                <div class="d-flex justify-content-center align-items-start w-30 gap-0-5 flex-column">
                    <button class="btn btn-outline-danger d-flex gap-1 flex-center" onclick="ReportCampaign('<?=$Campaign->getCampaignID()?>','reject')"><i class=" font-bold text-md fa-solid fa-circle-xmark"></i> <span class=" font-bold text-md"> Report Campaign</span></button>
                </div>
                <?php
                endif;
                ?>
            </div>
        </div>
        <div class="d-flex flex-column w-100 p-1 align-items-center">

            <div class="d-flex flex-column w-100 justify-content-center align-items-center">
                <div class="d-flex text-4xl font-bold mb-1 bg-dark py-0-5 px-2 text-center text-white justify-content-center w-80"> <span class="ml-1"><?= $Organization->getOrganizationName();?> Organization</span></div>
                <div class="d-flex w-80 justify-content-center align-items-start gap-1">
                    <div class="d-flex w-60 flex-column gap-0-5">
                        <div class="d-flex justify-content-start align-items-center"> <span class="font-bold text-md">Address </span> : <span class="ml-1"><?= $Organization->getAddress();?></span></div>
                        <div class="d-flex justify-content-start align-items-center"> <span class="font-bold text-md">Contact No </span> : <span class="ml-1"><?= $Organization->getContactNo();?></span></div>
                        <div class="d-flex justify-content-start align-items-center"> <span class="font-bold text-md">Email </span> : <span class="ml-1"><?= $Organization->getEmail();?></span></div>
                        <div class="d-flex justify-content-start align-items-center"> <span class="font-bold text-md"> Status </span> : <span class="ml-1 <?=$Organization->getVerificationStatus()===Organization::ORGANIZATION_VERIFIED ? 'bg-success' : ($Organization->getVerificationStatus()===Organization::ORGANIZATION_REJECTED ? 'bg-red-8' :'bg-yellow-8')?> px-2 py-0-5 text-white text-center font-bold border-radius-10"><?= $Organization->getVerificationStatus(true);?> Organization</span></div>
                    </div>
                    <div class="d-flex flex-column w-30 justify-content-center gap-0-5 align-items-start">
                        <?php
                        if (!$Organization->IsVerified() && !$Organization->IsReported()):
                        ?>

                        <button class="btn btn-outline-success d-flex gap-1 flex-center" onclick="VerifyOrganization('<?= $Organization->getOrganizationID();?>','verify')"><i class=" font-bold text-md fa-solid fa-circle-check"></i><span class=" font-bold text-md">Verify Organization</span></button>
                        <?php
                        endif;
                        if ($Position===MedicalTeam::TEAM_LEADER && !$Organization->IsReported()):
                        ?>
                        <button class="btn btn-outline-danger d-flex gap-1 flex-center" onclick="VerifyOrganization('<?= $Organization->getOrganizationID();?>','reject')"><i class=" font-bold text-md fa-solid fa-circle-xmark"></i><span class=" font-bold text-md">Report Organization</span></button>
                        <?php
                        endif;
                        ?>
                        <?php
                        if ($Organization->IsVerified()):
                        ?>
                        <div class="d-flex flex-column w-100 justify-content-center align-items-start gap-0-5">
                            <div class="d-flex justify-content-start align-items-center"> <span class="font-bold text-md">Verified By </span> : <span class="ml-1"><?= $Organization->getVerifierName()?></span></div>
                            <div class="d-flex justify-content-start align-items-center"> <span class="font-bold text-md">Verified Date </span> : <span class="ml-1"><?= $Organization->getVerifiedAt();?></span></div>
                        </div>
                        <?php
                        endif;
                        ?>
                            <?php
                            if ($Organization->IsReported()):
                            ?>
                                <div class="d-flex flex-column w-100 justify-content-center align-items-start gap-0-5">
                                    <div class="d-flex justify-content-start align-items-center"> <span class="font-bold text-md">Reported By </span> : <span class="ml-1"><?= $Organization->getReporterName()?></span></div>
                                    <div class="d-flex justify-content-start align-items-center"> <span class="font-bold text-md">Reported At </span> : <span class="ml-1"><?= $Organization->getReporterAt();?></span></div>
                                </div>
                        <?php
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-center">
            <div id="Map-Container" style="width: 45vw;height: 40vh" class="border-radius-10">
                <div id="map" class="w-100 h-100 border-radius-5" style=""></div>
                <div id="place"></div>
            </div>
        </div>

    </div>
    <div id="campaign-information" class="d-flex justify-content-center w-30 align-items-center m-1">
        <div class="d-flex flex-column w-100 border-2 p-1 gap-1">
            <div class="d-flex text-3xl bg-dark text-white py-0-5 px-1 text-center justify-content-center"> <span class="ml-1">Assigned Medical Team</span></div>
            <div class="d-flex">No Of Officers: <span class="ml-1"><?= $MedicalTeam->getNoOfMembers();?></span></div>
            <div class="d-flex w-100 overflow-y-overlay justify-content-start align-items-start" style="max-height: 60vh;min-height: 60vh">
                <table class="table " >
                    <thead class="sticky top-0">
                    <tr>
                        <th>Officer Name</th>
                        <th>Officer NIC</th>
                        <th>Task</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $MedicalOfficers = $MedicalTeam->getTeamMembers();
                    foreach ($MedicalOfficers as $MedicalOfficer){
                        ?>
                        <tr>
                            <td><?= $MedicalOfficer->getFullName();?></td>
                            <td><?= $MedicalOfficer->getNIC();?></td>
                            <td><?= $MedicalOfficer->getMedicalTeamTask($MedicalTeam->getTeamID());?></td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <?php
            if ($Position===MedicalTeam::TEAM_LEADER && $Organization->IsVerified() && !$Organization->IsReported()):
            $MedicalOfficers = $MedicalTeam->getTeamMembers();
            if (!$Campaign->IsReported()):
            ?>
                <button class="btn btn-outline-success" onclick="AllocateTask()">Allocate Task</button>
                <?php
            else:
                ?>
            <button class="btn btn-disabled btn-outline-success-disabled" data-disable="Task Allocation Disabled" data-btn-text="Allocate Task"></button>
                <?php
            endif;
                ?>
                <?php
                    // Check the Time is 12.00 P.M
            $now = date("H:i:s");
                if ($now>= date("H:i:s",strtotime("12:00:00")) && !$Campaign->IsReported()):
                ?>
                    <button class="btn btn-danger" onclick="EndCampaign()">End Campaign</button>
                <?php
                endif;
                ?>

            <?php
            endif;
            ?>

        </div>
    </div>
    <?php
        else:
    ?>
    <div class="d-flex flex-column justify-content-center align-items-center w-100 m-1 ">
        <div class="d-flex flex-column w-100 p-1 align-items-center">
            <div class="d-flex text-4xl font-bold mb-1"> <span class="ml-1">No Campaigns For Today!</span></div>
        </div>
    </div>
    <?php
        endif;
    ?>
</div>
<script>
    <?php
        if($MedicalTeam):
        ?>
    const AllocateTask = ()=>{
        OpenDialogBox({
            id: "AllocateTask",
            title: "Allocate Task",
            titleClass: "text-center text-2xl font-bold bg-dark text-white p-1",
            content:`
                        <div class="d-flex flex-column w-100 p-1 align-items-center">
                            <table class="" id="AllocateTask" >
                                  <thead>
                                        <tr>
                                           <th>Officer Name</th>
                                           <th>Officer NIC</th>
                                           <th>Task</th>
                                        </tr>
                                  </thead>
                                  <tbody>
                                  <?php
                                        $MedicalOfficers = $MedicalTeam->getTeamMembers();
                                        $CurrentTask = MedicalOfficer::getTaskOfCampaign($MedicalOfficer->getID(),$Campaign->getCampaignID());
                                        foreach ($MedicalOfficers as $MedicalOfficer){
                                  ?>
                                        <tr>
                                            <td><?= $MedicalOfficer->getFullName();?></td>
                                            <td><?= $MedicalOfficer->getNIC();?></td>
                                            <td>
                                                <select class="form-select" id="<?=$MedicalOfficer->getID()?>">
                                                    <?php
                                                        $Tasks= TeamMembers::getTasks();
                                                        foreach ($Tasks as $key=>$Task){
                                                            if ($CurrentTask===$Task){
                                                    ?>
                                                    <option value="<?= $key;?>" selected><?= $Task;?></option>
                                                    <?php
                                                            }
                                                            else
                                                            {
                                                    ?>
                                                      <option value="<?= $key;?>"><?= $Task;?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <?php
                                            }
                                        ?>
                                            </tbody>
                                        </table>

                                </select>
                            </div>
                        </div>
                    `,
            successBtnText: "Allocate",
            successBtnAction: ()=>{
                const AllocateTask = document.getElementById("AllocateTask");
                const Officers = AllocateTask.getElementsByTagName("tbody")[0].getElementsByTagName("tr");
                const OfficerTasks = [];
                for (let i = 0; i < Officers.length; i++) {
                    const Officer = Officers[i];
                    const OfficerID = Officer.getElementsByTagName("td")[2].getElementsByTagName("select")[0].id;
                    const OfficerTask = Officer.getElementsByTagName("td")[2].getElementsByTagName("select")[0].value;
                    OfficerTasks.push({OfficerID,OfficerTask});
                }
                const url ="/mofficer/medicalteam/allocateTask";
                const formData = new FormData();
                formData.append("MedicalTeamID",'<?= $MedicalTeam->getTeamID();?>');
                formData.append("OfficerTasks",JSON.stringify(OfficerTasks));
                fetch(url,{
                    method: "POST",
                    body: formData
                }).then((response)=>{
                    if (response.ok){
                        return response.json();
                    }else{
                        throw new Error("Something Went Wrong");
                    }
                }).then((data)=>{
                    console.log(data)
                    if (data.status){
                        CloseDialogBox("AllocateTask");
                        ShowToast({
                            message: data.message,
                            type: "success"
                        })
                        setTimeout(()=>{
                            location.reload();
                        },1000);
                    }else{
                        alert(data.message);
                    }
                }).catch((error)=>{
                    alert(error.message);

                })
            }
        })
    }
    const EndCampaign = ()=>{
        OpenDialogBox({
            title: "End Campaign",
            titleClass : "bg-dark text-white",
            content: `
                        <div class="d-flex flex-column w-100 p-1 align-items-center">
                            <div class="d-flex font-bold mb-1"> <span class="ml-1">Are You Sure You Want To End The Campaign?</span></div>
                        </div>
                    `,
            successBtnText: "End Campaign",
            cancelBtnText: "Cancel",
            successBtnAction : ()=>{
                const url ="/mofficer/campaigns/endCampaign";
                const formData = new FormData();
                formData.append("CampaignID",'<?= $Campaign->getCampaignID();?>');
                const successAction = ()=>{
                    ShowToast({
                        message: "Campaign Ended Successfully",
                        type: "success"
                    })
                    setTimeout(()=>{
                        location.reload();
                    },1000);
                }
                fetch(url,{
                    method: "POST",
                    body: formData
                }).then((response)=>response.json())
                    .then((data)=>{
                    console.log(data)
                    if (data.status){
                        CloseDialogBox();
                        successAction();
                    }else{
                        console.log(data);
                    }
                })
            }
        })
    }
    <?php
        endif;
    ?>
    function initMap() {
        const colombo = { lat: 6.8781340776734385, lng: 79.8833214428759 };
        const mylating = { lat: 6.8781340776734385, lng: 79.8833214428759 };
        <?php
        if (!empty($Campaign) && !empty($MedicalTeam) && !empty($Organization)):
        ?>
        const Marker = { lat: <?= $Campaign->getLatitude();?>, lng: <?= $Campaign->getLongitude();?> };
        <?php
        endif;
        ?>

        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 13,
            minZoom: 8,
            maxZoom: 16,
            center: Marker,
            restriction: {
                latLngBounds: {
                    north: 9.9,
                    south: 5.8,
                    west: 79.8,
                    east: 81.9,
                }
            },
        });


        // if (navigator.geolocation) {
        //     navigator.geolocation.getCurrentPosition(function (position) {
        //         initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
        //         map.setCenter(initialLocation);
        //     });
        // }
        // The map, centered at Colombo and restricted to the given sri lanka



        // Create the initial InfoWindow.
        // let infoWindow = new google.maps.InfoWindow();
        const marker = new google.maps.Marker({
            map,
            position: Marker,
        });

        infoWindow.open(map);
        // Configure the click listener.
        // map.addListener("click", (mapsMouseEvent) => {
        //     // Close the current InfoWindow.
        //     console.log('clicked')
        //     infoWindow.close();
        //     const place= mapsMouseEvent.latLng;
        //     const placeJSON= JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2);
        //     // Create a new InfoWindow.
        //     infoWindow = new google.maps.InfoWindow({
        //         position: place,
        //     });
        //     marker.setPosition(place);
        //     marker.setTitle("Set Locations");
        //
        //
        //     infoWindow.setContent(
        //         'Campaign Is here!'
        //     );
        //     infoWindow.open({
        //         anchor:marker,
        //         map
        //     });
        // });
    }
    window.initMap = initMap;


    const VerifyOrganization = (OrganizationID,status)=>{
        const url = "/mofficer/campaigns/verifyOrganization";
        const form = new FormData();
        form.append("OrganizationID",OrganizationID);
        form.append("Status",status);
        const contentMessage = status==='verify' ? "Are You Sure You Want To Verify This Organization?" : "Are You Sure You Want To Report This Organization?";
        const title = status==='verify' ? "Verify Organization" : "Report Organization";
        const button = status==='verify' ? "Verify" : "Report";
        OpenDialogBox({
            id: "VerifyOrganization",
            title: title,
            titleClass : "bg-dark text-white text-center",
            content: `
                     <div class="d-flex flex-center text-center font-bold text-md">
                        <span class="ml-1">${contentMessage}</span>
                     <div>
            `,
            successBtnText: button,
            successBtnAction: ()=>{
                if (status==="reject"){
                    OpenDialogBox({
                        id: "reject-reason",
                        title : "Report Reason",
                        titleClass: 'bg-dark px-2 py-1 text-center text-white',
                        popupOrder: 1,
                        content: `
                            <div class="d-flex flex-column w-100 p-1 align-items-center">
                                <div class="d-flex font-bold mb-1"> <span class="ml-1">Please Enter The Reason For Reporting This Organization</span></div>
                                <div class="d-flex w-100">
                                    <textarea id="reason" style="height: 100px;padding: 0.5rem" class="form-control" rows="5" placeholder="Enter Reason Here"></textarea>
                                </div>
                            </div>
                        `,
                        successBtnAction: ()=>{
                            const reason = document.getElementById("reason").value;
                            if (reason.length<5){
                                ShowToast({
                                    id:"Reason",
                                    type:"error",
                                    message:" Message Length should be greater than 5 Character "
                                })
                                return;
                            }
                            form.append("Reason",reason);
                            fetch(url,{
                                method: "POST",
                                body: form
                            }).then((response)=>{
                                if (response.ok){
                                    return response.json();
                                }else{
                                    throw new Error("Something Went Wrong");
                                }
                            }).then((data)=>{
                                console.log(data)
                                if (data.status){
                                    CloseDialogBox("VerifyOrganization");
                                    ShowToast({
                                        message: data.message,
                                        type: "success"
                                    })
                                    setTimeout(()=>{
                                        location.reload();
                                    },1000);
                                }else{
                                    alert(data.message);
                                }
                            })
                        }
                    })
                }
                else{
                    fetch(url,{
                        method: "POST",
                        body: form
                    }).then((response)=>{
                        if (response.ok){
                            return response.json();
                        }else{
                            throw new Error("Something Went Wrong");
                        }
                    }).then((data)=>{
                        console.log(data)
                        if (data.status){
                            CloseDialogBox("VerifyOrganization");
                            ShowToast({
                                message: data.message,
                                type: "success"
                            })
                            setTimeout(()=>{
                                location.reload();
                            },1000);
                        }else{
                            alert(data.message);
                        }
                    }).catch((error)=>{
                        alert(error.message);
                    })
                }

            }
        })
    }

    const ReportCampaign = (CampaignID)=>{
        const url = "/mofficer/campaigns/ReportCampaign";
        const form = new FormData();
        form.append("CampaignID",CampaignID);

        OpenDialogBox({
            id: "ReportCampaign",
            title: "Report Campaign",
            titleClass : "bg-dark text-white text-center",
            content: `
                     <div class="d-flex flex-column gap-1 flex-center text-center font-bold text-md">
                            <div class="d-flex flex-center gap-1 w-100">
                                <label class="form-label w-40" for="ReportReason">Reason</label>
                                <select class="form-control w-60" id="ReportReason" onchange="OtherOption()">
                                    <option value="1" selected>Campaign Is Not There</option>
                                    <option value="2">Campaign Is Not Active</option>
                                    <option value="3">No Donors In Campaign</option>
                                    <option value="4">Fake Campaign</option>
                                    <option value="5">Other</option>
                                </select>
                            </div>
                            <div id="ReportDescriptionDiv" class="none d-flex w-100 gap-1 justify-content-center align-items-start text-center font-bold text-md">
                                <label class="form-label w-40" for="ReportDescription">Description</label>
                                <textarea class="form-control w-60" style="height: 100px;padding: 0.5rem;" id="ReportDescription" maxlength="100" placeholder="Description"></textarea>
                            </div>
                     <div>
            `,
            successBtnText: "Report",
            successBtnAction: ()=>{
                const ReportReason = document.getElementById("ReportReason");
                const ReportDescription = document.getElementById("ReportDescription");
                form.append("Reason",ReportReason.value);
                form.append("Description",ReportDescription.value);
                fetch(url,{
                    method: "POST",
                    body: form
                }).then((response)=>{
                    if (response.ok){
                        return response.json();
                    }else{
                        throw new Error("Something Went Wrong");
                    }
                }).then((data)=>{
                    console.log(data)
                    if (data.status){
                        CloseDialogBox("ReportCampaign");
                        ShowToast({
                            message: data.message,
                            type: "success"
                        })
                        setTimeout(()=>{
                            location.reload();
                        },3000);
                    }else{
                        console.log(data)
                    }
                })
            }
        })
    }

    //TODO Implement This
    const UndoReportCampaign = (CampaignID) =>{
        const url = "/mofficer/campaigns/UndoReportCampaign";
        const form = new FormData();
        form.append("CampaignID",CampaignID);
        OpenDialogBox({
            id: "UndoReportCampaign",
            title: "Undo Report Campaign",
            titleClass : "bg-dark text-white text-center",
            content: `
                     <div class="d-flex flex-center text-center font-bold text-md">
                        <span class="ml-1">Are You Sure You Want To Undo Report This Campaign?</span>
                     <div>
            `,
            successBtnText: "Undo Report",
            successBtnAction: ()=>{
                fetch(url,{
                    method: "POST",
                    body: form
                }).then((response)=>{
                    if (response.ok){
                        return response.json();
                    }else{
                        throw new Error("Something Went Wrong");
                    }
                }).then((data)=>{
                    console.log(data)
                    if (data.status){
                        CloseDialogBox("UndoReportCampaign");
                        ShowToast({
                            message: data.message,
                            type: "success"
                        })
                        setTimeout(()=>{
                            location.reload();
                        },3000);
                    }else{
                        console.log(data)
                    }
                })
            }
        })
    }

    const OtherOption = ()=>{
        const ReportReason = document.getElementById("ReportReason");
        const ReportDescription = document.getElementById("ReportDescriptionDiv");
        if (ReportReason.value==='5'){
            ReportDescription.classList.remove("none");
        }else{
            ReportDescription.classList.add("none");
        }
    }

    const SeeMore = (Description) =>{
        OpenDialogBox({
            id: "SeeMore",
            title: "Description",
            titleClass : "bg-dark text-white text-center",
            content: `
                     <div class="d-flex flex-center text-center font-bold text-md">
                        <span class="ml-1">${Description}</span>
                     <div>
            `,
            showSuccessButton: false,
            cancelBtnText: "Close"
        })
    }

</script>