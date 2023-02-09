<?php
?>

<head>
<link rel="stylesheet" href="/public/styles/home.css">
</head>
<?php

use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;

$donation_Image='/public/images/donation.png';
$donation_History='/public/images/Icons/icons8-order-history-80.png';
$donation_Guideline = '/public/images/Icons/icons8-more-details-50.png';
$nearby_Donations = '/public/images/Icons/icons8-nearby-32.png';

/* @var string $firstName */
/* @var string $lastName */


$Image=new \App\view\components\Image\GeneralImage("/public/images/logo.png", "Home Image", "logo","250rem");


$c1 = new \App\view\components\Card\ClickableCard("Donation Guideline", $donation_Guideline,"Donation Guideline");
$c2 = new \App\view\components\Card\ClickableCard("Donation History", $donation_History,"Donation History");
$c3 = new \App\view\components\Card\ClickableCard("Nearby Donations", $nearby_Donations,"Nearby Donations");
?>


<div class="super-header">
    <div class="nav-beg">
        <div class="nav-logo d-flex g-flex-col">
            <div class="d-flex g-flex-col">
                <div class="d-flex g-flex-align-center">
                    <?php echo $Image->render();?>
                    <h1 class="nav-title">Welcome <br> <?php echo $firstName.' '.$lastName ?> </h1>
                </div>
                <div class="nav-desc">
                    <p class="text text-white">Thank you for visiting the Be Positive blood donation campaign management system.
                        As a registered user, you have the opportunity to make a positive impact on the lives of others by donating blood.
                        Your generosity and commitment to helping those in need is greatly appreciated.
                        Thank you for being a part of the Be Positive community and for doing your part to save lives.
                    </p>

                </div>
            </div>
        </div>

    </div>

</div>

<div class="home-body">
    <div class="d-flex g-flex-wrap">
        <a href="/donor/guideline"> <?php
            echo $c1->render();
            ?>
        </a>
        <a href="/donor/history"> <?php
            echo $c2->render();
            ?>
        </a>

        <a href="/donor/nearby">
            <?php
            echo $c3->render();

            ?></a>
    </div>
</div>

<script src="/public/scripts/home.js"></script>

