<?php
?>


<head>
    <link rel="stylesheet" href='/public/styles/home.css'>
    <link rel="stylesheet" href='/public/css/home.css'>
    <link rel="stylesheet" href='/public/css/custom/donor/campaignDetailsCard.css'>
</head>
<?php

use \App\view\components\ResponsiveComponent\Card\donationCard;
use App\view\components\ResponsiveComponent\NavbarComponent\DonorNavbar;
use Core\Application;

//$navbar = new DonorNavbar('Nearby Campaigns', '/donor/profile', '/public/images/icons/user.png', true,  $lastName, false);
//echo $navbar;

?>
<div class="absolute left-1 top-9">
    <button class="p-1 cursor bg-dark text-white box-shadow-white border-radius-50 d-flex flex-center gap-1" style="font-size: 1.5rem;border: none" onclick="window.location.href='/donor/dashboard'">
        <i class="fa-solid fa-circle-chevron-left"></i>
    </button>
</div>
<div class="sub-panel page-contain">

    <?php
    foreach ($data as $campaigns) {

//        echo("hi");
        //$names = $campaign->labels();
        $campaign = $campaigns->toArray();
//        $longDescription = $campaign['Campaign_Name']. " will held at ". $campaign['Venue']. " on " . $campaign['Campaign_Date'];
        //$longDescription ="hi";
        //echo $longDescription;
        $distance = checkDistance($campaign['Latitude'],$campaign['Longitude']);
        if($distance < 30){
            //do something
            $card = new donationCard(
                [
                    'ID'=>$campaign['Campaign_ID'],
                    'title' => $campaign['Campaign_Name'],
                    'subtitle' => $campaign['Venue'],
                    'description' => $campaign['Campaign_Description'],
                    'date' => $campaign['Campaign_Date'],
                    'latitude' => $campaign['Latitude'],
                    'longitude' => $campaign['Longitude'],
                    'distance' => $distance,
                ], Application::$app->getUser()->getID());
            echo $card->render();
        }
    }
    function checkDistance($lat, $long){
//        return 45;
//        echo $lat;
//        echo $long;
        if(!isset($_COOKIE['myLatitude']) && !isset($_COOKIE['myLongitude'])) {
            $distance = 0;
        } else {
            $delta_lat = $lat - $_COOKIE['myLatitude'];
            $delta_lon = $long - $_COOKIE['myLongitude'];

            $earth_radius = 6372.795477598;

            $alpha    = $delta_lat/2;
            $beta     = $delta_lon/2;
            $a        = sin(deg2rad($alpha)) * sin(deg2rad($alpha)) + cos(deg2rad($_COOKIE['myLatitude'])) * cos(deg2rad($lat)) * sin(deg2rad($beta)) * sin(deg2rad($beta)) ;
            $c        = asin(min(1, sqrt($a)));
            $distance = 2*$earth_radius * $c;
            $distance = round($distance, 4);
        }
        return $distance;
    }
    ?>

</div>
<script>
    function OpenDialogBoxtrigger(args) {
        const userID = args['userID'];
        const CampaignID = args['campaignID'];
        const url = '/api/campaign/checkattendance?userID='+userID+'&campaignID='+CampaignID;


        fetch(url, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
        }).then(response => response.json())
            .then(data => {
                const attendance = data;
                const title = args['title'];
                const subtitle = args['subtitle'];
                const description = args['description'];
                const date = args['date'];
                const latitude = args['latitude'];
                const longitude = args['longitude'];
                const popup = args['popup'];
                const distance = parseFloat(args['distance']).toFixed(2);
                OpenDialogBox({
                    id: 'nearbyCampaignView',
                    title: "Campaign Details",
                    titleClass: "text-center bg-dark text-white",
                    minHeight: "50vh",
                    content: `
                            <div class="d-flex flex-center flex-column">
                                <div class="d-flex w-100">
                                    <div id="map" style="width:50vw;height:400px"></div>
                                </div>
                                <div class="d-flex p-2 my-2 border-radius-10 flex-column justify-content-center border-2 border-dark align-item-center gap-1">
                                    <div class="d-flex">
                                        <div class="d-flex text-dark font-bold">Campaign Name : </div>`+title+`
                                    </div>
                                    <div class="d-flex">
                                        <div class="d-flex text-dark font-bold">Campaign Name : </div>`
                        +subtitle+`
                                    </div>
                                    <div class="d-flex">
                                        <div class="d-flex text-dark font-bold">Campaign Description : </div>
                                    `+description+`
                                    </div>
                                    <div class="d-flex">
                                        <div class="d-flex text-dark font-bold">Campaign Date : </div>`+date+`
                                    </div>
                                    <div class="d-flex">
                                        <div class="d-flex text-dark font-bold">Distance : </div>`+distance+` Km
                                    </div>
                                </div>
                        `,
                    successBtnText: attendance ? 'Not Interested' : 'Interested',
                    successBtnAction:()=>{
                        let attendanceMarkResult;
                        if (attendance){
                            attendanceMarkResult = removeAttendance(args['campaignID'],args['userID']);
                        }else {
                            attendanceMarkResult = markAttendance(args['campaignID'],args['userID']);
                        }
                        CloseDialogBox();
                        // console.log(attendanceMarkResult);
                        if (attendanceMarkResult){
                            ShowToast(
                                {
                                    message:'Prefence Changed Successfully',
                                    type: 'success',
                                    timeout: 3000,
                                });
                        }else {
                            ShowToast(
                                {
                                    message: "Error Occured Try Again",
                                    type: 'error',
                                    timeout: 3000,
                                }
                            );
                        }
                    }
                })
                initMap(parseFloat(latitude),parseFloat(longitude));
            })



        // console.log(args);
        // console.log(args);
        // const XHR = new XMLHttpRequest();
        // XHR.open("GET", "/api/campaign/checkattendance?userID="+args['userID']+"&campaignID="+args['campaignID'], true);
        // XHR.setRequestHeader("Content-Type", "application/json");
        // XHR.send();
        // XHR.onload = function () {
        // const attendance = JSON.parse(this.responseText);
        // console.log(attendance);
        // console.log(Object.keys(bankList));
        // Banks = Object.keys(bankList);
        // console.log(Banks);
        // OpenDialogBox({})

        //var data  = text.split(",");
        //console.log(data);


        initMap(parseFloat(args['latitude']),parseFloat(args['longitude']));

        let attendanceMsg = document.getElementById('attendanceMsg');
        let dialogBox = document.getElementById('nearbyCampaignView');

        let successBtn =dialogBox.firstChild.lastChild.firstChild;

        if(attendance === true){
            // console.log('Attendance');
            attendanceMsg.innerText = 'You have already marked Your Attendance';
            successBtn.innerText = 'Change of Mind';
            // console.log(successBtn)
        }
    }

    async function markAttendance(campaignID, donorID){
        let result = false;
        const XHR = new XMLHttpRequest();
        XHR.open("GET", "/donor/campaign/markAttendance?userID="+donorID+"&campaignID="+campaignID, true);
        XHR.setRequestHeader("Content-Type", "application/json");
        XHR.send();
        XHR.onload = await function () {
            result = JSON.parse(this.responseText);
            // return result;
        }
        console.log(result);
        // console.log(result);
        return result;
    }

    async function removeAttendance(campaignID, donorID){
        let result = false;
        const XHR = new XMLHttpRequest();
        XHR.open("GET", "/donor/campaign/removeAttendance?userID="+donorID+"&campaignID="+campaignID, true);
        XHR.setRequestHeader("Content-Type", "application/json");
        XHR.send();
        XHR.onload = await function () {
            result = JSON.parse(this.responseText);
            // return result;
        }
        console.log(result);
        return result;
    }


    const initMap=async (latitude,longitude)=> {

        const { Map } = await google.maps.importLibrary("maps");
        const place = { lat: 6.8781340776734385, lng: 79.8833214428759 };
        if (latitude && longitude){
            place.lat = latitude;
            place.lng = longitude;
        }
        console.log(place)
        const mylating = { lat: 6.8781340776734385, lng: 79.8833214428759 };

        const map = new Map(document.getElementById("map"), {
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
</script>
<script>
    window.onload = ()=>{
    //
        navigator.geolocation.getCurrentPosition((location)=>{
            const d = new Date();
            d.setTime(d.getTime() + (24*60*60*1000));
            let expires = "expires="+ d.toUTCString();
            document.cookie = 'myLatitude' + "=" + location.coords.latitude + ";" + expires + ";path=/";
            document.cookie = 'myLongitude' + "=" + location.coords.longitude + ";" + expires + ";path=/";
        },()=>{},{
            enableHighAccuracy: true});
    }
</script>