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
            $campaign = $campaign->toArray();
        $card = new donationCard(['title' => $campaign['Campaign_Name'], 'subtitle' => $campaign['Venue'], 'description' => $campaign['Campaign_Description']]);
        echo $card->render();
    }


//    for ($i = 0; $i < 8; $i++) {
//        $card = new donationCard(['title' => 'Date', 'subtitle' => 'venue', 'description' => 'Organization']);
  //      echo $card->render();
//    }
    ?>
<!--    </div>-->

</div>