<?php
/* @var $data array*/
/* @var $value BloodRequest*/
/* @var $total_pages int*/
/* @var $current_page int*/
use App\model\Requests\BloodRequest;
use App\model\Utils\Date;
use App\view\components\ResponsiveComponent\CardPane\CardPane;
use App\view\components\ResponsiveComponent\ImageComponent\BackGroundImage;
use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;

?>


<!--TODO Implement Emergency Request and Normal Request Filter-->


<div class="d-flex w-100 flex-column align-items-center bg-white-0-3 p-2">
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
            <!--a-->
        </div>
    </div>
    <div class="d-flex justify-content-center align-items-center w-100">
        <table class="w-100">
            <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Request Type</th>
                <th scope="col">Request by</th>
                <th scope="col">Request Date</th>
                <th scope="col">Request Type</th>
                <th scope="col">Requested Blood Group</th>
                <th scope="col">Request Status</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i=1;
            foreach ($data as $value):
            ?>
            <tr>
                <td><?= $i++;?></td>
                <td><?php echo $value->getRequestedBy()?></td>
                <td><?php echo $value->getRequestedBy()?></td>
                <td><?php echo Date::GetProperDate($value->getRequestedAt())?></td>
                <td><?php echo $value->getType()?></td>
                <td><?php echo $value->getBloodGroup()?></td>
                <td><?php echo $value->getRequestStatus()?></td>
                <td class="d-flex justify-content-center gap-0-5 align-items-center sticky right-0 bg-white">
                    <a class="text-dark btn gap-0-5 btn-outline-info d-flex align-items-center justify-content-center" href="/manager/mngMedicalOfficer/edit/<?php echo $id ?>" ><img src="/public/icons/view.svg" width="24px" alt="">View</a>
                    <a class="text-dark btn gap-0-5 btn-outline-success d-flex align-items-center justify-content-center" href="/manager/mngMedicalOfficer/edit/<?php echo $id ?>" ><img src="/public/icons/verify.svg" width="24px" alt="">Approve</a>
                </td>
            </tr>
            <?php
            endforeach;
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








