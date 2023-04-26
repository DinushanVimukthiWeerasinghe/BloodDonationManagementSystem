<?php

//print_r($BloodBanks);

?>
<div class="d-flex justify-content-center flex-column align-items-center p-1">
    <div class="d-flex gap-1 w-100">
        <div class="d-flex gap-1 text-dark align-items-center justify-content-between align-items-center w-100 ">
            <div id="Search" class="d-flex gap-0-5 align-items-center">
                <label for="Search" class="text-dark text-xl font-bold">Search</label>
                <input class="form-control" name="Search" id="search" onkeyup="SearchBank()">
            </div>
             <button class="btn btn-success" onclick="addNewBank()">Add New Bank</button>
        </div>
    </div>
    </div>
    <div id="div1" class="d-flex min-h-75 overflow-y-auto mb-3">
        <table class="" id="bankTable">
            <thead class="bg-white">
            <tr class="bg-white">
                <th class="bg-white">Blood Bank ID</th>
                <th class="bg-white">Blood Bank Name</th>
                <th class="bg-white">Address</th>
                <th class="bg-white">City</th>
                <th class="bg-white">Telephone Number</th>
                <th class="bg-white">Number Of Doctors</th>
                <th class="bg-white">Number Of Nurses</th>
                <th class="bg-white">Number Of Beds</th>
                <th class="bg-white">Number Of Storages</th>
                <th class="bg-white">Type</th>
                <th class="bg-white">Action</th>
            </tr>
            </thead>
            <tbody>

            <?php
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
                <tr class="bg-white-0-7 tableRows" id="<?php echo $id ?>">

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
                    <td class="d-flex flex-center">
                        <button type="button" class="btn btn-outline-success border-radius-10" onclick="editBnkData('<?php echo $id; ?>')">
                            <img src="/public/icons/edit.png" width="24px" alt="">
                        </button>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
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
