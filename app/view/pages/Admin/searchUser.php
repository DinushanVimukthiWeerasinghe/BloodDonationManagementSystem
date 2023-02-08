<?php
/* @var array $users*/

use App\model\users\Donor;
use App\model\users\Hospital;
use App\model\users\Manager;
use App\model\users\MedicalOfficer;
use App\model\users\Organization;
use App\model\users\Sponsor;
use App\model\users\User;

?>
<div class="d-flex justify-content-center align-items-center cards flex-wrap">
    <?php if (empty($users)) : ?>
        <div class="card">
            <div class="card-header ">
                <div class="text-dark text-xl font-bold">No Users Found</div>
            </div>
        </div>
    <?php else : ?>
        <?php foreach($users as $user): ?>
        <div class="card">
            <div class="card-header ">
                    <div class="text-dark text-xl font-bold">
                        <?php if ($user instanceof (Donor::class)) {
                            echo $user->getFirstName() . " " . $user->getLastName();
                        } elseif ($user instanceof (MedicalOfficer::class)) {
                            echo $user->getFirstName() . " " . $user->getLastName();
                        } elseif ($user instanceof (Manager::class)) {
                            echo $user->getFirstName() . " " . $user->getLastName();
                        } elseif ($user instanceof (Organization::class)) {
                            echo $user->getOrganizationName();
                        } elseif ($user instanceof (Sponsor::class)) {
                            echo $user->getFirstName() . " " . $user->getLastName();
                        } elseif ($user instanceof (Hospital::class)) {
                            echo $user->getHospitalName();
                        }elseif ($user instanceof (User::class)) {
                            echo $user->getID();
                        }
                        ?>
                    </div>
                </div>
            <div class="card-body">
                <div class=""><?php echo $user->getEmail(); ?></div>
                <div class=""><?php echo $user->getRole(); ?></div>
                <div class=""><?php echo $user->getLastActive(); ?></div>
            </div>
            <div class="card-action gap-1">
                <?php if ($user->getAccountStatus() == User::TEMPORARY_DEACTIVATED): ?>
                    <button class="btn btn-success" onclick="ActivateUser('<?=$user->getID();?>')">Activate</button>
                <?php elseif ($user->getAccountStatus() == User::ACTIVE): ?>
                    <button class="btn btn-warning" onclick="DeactivateUser('<?=$user->getID();?>')">Deactivate</button>
                <?php elseif ($user->getAccountStatus() == User::PERMANENTLY_DEACTIVATED): ?>
                    <button class="btn btn-danger" onclick="ReActivateUser('<?=$user->getID();?>')">Re Activate</button>
                <?php endif; ?>
                <?php if ($user->getAccountStatus() == User::ACTIVE): ?>
                    <button class="btn btn-danger" onclick='RemoveUser(" <?=$user->getID();?>")'>Ban User</button>
                <?php elseif ($user->getAccountStatus() == User::TEMPORARY_DEACTIVATED): ?>
                    <button class="btn btn-danger" onclick='RemoveUser(" <?=$user->getID();?>")'>Ban User</button>
                <?php elseif ($user->getAccountStatus() == User::PERMANENTLY_DEACTIVATED): ?>
                    <button class="btn btn-danger pointer-events-none btn-disabled" disabled onclick='RemoveUser(" <?=$user->getID();?>")'>Remove User</button>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
    <?php endif; ?>

</div>