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
<table>
    <thead class="sticky top-0">
    <tr>
        <th class="text-center">No</th>
        <th class="text-center">Full Name</th>
        <th class="text-center">NIC</th>
        <th class="text-center">Contact No</th>
        <th class="text-center">Email</th>
        <th class="text-center">Last Active</th>
        <th class="text-center">Status</th>
        <th class="text-center">Action</th>
    </tr>
    </thead>
    <tbody>
    <?php if (empty($users)) : ?>
        <tr>
            <td colspan="5" class="text-center">No Users Found</td>
        </tr>
    <?php else :
        $i = 1;
        foreach($users as $user):
            $UserName="";
            $NIC="";
            $ContactNo="";

            if ($user instanceof (Donor::class)) {
                $NIC=$user->getNIC();
                $UserName=$user->getFirstName() . " " . $user->getLastName();
                $ContactNo=$user->getContactNo();
            } elseif ($user instanceof (MedicalOfficer::class)) {
                $UserName=$user->getFirstName() . " " . $user->getLastName();
            } elseif ($user instanceof (Manager::class)) {
                $UserName=$user->getFirstName() . " " . $user->getLastName();
            } elseif ($user instanceof (Organization::class)) {
                $UserName=$user->getOrganizationName();
            } elseif ($user instanceof (Sponsor::class)) {
                $UserName=$user->getSponsorName();
            } elseif ($user instanceof (Hospital::class)) {
                $UserName=$user->getHospitalName();
            }
            $Email=$user->getEmail();
            $LastActive=$user->getLastActive();
            ?>
            <tr>
                <td class="text-center"><?=$i++;?></td>
                <td class="text-center"><?=$UserName?></td>
                <td class="text-center"><?=$NIC?></td>
                <td class="text-center"><?=$ContactNo?></td>
                <td class="text-center"><?=$Email?></td>
                <td class="text-center"><?=$LastActive?></td>
                <td class="text-center">
                    <?php if ($user->getStatus() == 1) : ?>
                        <span class="badge bg-success text-white">Active</span>
                    <?php else : ?>
                        <span class="badge bg-danger text-white">Inactive</span>
                    <?php endif; ?>
                </td>
                <td class="text-center">
                    <?php if ($user->getAccountStatus() == User::TEMPORARY_DEACTIVATED): ?>
                        <button class="btn btn-outline-success" onclick="ActivateUser('<?=$user->getID();?>')">Activate</button>
                    <?php elseif ($user->getAccountStatus() == User::ACTIVE): ?>
                        <button class="btn btn-yellow-500" onclick="DeactivateUser('<?=$user->getID();?>')">Deactivate</button>
                    <?php elseif ($user->getAccountStatus() == User::PERMANENTLY_DEACTIVATED): ?>
                        <button class="btn btn-danger" onclick="ReActivateUser('<?=$user->getID();?>')">Re Activate</button>
                    <?php endif; ?>
                    <?php if ($user->getAccountStatus() == User::ACTIVE): ?>
                        <button class="btn btn-danger" onclick='RemoveUser(" <?=$user->getID();?>")'>Ban User</button>
                    <?php elseif ($user->getAccountStatus() == User::TEMPORARY_DEACTIVATED): ?>
                        <button class="btn btn-danger" onclick='RemoveUser(" <?=$user->getID();?>")'>Ban User</button>
                    <?php elseif ($user->getAccountStatus() == User::PERMANENTLY_DEACTIVATED): ?>
                        <button class="btn btn-outline-danger pointer-events-none btn-disabled" disabled onclick='RemoveUser(" <?=$user->getID();?>")'>Remove User</button>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>