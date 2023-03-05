<?php


/* @var $Campaigns array*/
/* @var $campaign Campaign*/
/* @var $User User*/

use App\model\Campaigns\Campaign;
use App\model\users\User;

?>



<div class="d-flex m-1 bg-white border-radius-10 h-98 w-100 gap-1">
    <div class="d-flex flex-column align-items-center justify-content-start w-60 my-1">
        <div class="bg-dark py-1 px-2 w-90 text-center text-white mb-1">Statistics</div>
        <div class="w-100 d-flex justify-content-center">
            <div class="card card-sm">
                <div class="card-header flex-column">
                    <div class="font-bold">100</div>
                    <div class="font-bold">Total Campaigns</div>
                </div>
            </div>
            <div class="card card-sm">
                <div class="card-header flex-column">
                    <div class="font-bold">100</div>
                    <div class="font-bold">Total Campaigns</div>
                </div>
            </div>
            <div class="card card-sm">
                <div class="card-header flex-column">
                    <div class="font-bold">100</div>
                    <div class="font-bold">Total Campaigns</div>
                </div>
            </div>

        </div>
        <div class="bg-dark py-1 px-2 w-90 text-center text-white my-1">Assigned Campaign</div>
        <div class="d-flex w-90">
            <table class="table table-sm table-hover">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Campaign Name</th>
                        <th scope="col">Campaign Date</th>
                        <th scope="col">Venue</th>
                        <th scope="col">Assigned Position</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $i=1;
                foreach ($Campaigns as $campaign):
                ?>
                    <tr>
                        <th scope="row"><?=$i++?></th>
                        <td><?=$campaign->getCampaignName()?></td>
                        <td><?=$campaign->getCampaignDate()?></td>
                        <td><?=$campaign->getVenue()?></td>
                        <td>
                            <?php
                            $Team=$campaign->getAssignedTeam();
                            if ($User->getID()===$Team->getTeamLeader())
                                echo "<span class='text-info font-bold'>Team Leader</span>";
                            else
                                echo "Team Member";
                            ?>
                        </td>
                    </tr>
                <?php
                endforeach;
                ?>

                </tbody>
            </table>
        </div>
    </div>
    <div class="d-flex flex-column align-items-center justify-content-start w-40 my-1">
        <div class="bg-dark py-1 px-2 w-90 text-center text-white mb-3">Notification </div>
        <div class="min-w-30 bg-white p-2 border-radius-10">
            <canvas id="myChart" style="width:100%;max-width:700px;display: block;" class="chart chartjs-render-monitor" width="464" height="232"></canvas>
        </div>
    </div>

</div>

<script>

</script>
<script type="text/javascript">
    var barColors = [
        "rgba(255,0,53,1)",
        "rgba(255,0,53,0.9)",
        "rgba(255,0,53,0.8)",
        "rgba(255,0,53,0.7)",
        "rgba(255,0,53,0.6)",
        "rgba(255,0,53,0.5)",
        "rgba(255,0,53,0.6)",
        "rgba(255,0,53,0.7)",
        "rgba(255,0,53,0.8)",
        "rgba(255,0,53,0.9)",
        "rgba(255,0,53,1)",
    ];
    const url= "/mofficer/stat";
    const form = new FormData();
    form.append("ID", "<?=\Core\Application::$app->getUser()->getID()?>");
    fetch(url,{
        method:"POST",
        body: form
    }).then(response => response.json())
        .then(data => {
            if (data.status) {
                const TotalAssignmentsInMonth = data.data.TotalAssignmentsInMonth;
                const Months = Object.keys(TotalAssignmentsInMonth);
                const Values = Object.values(TotalAssignmentsInMonth);
                const chart = new Chart("myChart", {
                    type: "bar",
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    stepSize: 4,
                                },
                            }]
                        },
                    },
                    data: {
                        labels: Months,
                        datasets: [{
                            backgroundColor: barColors,
                            data: Values,
                            label: "Donation Campaigns in " + new Date().getFullYear()
                        }]
                    },

                });
            }
        })
        .catch(error => {
            console.log(error);
        });
    var xyValues = [
        {x:50, y:7},
        {x:60, y:8},
        {x:70, y:8},
        {x:80, y:9},
        {x:90, y:9},
        {x:100, y:9},
        {x:110, y:10},
        {x:120, y:11},
        {x:130, y:14},
        {x:140, y:14},
        {x:150, y:15}
    ];
    const Months= ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

    var xValues = ["Italy", "France", "Spain", "USA", "Argentina"];
    var yValues = [12, 10, 15, 11, 18];




    const chart2 =new Chart("myChart2", {
        type: "scatter",
        data: {
            datasets: [{
                pointRadius: 4,
                pointBackgroundColor: "rgba(255,0,0,1)",
                data: xyValues
            }]
        },
        options: {
            legend: {display: false},
            scales: {
                xAxes: [{ticks: {min: 40, max:160}}],
                yAxes: [{ticks: {min: 6, max:16}}],
            }
        }
    });

</script>


