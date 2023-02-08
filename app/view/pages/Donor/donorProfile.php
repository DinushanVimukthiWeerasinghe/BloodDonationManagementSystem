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

?>

<head>
    <link rel="stylesheet" href='/public/css/home.css'>
    <link rel="stylesheet" href='/public/styles/home.css'>
</head>



<div class="sub-panel">
    <div class="container">
        <div class="left">
            <img src="https://th.bing.com/th/id/R.d109030661f299bf427a10adebf80646?rik=QvhrbBgRD1Sqzw&pid=ImgRaw&r=0" alt="profile image for user" class="profilePicture" />
        </div>
        <div class="right">
            <table class="table" style="text-align: left">
                <tr><td>Donor ID</td><td>:</td><td><?php echo $donorID ?></td></tr>
                <tr><td>Name</td><td>:</td><td><?php echo $firstName . ' ' . $lastName ?></td></tr>
                <tr><td>Email</td><td>:</td><td><?php echo $email ?></td></tr>
                <tr><td>NIC</td><td>:</td><td><?php echo $NIC ?></td></tr>
                <tr><td>Mobile Number</td><td>:</td><td><?php echo $contactNumber ?></td></tr>
                <tr><td>Address</td><td>:</td><td><?php echo $city ?></td></tr>
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