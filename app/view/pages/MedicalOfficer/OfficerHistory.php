<?php
use App\model\users\MedicalOfficer;
use App\model\Utils\Date;
use Core\Application;
?>



<div class="d-flex m-1 justify-content-center ">
    <div class="d-flex w-100 justify-content-center  overflow-y-scroll">
        <table class="w-100 h-10" style="min-width: 90vh">
            <thead class="sticky top-0">
            <tr>
                <th>No</th>
                <th>Date</th>
                <th>Campaign Name</th>
                <th>Venue</th>
                <th>Role</th>
                <th>Task</th>
                <th>Action</th>
            </tr>
            </thead>


            <tbody id="content" class="">
            <?php
            /** @var $Campaign App\model\Campaigns\Campaign*/

            $i = 1;
            if (!empty($Campaigns)):
//                $Campaigns = array_merge(...array_fill(0, 1000, $Campaigns));
            $UserID = Application::$app->getUser()->getID();
                foreach ($Campaigns as $Campaign):
            ?>
                <tr>
                    <td ><?= $i++?></td>
                    <td><?= Date::GetProperDate($Campaign->getCampaignDate())?></td>
                    <td><?= $Campaign->getCampaignName()?></td>
                    <td><?= $Campaign->getVenue()?></td>
                    <td><?= MedicalOfficer::getRoleOfCampaign($UserID,$Campaign->getCampaignID())?></td>
                    <td><?= MedicalOfficer::getTaskOfCampaign($UserID,$Campaign->getCampaignID())?></td>
                    <td>
                        <button onclick="ViewTeam('<?=$Campaign->getCampaignID()?>')" class="btn btn-info btn-sm">View Team</button>
                        <button class="btn btn-primary btn-sm" onclick="ViewDetails('<?=$Campaign->getCampaignID()?>')">View Details</button>
                    </td>
                </tr>
            <?php
            endforeach;
            else:
                ?>
                <tr>
                    <td colspan="7" class="text-center">No Campaigns</td>
                </tr>
            <?php
            endif;
            ?>

            </tbody>
        </table>
    </div>

</div>

<script>
    const ViewDetails = (id)=>{
        const url = '/medicalOfficer/ViewReport';
        const formData = new FormData();
        formData.append('campaignID',id);
        fetch(url,{
            body: formData,
            method: "post"
        })
            .then(response => response.json())
            .then(data => {
                console.log(data)
                const Campaign = data.campaigns;
                OpenDialogBox({
                    id: "view-details",
                    title: "View Details",
                    titleClass: "bg-dark px-2 py-1 text-white text-center",
                    content: `
                    <div class="d-flex flex-column">
                        <div class="d-flex flex-column w-100 justify-content-center align-items-center">
                            <div class="d-flex font-bold my-1 w-100 text-center justify-content-center align-items-center bg-dark py-1 px-2 text-center text-white">Campaign Details</div>
                            <div class="d-flex justify-content-center w-100 gap-1">
                                <div class="d-flex flex-column w-50 flex-center gap-0-5 bg-dark text-white border-radius-10">
                                    <div class="d-flex gap-0-5"><span class="font-bold">Campaign Name </span>: <span>${Campaign.Campaign_Name}</span></div>
                                    <div class="d-flex gap-0-5"><span class="font-bold"> </span> Campaign Date: <span>${Campaign.Campaign_Date}</div>
                                    <div class="d-flex gap-0-5"><span class="font-bold"> </span>Venue : <span>${Campaign.Venue}</div>
                                    <div class="d-flex flex-column gap-0-5">
                                        <div class="font-bold">Description  </div> <div class="px-1" style="max-width: 400px">${Campaign.Campaign_Description} Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore, non.</div>
                                    </div>
                                </div>
                                <div class="d-flex w-50 flex-center">
                                    <div id="map" style="height: 300px;width: 300px"></div>
                                    <div id="infowindow-content">

                                    </div>
                                </div>

                            </div>
                        </div>

                `,

                })
                initMap(parseFloat(Campaign.Latitude),parseFloat(Campaign.Longitude));
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


    const ViewTeam = (campaignID)=>{
        const url = '/medicalOfficer/ViewTeam';
        const formData = new FormData();
        formData.append('campaignID',campaignID);
        fetch(url,{
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                console.log(data)
                if (data.status){
                    const {team} = data;
                    let TeamMembers = '<div class="d-flex flex-column">';
                    for (i=0;i<team.length;i++) {
                        const highlight = team[i].Position === 'Leader' ? 'text-primary' : '';
                        TeamMembers += `
                            <tr>
                                <td>${i+1}</td>
                                <td>${team[i].MemberName}</td>
                                <td class="${highlight}">${team[i].Position}</td>
                            </tr>
                        `
                    }

                    OpenDialogBox({
                        id: 'ViewTeam',
                        title: 'View Team',
                        titleClass: 'bg-dark text-white px-2',
                        content:`
                        <div class="d-flex flex-column">
                            <div class="d-flex flex-row justify-content-center ">
                                <table class="w-100">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Member Name</th>
                                        <th>Position</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        ${TeamMembers}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    `,
                    })
                }
            })

    }

</script>