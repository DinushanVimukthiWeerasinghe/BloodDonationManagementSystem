<!--<script src="/public/scripts/customAlert.js"></script>-->
<!--<link href="/public/styles/alert.css" rel="stylesheet">-->
<?php
///* @var string $firstName */
///* @var string $lastName */
//
///* @var MedicalOfficer $model */

use App\model\users\Organization;
use App\model\Utils\Security;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;

$Date = date("Y-m-d");
$background = new BackGroundImage();
$navbar = new AuthNavbar('Update Campaign', '#', '/public/images/icons/navbar/bell.png');
//echo AuthNavbar::getNavbarCSS();
echo $navbar;
echo $background;
?>
<style>
    <style>

    @media only screen and (max-width:541px) {
        .cre{
            width: 500px;
        }

    }
    @media only screen and (max-width:413px) {
        .cre{
            height: 500px;
            width: 400px;
        }
        .mapbtn{
            width: 60px;
            font-size: 5pt;
            margin-left: 10px;
        }
        .sel{
            display: none;
        }
    }
    @media only screen and (max-width:361px) {
        .cre{
            height: 500px;
            width: 350px;
        }
        .cre form{
            height: 700px;
        }
        .mapbtn{
            width: 60px;
            font-size: 5pt;
            margin-left: 10px;
        }
        .sel{
            display: none;
        }


    }
    @media only screen and (min-width: 766px) and (max-width: 913px){
        .cre{
            width: 800px;

        }
    }
    @media only screen and (max-width: 1025px) {
        .cre form{
            height: 400px;
        }
        .details{
            margin-top: -50px;
            font-size: 12pt;
        }
        .name label{
            font-size: 10pt;
        }
        .name input{
            height: 25px;
            font-size: 10pt;
        }
        #NearestBloodBank{
            font-size: 10pt;
        }
        #opt{
            font-size: 10pt;
        }

    }

</style>
<div class=" d-flex flex-column bg-white-0-7 border-radius-10 align-item-center justify-content-center w-50 p-1 h-100 cre">
    <form id="form" action="/organization/campaign/updateCampaign?id=<?=urlencode(Security::Encrypt($campaign->getCampaignID()))?>" method="post" class="d-flex flex-column p-3 text-xl w-100 gap-1">
        <div class="bg-dark py-0-5 px-2 text-center text-white details"> Fill Campaign Details</div>
        <div class="d-flex text-center flex-column gap-0-5 w-100">
            <div class="form-group w-100 name">
                <label class="w-40" for="CampaignName">Campaign Name</label>
                <input type="text" id="CampaignName" class="form-control w-60" name="Campaign_Name" value="<?php echo $campaign->getCampaignName() ?>" placeholder="Eg :- Suwasahana Blood Campaign" required>
            </div>
            <!--            <div class="form-group">-->
            <!--                <label class="w-40">Campaign Description</label>-->
            <!--                <textarea class="form-textarea" name="Campaign_Description" required></textarea>-->
            <!--            </div>-->
            <div class="form-group name">
                <label class="w-40" for="CampaignDate">Campaign Date</label>
                <input type="date" id="CampaignDate" class="form-date" name="Campaign_Date" value="<?php echo $campaign->getCampaignDate() ?>" min= "<?php echo date("Y-m-d", strtotime($Date.'+ 30days')) ?>" required style="border-radius: 50px;padding-left: 10px;padding-right: 10px">
            </div>
            <div class="form-group name">
                <label class="w-40" for="CampaignVenue">Venue</label>
                <input type="text" id="CampaignVenue" class="form-control w-20" name="Venue" value="<?php echo $campaign->getVenue() ?>" required style="width: 70%"  placeholder="Eg :- Sugatharamaya, Kirulapone">
                <button class="btn btn-info d-flex gap-0-5 align-items-center justify-content-center mapbtn" type="button" id="SelectLocationBtn" onclick="SelectLocation()">
                    <img src="/public/icons/location.svg" alt="map" class="invert-100" style="width: 20px; height: 20px;">
                    <span class="ms-1 sel">Select on Map</span>
                </button>
            </div>
            <div class="form-group name">
                <label class="w-40" for="NearestCity">Nearest City</label>
                <input type="text" id="NearestCity" class="form-control" value="<?php echo $campaign->getNearestCity() ?>" name="Nearest_City"  required  placeholder="Eg :- Nugegoda">
            </div>
            <input type="hidden" id="Latitude" name="Latitude" value="<?php echo $campaign->getLatitude()?>">
            <input type="hidden" id="Longitude" name="Longitude" value="<?php echo $campaign->getLongitude()?>">
            <input type="hidden" id="Agreed" name="Agreed">

        </div>
    </form>
    <div class="d-flex align-items-center justify-content-center gap-2">
        <button class="btn btn-success w-25" id="button" value="Create" onclick="update()" type="submit"> Update </button>
        <button class="btn btn-danger w-25" id="button" value="Cancel" onclick="history.back()"> Cancel </button>
    </div>
</div>

</div>
<script>
    function read(){
        let select = document.getElementById('error');
        if(select.selectedIndex === 1){
            document.getElementById('errors').style.visibility = 'visible';
            document.getElementById('button').disabled = true;
            document.getElementById('button').style.backgroundColor = '#F5F5F5';
            document.getElementById('button').style.color = 'black';
        }else{
            document.getElementById('errors').style.visibility = 'hidden';
            document.getElementById('button').disabled = false;
            document.getElementById('button').style.backgroundColor = 'rgba(251, 0, 0, 0.7)';
            document.getElementById('button').style.color = 'white';
        }
    }
    function expect(){
        let val = document.getElementById('expect').value;
        if(val === "1") {
            document.getElementById('expec').style.visibility = 'visible';
        }else{
            document.getElementById('amount').value = "";
            document.getElementById('expec').style.visibility = 'hidden';
        }
    }
    const update = (event)=>{

        // event.preventDefault();
        const name = document.getElementById('CampaignName').value;
        const date = document.getElementById('CampaignDate').value;
        const venue = document.getElementById('CampaignVenue').value;
        const city = document.getElementById('NearestCity').value;
        // const
        if(name === ''){
            ShowToast({
                message: 'Campaign Name cannot be Empty!',
                type: 'danger',
            });
        }
        else if(date === ''){
            ShowToast({
                message: 'Campaign Date cannot be Empty!',
                type: 'danger',
            });
        }
        else if(venue === ''){
            ShowToast({
                message: 'Campaign Venue cannot be Empty!',
                type: 'danger',
            });
        }
        else if(city === ''){
            ShowToast({
                message: 'Nearest City cannot be Empty!',
                type: 'danger',
            });
        }
        else {
            OpenDialogBox({
                // id:'sendEmail',
                title: 'Update Confirmation',
                content: `Are You Sure You Want to Update Details?`,
                successBtnText: 'Yes',
                successBtnAction: () => {
                    document.querySelector('form').submit();
                },

            });
        }
        SendEmail.preventDefault();
    };
     // document.querySelector('form').addEventListener('submit', update);

    let map;
    function initMap() {
        const colombo = { lat: 6.8781340776734385, lng: 79.8833214428759 };
        var sriLankaBounds = {
            north: 9.9355,
            south: 5.575,
            east: 81.8815,
            west: 79.6524,
        };

        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 10,
            minZoom: 8,
            maxZoom: 20,
            center: colombo,
            mapTypeId: "roadmap",
            streetViewControl: false,
            fullscreenControl: false,
            zoomControl: true,
            zoomControlOptions: {
                position: google.maps.ControlPosition.LEFT_CENTER,
            },
            backgroundColor: "#fff",
            restriction: {
                latLngBounds: sriLankaBounds,
                strictBounds: false,
            },
        });

        const input = document.getElementById("pac-input");
        const searchBox = new google.maps.places.SearchBox(input);
        // Change CSS of search box
        input.style.border = "0.5px solid black";
        input.style.marginTop = "10px";
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        map.addListener("bounds_changed", () => {
            searchBox.setBounds(map.getBounds());
        });
        let markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener("places_changed", () => {
            const places = searchBox.getPlaces();

            if (places.length == 0) {
                return;
            }
            // Clear out the old markers.
            markers.forEach((marker) => {
                marker.setMap(null);
            });
            markers = [];
            // For each place, get the icon, name and location.
            const bounds = new google.maps.LatLngBounds();
            places.forEach((place) => {
                if (!place.geometry || !place.geometry.location) {
                    console.log("Returned place contains no geometry");
                    return;
                }
                const icon = {
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(25, 25),
                };
                // Create a marker for each place.
                markers.push(
                    new google.maps.Marker({
                        map,
                        icon,
                        title: place.name,
                        position: place.geometry.location,
                    })
                );

                if (place.geometry.viewport) {
                    // Only geocodes have viewport.
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
            });
            map.fitBounds(bounds);
        });
        // Configure the click listener.
        const marker = new google.maps.Marker({
            map: map,
        });

        map.addListener("click", (mapsMouseEvent) => {
            const lat = mapsMouseEvent.latLng.lat();
            const lng = mapsMouseEvent.latLng.lng();
            document.getElementById('Latitude').value = lat;
            document.getElementById('Longitude').value = lng;
            marker.setPosition(mapsMouseEvent.latLng);
        });

    }

    function SelectLocation(){
        OpenDialogBox({
            id: 'location',
            title: 'Select Campaign Location',
            titleClass: 'bg-dark text-white',
            content: `
                    <div style="display: none;">
                        <label for="pac-input"></label>
                        <input
                                id="pac-input"
                                style="width:40%;font-size: large;text-align: center"
                                type="text"
                                placeholder="Enter a location"
                        />
                    </div>
                    <div class="" id="map" style="height: 400px; width: 100%;"></div>
                `,
            successBtnText: 'Select',
            successBtnAction: function () {
                const lat = document.getElementById('Latitude').value;
                const lng = document.getElementById('Longitude').value;
                if(lat === '' || lng === ''){
                    ShowToast({
                        message : 'Please Select Campaign Location on Map.',
                        type : 'danger'
                    })
                }else{
                    const button = document.getElementById('SelectLocationBtn');
                    button.classList.remove('btn-info');
                    button.classList.add('btn-success');
                    button.getElementsByTagName('span')[0].innerHTML = 'Location Selected';
                    button.getElementsByTagName('img')[0].src = '/public/icons/addedLocation.svg';
                    CloseDialogBox('location');

                }
            },
        })
        initMap();

    }
    // const cancellation=(click)=>{
    //     OpenDialogBox({
    //         title: 'Cancel Confirmation',
    //         content: 'Are You Sure You want to Go Back? Your Changes will not be saved.'
    //         successBtnText: 'Yes',
    //         successBtnAction: () =>{
    //             // history.back();
    //         },
    //     });
    // }

</script>

