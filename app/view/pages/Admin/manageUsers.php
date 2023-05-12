
<?php

use App\model\users\Donor;
use App\model\users\Hospital;
use App\model\users\Manager;
use App\model\users\MedicalOfficer;
use App\model\users\Organization;
use App\model\users\Person;
use App\model\users\Sponsor;
use App\model\users\User;
/** @var Array $users */
/** @var Person $user */
/** @var string $Role */
/** @var int $TotalActive */
/** @var int $TotalUsers */
/** @var int $TotalDeactivated */
/** @var int $TotalBanned */
//print_r($users);
?>


<div class="d-flex bg-white align-self-start justify-content-center" style="width: 100%;min-width: 5%">
    <div class="d-flex flex-row justify-content-center border-bottom-4-primary gap-1 align-items-center" id="UserCategory" style="width: 75%">
        <div class="d-flex w-95 justify-content-center align-items-center border-2 border-primary bg-primary border-radius-5 justify-content-evenly p-0-5 mb-0-5" id="Donor" onclick="ViewUser('Donor')">
            <img src="/public/images/icons/user/donor.png" class="w-30 bg-white border-radius-50" id="DonorIcon" alt="" style="padding: 8px;" width="512">
                        <span class="text-white text-xl font-bold">Donor</span>
        </div>
        <div class="d-flex w-95 justify-content-center align-items-center border-2 border-primary bg-white border-radius-5 justify-content-evenly p-0-5 mb-0-5" id="Organization"  onclick="ViewUser('Organization')" >
            <img src="/public/images/icons/user/organization.png" class="w-30 bg-white border-radius-50" id="OrganizationIcon" alt="" style="padding: 8px;" width="512">
                        <span class=" text-xl font-bold">Organization</span>
        </div>
        <div class="d-flex w-95 justify-content-center align-items-center border-2 border-primary bg-white border-radius-5 justify-content-evenly p-0-5 mb-0-5"  id="MedicalOfficer" onclick="ViewUser('MedicalOfficer')" >
            <img src="/public/images/icons/user/medicalOfficer.png" class="w-30 bg-white border-radius-50" id="MedicalOfficerIcon" alt="" style="padding: 8px;" width="512">
                        <span class=" text-xl font-bold">Medical Officer</span>
        </div>
        <div class="d-flex w-95 justify-content-center align-items-center border-2 border-primary bg-white border-radius-5 justify-content-evenly p-0-5 mb-0-5" id="Hospital" onclick="ViewUser('Hospital')" >
            <img src="/public/images/icons/user/hospital.png" class="w-30 bg-white border-radius-50" id="HospitalIcon" alt="" style="padding: 8px;" width="512">
                        <span class=" text-xl font-bold">Hospital</span>
        </div>
        <div class="d-flex w-95 justify-content-center align-items-center border-2 border-primary bg-white border-radius-5 justify-content-evenly p-0-5 mb-0-5" id="Sponsor" onclick="ViewUser('Sponsor')" >
            <img src="/public/images/icons/user/sponsor.png" class="w-30 bg-white border-radius-50" id="SponsorIcon" alt="" style="padding: 8px;" width="1024">
                        <span class=" text-xl font-bold">Sponsor</span>
        </div>
        <div class="d-flex w-95 justify-content-center align-items-center border-2 border-primary bg-white border-radius-5 justify-content-evenly p-0-5 mb-0-5" id="Manager" onclick="ViewUser('Manager')" >
            <img src="/public/images/icons/user/manager.png" class="w-30 bg-white border-radius-50" id="ManagerIcon" alt="" style="padding: 8px;" width="96">
                        <span class=" text-xl font-bold">Manager</span>
        </div>
    </div>

</div>



<div class="d-flex h-100 w-100 justify-content-center align-items-center">


    <div class="d-flex w-100 m-1 justify-content-center align-self-baseline gap-2 flex-column" >
        <div class="d-flex justify-content-center align-items-center mt-2">
            <div id="Search" class="d-flex align-items-center gap-1">
                <label for="Search" class="text-dark text-xl font-bold">Search</label>
                <input type="text" class="form-control" name="Search" placeholder="Search" onkeyup="SearchUser('<?=$Role?>')">
            </div>
            <button id="addNewUser" class="btn btn-success" hidden="hidden">
        </div>
        <div class="d-flex justify-content-center align-items-center flex-wrap overflow-y-overlay">
            <div class="d-flex justify-content-center w-100 mx-2" id="userTable" style="max-height: 70vh">
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
                                    <?php if ($user->getAccountStatus() === User::ACTIVE) : ?>
                                        <span class="badge bg-success text-white">Active</span>
                                    <?php elseif ($user->getAccountStatus() === User::TEMPORARY_DEACTIVATED): ?>
                                        <span class="badge bg-warning text-white">Inactive</span>
                                    <?php elseif ($user->getAccountStatus() === User::PERMANENTLY_DEACTIVATED): ?>
                                        <span class="badge bg-danger text-white">Deleted</span>
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
                                    <button class="btn btn-outline-danger pointer-events" onclick='resetPassword(" <?=$user->getID();?>")'>Reset Password</button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="d-flex h-100 flex-column justify-content-center align-items-center flex-wrap bg-white-0-7">
        <div class="card card-sm">
            <div class="card-header text-dark">
                <h3 class="card-title">Total <span id="Role"> <?=$Role?></span>s</h3>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-center align-items-center">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <h1 class="text-dark" id="TotalActive"><?= $TotalActive?></h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-sm">
            <div class="card-header text-dark">
                <h3 class="card-title">Deactivated <span id="Role"> <?=$Role?></span>s</h3>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-center align-items-center">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <h1 class="text-dark" id="TotalDeactivated"><?= $TotalDeactivated?></h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-sm">
            <div class="card-header text-dark">
                <h3 class="card-title">Disabled <span id="Role"> <?=$Role?></span></h3>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-center align-items-center">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <h1 class="text-dark" id="TotalBanned"><?= $TotalBanned?></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

</script>