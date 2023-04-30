<?php
use App\model\users\MedicalOfficer;
use App\model\Utils\Date;
use Core\Application;
?>



<div class="d-flex m-1 justify-content-center ">
    <div class="d-flex w-100 justify-content-center  overflow-y-scroll">
        <table class="w-100 h-10" style="min-width: 90vh">
            <thead class="sticky top-0">
            <tr>
                <th>No</th>
                <th>Date</th>
                <th>Campaign Name</th>
                <th>Venue</th>
                <th>Role</th>
                <th>Task</th>
                <th>Action</th>
            </tr>
            </thead>

            <div id="loader" class="bg-white absolute d-flex justify-content-center align-items-center" style="z-index: 999;height: 100%;margin-top: 35px;">
                <img src="/public/loading2.svg" alt="" width="100px">
            </div>
            <tbody id="content" class="">
            <?php
            /** @var $Campaign App\model\Campaigns\Campaign*/

            $i = 1;
            if (!empty($Campaigns)):
//                $Campaigns = array_merge(...array_fill(0, 1000, $Campaigns));
            $UserID = Application::$app->getUser()->getID();
                foreach ($Campaigns as $Campaign):
            ?>
                <tr>
                    <td ><?= $i++?></td>
                    <td><?= Date::GetProperDate($Campaign->getCampaignDate())?></td>
                    <td><?= $Campaign->getCampaignName()?></td>
                    <td><?= $Campaign->getVenue()?></td>
                    <td><?= MedicalOfficer::getRoleOfCampaign($UserID,$Campaign->getCampaignID())?></td>
                    <td><?= MedicalOfficer::getTaskOfCampaign($UserID,$Campaign->getCampaignID())?></td>
                    <td>
                        <button onclick="ViewTeam('<?=$Campaign->getCampaignID()?>')" class="btn btn-info btn-sm">View Team</button>
                        <button class="btn btn-primary btn-sm" onclick="ViewReport()">View Report</button>
                    </td>
                </tr>
            <?php
            endforeach;
            else:
                ?>
                <tr>
                    <td colspan="7" class="text-center">No Campaigns</td>
                </tr>
            <?php
            endif;
            ?>

            </tbody>
        </table>
    </div>

</div>

<script>
    const ViewReport = ()=>{
        const url = '/medicalOfficer/ViewReport';
        fetch(url)
            .then(response => response.json())
            .then(data => {
                console.log(data)
            })

    }

    const ViewTeam = (campaignID)=>{
        const url = '/medicalOfficer/ViewTeam';
        const formData = new FormData();
        formData.append('campaignID',campaignID);
        fetch(url,{
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                console.log(data)
                if (data.status){
                    const {team} = data;
                    let TeamMembers = '<div class="d-flex flex-column">';
                    for (i=0;i<team.length;i++) {
                        const highlight = team[i].Position === 'Leader' ? 'text-primary' : '';
                        TeamMembers += `
                            <tr>
                                <td>${i+1}</td>
                                <td>${team[i].MemberName}</td>
                                <td class="${highlight}">${team[i].Position}</td>
                            </tr>
                        `
                    }

                    OpenDialogBox({
                        id: 'ViewTeam',
                        title: 'View Team',
                        titleClass: 'bg-dark text-white px-2',
                        content:`
                        <div class="d-flex flex-column">
                            <div class="d-flex flex-row justify-content-center ">
                                <table class="w-100">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Member Name</th>
                                        <th>Position</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        ${TeamMembers}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    `,
                    })
                }
            })

    }

</script>