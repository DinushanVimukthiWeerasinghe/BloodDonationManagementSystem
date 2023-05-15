<?php
?>

<head>
</head>
<?php

use App\model\Notification\DonorNotification;
use App\view\components\Card\ClickableCard;
use App\view\components\Image\GeneralImage;
use App\view\components\ResponsiveComponent\Alert\FlashMessage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;
use App\view\components\ResponsiveComponent\NavbarComponent\DonorNavbar;
use App\view\components\ResponsiveComponent\NotificationComponent\Notification;

$donation_Image='/public/images/donation.png';
$donation_History='fa-solid fa-clock-rotate-left';
$donation_Guideline = 'fa-solid fa-hand-holding-medical';
$nearby_Donations = 'fa-solid fa-map-marker-alt';
$blood_Requests = '';

/* @var string $firstName */
/* @var string $lastName */


$Image=new GeneralImage("/public/images/logo.png", "Home Image", "logo","250rem");
$profileImage = $profileImage ?? '/public/images/icons/user.png';

$c1 = new ClickableCard("Donation Guideline", $donation_Guideline,"Donation Guideline");
$c2 = new ClickableCard("Donation History", $donation_History,"Donation History");
$c3 = new ClickableCard("Nearby Donations", $nearby_Donations,"Nearby Donations");
//$c4 = new \App\view\components\Card\ClickableCard("Blood Requests", $blood_Requests,"Blood Requests");

$navbar = new DonorNavbar('Donor Board', '/donor/profile', $profileImage, true,$firstName . ' ' . $lastName,false );
//echo $navbar;

//$notification = new Notification;
//echo $notification->getNotification('Notification', 'Are you sure you want to', 'Notification', 'Are you sure', 'Are you sure', 'Are you sure', 'Are you sure', 'Are you sure');
$alert = new FlashMessage();


if ($verificationStatus == \App\model\users\Donor::PENDING){
    echo $alert->ErrorAlert("You are not verified yet please verify your account by visiting the nearest blood bank or blood donation campaign");
}else if ($verificationStatus == \App\model\users\Donor::NOT_VERIFIED){
    if ($state == 0){
        echo $alert->ErrorAlert("You Cannot Donate Blood at this time Moment");
    }else{
        echo $alert->SuccessAlert("You Can Donate Blood at this time Moment");
    }
}

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
                    <p class="text text-white text-xl text-center" style="font-weight: 400">Thank you for visiting the Be Positive blood donation campaign management system.
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
<!--        <a href="/donor/request"> --><?php
//            echo $c4->render();
//            ?>
<!--        </a>-->
    </div>
</div>

<script src="/public/scripts/home.js"></script>
<script>
    <?php echo $alert->DestroyAlert() ?>;

    window.onload = () => {onLoadTrigger(<?php echo $_SESSION['pop']; ?>)};

    function onLoadTrigger(trigger){
        CloseDialogBox();
        if (trigger === 0){
        OpenDialogBox({
            title: 'Quick Data Collection About You',
            id : 'dataPop',
            content: `<form action="/donor/profile/loginPrompt" method="post" id='donorDataCollection'>
                        <label>Are you?</label>
                        <ul class="" style="text-align: left">
                        <li class="">Patient of serious disease condition.</li>
                        <li class="">Pregnant</li>
                        <li class="">Homosexual.</li>
                        <li class="">Sex worker or their client.</li>
                        <li class="">Drug addict.</li>
                        <li class="">Engaging in sex with any of the above.</li>
                        <li class="">Having more than one sexual partner.</li>
                        </ul><br>
                        <input type="checkbox" name="agree" id='agree' value='0'> &emsp; I am free from all of above</input>
                                                  </form>`,
            successBtnText: 'Submit',
            successBtnAction: () => {
                // document.getElementById('donorDataCollection').submit();
                <?php $_SESSION['pop'] = 1; ?>
                CloseDialogBox();
            },
            cancelBtnAction: () => {
                <?php $_SESSION['pop'] = 1; ?>
                CloseDialogBox();
            }
        })
            // CloseDialogBox();
        }
    }
</script>