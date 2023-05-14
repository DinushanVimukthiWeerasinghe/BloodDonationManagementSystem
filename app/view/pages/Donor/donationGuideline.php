<!--<head>-->
<!--    <link rel="stylesheet" href="/public/css/home.css">-->
<!--</head>-->
<?php

use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\DonorNavbar;

//$navbar = new DonorNavbar('Donation Guideline', '/donor/profile', '/public/images/icons/user.png', true,false );
//echo $navbar;
//$background = new BackGroundImage();
//
//echo $background;
?>
<div class="absolute left-1 top-9">
    <button class="p-1 cursor bg-dark text-white box-shadow-white border-radius-50 d-flex flex-center gap-1" style="font-size: 1.5rem;border: none" onclick="window.location.href='/donor/dashboard'">
        <i class="fa-solid fa-circle-chevron-left"></i>
    </button>
</div>

<div class="d-flex justify-content-center bg-white-0-5 border-radius-10 w-80 p-2 gap-1 flex-column align-items-center">


    <div class="d-flex flex-column justify-content-center align-items-center gap-0-5">

        <div class="text-2xl bg-white p-1 border-radius-10 font-bold">Who can donate blood?</div>
       <p>The person must fulfill several criteria to be accepted as a blood donor. These criteria are set forth to ensure the safety of the donor as well as the quality of donated blood.</p>
   </div>
    <div class="d-flex flex-column justify-content-center align-items-center gap-0-5">

        <div class="text-2xl bg-white p-1 border-radius-10 font-bold">Donor Selection Criteria</div>
        <ul class="Criteria">
            <li>Age above 18 years and below 60 years.</li>
            <li>If previously donated, at least 4 months should be elapsed since the date of previous donation.</li>
            <li>Hemoglobin level should be more than 12g/dL. (this blood test is done prior to each blood donation)</li>
            <li>Free from any serious disease condition or pregnancy.</li>
            <li>Should have a valid identity card or any other document to prove the identity.</li>
            <li>Free from "Risk Behaviours".</li>
        </ul>
   </div>
    <div class="d-flex flex-column justify-content-center align-items-center gap-0-5">

        <div class="text-2xl bg-white p-1 border-radius-10 font-bold">Risk Behaviours</div>
        <ul>
            <li>Homosexuals</li>
            <li>Homosexuals</li>
            <li>Sex workers and their clients</li>
            <li>Drug addicts</li>
            <li>Engaging in sex with any of the above</li>
            <li>Having more than one sexual partner</li>
        </ul>
    </div>
    <div class="d-flex flex-column justify-content-center align-items-center gap-0-5">

        <div class="text-2xl bg-white p-1 border-radius-10 font-bold">Type of Donors</div>
        <ul>
            <li>Voluntary non remunerated donors. (donate for the sake of others and do not expect any benefit. their blood is considered safe and healthy)</li>
            <li>Replacement donors. (donate to replace the units used for their friends or family members)</li>
            <li>Paid donors. (receive payment for donation</li>
            <li>Directed donors. (donate only for a specific patient's requirement)</li>
        </ul>
    </div>

<p style="padding-top: 5px">Directed donations are used in certain conditions such as in rare blood groups</p>
<p>NBTS achieved the mighty figure of 100% voluntary non-remunerated blood donor base.</p>
</div>

<div class="footerBar"></div>