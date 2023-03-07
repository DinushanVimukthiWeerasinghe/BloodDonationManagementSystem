

<div class="d-flex w-100 flex-column align-items-center bg-white p-1 border-radius-10 m-1">
    <div class="d-flex w-100 flex-row">
        <div class="d-flex bg-white-0-7 p-1 text-dark justify-content-between align-items-center w-100 flex-row gap-0-5 justify-content-center border-bottom-2 mb-1">
            <div class="d-flex align-items-center gap-1 w-20">
            </div>
            <div id="Search" class="d-flex gap-0-5 align-items-center w-30">
                <label for="search" class="search">Search </label>
                <input class="form-control" name="search" id="search" onkeyup="Search('/manager/mngDonors/Search')">
            </div st>
            <div id="Filters" class="d-flex gap-1 w-40 justify-content-end">
                <div class="form-group w-80 jus">
                    <label for="BloodFilter" class="search w-80 text-right">Blood Group</label>
                    <select class="form-control w-20" name="BloodFilter" id="BloodFilter" onchange="FilterFromBloodGroup()">
                        <option value="All" >All</option>
                        <?php
                        foreach($BloodTypes as $BloodType):
                            if ($BloodGroup===$BloodType->getBloodGroupName()):
                                ?>
                                <option value="<?php echo $BloodType->getBloodGroupIDForGET()?>" selected><?php echo $BloodType->getBloodGroupName()?></option>
                                <?php
                                continue;
                            endif;
                            ?>
                            <option value="<?php echo $BloodType->getBloodGroupIDForGET()?>"><?php echo $BloodType->getBloodGroupName()?></option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex w-100 overflow-y-scroll" style="margin-left: 50px">
        <table class="w-100 ">
            <thead class="sticky top-0">
            <tr>
                <th scope="col">No</th>
                <th scope="col">Campaign Name</th>
                <th scope="col">Sponsor Name</th>
                <th scope="col">Expected Amount</th>
                <th scope="col">Sponsored Amount</th>
                <th scope="col">Sponsored Date</th>
                <th scope="col">Remaining</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody id="content">
            <div id="loader" class="none bg-white absolute w-100 h-100 d-flex justify-content-center align-items-center" style="z-index: 999;height: 90%;margin-top: 35px;">
                <img src="/public/loading2.svg" alt="" width="100px">
            </div>
            <?php
            if (empty($data)):
                ?>
                <tr>
                    <td colspan="8" class="text-center">No Data Found</td>
                </tr>
            <?php
            else:
                $i=1;
                foreach ($data as $value):
                    $id = $value->getID();
                    ?>
                    <tr>
                        <td data-label="No "><?= $i++;?></td>
                        <td data-label="Full Name " class="font-bold"><?php echo $value->getFullName()?></td>
                        <td data-label="NIC "><?php echo $value->getNIC()?></td>
                        <td data-label="Contact No "><?php echo $value->getContactNo()?></td>
                        <td data-label="Blood Group "><?php echo $value->getBloodGroup()?></td>
                        <td data-label="Address "><?php echo $value->getAddress()?></td>
                        <td data-label="Status "><?php echo $value->getVerificationStatus()?></td>
                        <td class="d-flex justify-content-center gap-0-5 align-items-center">
                            <button class="text-dark btn gap-0-5 btn-outline-info d-flex align-items-center justify-content-center" onclick="ViewDonor('<?php echo $id ?>')" ><img src="/public/icons/view.svg" width="24px" alt="">View</button>
                            <button class="text-dark btn gap-0-5 btn-outline-info d-flex align-items-center justify-content-center" onclick="SendEmail('<?php echo $id ?>')" ><img src="/public/icons/mail.png" width="24px" alt="">Send Email</button>
                        </td>
                    </tr>
                <?php
                endforeach;
            endif;
            ?>

            </tbody>
        </table>
    </div>
    <div></div>
<!--    <div id="tableFooter" class="py-0-5 bg-white w-100 d-flex justify-content-end align-items-center">-->
<!--        <div class="d-flex">-->
<!--            <div class="d-flex align-items-center justify-content-center">-->
<!--                <div class="d-flex gap-1 align-items-center">-->
<!--                    <label for="page" class="search">Record Per Page</label>-->
<!--                    <select class="px-2 py-0-5" name="page" id="rpp" onchange="ChangeRecordsPerPage()">-->
<!--                        --><?php
//                        $i=5;
//                        while ($i<20):
//                            /** @var int $rpp */
//                            if ((int)$rpp===$i):
//                                ?>
<!--                                <option selected value="--><?php //=$i?><!--">--><?php //=$i?><!--</option>-->
<!--                            --><?php
//                            else :
//                                ?>
<!--                                <option value="--><?php //=$i?><!--">--><?php //=$i?><!--</option>-->
<!--                            --><?php
//                            endif;
//                            ?>
<!--                            --><?php
//                            $i=$i+5;
//                        endwhile;
//                        ?>
<!--                    </select>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="d-flex align-items-center justify-content-center bg-white border-radius-10 " style="padding: 0.3rem 0.6rem">-->
<!--                <a href="--><?php //=$getParams($_GET)?><!--page=--><?php //=$current_page-1?><!--">-->
<!--                    <img src="/public/icons/chevron-left.svg" width="20rem">-->
<!--                </a>-->
<!--            </div>-->
<!--            <div class="d-flex align-items-center justify-content-center bg-white-0-5 border-radius-10 " style="padding: 0.3rem 0.6rem">-->
<!--                <a href="--><?php //=$getParams($_GET)?><!--page=--><?php //=$current_page+1?><!--">-->
<!--                    <img src="/public/icons/chevron-right.svg" width="20rem">-->
<!--                </a>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
</div>