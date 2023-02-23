<head>
    <link rel="stylesheet" href="/public/css/home.css">
    <link rel="stylesheet" href="/public/styles/home.css">
    <link rel="stylesheet" href='/public/css/custom/donor/campaignDetailsCard.css'>

</head>
<?php
use \App\view\components\ResponsiveComponent\Card\donationCard;
use App\view\components\ResponsiveComponent\NavbarComponent\DonorNavbar;


$navbar = new DonorNavbar('Donor History', '/donor/profile', '/public/images/icons/user.png', true,$firstName . ' ' . $lastName,false );
echo $navbar;

?>

<div class="title-container">
    <h1>Donation History</h1>
</div>
<label class="card-view">Recent Donations</label>
<div class="sub-panel page-contain">
    <?php

    $card = new donationCard(['title'=>'May 21', 'subtitle'=>'2l', 'description'=>'Healthy']);
    for ($i =0; $i < 4; $i++)
    {
        echo $card->render();
    }
    ?>
</div>