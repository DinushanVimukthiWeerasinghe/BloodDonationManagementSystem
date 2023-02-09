<?php
/** @var int $total_pages */
/** @var int $current_page */
/** @var string $q */

use App\model\users\MedicalOfficer;
use App\view\components\Loader\Loader;
use App\view\components\ResponsiveComponent\CardPane\CardPane;
?>
<div id="filter-pane" class="filter-pane">
    <div class="search-input">
        <label class="search">Search
            <input class="search-box" name="search" id="search" onkeyup="SearchFunction()">
        </label>
        <div class="search-icon" id="search-btn" onclick="SearchFunction()">
            <img src="/public/images/icons/search.png" alt="">
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
        <div class="card  detail-card">
            <div class="card-image">
                <img src="/public/images/icons/manager/manageMedicalOfficer/doctor.png" alt="">
            </div>
            <div class="card-body">
                <div class="card-title">
                    No Medical Officers
                </div>
            </div>
        </div>
        <?php
    }
    foreach ($data as $value) {
        $id=$value->getID();
        $image=$value->getProfileImage();
        $name=$value->getFullName();
        $position=$value->getPosition();
        $NIC=$value->getNIC();
        $branch=$value->getBranchLocation();
        ?>
        <div class="detail-card none" id="MO7646" onclick="RedirectID('<?= $id?>')">
            <div class="card-image">
                <img src='<?= $image?>' alt="">
            </div>
            <div class="card-body">
                <div class="card-title"><?= $name ?></div>
                <div class="card-description"><?= $position ?></div>
                <div class="card-description"><?= $NIC ?></div>
                <div class="card-description"><?= $branch ?></div>
            </div>
        </div>
        <?php
    }
    ?>

</div
