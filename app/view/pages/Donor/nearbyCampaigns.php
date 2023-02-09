<?php
?>


<head>
    <link rel="stylesheet" href='/public/styles/home.css'>
    <link rel="stylesheet" href='/public/css/home.css'>
    <link rel="stylesheet" href='/public/css/custom/donor/campaignDetailsCard.css'>
</head>
<?php

use App\view\components\ResponsiveComponent\Card\campaignCard;

?>
<div class="sub-panel page-contain">
<!--    <div class="page-contain">-->
    <?php
    for ($i = 0; $i < 8; $i++) {
        $card = new CampaignCard(['campaign' => 'campaign', 'venue' => 'venue', 'date' => 'date', 'organization' => 'organization']);
        echo $card->render();
    }
    ?>
<!--    </div>-->

</div>