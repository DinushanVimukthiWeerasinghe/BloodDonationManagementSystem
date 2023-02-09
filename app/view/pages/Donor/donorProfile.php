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



<div class="d-flex bg-white-0-5 mt-7 w-80 p-3 border-radius-10 min-h-80 flex-column justify-content-center align-items-center">
    <div class="d-flex gap-2">
        <div class="d-flex">
            <img src="https://th.bing.com/th/id/R.d109030661f299bf427a10adebf80646?rik=QvhrbBgRD1Sqzw&pid=ImgRaw&r=0" width="200rem" alt="profile image for user" class="profilePicture" />
        </div>
        <div class="d-flex flex-column">
            <div class="d-flex flex-column " id="PersonalDetails">
                <div class="d-flex">
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
            </div>
        </table>
        </div>
    </div>

    <div class="button">
        <button type="button" class="button-9">Change Password</button>
    </div>
    <div class="info-card shadow">
            <p> Blood Type: <?php echo $bloodGroup ?></p>
            <p>Weight(Kg): <?php echo $weight ?> </p>
            <p>Chronic Diseases: <?php echo $remark ?></p>
    </div>
</div>