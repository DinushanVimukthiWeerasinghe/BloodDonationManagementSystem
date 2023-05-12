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


$navbar = new DonorNavbar('Donor History', '/donor/profile', '/public/images/icons/user.png', true,false );
echo $navbar;


?>

<div class="title-container">
    <h1>Donation History</h1>
</div>
<label class="card-view">Recent Donations</label>

<div class="sub-panel page-contain">
    <table class="overflow-x-auto" id="bankTable">
        <thead class="bg-white">
        <tr class="bg-white">
            <!--                <th class="bg-white">Blood Bank ID</th>-->
            <th class="bg-white">Date</th>
            <th class="bg-white">Time</th>
            <th class="bg-white">Campaign Name</th>
            <th class="bg-white">Organization Name</th>
            <th class="bg-white">Remark</th>
        </tr>
        </thead>
        <tbody>
        <?php
        /* var array $data */

        //$data = [];
        //print_r( $data[0]);

        if (!$data){
            echo "NO Data Available";
        }else{
        foreach($data as $donation)
        {
//        $card = new donationCard(['title'=>"On " . explode(' ',$donation['DateTime'])[0] ,'subtitle'=>'At ' . explode(' ',$donation['DateTime'])[1] , 'description'=> $donation['Remark']], false);
            ?>
            <tr class="bg-white-0-7 tableRows">

                <td><?php echo $donation['Date'] ?></td>
                <td><?php echo $donation['Time'] ?></td>
                <td><?php echo $donation['CampaignName'] ?></td>
                <td><?php echo $donation['Organization'] ?></td>
                <td><?php echo $donation['Remark'] ?></td>

            </tr>
        <?php }} ?>


        </tbody>
    </table>


</div>

<script>
    let cards = document.getElementsByClassName('popLabel');
    // console.log(cards);
    for (let i = 0; i < cards.length; i++){
    cards.item(i).innerHTML ='';
    }
</script>