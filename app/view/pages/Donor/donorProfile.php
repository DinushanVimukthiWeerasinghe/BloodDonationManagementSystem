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

/* @var string $BloodGroup */
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

//$BloodGroup;
$weight = "100";
$remark = "Goodbye";

//$Gender;
//$Nationality;
//$Profile_Image;
//$Availability;
//$Status;
//$Nearest_Bank;
//$Donation_Availability;
//$Verified;
//$Verified_At;
//$Verified_By;
//$Verification_Remarks;
//$BloodPacket_ID;
//$Created_At;
//$Updated_At;


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
            <img src="<?=$Profile_Image?>" width="300rem" alt="profile image for user" class="border-2 border-radius-10 border-success" />
        </div>
        <div class="d-flex flex-column bg-white p-2">
            <div class="d-flex gap-1 flex-column " id="PersonalDetails">
                <div class="d-flex ">
                    Name : <?php echo $First_Name . " " . $Last_Name ?>
                </div>
                <div class="d-flex" id="email">
                    Email : <?php echo $Email ?>
                </div>
                <div class="d-flex">
                    NIC : <?php echo $NIC ?>
                </div>
                <div class="d-flex" id="number">
                    Contact Number : <?php echo $Contact_No ?>
                </div>
                <div class="d-flex">
                    City : <?php echo $City ?>
                </div>
                <div class="button">
                    <button type="button" class="btn btn-success">Change Password</button>
                    <button type="button" class="btn btn-success" onclick="editData('<?php echo $Donor_ID;?>')">Edit Data</button>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex gap-1 justify-content-evenly">
        <div class="bg-white d-flex flex-column gap-1 p-3 border-radius-10">
            <p> Blood Type: <?php echo $BloodGroup ?></p>
            <p>Weight(Kg): <?php echo $weight ?> </p>
            <p>Chronic Diseases: <?php echo $remark ?></p>
        </div>

    </div>

</div>

<script>

        const editData = (id) => {

            let email = document.getElementById('email').innerHTML.split(':')[1];
            let number = document.getElementById('number').innerHTML.split(':')[1];

            OpenDialogBox({
                title: 'Edit Details',
                content: `<form action="/donor/profile/edit" method="post" id='editForm'>
                            <label for='email'>Email</label><input class='text-center border-radius-6' id='newEmail' type='email' name='Email' value=${email}>
                            <label for='number'> Number </label><input class='text-center border-radius-6' id='newNumber' type='tel' name='Contact_No' value=${number}>
                          </form>`,
                successBtnText: 'Change',
                successBtnAction: () => {
                    // let newMail = document.getElementById('newEmail').value;
                    // let newNumber = document.getElementById('newNumber').value;
                    // const url = '/donor/profile/edit';
                    // const form = new FormData();
                    // form.append('Donor_ID', id);
                    // form.append('Email', newMail);
                    // form.append('Contact_No', newNumber);
                    // form.submit();
                    //console.log(document.getElementById('editForm'));
                    document.getElementById('editForm').submit();
                }
            })
        }
</script>