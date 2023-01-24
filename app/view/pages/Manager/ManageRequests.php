<?php
/* @var $data array*/
/* @var $value BloodRequest*/

use App\model\Requests\BloodRequest;
use App\model\Utils\Date;
use App\view\components\ResponsiveComponent\ButtonComponent\DashBoardButton;
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
    <div id="detail-pane" class="min-w-80 max-w-90 mt-10 min-h-80 d-flex justify-content-center flex-column align-items-center">

        <div id="filter-pane" class="filter-pane">
            <div class="text-3xl">Filter Request : </div>
            <div class="d-flex justify-content-evenly">
                <div class="search-input">
                    <input type="checkbox" class="check-box" name="emergencyRequest" id="emergency" onchange="FilterOnlyNormalRequest()" checked>
                    <label for="emergency" class="search">Emergency Request </label>
                </div>
                <div class="search-input">
                    <input type="checkbox" class="check-box" name="normalRequest" id="emergency" onchange="FilterOnlyEmergencyRequest()" checked>
                    <label for="emergency" class="search">Normal Request </label>
                </div>
            </div>


        </div>
        <div class="filter-card">
            <div class="card-navigation">
                <a class="disabled" href="?page=1"><img class="nav-btn" src="/public/images/icons/previous.png"
                                                        alt=""></a>
                <div class="page-numbers">
                    <a href='?page=1' class='disabled'>
                        <div class='page-number active'>1</div>
                    </a>
                </div>
                <a class="disabled" href="?page=1"><img class="nav-btn" src="/public/images/icons/next.png" alt=""></a>
            </div>
        </div>
        <div id="card-pane" class="card-pane">
            <div class="pane-loader">
                <img src="/public/loading2.svg" alt="" width="200px">
            </div>
            <?php
            if (empty($data)){
                ?>
                <div class="card detail-card">
                    <div class="card-image">
                        <img src="/public/images/icons/manager/manageMedicalOfficer/doctor.png" alt="">
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
                <div class="card bg-white" id="MO7646">
                    <div class="card-image" style="height: auto;min-height: auto">
                        <img src='<?= $Image?>' class="rem-5" alt="" style="border-radius: 50%;height: auto!important;">
                    </div>
                    <div class="card-body">
                        <div class="card-title"><?= $Requester ?></div>
                        <div class="card-description"><?= $Time ?></div>
                        <div class="card-description"><?= $Type ?></div>
                    </div>
                    <div class="card-action">
                        <button class="btn btn-outline-primary" onclick="fund()">View</button>
                    </div>
                </div>
                <?php
            }
            ?>

        </div
    </div>
    <?php
    echo CardPane::GetJS('/manager/mngMedicalOfficer/search');
    ?>
    <script src="/public/scripts/manager/demo.js"></script>
    <script>
        const fund = () => {
            fetch('https://reqres.in/api/users?page=2', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                },
            })
                .then(response => response.json())
                .then(data => {
                    console.log('Success:', data);
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        }
    </script>







