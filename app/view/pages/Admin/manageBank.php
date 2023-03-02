<?php

//print_r($BloodBanks);

?>
<div class="d-flex justify-content-center flex-column align-items-center bg-white-0-3 p-2">
    <div class="d-flex w-100">
        <div class="d-flex bg-white-0-7 p-1 text-dark justify-content-between align-items-center w-100 ">
            <div id="Search" class="d-flex gap-0-5 align-items-center">
                <label for="search" class="search">Search </label>
                <input class="form-control" name="search" id="search" onkeyup="SearchFunction()">
            </div>
            </div>
<!--a-->
        </div>
    </div>
    <button class="" onclick="addNewBank()">Add New Bank</button>
    <div class="d-flex justify-content-center align-items-center">
        <table class="" id="bankTable">
            <tr>
                <th></th>
                <th>Blood Bank ID</th>
                <th>Blood Bank Name</th>
                <th>Address</th>
                <th>City</th>
                <th>Telephone Number</th>
                <th>Number Of Doctors</th>
                <th>Number Of Nurses</th>
                <th>Number Of Beds</th>
                <th>Number Of Storages</th>
                <th>Type</th>
                <th>Edit Bank</th>

            </tr>
            <?php
            $i=1;
            foreach ($BloodBanks as $BloodBank) {
            $id=$BloodBank->getBloodBankID();
            $name = $BloodBank->getBankName();
            $address = $BloodBank->getAddress1() . ', ' . $BloodBank->getAddress2();
            $city = $BloodBank->getCity();
            $telephone = $BloodBank->getTelephoneNo();
            $numberOfDoctors = $BloodBank->getNoOfDoctors();
            $numberOfNurses = $BloodBank->getNoOfNurses();
            $numberOfBeds = $BloodBank->getNoOfBeds();
            $numberOfStorages = $BloodBank->getNoOfStorages();
            $type = $BloodBank->getType();
            ?>
                <tr class="bg-white-0-7" id="<?php echo $id ?>">

                    <td><?php echo $i++ ?>.</td>
                    <td><?php echo $id ?></td>
                    <td><?php echo $name ?></td>
                    <td><?php echo $address ?></td>
                    <td><?php echo $city ?></td>
                    <td><?php echo $telephone ?></td>
                    <td><?php echo $numberOfDoctors ?></td>
                    <td><?php echo $numberOfNurses ?></td>
                    <td><?php echo $numberOfBeds ?></td>
                    <td><?php echo $numberOfStorages ?></td>
                    <td><?php echo $type ?></td>

                    <td>
                        <button type="button" class="btn btn-success" onclick="editBnkData('<?php echo $id; ?>')">
                            <img src="/public/icons/edit.png" width="24px" alt="">
                        </button>

                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <div id="tableFooter" class="mt-1">
        <div class="d-flex gap-0-5">
            <div class="bg-white border-radius-10 " style="padding: 0.3rem 0.6rem"><</div>
            <div class="bg-white border-radius-10 " style="padding: 0.3rem 0.6rem">1</div>
            <div class="bg-white border-radius-10 " style="padding: 0.3rem 0.6rem">></div>
        </div>
    </div>
</div>


<!---->
<!--//<div class="d-flex" id="ManageBloodBanks">-->
<!--//    <div class="card bg-white">-->
<!--//        <div class="card-header">-->
<!--//            <img src="/public/images/icons/admin/dashboard/blood-bank.png" alt="">-->
<!--//            <div class="card-title">View Blood Bank</div>-->
<!--//        </div>-->
<!--//    </div>-->
<!--//    <div class="card bg-white">-->
<!--//        <div class="card-header">-->
<!--//            <img src="/public/images/icons/admin/dashboard/blood-bank.png" alt="">-->
<!--//            <div class="card-title">Edit Blood Bank</div>-->
<!--//        </div>-->
<!--//    </div>-->
<!--//    <div class="card bg-white">-->
<!--//        <div class="card-header">-->
<!--//            <img src="/public/images/icons/admin/dashboard/blood-bank.png" alt="">-->
<!--//            <div class="card-title">Remove Blood Bank</div>-->
<!--//        </div>-->
<!--//    </div>-->
<!--//</div>-->
<!--//<div class="d-flex" id="ManageBloodBanks">-->
<!--//    <div class="card bg-white" onclick="AddNewManager()">-->
<!--//        <div class="card-header">-->
<!--//            <img src="/public/images/icons/admin/dashboard/manager.png" alt="">-->
<!--//            <div class="card-title">Assign Manager</div>-->
<!--//        </div>-->
<!--//    </div>-->
<!--//    <div class="card bg-white">-->
<!--//        <div class="card-header">-->
<!--//            <img src="/public/images/icons/admin/dashboard/manager.png" alt="">-->
<!--//            <div class="card-title">Edit Manager</div>-->
<!--//        </div>-->
<!--//    </div>-->
<!--//    <div class="card bg-white">-->
<!--//        <div class="card-header">-->
<!--//            <img src="/public/images/icons/admin/dashboard/manager.png" alt="">-->
<!--//            <div class="card-title">Remove Manager</div>-->
<!--//        </div>-->
<!--//    </div>-->
<!--//</div>-->
