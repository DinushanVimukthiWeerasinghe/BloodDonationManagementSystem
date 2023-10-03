<table class="w-100 ">
    <thead class="sticky top-0">
    <tr>
        <th scope="col">No</th>
        <th scope="col">Full Name</th>
        <th scope="col">NIC</th>
        <th scope="col">Contact No</th>
        <th scope="col">Blood Group</th>
        <th scope="col">Address</th>
        <th scope="col">Status</th>
        <th scope="col">Action</th>
    </tr>
    </thead>
    <tbody id="content">
    <div id="loader" class="none bg-white absolute w-100 h-100 d-flex justify-content-center align-items-center" style="z-index: 999;height: 90%;margin-top: 35px;">
        <img src="/public/loading2.svg" alt="" width="100px">
    </div>
    <?php
    if (empty($data)):
        ?>
        <tr>
            <td colspan="8" class="text-center">No Data Found</td>
        </tr>
    <?php
    else:
        $i=1;
        foreach ($data as $value):
            $id = $value->getID();
            ?>
            <tr>
                <td data-label="No "><?= $i++;?></td>
                <td data-label="Full Name " class="font-bold"><?php echo $value->getFullName()?></td>
                <td data-label="NIC "><?php echo $value->getNIC()?></td>
                <td data-label="Contact No "><?php echo $value->getContactNo()?></td>
                <td data-label="Blood Group "><?php echo $value->getBloodGroup()?></td>
                <td data-label="Address "><?php echo $value->getAddress()?></td>
                <td data-label="Status "><?php echo $value->getVerificationStatus()?></td>
                <td class="d-flex justify-content-center gap-0-5 align-items-center">
                    <button class="text-dark btn gap-0-5 btn-outline-info d-flex align-items-center justify-content-center" onclick="ViewDonor('<?php echo $id ?>')" ><img src="/public/icons/view.svg" width="24px" alt="">View</button>
                    <button class="text-dark btn gap-0-5 btn-outline-info d-flex align-items-center justify-content-center" onclick="SendEmail('<?php echo $id ?>')" ><img src="/public/icons/mail.png" width="24px" alt="">Send Email</button>
                </td>
            </tr>
        <?php
        endforeach;
    endif;
    ?>

    </tbody>
</table>