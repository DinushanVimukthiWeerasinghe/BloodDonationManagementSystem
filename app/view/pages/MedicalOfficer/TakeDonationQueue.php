
<?php
/* @var Campaign $Campaign*/
/* @var string $Task*/
/* @var array $DonorTakeBloodDonation*/
/* @var CampaignDonorQueue $DonorInQueue*/
/* @var Donor $Donor*/

use App\model\Campaigns\Campaign;
use App\model\Campaigns\CampaignDonorQueue;
use App\model\users\Donor;
?>

<div class=" d-flex  flex-column bg-white justify-content-center align-items-center w-100 h-100 m-1 border-radius-10">
    <div class="d-flex w-95 m-1 justify-content-center bg-dark text-center text-xl py-1 text-white"><?= $Task?> - <?=$Campaign->getCampaignName()?></div>
    <div class="d-flex w-95 flex-wrap gap-1 justify-content-center h-100 align-items-start">
        <?php
        if (!empty($DonorTakeBloodDonation)):
            foreach ($DonorTakeBloodDonation as $DonorInQueue):
                $Donor=$DonorInQueue->getDonor();
        ?>
        <div class="card d-flex flex-center gap-0-5">
            <img src="<?=$Donor->getProfileImage()?>" class="border-radius-10" alt="donation" width="60%">
            <div class="card-header flex-column gap-0-5">
                <div class="text-xl text-center"><?= $Donor->getFullName()?></div>
                <div class="text-xl text-center"><?= $Donor->getNIC()?></div>
            </div>
            <div class="card-footer">
                <a href="/mofficer/take-donation?NIC=<?=$Donor->getNIC()?>" class="btn btn-primary w-80">Take Donation</a>
            </div>
        </div>

        <?php
            endforeach;
        else:
        ?>
        <div class="d-flex justify-content-center align-items-center w-100 h-100">
            <div class="text-xl text-center">No Donors in Queue</div>
        </div>
        <?php
        endif;
        ?>

    </div>
</div>
