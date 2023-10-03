<div class="d-flex align-self-start justify-content-center py-2" style="width: 100%;min-width: 50%">
    <div class="d-flex flex-row justify-content-center border-bottom-4-primary gap-1 align-items-center" id="UserCategory" style="width: 25%">
        <div class="d-flex w-95 justify-content-center align-items-center border-2 border-primary bg-primary border-radius-5 justify-content-evenly p-0-5 mb-0-5" id="Hospital" onclick="ViewNotification('Hospital')" >
            <img src="/public/images/icons/user/hospital.png" class="w-30 bg-white border-radius-50" id="HospitalIcon" alt="" style="padding: 8px;" width="512">
            <span class="text-white text-xl font-bold">Hospital</span>
        </div>
        <div class="d-flex w-95 justify-content-center align-items-center border-2 border-primary bg-white border-radius-5 justify-content-evenly p-0-5 mb-0-5" id="Manager" onclick="ViewNotification('Manager')" >
            <img src="/public/images/icons/user/manager.png" class="w-30 bg-white border-radius-50" id="ManagerIcon" alt="" style="padding: 8px;" width="96">
            <span class=" text-xl font-bold">Manager</span>
        </div>

    </div>

</div>



<div class="d-flex flex-column justify-content-start align-items-center gap-2 w-90 p-2 bg-white border-radius-10 my-1" id="ManageBloodBanks" style="min-height: 70vh">
    <div class="d-flex flex-center gap-2 bg-dark px-2 py-1 w-60 border-radius-5 relative">
        <span class="text-white text-xl font-bold">Manage Notifications</span>
        <button class="btn btn-success absolute right-1 d-flex flex-center gap-1" id="addNewNotification" onclick="addNewHospitalNotification()">
            <i class="fas fa-plus"></i>
            Notification
        </button>
    </div>
    <div class="d-flex w-90 justify-content-center align-items-center flex-wrap">
        <div class="d-flex justify-content-center w-100 mx-2  overflow-y-overlay" id="userTable" style="max-height: 70vh">
            <table class="w-100">
                <thead class="sticky top-0">
                <tr>
                    <th class="text-center">No</th>
                    <?php for ($i = 0; $i < sizeof($notifications['Headings']) ; $i++) {
                        echo "<th class='text-center'>". $notifications['Headings'][$i]. "</th>";
                    }
                    array_shift($notifications)?>
                </tr>
                </thead>
                <tbody>
                <?php if (empty($notifications)) : ?>
                    <tr>
                        <td colspan="5" class="text-center">No Notifications Found</td>
                    </tr>
                <?php else :
                    $i = 1;
                    foreach($notifications as $notification):
                        ?>
                        <tr>
                            <td class="text-center"><?=$i++;?></td>
                            <?php for ($j = 0; $j < sizeof($notification); $j++){
                                $keys =array_keys($notification);
                                echo "<td class ='text-center'>". $notification[$keys[$j]]."</td>";
                            } ?>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<!--    <div class="card bg-white">-->
<!--        <div class="card-header">-->
<!--            <img src="/public/images/icons/admin/dashboard/alert.png" alt="">-->
<!--            <div class="card-title">Add Notification</div>-->
<!--        </div>-->
<!--    </div>-->
</div>
