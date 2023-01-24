
<?php
use App\model\users\Manager;
use App\model\users\MedicalOfficer;
use App\model\users\Person;

/** @var Array $users */
/** @var Person $user */

//print_r($users);
?>

<div class="d-flex justify-content-center align-center flex-column">
<!--    <div class="title">Donor</div>-->

    <table class="w-50">
        <thead>
        <tr>
            <th>User Id</th>
            <th> Email </th>
            <th> NIC </th>
            <th>Last Active</th>
            <th>Role</th>
            <th>Reset Password</th>
            <th>Temporary Action</th>
            <th>Action</th>

        </tr>
        </thead>
        <tbody>
        <?php foreach($users as $user): ?>
            <tr>
                <td><?php echo $user->getID(); ?></td>
                <td><?php echo $user->getEmail(); ?></td>
                <td><?php echo $user->getNIC(); ?></td>
                <td><?php echo $user->getLastActive(); ?></td>
                <td><?php echo $user->getRole(); ?></td>
                <td>
                    <button class="btn btn-info">Reset Password</button>
                </td>
                <td>
                    <button class="btn btn-success">Activate</button>
                </td>
                <td>
                    <button class="btn btn-danger">Remove User</button>
                </td>
            </tr>
        <?php endforeach; ?>

    </table>
</div>

