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

$navbar = new DonorNavbar('Nearby Campaigns', '/donor/profile', '/public/images/icons/user.png', true, $firstName . ' ' . $lastName, false);
echo $navbar;

?>

<div class="sub-panel page-contain">
<!--    <div class="page-contain">-->
    <?php


//    echo $data;
//    exit();
    foreach ($data as $campaign) {

//        echo("hi");
        //$names = $campaign->labels();
        $campaign = $campaign->toArray();
        $longDescription = $campaign['Campaign_Name']. " will held at ". $campaign['Venue']. " on " . $campaign['Campaign_Date'];
        //$longDescription ="hi";
        //echo $longDescription;
        $card = new donationCard(['title' => $campaign['Campaign_Name'], 'subtitle' => $campaign['Venue'], 'description' => $campaign['Campaign_Description']], $longDescription);
        echo $card->render();
    }


//    for ($i = 0; $i < 8; $i++) {
//        $card = new donationCard(['title' => 'Date', 'subtitle' => 'venue', 'description' => 'Organization']);
  //      echo $card->render();
//    }
    ?>
<!--    </div>-->

</div>