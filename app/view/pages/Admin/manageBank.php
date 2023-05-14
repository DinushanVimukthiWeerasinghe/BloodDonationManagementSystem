<?php

//print_r($BloodBanks);

?>
<div class="d-flex flex-column align-items-center w-100 p-0-5 h-100">
    <div class="d-flex mb-2 mt-1 gap-1 w-100">
        <div class="d-flex gap-1 text-dark align-items-center justify-content-between align-items-center w-95 ">
            <div></div>
            <div id="Search" class="d-flex gap-0-5 align-items-center">
                <label for="Search" class="text-dark text-xl font-bold">Search</label>
                <input class="form-control" name="Search" id="search" onkeyup="SearchBank()">
            </div>
             <button class=" mr-1 btn btn-success d-flex flex-center gap-1 btn-lg" onclick="addNewBank()">
                 <i class="fa-solid fa-plus"></i>
                 Add Blood Bank
             </button>
        </div>
    </div>
    <div class="d-flex w-95 pt-2 pb-1 flex-center flex-column bg-white border-radius-10" style="max-height: 80vh">
        <div class="w-95  d-flex min-h-75 overflow-y-overlay" id="div1">
            <table class="" id="bankTable">
                <thead class="sticky top-0">
                <tr>
                    <th class="sticky left-0 bg-white" style="z-index: 9">No</th>
                    <th>Blood Bank Name</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Telephone Number</th>
                    <th>Number Of Doctors</th>
                    <th>Number Of Nurses</th>
                    <th>Number Of Beds</th>
                    <th>Number Of Storages</th>
                    <th>Type</th>
                    <th class="sticky right-0 bg-white" style="z-index: 9">Action</th>
                </tr>
                </thead>
                <tbody>

                <?php
                $no=1;
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
                    <tr class="bg-white-0-7 " id="<?php echo $id ?>">

                        <td class="sticky left-0 bg-white"><?php echo $no++ ?></td>
                        <td><?php echo $name ?></td>
                        <td><?php echo $address ?></td>
                        <td><?php echo $city ?></td>
                        <td><?php echo $telephone ?></td>
                        <td><?php echo $numberOfDoctors ?></td>
                        <td><?php echo $numberOfNurses ?></td>
                        <td><?php echo $numberOfBeds ?></td>
                        <td><?php echo $numberOfStorages ?></td>
                        <td><?php if($type === \App\model\BloodBankBranch\BloodBank::BRANCH){
                            echo "Branch";
                            }elseif ($type === \App\model\BloodBankBranch\BloodBank::MAIN){
                            echo "Main";
                            } ?></td>
                        <td class=" sticky right-0 bg-white" style="z-index: 9">
                            <button type="button" class="btn btn-outline-success border-radius-10" onclick="editBnkData('<?php echo $id; ?>')">
                                <i class="fas fa-edit"></i>
                                Edit
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
</div>


