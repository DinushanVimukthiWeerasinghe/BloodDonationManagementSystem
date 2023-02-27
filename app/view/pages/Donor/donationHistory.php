<head>
    <link rel="stylesheet" href="/public/css/home.css">
    <link rel="stylesheet" href="/public/styles/home.css">
    <link rel="stylesheet" href='/public/css/custom/donor/campaignDetailsCard.css'>

</head>
<?php


use App\model\Donations\AcceptedDonations;
use App\model\Donations\Donation;
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
    /* var array $data */

    //$data = [];
    //print_r( $data[0]);
    foreach($data as $i)
    {
        $donation = new AcceptedDonations();
        $donation ->loadData($i);
        $date = date($donation -> getDonationDateTime());
        $date = explode(" ", $date)[0];
        $date = explode("-", $date);
        $date = implode("/", $date);
        $card = new donationCard(['title'=>'On ' . $date , 'subtitle'=> $donation->getDonationId(), 'description'=> $donation->getPacketId()], "");


        echo $card->render();
    }
    ?>
</div>