<?php
\App\view\components\ResponsiveComponent\Alert\FlashMessage::RenderFlashMessages();
?>
<div class="d-flex flex-column justify-content-start overflow-y-overlay" style="max-height: 100vh">
    <div class="d-flex flex-wrap flex-center w-100 gap-2 p-2 border-radius-5">
        <div class="d-flex flex-column bg-white text-white box-shadow-purple border-dark border-radius-5"
             style="width: 250px;height: 180px">
            <div class="d-flex flex-column flex-center gap-0-5 h-100">
                <div class="font-bold text-xl">Total Donations Given</div>
                <div class="single-chart">
                    <svg viewBox="0 0 36 36" class="circular-chart purple">
                        <path class="circle-bg"
                              d="M18 2.0845
              a 15.9155 15.9155 0 0 1 0 31.831
              a 15.9155 15.9155 0 0 1 0 -31.831"
                        />
                        <path class="circle"
                              stroke-dasharray="100, 100"
                              d="M18 2.0845
              a 15.9155 15.9155 0 0 1 0 31.831
              a 15.9155 15.9155 0 0 1 0 -31.831"
                        />
                        <text x="18" y="20.35" class="percentage"><?php echo $bloodPacketsCount?></text>
                    </svg>
                </div>
                <div><span class="font-extraBold text-purple-8 text-xl"><?php echo $bloodPacketsCount?></span></div>

            </div>
            <div class="w-90 bg-purple-8 border-radius-5 align-self-center"
                 style="height: 8px;width: 85%;margin-bottom:2px">

            </div>
        </div>
        <div class="d-flex flex-column bg-white text-white box-shadow-dark border-dark border-radius-5"
             style="width: 250px;height: 180px">
            <div class="d-flex flex-column flex-center gap-0-5 h-100">
                <div class="d-flex flex-column font-bold text-xl">
                    Total Donors Registered
                </div>

                <div class="single-chart">
                    <svg viewBox="0 0 36 36" class="circular-chart dark">
                        <path class="circle-bg"
                              d="M18 2.0845
              a 15.9155 15.9155 0 0 1 0 31.831
              a 15.9155 15.9155 0 0 1 0 -31.831"
                        />
                        <path class="circle"
                              stroke-dasharray="100, 100"
                              d="M18 2.0845
              a 15.9155 15.9155 0 0 1 0 31.831
              a 15.9155 15.9155 0 0 1 0 -31.831"
                        />
                        <text x="18" y="20.35" class="percentage"><?php echo $donorsCount?></text>
                    </svg>
                </div>
                <div><span class="font-extraBold text-dark text-xl"><?php echo $donorsCount?></span></div>
            </div>
            <div class="w-100 bg-dark border-radius-5 align-self-center"
                 style="height: 8px;width: 85%;margin-bottom:2px">
            </div>
        </div>
        <div class="d-flex flex-column bg-white text-white box-shadow-green border-dark border-radius-5"
             style="width: 250px;height: 180px">
            <div class="d-flex flex-column flex-center gap-0-5 h-100">
                <div class="font-bold text-xl">Total Blood Banks</div>
                <div class="single-chart">
                    <svg viewBox="0 0 36 36" class="circular-chart green">
                        <path class="circle-bg"
                              d="M18 2.0845
              a 15.9155 15.9155 0 0 1 0 31.831
              a 15.9155 15.9155 0 0 1 0 -31.831"
                        />
                        <path class="circle"
                              stroke-dasharray="100, 100"
                              d="M18 2.0845
              a 15.9155 15.9155 0 0 1 0 31.831
              a 15.9155 15.9155 0 0 1 0 -31.831"
                        />
                        <text x="18" y="20.35" class="percentage">
                            <?php echo $bloodBanksCount?>
                        </text>
                    </svg>
                </div>
                <div><span class="font-extraBold text-success text-xl"><?php echo $bloodBanksCount?></span></div>
            </div>
            <div class="w-100 bg-green-6 border-radius-5 align-self-center"
                 style="height: 8px;width: 85%;margin-bottom:2px">

            </div>
        </div>
        <div class="d-flex flex-column bg-white text-white box-shadow-primary border-dark border-radius-5"
             style="width: 250px;height: 180px">
            <div class="d-flex flex-column flex-center gap-0-5 h-100">
                <div class="font-bold text-xl">Total Medical Officers</div>
                <div class="single-chart">
                    <svg viewBox="0 0 36 36" class="circular-chart primary">
                        <path class="circle-bg"
                              d="M18 2.0845
              a 15.9155 15.9155 0 0 1 0 31.831
              a 15.9155 15.9155 0 0 1 0 -31.831"
                        />
                        <path class="circle"
                              stroke-dasharray="100, 100"
                              d="M18 2.0845
              a 15.9155 15.9155 0 0 1 0 31.831
              a 15.9155 15.9155 0 0 1 0 -31.831"
                        />
                        <text x="18" y="20.35" class="percentage"><?php echo $medicalOfficerCount?></text>
                    </svg>
                </div>
                <div><span class="font-extraBold text-primary text-xl"><?php echo $medicalOfficerCount?></span></div>
            </div>
            <div class="w-100 bg-primary border-radius-5 align-self-center"
                 style="height: 8px;width: 85%;margin-bottom:2px">

            </div>
        </div>
        <div class="d-flex flex-column bg-white text-white box-shadow-yellow border-dark border-radius-5"
             style="width: 250px;height: 180px">
            <div class="d-flex flex-column flex-center gap-0-5 h-100">
                <div class="font-bold text-xl"> Ongoing Blood Retrieval </div>
                <div class="single-chart">
                    <svg viewBox="0 0 36 36" class="circular-chart yellow">
                        <path class="circle-bg"
                              d="M18 2.0845
              a 15.9155 15.9155 0 0 1 0 31.831
              a 15.9155 15.9155 0 0 1 0 -31.831"
                        />
                        <path class="circle"
                              stroke-dasharray="100, 100"
                              d="M18 2.0845
              a 15.9155 15.9155 0 0 1 0 31.831
              a 15.9155 15.9155 0 0 1 0 -31.831"
                        />
                        <text x="18" y="20.35" class="percentage"><?php echo $onGoingCampaigns ?></text>
                    </svg>
                </div>
                <div><span class="font-extraBold text-yellow-8 text-xl"><?php echo $onGoingCampaigns ?></span></div>
            </div>
            <div class="w-100 bg-warning border-radius-5 align-self-center"
                 style="height: 8px;width: 85%;margin-bottom:2px">

            </div>
        </div>
    </div>
    <div class="d-flex w-100 justify-content-center align-items-center gap-1 mt-1">
        <div class="min-w-30 bg-white p-2 border-radius-10">
            <canvas id="myChart" style="width:600px;min-width:400px;max-width: 600px" ></canvas>
        </div>
        <div class="min-w-30 bg-white p-2 border-radius-10">
            <canvas id="myChart2" style="width:600px;min-width:400px;max-width: 600px" ></canvas>
        </div>
    </div>
    <div class="d-flex w-100 justify-content-center align-items-center gap-1 mt-1 mb-2">
    <div class=" bg-white p-1 border-radius-10 mb-2 border-3 border-dark">
        <div class="title"> Important Stats</div>
        <ul class="list list-style-none">
            <li class="d-flex align-items-center justify-content-evenly">Ongoing Campaigns : <div class="text-2xl"> <?php echo $onGoingCampaigns ?> </div></li>
            <li class="d-flex align-items-center justify-content-evenly">Pending Blood Requests : <div class="text-2xl"> <?php echo $pendingBloodRequests  ?> </div></li>
            <li class="d-flex align-items-center justify-content-evenly">Total Users : <div class="text-2xl"><?php echo $totalUsers ?></div></li>
        </ul>
    </div>
    </div>
</div>
<script type="text/javascript">

    // let cards = descriptionCardsContainer.childNodes;
    // let cardsd = cards.querySelectorAll("div");

    // console.log(cards);

    //loadPieChartDonors(<?php //echo $donorsCount ?>//, <?php //echo $availableDonors ?>//);
    //TODO : REMOVE THIS
    loadPieChartDonors(507, 350);






    let BloodGroups = [];
    const XHR = new XMLHttpRequest();
    XHR.open("GET", "/api/bloodGroups/getall", true);
    XHR.setRequestHeader("Content-Type", "application/json");
    XHR.send();
    XHR.onload = function () {
        // const bloodGroups = JSON.parse(this.responseText);
        //TODO : REMOVE THIS
        const bloodGroups = ["A+", "A-", "B+", "B-", "AB+", "AB-", "O+", "O-"];
        loadPieChart(bloodGroups);
        // Managers = Object.keys(managerList);
       }

        // loadPieChart();
        // loadScatterPlot();

    function loadPieChartDonors(totalDonors, availableDonors) {
        let yValues = [availableDonors, totalDonors - availableDonors];
        let xValues = ["Available Donors", "Unavailable Donors"];
        let barColors = [
            "rgba(255, 0, 0, 1)",       // Red
            "rgba(220, 20, 60, 1)",     // Crimson
        ]
        const chart = new Chart("myChart2", {
            type: "pie",
            data: {
                labels: xValues,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValues
                }]
            },
            options: {
                title: {
                    display: true,
                    text: "Available Donors"
                }
            }
        });
    }

    function loadPieChart(bloodGroups) {
            //TODO:Remove this
            let yValues = [55, 49, 44, 24, 15, 45, 45, 44,54];
            let xValues = ["A+", "A-", "B+", "B-", "AB+", "AB-", "O+", "O-"];
            // let yValues = Object.values(bloodGroups);
            // let xValues = Object.keys(bloodGroups);
            // console.log(bloodGroups.toArray());
            // let xValues = ["A+", "A-", "B+", "B-", "AB+", "AB-", "O+", "O-"];

            let barColors = [
                "rgba(255, 0, 0, 1)",       // Red
                "rgba(220, 20, 60, 1)",     // Crimson
                "rgba(178, 34, 34, 1)",     // Fire Brick
                "rgba(165, 42, 42, 1)",     // Brown
                "rgba(139, 0, 0, 1)",       // Dark Red
                "rgba(128, 0, 0, 1)",       // Maroon
                "rgba(255, 0, 0, 0.8)",     // Red with alpha
                "rgba(220, 20, 60, 0.8)",   // Crimson with alpha
            ];

        const chart =new Chart("myChart", {
            type: "bar",
            data: {
                labels: xValues,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValues
                }]
            },
            options: {
                title: {
                    display: true,
                    text: "Blood Groups"
                },
                legend: { display: false }
            }
        });

    }


</script>
