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

$navbar= new AuthNavbar('Manage Requests','/manager','/public/images/icons/user.png',true,false);
echo $navbar;
$background=new BackGroundImage();
echo $background;
?>


<!--<div class="class-pane d-flex ">-->
<!--    <div class="card nav-card" onclick="Redirect('/manager/mngRequests/er')">-->
<!--        <div class="card-header">-->
<!--            <img src="/public/images/icons/search.png" style="filter: invert(100%)" alt="">-->
<!--            <div class="header-title">Emergency Request</div>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="card nav-card">-->
<!--        <div class="card-header nav">-->
<!--            <img src="/public/images/icons/camera.png" style="filter: invert(100%)" alt="">-->
<!--            <div class="header-title">Blood Request</div>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="card nav-card">-->
<!--        <div class="card-header">-->
<!--            <img src="/public/images/icons/search.png" style="filter: invert(100%)" alt="">-->
<!--            <div class="header-title">Disable Donor</div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!--TODO Implement Emergency Request and Normal Request Filter-->

<div id="detail-pane" class="min-w-80 max-w-90 min-h-80 d-flex justify-content-center flex-column align-items-center">
    <div id="detail-pane" class="min-w-80 max-w-90 mt-10 min-h-80 d-flex justify-content-center flex-column align-items-center" style="margin-top: 6rem">

        <div id="filter-pane" class="filter-pane">
<!--            <div class="text-xl">Filter Request : </div>-->
            <div class="d-flex justify-content-evenly gap-4">
                <div class="search-input gap-2">
                    <label for="emergency" class="search text-white " style="font-size: 1.5rem">Emergency Request </label>
                    <input type="checkbox" class="check-box" name="emergencyRequest" id="emergency" onchange="FilterOnlyNormalRequest()" checked>
                </div>
                <div class="search-input gap-2">
                    <label for="emergency" class="search text-white" style="font-size: 1.5rem">Normal Request </label>
                    <input type="checkbox" class="check-box" name="normalRequest" id="emergency" onchange="FilterOnlyEmergencyRequest()" checked>
                </div>
            </div>


        </div>
        <div class="filter-card">
            <div class="card-navigation">
                <?php
                if ($current_page<=1):
                ?>
                <a class="disabled" href="?page=1"><img class="nav-btn" src="/public/images/icons/previous.png"
                                                        alt=""></a>
                <?php
                else :
                ?>
                <a  href="?page=<?=$current_page-1?>"><img class="nav-btn" src="/public/images/icons/previous.png"
                                                        alt=""></a>
                <?php
                    endif;
                ?>
                <div class="page-numbers">
                    <?php
                    for ($i=1;$i<=$total_pages;$i++){
                        if ($i===$current_page):
                    ?>
                    <a href='?page=<?=$i?>' class="disabled">
                        <div class='page-number active'><?=$i?></div>
                    </a>
                            <?php
                        else:
                            ?>
                            <a href='?page=<?=$i?>'>
                                <div class='page-number '><?=$i?></div>
                            </a>
                            <?php
                        endif;
                            ?>
                    <?php
                    }
                    ?>
                </div>
                <?php
                if ($current_page>=$total_pages):
                ?>
                <a class="disabled" href="?page=1"><img class="nav-btn" src="/public/images/icons/next.png" alt=""></a>
                <?php
                else:
                ?>
                <a href="?page=<?=$current_page+1?>"><img class="nav-btn" src="/public/images/icons/next.png" alt=""></a>
                <?php
                endif;
                ?>
            </div>
        </div>
        <div id="card-pane" class="card-pane">
            <div id="pane-loader" class="pane-loader">
                <img src="/public/loading2.svg" alt="" width="200px">
            </div>
            <?php
            if (empty($data)){
                ?>
                <div class="card detail-card">
                    <div class="card-image">
                        <img src="/public/images/icons/manager/manageRequest/bloodRequest.png" alt="">
                    </div>
                    <div class="card-body">
                        <div class="card-title">
                            No Requests
                        </div>
                    </div>
                </div>
                <?php
            }
            foreach ($data as $value) {
                $id=$value->getRequestID();
                $BloodGroup=$value->getBloodGroup();
                $Requester=$value->getRequestedBy();
                $Time= Date::GetProperDateTime($value->getRequestedAt());
                $Image=$value->getBloodTypeImage();
                $Type=$value->getType();
                ?>
                <div class="card none bg-white" id="MO7646">
                    <div class="card-image" style="height: auto;min-height: auto">
                        <img src='<?= $Image?>' class="rem-5" alt="" style="border-radius: 50%;height: auto!important;">
                    </div>
                    <div class="card-body">
                        <div class="card-title"><?= $Requester ?></div>
                        <div class="card-description"><?= $Time ?></div>
                        <div class="card-description"><?= $Type ?></div>
                    </div>
                    <div class="card-action">
                        <button class="btn btn-outline-primary" onclick="ViewRequest('<?=$id?>')">View</button>
                    </div>
                </div>
                <?php
            }
            ?>

        </div
    </div>
    <script>
    <?php
    echo CardPane::GetLoaderJS();
    ?>
    </script>
    <script src="/public/scripts/manager/demo.js"></script>
    <script>


        const ViewRequest = (id) => {
            const url = '/manager/mngRequests/find';
            const form = new FormData();
            form.append('id', id);
            fetch(url, {
                method: 'POST',
                body: form
            }).then((response) => {
                return response.json();
            }).then((data) => {
                if (data.success){
                    OpenDialogBox({
                        title: 'Request Details',
                        content :`
                            <div class="d-flex align-items-center justify-content-center flex-column">
                                <div class="d-flex">
                                    <div class="text-xl">Request ID : </div>
                                    <div class="text-xl">${data.data.id}</div>
                                </div>
                                <div class="d-flex">
                                    <div class="text-xl">Requester : </div>
                                    <div class="text-xl">${data.data.hospital}</div>
                                </div>
                                <div class="d-flex">
                                    <div class="text-xl">Blood Group : </div>
                                    <div class="text-xl">${data.data.bloodGroup}</div>
                                </div>
                                <div class="d-flex">
                                    <div class="text-xl">Request Type : </div>
                                    <div class="text-xl">${data.data.type}</div>
                                </div>
                            </div>
                        `,
                        successBtnText: 'Approve',
                        successBtnAction: () => {
                            CloseDialogBox();
                        }
                    })
                }
            }).catch((error) => {
                console.log(error);
            });


        }
    </script>







