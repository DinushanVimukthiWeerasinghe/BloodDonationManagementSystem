<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />


<div class="w-95 h-95 m-1 gap-1 d-flex">
    <div class="w-45 bg-white border-radius-10">
        <div id="stat" class="d-flex flex-column justify-content-center align-items-center">
            <div class="text-2xl font-bold">Statistics</div>
            <div class="d-flex justify-content-center align-items-center">
                <div class="card card-xs gap-1">
                    <div class="card-header">
                        <div class="text-2xl font-bold">1000</div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-center align-items-center">
                            <div class=""> Donors</div>
                        </div>
                    </div>
                </div>
                <div class="card card-xs gap-1">
                    <div class="card-header">
                        <div class="text-2xl font-bold">1000</div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-center align-items-center">
                            <div class=""> Donations</div>
                        </div>
                    </div>
                </div>
                <div class="card card-xs gap-1">
                    <div class="card-header">
                        <div class="text-2xl font-bold">1000</div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-center align-items-center">
                            <div class=""> Campaigns</div>
                        </div>
                    </div>
                </div>
                <div class="card card-xs gap-1">
                    <div class="card-header">
                        <div class="text-2xl font-bold">1000</div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-center align-items-center">
                            <div class=""> Blood Bags</div>
                        </div>
                    </div>
                </div>
            </div>
            <canvas id="myChart3" style="width:100%;max-width:700px;display: block;" ></canvas>
        </div>
    </div>
    <div class="w-55 bg-white h-100 border-radius-10">
        <div class="min-w-30 bg-white p-2 border-radius-10">
            <canvas id="myChart" style="width:100%;max-width:700px;display: block;max-height: 300px" ></canvas>
            <canvas id="myChart2" style="width:100%;max-width:700px;display: block;" ></canvas>

        </div>
    </div>
</div>

<script>
    var barColors = [
        "#b90209",
    ];
    const url= "/manager/stat";
    const form = new FormData();
    form.append("ID", "<?=\Core\Application::$app->getUser()->getID()?>");
    fetch(url,{
        method:"POST",
        body: form
    }).then(response => response.json())
        .then(data => {
            if (data.status) {
                const TotalAssignmentsInMonth = data.data.TotalAssignmentsInMonth;
                const BloodTypes = ["A+","A-","B+","B-","AB+","AB-","O+","O-"]
                const Months = Object.keys(TotalAssignmentsInMonth);
                const Values = Object.values(TotalAssignmentsInMonth);
                const ctx = document.getElementById("myChart3").getContext("2d");
                const ctx2 = document.getElementById("myChart2").getContext("2d");
                const ctx3 = document.getElementById("myChart").getContext("2d");
                const myChart = new Chart(ctx, {
                    type: "bar",
                    options: {
                        indexAxis: 'y',
                        scales:{
                            y:{
                                beginAtZero:true,
                            }
                        }
                    },
                    data: {
                        labels: Months,
                        datasets: [{
                            axis:'y',
                            fill :false,
                            backgroundColor: barColors,
                            data: Values,
                            label: "Donation Campaigns in " + new Date().getFullYear()
                        }]
                    },

                });
                const myChart2 = new Chart(ctx2, {
                    type: "line",
                    data: {
                        labels: Months,
                        datasets: [{
                            axis:'y',
                            fill :false,
                            backgroundColor: barColors,
                            data: Values,
                            label: "Donation Campaigns in " + new Date().getFullYear()
                        }]
                    },

                });
                const myChart3 = new Chart(ctx3, {
                    type: "pie",
                    data: {
                        labels: BloodTypes,
                        datasets: [{
                            axis:'y',
                            fill :false,
                            backgroundColor: [
                                'rgba(255, 0, 0, 1)',
                                'rgba(255, 0, 0, 0.8)',
                                'rgba(255, 0, 0, 0.6)',
                                'rgba(255, 0, 0, 0.4)',
                                'rgba(255, 0, 0, 1)',
                                'rgba(255, 0, 0, 0.8)',
                                'rgba(255, 0, 0, 0.6)',
                                'rgba(255, 0, 0, 0.4)',
                                'rgba(255, 0, 0, 1)',
                                'rgba(255, 0, 0, 0.8)',
                                'rgba(255, 0, 0, 0.6)',
                                'rgba(255, 0, 0, 0.4)',

                            ],
                            data: Values.slice(0,8),
                            label: "Blood Types"
                        }]
                    },

                });
            }
        })
        .catch(error => {
            console.log(error);
        });
</script>

