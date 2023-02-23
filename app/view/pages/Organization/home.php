<?php

use Core\Application;
use App\model\users\User;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="/public/styles/Orghome.css">
</head>
<body>
<!-- leftcorner -->
<!--<section class="leftContainer">-->
<!--    <img src="../../../../public/images/profile.png" class="leftImage">-->
<!--    <h1 class="lefttopic">Welcome --><?php //echo $name?><!-- Club</h1>-->
<!--    <img src="../../../../public/images/campaign.png" class="left1ConImage">-->
<!--    <p class="left1Con">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard</p>-->
<!--    <img src="../../../../public/images/campaign.png" class="left2ConImage">-->
<!--    <p class="left2Con">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the</p>-->
<!--</section>-->
<!-- leftcorner end-->
<!-- navigationbar Start-->
<section class="navbar">
    <h1 class="lefttopic"><?php echo $name?> Organization</h1>
    <img src="../../../../public/images/bell.png" class="bell">
    <img src="../../../../public/images/profile.png" class="profile">
    <a href="/logout"><img src="../../../../public/images/sign-out.png" class="logout"></a>
</section>
<!-- navigationbar end -->
<!-- rightcorner start -->
<!--        <section class="rightCorner">-->
<!--            <div class="rc1">-->
<!--                <img src="../../../../public/images/profile.png" class="rc1img">-->
<!--                <p class="rc1Con">--><?php //echo $name ?><!-- Club Organisation</p>-->
<!--            </div>-->
<!--            <div class="rc2">-->
<!--                <img src="../../../../public/images/profile.png" class="rc1img">-->
<!--                <p class="rc2Con">--><?php //echo $name ?><!-- Club Organisation</p>-->
<!--            </div>-->
<!--        </section>-->
<!-- rightcorner end -->
<!--bottom start-->


<!--<a href="organisation/guidelines">-->
<!--        <div class="bottom1">-->
<!--            <img src="../../../../public/images/campaign.png" class="img1">-->
<!--            <p class="img1Con">Campaign Guidelines</p>-->
<!--        </div>-->
<!--</a>-->
<!---->
<!--<a href="organisation/manage">-->
<!--    <div class="bottom2">-->
<!--        <img src="../../../../public/images/campaign.png" class="img2">-->
<!--        <p class="img2Con">Manage Campaign</p>-->
<!--    </div>-->
<!--</a>-->
<!---->
<!--<a href="organisation/history">-->
<!--    <div class="bottom3">-->
<!--        <img src="../../../../public/images/campaign.png" class="img3">-->
<!--        <p class="img3Con">History</p>-->
<!--    </div>-->
<!--</a>-->
<div class="contentArea" style="border-radius: 80px;">
    <a href="#">
        <div class="near1">
            <img src="../../../../public/images/guideline.png">
            <p>Read Guidelines</p>
        </div>
    </a>
    <a href="organisation/manage">
        <div class="near2">
            <img src="../../../../public/images/campaign.png">
            <p>Manage Campaigns</p>
        </div>
    </a>
    <a href="organisation/history">
        <div class="near3">
            <img src="../../../../public/images/historyico.png">
            <p>Campaign History</p>
        </div>
    </a>

</div>

