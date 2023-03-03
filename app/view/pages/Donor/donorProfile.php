<?php

/* @var string $Donor_ID */
/* @var string $First_Name */
/* @var string $Last_Name */
/* @var string $Address1 */
/* @var string $Address2 */
/* @var string $Email */
/* @var string $NIC */
/* @var string $Contact_No */
/* @var string $City */

/* @var string $bloodGroup */
/* @var string $weight */
/* @var string $remark */

use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\DonorNavbar;

$Donor_ID;
$First_Name;
$Last_Name;
$Address1;
$Address2;
$Email;
$NIC;
$Contact_No;
$City ;

$bloodGroup = "B+";
$weight = "100";
$remark = "Goodbye";

$Gender;
$Nationality;
$Profile_Image;
$Availability;
$Status;
$Nearest_Bank;
$Donation_Availability;
$Verified;
$Verified_At;
$Verified_By;
$Verification_Remarks;
$BloodPacket_ID;
$Created_At;
$Updated_At;


$background = new BackGroundImage();

echo $background;

$navbar = new DonorNavbar('Donor Profile', '/donor/profile', '/public/images/icons/user.png', true, $First_Name . ' ' . $Last_Name, false);
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
                    Name : <?php echo $First_Name . " " . $Last_Name ?>
                </div>
                <div class="d-flex">
                    Email : <?php echo $Email ?>
                </div>
                <div class="d-flex">
                    NIC : <?php echo $NIC ?>
                </div>
                <div class="d-flex">
                    Contact Number : <?php echo $Contact_No ?>
                </div>
                <div class="d-flex">
                    City : <?php echo $City ?>
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