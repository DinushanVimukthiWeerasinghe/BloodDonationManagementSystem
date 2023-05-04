<?php
/** @var int $total_pages */
/** @var int $current_page */
/** @var string $q */
/** @var array $data */
/** @var MedicalOfficer $value */

use App\model\users\MedicalOfficer;
use App\view\components\Loader\Loader;
use App\view\components\ResponsiveComponent\CardPane\CardPane;
?>
<div class="d-flex justify-content-center flex-column align-items-center bg-white-0-3 p-2">
    <div class="d-flex w-100">
        <div class="d-flex bg-white-0-7 p-1 text-dark justify-content-between align-items-center w-100 ">
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
            <!--a-->
        </div>
    </div>
    <div class="d-flex justify-content-center align-items-center">
        <table class="">
            <tr>
                <th></th>
                <th>Full Name</th>
                <th>NIC</th>
                <th>Email</th>
                <th>Contact No</th>
                <th>Gender</th>
                <th>Position</th>
                <th>Nationality</th>
                <th>Action</th>
            </tr>
            <tbody id="content">
            <?php
            $i=1;
            if (!empty($data)):
                foreach ($data as $value) {
                    $id=$value->getID();
                    $image=$value->getProfileImage();
                    $name=$value->getFullName();
                    $position=$value->getPosition();
                    $NIC=$value->getNIC();
                    $contact=$value->getContactNo();
                    $email=$value->getEmail();
                    $gender=$value->getGender();
                    $nationality=$value->getNationality();
                    ?>
                    <tr class="bg-white-0-7">
                        <td data-label="No "><?php echo $i++ ?>.</td>
                        <td data-label="Name" class="font-bold"><?php echo $name ?></td>
                        <td data-label="NIC"><?php echo $NIC ?></td>
                        <td data-label="Email"><?php echo $email?></td>
                        <td data-label="Contact No"><?php echo $contact?></td>
                        <td data-label="Gender"><?php echo $gender?></td>
                        <td data-label="Position"><?php echo $position ?></td>
                        <td data-label="Nationality"><?php echo $nationality?></td>
                        <td class="d-flex justify-content-center gap-1 align-items-center">
                            <?php /** @var string $type */
                            if ($type==='assign'): ?>
                            <button id="btn-<?= $id?>" class="text-dark btn gap-0-5 btn-outline-success d-flex align-items-center justify-content-center" onclick="AssignMedicalOfficer('<?php echo $id ?>')" ><img src="/public/icons/checkCircle.svg" width="24px" alt=""><span>Assign</span></button>
                    <?php  else: ?>
                        <button class="text-dark btn gap-0-5 btn-outline-success d-flex align-items-center justify-content-center" onclick="EditMedicalOfficer('<?php echo $id ?>')" ><img src="/public/icons/edit.png" width="24px" alt="">Edit</button>
                        <button class="text-dark btn gap-0-5 btn-outline-info d-flex align-items-center justify-content-center" onclick="SendEmail('<?php echo $id ?>')" ><img src="/public/icons/mail.png" width="24px" alt="">Send Email</button>
                        <?php
                            endif;
                        ?>
                        </td>
                    </tr>
            <?php }
                else :?>
                <tr>
                    <td colspan="9" class="text-center">No Data Found</td>
                </tr>
            <?php endif; ?>
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

