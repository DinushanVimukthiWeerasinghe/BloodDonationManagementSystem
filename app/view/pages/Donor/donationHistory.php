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
    foreach($data as $donation)
    {
//        $donation = new AcceptedDonations();
//        $donation ->loadData($i);
//        $donation = $i;
//        print_r($i);
//        exit();
//        $date = date($donation -> getDonationDateTime());
//        $date = explode(" ", $date)[0];
//        $date = explode("-", $date);
//        $date = implode("/", $date);
        $card = new donationCard(['title'=>"On " . explode(' ',$donation['DateTime'])[0] ,'subtitle'=>'At ' . explode(' ',$donation['DateTime'])[1] , 'description'=> $donation['Remark']], false);


        echo $card->render();
    }
    ?>
</div>

<script>
    let cards = document.getElementsByClassName('popLabel');
    // console.log(cards);
    for (let i = 0; i < cards.length; i++){
    cards.item(i).innerHTML ='';
    }
</script>