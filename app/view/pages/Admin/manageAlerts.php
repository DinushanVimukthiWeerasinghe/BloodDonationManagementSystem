<div class="d-flex bg-white align-self-start justify-content-center" style="width: 100%;min-width: 50%">
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



<div class="d-flex" id="ManageBloodBanks">
    <div class="d-flex justify-content-center align-items-center flex-wrap overflow-y-overlay">
        <div class="d-flex justify-content-center w-100 mx-2" id="userTable" style="max-height: 70vh">
            <table>
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

<div class="d-flex w-20 justify-content-center align-items-center border-2 border-primary bg-primary border-radius-5 justify-content-evenly p-0-5 mb-0-5" >
    <button class="btn btn-success" id="addNewNotification" onclick="addNewHospitalNotification()">ADD New Notification</button>
</div>
