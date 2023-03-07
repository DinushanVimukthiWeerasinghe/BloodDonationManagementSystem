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

$getParams = function ($params) {
    $str = '?';
    if (empty($params)) return $str;
    foreach ($params as $key => $value) {
        if ($key == 'page')
            continue;
        $str .= $key . '=' . $value . '&';
    }
    return $str;
};
?>


<!--TODO Implement Emergency Request and Normal Request Filter-->


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
    <div class="d-flex w-100 overflow-y-scroll" style="margin-left: 50px">
        <table class="w-100 ">
            <thead class="sticky top-0">
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
                $id = $value->getRequestID();
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
                    <button class="text-dark btn gap-0-5 btn-outline-success d-flex align-items-center justify-content-center" onclick="ViewBloodRequest('<?php echo $id ?>')" ><img src="/public/icons/eye.svg" width="24px" alt="">View</button>
                    <button class="text-dark btn gap-0-5 btn-outline-info d-flex align-items-center justify-content-center" onclick="ApproveRequest('<?php echo $id ?>')" ><img src="/public/icons/checkCircle.svg" width="24px" alt="">Supply</button>
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
                    <select class="px-2 py-0-5" name="page" id="rpp" onchange="ChangeRecordsPerPage()">
                        <?php
                        $i=5;
                        while ($i<20):
                            /** @var int $rpp */
                            if ((int)$rpp===$i):
                                ?>
                                <option selected value="<?=$i?>"><?=$i?></option>
                            <?php
                            else :
                                ?>
                                <option value="<?=$i?>"><?=$i?></option>
                            <?php
                            endif;
                            ?>
                            <?php
                            $i=$i+5;
                        endwhile;
                        ?>
                    </select>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-center bg-white border-radius-10 " style="padding: 0.3rem 0.6rem">
                <a href="<?=$getParams($_GET)?>page=<?=$current_page-1?>">
                    <img src="/public/icons/chevron-left.svg" width="20rem">
                </a>
            </div>
            <div class="d-flex align-items-center justify-content-center bg-white-0-5 border-radius-10 " style="padding: 0.3rem 0.6rem">
                <a href="<?=$getParams($_GET)?>page=<?=$current_page+1?>">
                    <img src="/public/icons/chevron-right.svg" width="20rem">
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    const  ViewBloodRequest = (id) => {
        const url = `/manager/mngRequests/find`;
        const formData = new FormData();
        formData.append('id', id);
        fetch(url, {
            method: 'POST',
            body: formData
        }).then(response => response.json())
            .then(data => {
                console.log(data)
            })
    }

    const  ApproveRequest = (id) => {
        console.log(id)
    }
</script>








