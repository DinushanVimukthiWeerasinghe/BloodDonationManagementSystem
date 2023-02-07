<?php

use App\model\users\Donor;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;
$navbar = new AuthNavbar('Manage Donors', '/manager', '/public/images/icons/user.png', '$firstName' . ' ' . '$lastName');
echo $navbar;
$background = new BackGroundImage();
echo $background;
/* @var $data Donor */

?>
<?php
 if (!empty($data)) :
?>
<div class="d-flex flex-wrap bg-white-0-3 p-3 gap-3 w-80 mt-5 justify-content-center border-radius-10" id="main" style="overflow-y: scroll">

    <div id="PersonalDetail" class="d-flex flex-column bg-white p-2 border-radius-10 align-items-center gap-1">
        <div class="d-flex p-1 w-100 justify-content-center align-items-center">
            <img src="<?= $data->getProfileImage() ?>" alt="" class="border-1 p-1 border-radius-10 border-primary">
        </div>
        <div class="d-flex text-2xl font-bold mb-1">Personal Details</div>
        <div class="d-flex w-100 justify-content-between" id="Name">
            <div>Full Name</div>
            <div><?= $data->getFullName() ?></div>
        </div>
        <div class="d-flex w-100 justify-content-between" id="NIC">
            <div>NIC</div>
            <div><?= $data->getNIC() ?></div>
        </div>
        <div class="d-flex w-100 justify-content-between" id="Address">
            <div>Address</div>
            <div><?= $data->getAddress() ?></div>
        </div>
        <div class="d-flex w-100 justify-content-between" id="ContactNo">
            <div>Contact No</div>
            <div><?= $data->getContactNo() ?></div>
        </div>
        <div class="d-flex w-100 justify-content-between" id="Email">
            <div>Email</div>
            <div><?= $data->getEmail() ?></div>
        </div>
        <div class="d-flex w-100 justify-content-between" id="Gender">
            <div>Gender</div>
            <div><?= $data->getGender() ?></div>
        </div>
    </div>
    <div class="d-flex flex-column">
        <div id="DonationDetail" class="d-flex bg-white border-radius-10 p-2 flex-column align-items-center gap-1">
            <div class="d-flex text-2xl font-bold mb-1">Donation Details</div>
            <div class="d-flex w-100 justify-content-between" id="Name">
                <div>No Of Donations</div>
                <div>1</div>
            </div>
            <div class="d-flex w-100 justify-content-between" id="Name">
                <div>Total Volume Donated</div>
                <div>1500ml</div>
            </div>
            <div class="d-flex w-100 justify-content-between" id="Name">
                <div>Last Donation Date</div>
                <div>2022 Jan 14</div>
            </div>
        </div>
        <div id="MedicalDetail" class="d-flex flex-column align-items-center gap-1 mt-2 bg-white border-radius-10 p-2">
            <div class="d-flex text-2xl font-bold mb-1">Medical Details</div>
            <div class="d-flex w-100 justify-content-between" id="Name">
                <div>Blood Type :</div>
                <div>O+</div>
            </div>
            <div class="d-flex w-100 justify-content-between" id="Name">
                <div>Medical Issues :</div>
                <div class="d-flex flex-column">
                    <div>Heart Patient <span class="">x</span></div>
                    <div>Heart Patient x</div>
                    <div>Heart Patient x</div>
                </div>
            </div>
            <div class="d-flex w-100 justify-content-between" id="Weight">
                <div>Average Weight :</div>
                <div>65KG</div>
            </div>
            <div class="d-flex w-100 justify-content-between" id="Weight">
                <div>Average Height :</div>
                <div>164cm</div>
            </div>
        </div>
    </div>
    <div class="d-flex flex-column">
        <div id="DonationDetail" class="d-flex flex-column align-items-center gap-1">
            <div class="d-flex text-2xl font-bold mb-1  bg-white border-radius-10 py-1 px-2">Recent Activities</div>
            <div class="d-flex flex-column text-center bg-white-0-3 border-radius-10 p-2" id="RecentDonation">
                <div class="d-flex text-2xl font-bold mb-1 justify-content-center bg-white py-0-5 px-2 border-radius-10">Recent Donation (Within 2 Yr)</div>
                <div class="d-flex flex-wrap justify-content-center align-items-center" id="Donations">
                    <div class="card bg-white " style="width: fit-content;height: fit-content;padding: 1.5rem">
                        <div class="card-body">
                            <div class="d-flex justify-content-center" id="Name">
                                <div>Date :</div>
                                <div>2022 Jan 14</div>
                            </div>
                            <div class="d-flex justify-content-center" id="Name">
                                <div>Volume :</div>
                                <div>1500ml</div>
                            </div>
                            <div class="d-flex justify-content-center" id="Name">
                                <div>Location :</div>
                                <div>Colombo</div>
                            </div>
                        </div>
                    </div>
                    <div class="card p-2 bg-white " style="width: fit-content;height: fit-content;padding: 1.5rem">
                        <div class="card-body">
                            <div class="d-flex justify-content-center" id="Name">
                                <div>Date :</div>
                                <div>2022 Jan 14</div>
                            </div>
                            <div class="d-flex justify-content-center" id="Name">
                                <div>Volume :</div>
                                <div>1500ml</div>
                            </div>
                            <div class="d-flex justify-content-center" id="Name">
                                <div>Location :</div>
                                <div>Colombo</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex text-2xl font-bold mb-1  bg-white border-radius-10 py-1 px-2">Actions</div>
            <div class="d-flex gap-1 justify-content-between text-center bg-white-0-3 border-radius-10 p-2" id="RecentDonation">
                <div class="card card-xs bg-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-center" id="Name">
                            <div>Send Message</div>
                        </div>
                    </div>
                </div>
                <div class="card card-xs bg-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-center" id="Name">
                            <div>Send Message</div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>
<?php
else:
?>
<div class="">
    No Donor
</div>

<?php
endif;
?>
<style>


    @media screen and (max-width: 768px) {
        .w-80 {
            width: 100%;
        }
    }

    @media screen and (max-width: 540px) {
        .w-80 {
            width: 90%;
        }

        #main {
            overflow-y: scroll;
        }
    }
</style>
