<?php

/* @var Campaign $value*/

use App\model\Campaigns\Campaign;
use App\model\Utils\Date;

?>
<div class="d-flex w-100 flex-column align-items-center bg-white p-1 border-radius-10 m-1">
    <div class="d-flex w-100 flex-row">
        <div class="d-flex bg-white-0-7 p-1 text-dark justify-content-between align-items-center w-100 flex-row gap-0-5 justify-content-center ">
            <div class="d-flex align-items-center gap-1 btn btn-outline-success" onclick="AddMedicalOfficer()">
                <img src="/public/icons/person-add.svg" width="24" alt=""/>
                <span class=" font-bold">Add Officer</span>
            </div>
            <div id="Search" class="d-flex gap-0-5 align-items-center">
                <label for="search" class="search">Search </label>
                <input class="form-control" name="search" id="search" onkeyup="Search('/manager/mngMedicalOfficer/search')">
            </div>
            <div id="Filters" class="d-flex gap-1">
                <div class="form-group">
                    <label for="filter" class="search ">Position</label>
                    <select class="form-control" name="filter" id="filter">
                        <option value="All">All</option>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="filter" class="search ">Branch</label>
                    <select class="form-control" name="filter" id="filter">
                        <option value="All">All</option>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex w-100 overflow-y-scroll">
        <table class="w-100">
            <thead class="sticky top-0">
            <tr>
                <th>No</th>
                <th>Campaign Date</th>
                <th>Campaign Name</th>
                <th>Campaign Date</th>
                <th>Venue</th>
                <th>Organization Name</th>
                <th>Request Status</th>
                <th>Verified By</th>
                <th>Assigned Team</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody id="content" class="">
            <div id="loader" class="none bg-white absolute w-100 h-100 d-flex justify-content-center align-items-center" style="z-index: 999;height: 90%;margin-top: 35px;">
                <img src="/public/loading2.svg" alt="" width="100px">
            </div>
            <?php
            $i=1;
            if (!empty($data)):
            foreach ($data as $value):
                ?>
                <tr class="bg-white-0-7">
                    <td data-label="No"><?= $i++;?>.</td>
                    <td data-label="Date"><?php echo Date::GetProperDate($value->getCampaignDate());?></td>
                    <td data-label="Campaign Name"><?php echo $value->getCampaignName()?></td>
                    <td data-label="Campaign Date"><?php echo Date::GetProperDate($value->getCampaignDate())?></td>
                    <td data-label="Venue"><?php echo $value->getVenue()?></td>
                    <td data-label="Organization"><?php echo $value->getOrganizationID()?></td>
                    <td data-label="Campaign Status"><?php echo $value->getCampaignStatus()?></td>
                    <td><?php echo $value->getCampaignStatus()?></td>
                    <td><?php echo $value->getCampaignStatus()?></td>
                    <td>
                        <button class="btn btn-outline-info" onclick="ViewCampaignRequest('<?php echo $value->getCampaignID()?>')">View</button>
                        <?php
                            if ($value->isVerified()):
                        ?>
                        <button class="btn btn-outline-success" onclick="AssignTeam('<?php echo $value->getCampaignID()?>')">Assign Team</button>
                                <?php
                            else:
                                ?>
                                <button class="btn btn-outline-success" onclick="AcceptCampaignRequest('<?php echo $value->getCampaignID()?>')">Accept</button>
                                <button class="btn btn-outline-danger" onclick="RejectCampaignRequest('<?php echo $value->getCampaignID()?>')">Reject</button>
                            <?php
                        endif;
                        ?>
                    </td>
                </tr>
            <?php
            endforeach;
            else :?>
            <tr>
                <td colspan="9" class="text-center">No Data Found</td>
            </tr>
            <?php
            endif;
            ?>

            </tbody>
        </table>
    </div>
    <div id="tableFooter" class="py-0-5 bg-white w-100 d-flex justify-content-end align-items-center">
        <div class="d-flex">
            <div class="d-flex align-items-center justify-content-center">
                <div class="d-flex gap-1 align-items-center">
                    <label for="page" class="search">Record Per Page</label>
                    <select class="px-2 py-0-5" name="page" id="page">
                        <?php
                        for ($i = 1; $i <= $total_pages; $i++) {
                            if ($i == $current_page) {
                                echo "<option value='$i' selected>$i</option>";
                            } else {
                                echo "<option value='$i'>$i</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-center bg-white border-radius-10 " style="padding: 0.3rem 0.6rem">
                <img src="/public/icons/chevron-left.svg" width="20rem">
            </div>
            <div class="d-flex align-items-center justify-content-center bg-white-0-5 border-radius-10 " style="padding: 0.3rem 0.6rem">
                <img src="/public/icons/chevron-right.svg" width="20rem">
            </div>
        </div>
    </div>
</div>


