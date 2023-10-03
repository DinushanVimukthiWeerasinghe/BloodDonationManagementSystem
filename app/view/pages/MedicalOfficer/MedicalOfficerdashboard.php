<?php


/* @var $Campaigns array*/
/* @var $campaign Campaign*/
/* @var $User User*/

use App\model\Campaigns\Campaign;
use App\model\users\User;

?>



<div class="d-flex flex-column align-items-center m-1 border-radius-10 h-98 w-100 gap-1">
    <div class="d-flex flex-column align-items-center justify-content-start w-100 mt-1">
<!--        <div class="bg-dark py-1 px-2 w-100 text-center text-white mb-1"></div>-->
        <div class="w-100 d-flex justify-content-center gap-1">
            <div class="d-flex flex-column bg-white text-white border-dark border-radius-5"
                 style="width: 250px;height: 180px">
                <div class="d-flex flex-column flex-center gap-1 h-100">
                    <div class="d-flex flex-column font-bold text-xl">
                        No Of Campaigns
                    </div>
                    <div class="d-flex text-primary font-extraBold" style="font-size: 3.5rem">
                        40
                    </div>
                </div>
                <div class="w-100 bg-primary border-radius-5 align-self-center"
                     style="height: 5px;margin-bottom: 2px;width: 100%"></div>
            </div>
            <div class="d-flex flex-column bg-white text-white border-dark border-radius-5"
                 style="width: 250px;height: 180px">
                <div class="d-flex flex-column flex-center gap-1 h-100">
                    <div class="d-flex flex-column font-bold text-xl">
                        Next Campaign
                    </div>
                    <div class="single-chart">
                        <div class="d-flex flex-column border-dark border-2 border-radius-5 align-items-center justify-content-between" style="width: 90px;height: 100px">
                            <div class="bg-dark py-0-5 px-1 text-center text-white w-100 d-flex gap-0-5" style="border-top-left-radius: 1.0rem;border-top-right-radius: 1.0rem;"><i class="fa-solid fa-calendar-days"></i>April</div>
                            <div class=""><span class="text-3xl font-bold">21</span><sup class="absolute">st</sup></div>
                            <div></div>
                        </div>
                    </div>
                </div>
                <div class="w-100 bg-info border-radius-5 align-self-center"
                     style="height: 5px;margin-bottom: 2px;width: 100%"></div>
            </div>
            <div class="d-flex flex-column bg-white text-white border-dark border-radius-5"
                 style="width: 250px;height: 180px">
                <div class="d-flex flex-column flex-center gap-0-5 h-100">
                    <div class="d-flex flex-column font-bold text-xl">
                        Total Donations
                    </div>
                    <div class="d-flex text-yellow-10 font-extraBold" style="font-size: 3.5rem">
                        35
                    </div>
                </div>
                <div class="w-100 bg-warning border-radius-5 align-self-center"
                     style="height: 5px;margin-bottom: 2px;width: 100%"></div>
            </div>
            <div class="d-flex flex-column bg-white text-white border-dark border-radius-5"
                 style="width: 250px;height: 180px">
                <div class="d-flex flex-column flex-center gap-0-5 h-100">
                    <div class="d-flex flex-column font-bold text-xl">
                        Blood Campaigns
                    </div>

                    <div class="single-chart">
                        <svg viewBox="0 0 36 36" class="circular-chart primary">
                            <path class="circle-bg"
                                  d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831"
                            />
                            <path class="circle"
                                  stroke-dasharray="30, 100"
                                  d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831"
                            />
                            <text x="18" y="20.35" class="percentage">30%</text>
                        </svg>
                    </div>
                    <div><span class="font-extraBold text-primary text-xl">300</span> <span class="text-2xl">/</span> <span>100</span></div>
                </div>
                <div class="w-100 bg-primary border-radius-5 align-self-center"
                     style="height: 5px;margin-bottom: 2px;width: 100%"></div>
            </div>
            <div class="d-flex flex-column bg-white text-white border-dark border-radius-5"
                 style="width: 250px;height: 180px">
                <div class="d-flex flex-column flex-center gap-0-5 h-100">
                    <div class="d-flex flex-column font-bold text-xl">
                        Blood Campaigns
                    </div>

                    <div class="single-chart">
                        <svg viewBox="0 0 36 36" class="circular-chart primary">
                            <path class="circle-bg"
                                  d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831"
                            />
                            <path class="circle"
                                  stroke-dasharray="30, 100"
                                  d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831"
                            />
                            <text x="18" y="20.35" class="percentage">30%</text>
                        </svg>
                    </div>
                    <div><span class="font-extraBold text-primary text-xl">300</span> <span class="text-2xl">/</span> <span>100</span></div>
                </div>
                <div class="w-100 bg-primary border-radius-5 align-self-center"
                     style="height: 5px;margin-bottom: 2px;width: 100%"></div>
            </div>
        </div>
    </div>
    <div class="d-flex gap-1 align-items-center justify-content-center w-90 my-1">
<!--        <div class="bg-dark py-1 px-2 w-90 text-center text-white mb-3">Notification </div>-->
        <div class="w-50 h-100 d-flex flex-column align-items-center bg-white p-2 border-radius-10">
            <div class="bg-dark py-1 px-2 w-90 text-center text-xl text-white mb-3">My Campaigns </div>
            <canvas id="myChart" ></canvas>
        </div>
        <div class="w-50 bg-white d-flex flex-column align-items-center p-2 border-radius-10">
            <div class="bg-dark py-1 px-2 w-90 text-center text-xl text-white ">Calender </div>
            <div class="calendar">
                <div class="header">
                    <div class="nav-btn prev-btn" id="prev-btn">
                        <i class="fas fa-chevron-left"></i>
                    </div>
                    <div class="month-year">
                        <span id="month"></span>
                        <span id="year"></span>
                    </div>
                    <div class="nav-btn next-btn" id="next-btn">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>
                <div class="weekdays">
                    <div>Sun</div>
                    <div>Mon</div>
                    <div>Tue</div>
                    <div>Wed</div>
                    <div>Thu</div>
                    <div>Fri</div>
                    <div>Sat</div>
                </div>
                <div class="days">
                </div>
            </div>
        </div>

    </div>

</div>

<script src="/public/js/components/calender/calender.js"></script>
<script type="text/javascript">
    const ViewCampaign = (Campaign)=>{
        const Status = Campaign.CampaignStatus;
        let bgcolor = "bg-success";
        switch (Status) {
            case "Pending":
                bgcolor = "bg-warning";
                break;
            case "Finished":
                bgcolor = "bg-success";
                break;
            case "Approved":
                bgcolor = "bg-success";
                break;
            case "Rejected":
                bgcolor = "bg-danger";
                break;
            case "Reported":
                bgcolor = "bg-danger";
                break;
        }
        OpenDialogBox({
            id:"ViewCampaign",
            title:"View Campaign",
            titleClass:"bg-dark text-white text-center px-2 py-1",
            showSuccessButton:false,
            cancelBtnText:"Close",
            content:`
                <div class="d-flex flex-column">
                        <div class="d-flex flex-column w-100 justify-content-center align-items-center">
                            <div class="d-flex font-bold my-1 w-100 text-center justify-content-center align-items-center bg-dark py-1 px-2 text-center text-white">Campaign Details</div>
                            <div class="d-flex justify-content-center w-100 gap-1">
                                <div class="d-flex flex-column w-50 flex-center gap-0-5 bg-dark text-white border-radius-10">
                                    <div class="d-flex gap-0-5"><span class="font-bold">Campaign Name </span>: <span>${Campaign.CampaignName}</span></div>
                                    <div class="d-flex gap-0-5"><span class="font-bold"> </span> Campaign Date: <span>${Campaign.CampaignDate}</div>
                                    <div class="d-flex gap-0-5"><span class="font-bold"> </span>Venue : <span>${Campaign.Venue}</div>
                                    <div class="d-flex flex-column gap-0-5">
                                        <div class="font-bold">Description  </div> <div class="px-1" style="max-width: 400px">${Campaign.CampaignDescription} </div>
                                    </div>
                                    <div class="d-flex flex-center gap-0-5"><span class="font-bold"> </span>Status : <span class="px-1 py-0-5 border-radius-5 ${bgcolor}">${Campaign.CampaignStatus}</div>
                                </div>
                                <div class="d-flex w-50 flex-center">
                                    <div id="map" style="height: 300px;width: 300px"></div>
                                    <div id="infowindow-content">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="d-flex flex-column w-100 justify-content-center align-items-center">
                            <div class="d-flex w-100 font-bold my-1 text-center justify-content-center align-items-center bg-dark py-1 px-2 text-center text-white">Organization Details</div>
                            <div class="d-flex">
                                        <span class="font-bold">Organization Name </span> : <span>${Campaign.OrganizationName}</span>
                            </div>
                            <div class="d-flex">
                                        City : ${Campaign.OrganizationCity}
                            </div>
                            <div class="d-flex">
                                        Contact : ${Campaign.OrganizationContactNo}
                            </div>
                            <div class="d-flex">
                                        Email : ${Campaign.OrganizationEmail}
                            </div>
                        </div>
                        <div class="d-flex flex-column w-100 justify-content-center align-items-center">
                            <div class="d-flex w-100 font-bold my-1 text-center justify-content-center align-items-center bg-dark py-1 px-2 text-center text-white">
                                Your have assigned as
                                    <span class="d-flex bg-success border-radius-5 px-1 ml-0-5 py-0-5 text-center text-white">
                                        Group ${Campaign.TeamPosition}
                                    </span>
                            </div>

                        </div>

            `
        })
        initMap(parseFloat(Campaign.Latitude),parseFloat(Campaign.Longitude));
    }
    const initMap=(latitude,longitude)=> {
        const place = { lat: 6.8781340776734385, lng: 79.8833214428759 };
        if (latitude && longitude){
            place.lat = latitude;
            place.lng = longitude;
        }
        console.log(place)
        const mylating = { lat: 6.8781340776734385, lng: 79.8833214428759 };

        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 13,
            minZoom: 8,
            maxZoom: 16,
            center: place,
            restriction: {
                latLngBounds: {
                    north: 9.9,
                    south: 5.8,
                    west: 79.8,
                    east: 81.9,
                }
            },
        });
        const infowindow = new google.maps.InfoWindow();

        new google.maps.Marker({
            position: place,
            map,
            title: "Campaign Location",

        })
        // Create the initial InfoWindow.
        let infoWindow = new google.maps.InfoWindow({
            position: place,
            content: "Campaign Location",
        });
        const infowindowContent = document.getElementById("infowindow-content");
        let marker = new google.maps.Marker({
            map,
            anchorPoint: new google.maps.Point(0, -29),

        });
        infoWindow.open({
            anchor:marker,
            map
        });
    }
    const ViewChart = ()=>{
        const barColors = [
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
                    console.log(data)
                    const TotalAssignmentsInMonth = data.data.TotalAssignmentsInMonth;
                    const Months = Object.keys(TotalAssignmentsInMonth);
                    const Values = Object.values(TotalAssignmentsInMonth);
                    const ctx = document.getElementById("myChart").getContext("2d");
                    const chart = new Chart(ctx, {
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

                    /*Add to Calender*/
                    const Campaigns = data.data.Campaigns;
                    Campaigns.forEach((Campaign)=>{
                        const CampaignDate = Campaign.CampaignDate;
                        addEvent("Campaign",CampaignDate,()=>{ViewCampaign(Campaign)})
                    })

                }
            })

    }
    window.addEventListener("load",()=>{
        ViewChart();
    })
</script>


