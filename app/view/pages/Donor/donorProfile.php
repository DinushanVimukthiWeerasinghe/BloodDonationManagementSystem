<?php

/* @var string $donorID */
/* @var string $firstName */
/* @var string $lastName */
/* @var string $email */
/* @var string $NIC */
/* @var string $contactNumber */
/* @var string $city */

/* @var string $bloodGroup */
/* @var string $weight */
/* @var string $remark */

use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\DonorNavbar;

$donorID = "1234";
$firstName = "John";
$lastName = "Smith";
$email = "John@example.com";
$NIC = "123456789";
$contactNumber = "123456789";
$city = "Colorado";

$bloodGroup = "B+";
$weight = "100";
$remark = "Goodbye";

$background = new BackGroundImage();

echo $background;

$navbar = new DonorNavbar('Donor Profile', '/donor/profile', '/public/images/icons/user.png', true, $firstName . ' ' . $lastName, false);
echo $navbar;


?>

<!--<head>-->
<!--    <link rel="stylesheet" href='/public/css/home.css'>-->
<!--    <link rel="stylesheet" href='/public/styles/home.css'>-->
<!--</head>-->



<div class="d-flex gap-1 bg-white-0-5 mt-7 p-3 border-radius-10 min-h-80 flex-column justify-content-center align-items-center">
    <div class="d-flex border-radius-10 gap-2 bg-white p-2">
        <div class="d-flex">
            <img src="/public/upload/profile/donorDefault.png" width="300rem" alt="profile image for user" class="border-2 border-radius-10 border-success" />
        </div>
        <div class="d-flex flex-column bg-white p-2">
            <div class="d-flex gap-1 flex-column " id="PersonalDetails">
                <div class="d-flex ">
                    Name : <?php echo $firstName . " " . $lastName ?>
                </div>
                <div class="d-flex">
                    Email : <?php echo $email ?>
                </div>
                <div class="d-flex">
                    NIC : <?php echo $NIC ?>
                </div>
                <div class="d-flex">
                    Contact Number : <?php echo $contactNumber ?>
                </div>
                <div class="d-flex">
                    City : <?php echo $city ?>
                </div>
                <div class="button">
                    <button type="button" class="btn btn-success">Change Password</button>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex gap-1 justify-content-evenly">
        <div class="bg-white d-flex flex-column gap-1 p-3 border-radius-10">
            <p> Blood Type: <?php echo $bloodGroup ?></p>
            <p>Weight(Kg): <?php echo $weight ?> </p>
            <p>Chronic Diseases: <?php echo $remark ?></p>
        </div>
        <div class="bg-white d-flex flex-column gap-1 p-3 border-radius-10">
            <p> Blood Type: <?php echo $bloodGroup ?></p>
            <p>Weight(Kg): <?php echo $weight ?> </p>
            <p>Chronic Diseases: <?php echo $remark ?></p>
        </div>

    </div>

</div>