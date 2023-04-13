<?php

/* @var string $firstName */

/* @var string $lastName */

use App\model\users\MedicalOfficer;
use App\view\components\ResponsiveComponent\Alert\FlashMessage;

//echo new primaryTitle('Manage Medical Officers');
/* @var array $data */
/* @var MedicalOfficer $value */



FlashMessage::RenderFlashMessages();
?>

<div class="d-flex justify-content-center flex-column align-items-center bg-white-0-3 p-2">
    <div class="d-flex w-100">
        <div class="d-flex bg-white-0-7 p-1 text-dark justify-content-between align-items-center w-100 ">
            <div id="Search" class="d-flex gap-0-5 align-items-center">
                <label for="search" class="search">Search </label>
                <input class="form-control" name="search" id="search" onkeyup="SearchFunction()">
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
    <div class="d-flex justify-content-center align-items-center">
        <table class="">
            <tr>
                <th></th>
                <th>Full Name</th>
                <th>NIC</th>
                <th>Email</th>
                <th>Contact No</th>
                <th>Position</th>
                <th>Action</th>
            </tr>
            <?php
            $i=1;
            foreach ($data as $value) {
            $id=$value->getID();
            $image=$value->getProfileImage();
            $name=$value->getFullName();
            $position=$value->getPosition();
            $NIC=$value->getNIC();
            $contact=$value->getContactNo();
            $email=$value->getEmail();
            $gender=$value->getGender();
            ?>
                <tr class="bg-white-0-7">
                    <td><?php echo $i++ ?>.</td>
                    <td class="font-bold"><?php echo $name ?></td>
                    <td><?php echo $NIC ?></td>
                    <td><?php echo $email?></td>
                    <td><?php echo $contact?></td>
                    <td><?php echo $position ?></td>
                    <td class="d-flex justify-content-center align-items-center">
                        <a class="text-dark" href="/manager/mngMedicalOfficer/edit/<?php echo $id ?>"><img src="/public/icons/edit.png" width="24px" alt=""></a>
<!--                        <a href="/manager/mngMedicalOfficer/delete/--><?php //echo $id ?><!--"><img src="/public/icons/delete.png" alt="" width="24px"></a>-->
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
