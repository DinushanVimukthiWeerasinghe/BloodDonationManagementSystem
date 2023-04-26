
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


<div class="d-flex bg-white align-self-start mr-1" style="width: 100%;min-width: 5%">
    <div class="d-flex flex-row justify-content-center gap-1 align-items-center" id="UserCategory" style="width: 75%">
        <div class="d-flex flex-column w-95 justify-content-center align-items-center  border-radius-5" id="Donor" onclick="ViewUser('Donor')">
            <img src="/public/images/icons/user/donor.png" class="w-90 bg-primary border-radius-50" id="DonorIcon" alt="" style="padding: 8px;" width="64px">
                        <span class="text-black mt-1">Donor</span>
        </div>
        <div class="d-flex flex-column w-95 justify-content-center align-items-center bg-white border-radius-5" id="Organization"  onclick="ViewUser('Organization')" >
            <img src="/public/images/icons/user/organization.png" class="w-90 bg-accent border-radius-50" id="OrganizationIcon" alt="" style="padding: 8px;" width="64px">
                        <span class="text-black mt-1">Organization</span>
        </div>
        <div class="d-flex flex-column w-95 justify-content-center align-items-center bg-white border-radius-5"  id="MedicalOfficer" onclick="ViewUser('MedicalOfficer')" >
            <img src="/public/images/icons/user/medicalOfficer.png" class="w-90 bg-accent border-radius-50" id="MedicalOfficerIcon" alt="" style="padding: 8px;" width="64px">
                        <span class="text-black mt-1">Medical Officer</span>
        </div>
        <div class="d-flex flex-column w-95 justify-content-center align-items-center bg-white border-radius-5" id="Hospital" onclick="ViewUser('Hospital')" >
            <img src="/public/images/icons/user/hospital.png" class="w-90 bg-accent border-radius-50" id="HospitalIcon" alt="" style="padding: 8px;" width="64px">
                        <span class="text-black mt-1">Hospital</span>
        </div>
        <div class="d-flex flex-column w-95 justify-content-center align-items-center bg-white border-radius-5" id="Sponsor" onclick="ViewUser('Sponsor')" >
            <img src="/public/images/icons/user/sponsor.png" class="w-90 bg-accent border-radius-50" id="SponsorIcon" alt="" style="padding: 8px;" width="64px">
                        <span class="text-black mt-1">Sponsor</span>
        </div>
        <div class="d-flex flex-column w-95 justify-content-center align-items-center bg-white border-radius-5" id="Manager" onclick="ViewUser('Manager')" >
            <img src="/public/images/icons/user/manager.png" class="w-90 bg-accent border-radius-50" id="ManagerIcon" alt="" style="padding: 8px;" width="64px">
                        <span class="text-black mt-1">Manager</span>
        </div>
    </div>

</div>



<div class="d-flex h-100 w-100 justify-content-between">
<!--<div class="">-->
<!--</div>-->


<div class="d-flex justify-content-center align-self-baseline flex-column " >
    <div class="d-flex justify-content-center align-items-center my-2">
        <div id="Search" class="d-flex align-items-center gap-1">
            <label for="Search" class="text-dark text-xl font-bold">Search</label>
            <input type="text" class="form-control" name="Search" placeholder="Search" onkeyup="SearchUser('<?=$Role?>')">
        </div>
        <button id="addNewUser" class="btn btn-success" hidden="hidden">
    </div>
<!--    <div class="title">Donor</div>-->
    <div class="d-flex justify-content-center align-items-center cards flex-wrap" id="userTable">
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
                                echo $user->getSponsorName();
                            } elseif ($user instanceof (Hospital::class)) {
                                echo $user->getHospitalName();
                            }
                             ?>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class=""><?php echo $user->getEmail(); ?></div>
                        <div class=""><?php echo $user->getRole(); ?></div>
                        <div class=""><?php echo $user->getLastActive(); ?></div>
                        <div class=""><?php if($user instanceof (Manager::class)){
                                echo \App\model\BloodBankBranch\BloodBank::findOne(['BloodBank_ID'=>$user->getBloodBankID()])->getBankName();
                            } ?></div>
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