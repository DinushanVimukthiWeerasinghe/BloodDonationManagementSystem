<?php
/* @var DonorHealthCheckUp $DonorCheck */
/* @var Donor $Donor */

use App\model\Donor\DonorHealthCheckUp;
use App\model\users\Donor;
use App\view\components\ResponsiveComponent\Alert\FlashMessage;

?>

<?php FlashMessage::RenderFlashMessages();?>
<div class="d-flex w-100 gap-1 flex-column justify-content-start align-items-center bg-white m-1 border-radius-10">
    <div class="bg-dark mt-1 px-2 py-1 text-white text-center w-90">
        Blood Check - Queue (<?=$Campaign->getCampaignName()?>)

    </div>
    <div class="d-flex w-80 overflow-y-scroll ">
        <table class="w-100 ">
            <thead class="sticky top-0 border-1 border-dark">
            <tr>
                <th>No</th>
                <th>Full Name</th>
                <th>NIC</th>
                <th>Contact No</th>
                <th>Gender</th>
                <th>Action</th>
            </tr>
            </thead>
            <div id="loader" class="none bg-white absolute w-100 h-100 d-flex justify-content-center align-items-center" style="z-index: 999;height: 90%;margin-top: 35px;">
                <img src="/public/loading2.svg" alt="" width="100px">
            </div>
            <tbody id="content" class="">
            <?php

            if (!empty($DonorForCheckBlood)) :
                foreach ($DonorForCheckBlood as $DonorCheck) :
                    $Donor=$DonorCheck->getDonor();
                    ?>
                    <tr>
                        <td><?= $Donor->getID() ?></td>
                        <td><?= $Donor->getFullName() ?></td>
                        <td><?= $Donor->getNIC() ?></td>
                        <td><?= $Donor->getContactNo() ?></td>
                        <td><?= $Donor->getGender() ?></td>
                        <td>
                            <a href="/mofficer/take-donation?NIC=<?= $Donor->getNIC() ?>" class="btn btn-outline-success">Check</a>
                        </td>
                    </tr>
                <?php
                endforeach;
            else:
                ?>
                <tr class="bg-white-0-7" id="no-data">
                    <td colspan="9" class="text-center">No Donor in Queue</td>
                </tr>
            <?php
            endif;
            ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    const AutoReload = ()=>{
        const url ="/mofficer/take-donation";
        fetch(url)
            .then(response => response.text())
            .then(data => {
                console.log("Auto Reload");
                const DomParser = new DOMParser();
                const Doc = DomParser.parseFromString(data, 'text/html');
                const table = Doc.querySelector("table tbody").innerHTML;
                document.querySelectorAll("table tbody")[0].innerHTML=table;
            })
            .catch(error => {
                console.log(error);
            });
    }
    setInterval(AutoReload, 3000);
</script>

