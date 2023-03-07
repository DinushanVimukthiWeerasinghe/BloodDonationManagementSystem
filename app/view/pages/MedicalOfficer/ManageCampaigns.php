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
Hi
<div class="d-flex w-100 m-1 border-radius-10 bg-white justify-content-center gap-1 ">

    <?php
        if (!empty($Campaign) && !empty($MedicalTeam) && !empty($Organization)):
    ?>
    <div id="campaign-information" class="d-flex flex-column align-items-center w-70 m-1 ">
        <div class="d-flex flex-column w-100 p-1 align-items-center">
            <div class="d-flex text-4xl font-bold mb-1 bg-dark py-0-5 px-2 text-center text-white w-80 justify-content-center"> <span class="ml-1"><?= $Campaign->getCampaignName();?></span></div>
            <div class="d-flex"> Venue: <span class="ml-1"><?= $Campaign->getVenue();?></span></div>
            <div class="d-flex"> Date: <span class="ml-1"><?= $Campaign->getCampaignDate();?></span></div>
            <div class="d-flex"> Status: <span class="ml-1"><?= $Campaign->getCampaignStatus();?></span></div>

        </div>
        <div class="d-flex flex-column w-100 p-1 align-items-center">
            <div class="d-flex text-4xl font-bold mb-1 bg-dark py-0-5 px-2 text-center text-white justify-content-center w-80"> <span class="ml-1"><?= $Organization->getOrganizationName();?> Organization</span></div>
            <div class="d-flex"><span class="ml-1"><?= $Organization->getAddress();?></span></div>
            <div class="d-flex"> <span class="ml-1"><?= $Organization->getContactNo();?></span></div>
            <div class="d-flex"> <span class="ml-1"><?= $Organization->getEmail();?></span></div>
            <div class="d-flex"> Status: <span class="ml-1"><?= $Organization->getStatus();?></span></div>
            <div id="Map-Container" style="position: absolute; width: 50%;height: 50%; bottom: 5vh;left: 10vw">
                <div id="map" class="w-100 h-100" style="position:sticky;overflow: visible"></div>
                <div id="place"></div>
            </div>
        </div>

    </div>
    <div id="campaign-information" class="d-flex justify-content-center w-30 align-items-center m-1">
        <div class="d-flex flex-column w-100 border-2 p-1 gap-1">
            <div class="d-flex text-3xl bg-dark text-white py-0-5 px-1 text-center justify-content-center"> <span class="ml-1">Assigned Medical Team</span></div>
            <div class="d-flex">No Of Officers: <span class="ml-1"><?= $MedicalTeam->getNoOfMembers();?></span></div>
            <table class="" >
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
            <?php
            if ($Position===MedicalTeam::TEAM_LEADER):
            $MedicalOfficers = $MedicalTeam->getTeamMembers();
            ?>
            <button class="btn btn-outline-success" onclick="AllocateTask()">Allocate Task</button>
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
                                                    ?>
                                                        <option value="<?= $key;?>"><?= $Task;?></option>
                                                    <?php
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

</script>