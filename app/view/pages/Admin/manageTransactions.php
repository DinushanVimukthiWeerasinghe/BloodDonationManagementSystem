<?php
/** @var $Transaction SponsorshipRequest*/
/** @var $Transactions array*/

use App\model\Requests\SponsorshipRequest;

?>
<div class="d-flex flex-column min-w-90 min-h-80  ">
    <div class="d-flex w-100 justify-content-between my-1">
        <div class="d-flex gap-1 flex-center">
            <label for="Search" class="text-dark text-xl font-bold">Search</label>
            <input class="form-control" name="Search" id="Search" onkeyup="SearchBank()">
        </div>
        <div class="d-flex gap-1 flex-center">
            <label for="Search" class="text-dark text-xl font-bold">Search</label>
            <input class="form-control" name="Search" id="Search" onkeyup="SearchBank()">
        </div>

    </div>
    <div class="d-flex flex-column bg-white max-h-80 w-100">
        <div class="d-flex max-h-100 overflow-y-scroll">
            <table class="table table-striped table-hover">
                <thead class="bg-white">
                <tr class="bg-white">
                    <th scope="col" class="bg-white ">No</th>
                    <th scope="col" class="bg-white ">Campaign Name</th>
                    <th scope="col" class="bg-white ">Sponsor Name</th>
                    <th scope="col" class="bg-white ">Amount</th>
                    <th scope="col" class="bg-white ">Date</th>
                    <th scope="col" class="bg-white ">Status</th>
                    <th scope="col" class="bg-white ">Managed By</th>
                    <th scope="col" class="bg-white ">Blood Bank</th>
                    <th scope="col" class="bg-white ">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $i=1;
                foreach ($Transactions as $Transaction) :
                    $CampaignName = $Transaction->getCampaignName();
                    $SponsorName = $Transaction->getSponsorName();
                    $amount = $Transaction->getSponsoredAmount();
                    $ManagerName = $Transaction->getManagerName();
                    $BloodBankName = $Transaction->getManagerBloodBankName();
                    $date = $Transaction->getSponsorshipDate();
                    $Status = $Transaction->getSponsorStatus();
                    ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= $CampaignName ?></td>
                        <td><?php echo $SponsorName ?></td>
                        <td><?php echo $amount ?></td>
                        <td><?php echo $date ?></td>
                        <td><?php echo $Status ?></td>
                        <td><?php echo $ManagerName ?></td>
                        <td><?php echo $BloodBankName ?></td>
                        <td>
                            <button type="button" class="btn btn-outline-success border-radius-10" >
                                <img src="/public/icons/edit.png" width="24px" alt="">
                            </button>
                        </td>
                    </tr>

                <?php endforeach;
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
