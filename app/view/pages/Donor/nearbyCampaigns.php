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

//$navbar = new DonorNavbar('Nearby Campaigns', '/donor/profile', '/public/images/icons/user.png', true,  $lastName, false);
//echo $navbar;

?>

<div class="sub-panel page-contain">
<!--    <div class="page-contain">-->
    <?php


//    echo $data;
//    exit();
    foreach ($data as $campaigns) {

//        echo("hi");
        //$names = $campaign->labels();
        $campaign = $campaigns->toArray();
//        $longDescription = $campaign['Campaign_Name']. " will held at ". $campaign['Venue']. " on " . $campaign['Campaign_Date'];
        //$longDescription ="hi";
        //echo $longDescription;
        if(checkDistance($campaign['Latitude'],$campaign['Longitude']) < 30){
            //do something
            $card = new donationCard(['title' => $campaign['Campaign_Name'], 'subtitle' => $campaign['Venue'], 'description' => $campaign['Campaign_Description'], 'date' => $campaign['Campaign_Date'], 'latitude' => $campaign['Latitude'], 'longitude' => $campaign['Longitude']]);
            echo $card->render();
        }
    }


//    for ($i = 0; $i < 8; $i++) {
//        $card = new donationCard(['title' => 'Date', 'subtitle' => 'venue', 'description' => 'Organization']);
  //      echo $card->render();
//    }

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
//        echo "distance";
//        echo $distance;
        return $distance;
    }
    ?>
<!--    </div>-->

</div>

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