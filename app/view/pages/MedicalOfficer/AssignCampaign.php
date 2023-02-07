<?php

use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;

$navbar = new AuthNavbar('Medical Officer Board', '/manager', '/public/images/icons/user.png', true,false );


$background = new BackGroundImage();
echo $navbar;
echo $background;
?>

<div class="d-flex flex-column bg-white-0-3 border-radius-10 p-2">
    <div class="d-flex flex-column mb-1" id="ManageDonor">
        <h1 class="text-center">Manage Donor</h1>
        <div class="d-flex flex-wrap">
            <div class="card" onclick="VerifyDonor()">
                <div class="card-header flex-column text-dark">
                    <div class="card-header-img">
                        <img src="/public/images/icons/verify.png" alt="verify" />
                    </div>
                    <h3>Verify Donor</h3>
                </div>
            </div>
            <div class="card">
                <div class="card-header flex-column text-dark">
                    <div class="card-header-img">
                        <img src="/public/images/icons/verify.png" alt="verify" />
                    </div>
                    <h3>Add Donor</h3>
                </div>
            </div>
            <div class="card">
                <div class="card-header flex-column text-dark">
                    <div class="card-header-img">
                        <img src="/public/images/icons/verify.png" alt="verify" />
                    </div>
                    <h3>Take Donation</h3>
                </div>
            </div>
            <div class="card">
                <div class="card-header flex-column text-dark">
                    <div class="card-header-img">
                        <img src="/public/images/icons/verify.png" alt="verify" />
                    </div>
                    <h3>Report Donor</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex flex-column mt-1" id="ManageDonor">
        <h1 class="text-center">Manage Donations</h1>
        <div class="d-flex flex-wrap">
            <div class="card">
                <div class="card-header flex-column text-dark">
                    <div class="card-header-img">
                        <img src="/public/images/icons/verify.png" alt="verify" />
                    </div>
                    <h3>Verify Donation</h3>
                </div>
            </div>
            <div class="card">
                <div class="card-header flex-column text-dark">
                    <div class="card-header-img">
                        <img src="/public/images/icons/verify.png" alt="verify" />
                    </div>
                    <h3>Reject Donation</h3>
                </div>
            </div>
            <div class="card">
                <div class="card-header flex-column text-dark">
                    <div class="card-header-img">
                        <img src="/public/images/icons/verify.png" alt="verify" />
                    </div>
                    <h3>Examine Donation</h3>
                </div>
            </div>
            <div class="card">
                <div class="card-header flex-column text-dark">
                    <div class="card-header-img">
                        <img src="/public/images/icons/verify.png" alt="verify" />
                    </div>
                    <h3>Store Donation</h3>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="/public/js/mofficer/index.js"></script>