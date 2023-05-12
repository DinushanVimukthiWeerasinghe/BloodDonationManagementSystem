<div class="information-cards d-flex justify-content-center align-items-center bg-white-0-5">
        <div class="card card-sm bg-white border border-radius-5 d-flex align-center flex-row justify-content-center">
            <div class="card-header">
                <img src="/public/images/icons/admin/dashboard/blood-donation.png" alt="" class="max-w-rem-4">
                <div class="card-title">
                    <div class="text-center text-dark text-2xl p-1 border-2 border-radius-15 border-primary"><?php echo $bloodPacketsCount?></div>
                </div>
            </div>
        </div>
        <div class="card card-sm bg-white border border-radius-5 d-flex align-center flex-row justify-content-center">
            <div class="card-header">
                <img src="/public/images/icons/admin/dashboard/organization-chart.png" alt="" class="max-w-rem-4">
                <div class="card-title">
                    <div class="text-center text-dark text-2xl p-1 border-2 border-radius-15 border-primary"><?php echo $donorsCount?></div>
                </div>
            </div>
        </div>
        <div class="card card-sm bg-white border border-radius-5 d-flex align-center flex-row justify-content-center">
            <div class="card-header">
                <img src="/public/images/icons/admin/dashboard/blood-bank.png" alt="" class="max-w-rem-4">
                <div class="card-title">
                    <div class="text-center text-dark text-2xl p-1 border-2 border-radius-15 border-primary"><?php echo $bloodBanksCount?></div>
                </div>
            </div>
        </div>

</div>
<div class="d-flex w-100 min-h-15 justify-content-center align-items-center gap-1 mt-1">
    <div class="min-w-30 bg-white p-2 border-radius-10">
        <canvas id="myChart" style="width:100%;max-width:700px;display: block;" class="chart chartjs-render-monitor" width="464" height="232"></canvas>
    </div>
        <div class="min-w-30 bg-white p-2 border-radius-10">
        <canvas id="myChart2" style="width:100%;max-width:700px;display: block;" class="chart chartjs-render-monitor" width="464" height="232"></canvas>
    </div>
</div>
<div class="d-flex w-100 min-h-15 justify-content-center align-items-center gap-1 mt-1 mb-2">
<div class="min-w-40 bg-white p-2 border-radius-10">
    <div class="title"> Important Stats</div>
    <ul class="list list-style-none">
        <li class="d-flex align-items-center justify-content-evenly">Total Users : <div class="text-2xl">54</div></li>
        <li class="d-flex align-items-center justify-content-evenly">Total Users : <div class="text-2xl">50</div></li>
        <li class="d-flex align-items-center justify-content-evenly">Total Users : <div class="text-2xl">30</div></li>
    </ul>
</div>
</div>

<script type="text/javascript">
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
    var xValues = ["Italy", "France", "Spain", "USA", "Argentina"];
    var yValues = [55, 49, 44, 24, 15];
    var barColors = [
        "#b91d47",
        "#00aba9",
        "#2b5797",
        "#e8c3b9",
        "#1e7145"
    ];


    const chart =new Chart("myChart", {
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
                text: "World Wide Wine Production"
            }
        }
    });
    const chart2 =new Chart("myChart2", {
        type: "scatter",
        data: {
            datasets: [{
                pointRadius: 4,
                pointBackgroundColor: "rgb(0,0,255)",
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
