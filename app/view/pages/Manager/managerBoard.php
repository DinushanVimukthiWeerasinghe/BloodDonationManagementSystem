<?php
/** @var array $Data */

use App\model\Audits\ManagerNotice;
use App\model\Campaigns\ApprovedCampaigns;
use App\model\Campaigns\Campaign;
use App\model\Requests\BloodRequest;
use App\model\Utils\Date;

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
      integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
      crossorigin="anonymous" referrerpolicy="no-referrer"/>

<div class="d-flex flex-column m-1 gap-1 overflow-y-overlay">
    <div class="w-100 bg-white"></div>

    <div class="d-flex flex-wrap flex-center bg-white-0-3 w-100 gap-1 p-2 border-radius-5">
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
                              stroke-dasharray="<?=$Data['Campaigns']['Percentage']?>, 100"
                              d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831"
                        />
                        <text x="18" y="20.35" class="percentage"><?=$Data['Campaigns']['Percentage']?>%</text>
                    </svg>
                </div>
                <div><span class="font-extraBold text-primary text-xl"><?=$Data['Campaigns']['Successful']?></span> <span class="text-2xl">/</span> <span><?=$Data['Campaigns']['Total']?></span></div>
            </div>
            <div class="w-100 bg-primary border-radius-5 align-self-center"
                 style="height: 5px;margin-bottom: 2px;width: 100%"></div>
        </div>
        <div class="d-flex flex-column bg-white text-white border-dark border-radius-5"
             style="width: 250px;height: 180px">
            <div class="d-flex flex-column flex-center gap-0-5 h-100">
                <div class="font-bold text-xl">Successful Donations</div>
                <div class="single-chart">
                    <svg viewBox="0 0 36 36" class="circular-chart yellow">
                        <path class="circle-bg"
                              d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831"
                        />
                        <path class="circle"
                              stroke-dasharray="<?=$Data['Donations']['Percentage']?>, 100"
                              d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831"
                        />
                        <text x="18" y="20.35" class="percentage"><?=$Data['Donations']['Percentage']?>%</text>
                    </svg>
                </div>
                <div><span class="font-extraBold text-warning text-xl"><?=$Data['Donations']['Successful']?></span> / <span><?=$Data['Donations']['Total']?></span></div>
            </div>
            <div class="w-100 bg-warning border-radius-5 align-self-center"
                 style="height: 5px;margin-bottom: 2px;width: 100%"></div>
        </div>
        <div class="d-flex flex-column bg-white text-white border-dark border-radius-5"
             style="width: 250px;height: 180px">
            <div class="d-flex flex-column flex-center gap-0-5 h-100">
                <div class="text-xl font-bold">Retrieved Sponsors</div>
                <div class="single-chart">
                    <svg viewBox="0 0 36 36" class="circular-chart secondary">
                        <path class="circle-bg"
                              d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831"
                        />
                        <path class="circle"
                              stroke-dasharray="<?=$Data['Sponsorships']['Percentage']?>, 100"
                              d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831"
                        />
                        <text x="18" y="20.35" class="percentage"><?=$Data['Sponsorships']['Percentage']?>%</text>
                    </svg>
                </div>
                <div><span class="font-extraBold text-secondary text-xl"><?=$Data['Sponsorships']['Received']?></span> / <span><?=$Data['Sponsorships']['Total']?></span></div>

            </div>
            <div class="w-100 bg-secondary border-radius-5 align-self-center"
                 style="height: 5px;margin-bottom: 2px;width: 100%"></div>
        </div>
        <div class="d-flex flex-column bg-white text-white border-dark border-radius-5"
             style="width: 250px;height: 180px">
            <div class="d-flex flex-column flex-center gap-0-5 h-100">
                <div class="font-bold text-xl">Medical Officers</div>
                <div class="single-chart">
                    <svg viewBox="0 0 36 36" class="circular-chart green">
                        <path class="circle-bg"
                              d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831"
                        />
                        <path class="circle"
                              stroke-dasharray="<?=$Data['MedicalOfficers']['Percentage']?>, 100"
                              d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831"
                        />
                        <text x="18" y="20.35" class="percentage"><?=$Data['MedicalOfficers']['Percentage']?></text>
                    </svg>
                </div>
                <div><span class="font-extraBold text-success text-xl"><?=$Data['MedicalOfficers']['Total']?></span> / <span><?=$Data['MedicalOfficers']['Total']?></span></div>

            </div>
            <div class="w-100 bg-success border-radius-5 align-self-center"
                 style="height: 5px;margin-bottom: 2px;width: 100%"></div>
        </div>
        <div class="d-flex flex-column bg-white text-white border-dark border-radius-5"
             style="width: 250px;height: 180px">
            <div class="d-flex flex-column flex-center gap-0-5 h-100">
                <div class="font-bold text-xl">Blood Requests</div>
                <div class="single-chart">
                    <svg viewBox="0 0 36 36" class="circular-chart blue">
                        <path class="circle-bg"
                              d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831"
                        />
                        <path class="circle"
                              stroke-dasharray="<?=$Data['Requests']['Percentage']?>, 100"
                              d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831"
                        />
                        <text x="18" y="20.35" class="percentage"><?=$Data['Requests']['Percentage']?>%</text>
                    </svg>
                </div>
                <div><span class="font-extraBold text-info text-xl"><?=$Data['Requests']['Supplied']?></span> / <span><?=$Data['Requests']['Total']?></span></div>

            </div>
            <div class="w-100 bg-info border-radius-5 align-self-center"
                 style="height: 5px;margin-bottom: 2px;width: 100%"></div>
        </div>
    </div>
    <div id="Charts" class="d-flex flex-wrap bg-white p-2 border-radius-5 gap-1 justify-content-center">
        <div class="d-flex flex-column w-60">
            <canvas id="myChart" style="width:100%;max-width:700px;display: block;max-height: 300px" ></canvas>
            <div class="font-bold mt-1 text-center text-xl">
                Blood Donations in the last 12 months
            </div>
        </div>
        <div class="d-flex flex-column w-35">
            <canvas id="myChart2" style="width:100%;max-width:700px;max-height:300px;display: block;min-width: 200px;min-height: 250px" ></canvas>
            <div class="font-bold mt-1 text-center text-xl">
                Blood Donated in the last 12 months
            </div>
        </div>
    </div>
    <div id="Notify" class="d-flex bg-white-0-3 gap-1 p-1">
        <div class="d-flex gap-1 p-1 flex-column border-radius-5">
            <div class="font-bold bg-white border-radius-10 px-2 py-0-5 text-center text-xl">
                Next 7 Days Campaigns
            </div>
            <div class="d-flex flex-column gap-0-5" style="width: 350px">
                <?php
                /***
                 * @var $Campaigns ApprovedCampaigns[]
                 */
                if (!empty($Campaigns)):
                foreach ($Campaigns as $Campaign):
                ?>
                <div class="d-flex gap-1 border-1 justify-content-between bg-white border-radius-5 flex-center border-dark p-1">
                    <div class="d-flex flex-column">
                        <div class="text-md font-bold"><?=$Campaign->getCampaign()->getCampaignName();?></div>
                        <div class="text-md "><?=$Campaign->getCampaign()->getCampaignDate()?></div>
                    </div>
                    <a href="/manager/mngCampaigns?status=2" class="btn btn-sm btn-outline-primary">View</a>
                </div>
                <?php
                endforeach;
                else:
                ?>
                <div class="d-flex gap-1 border-1 justify-content-between bg-white border-radius-5 flex-center border-dark p-1">
                    <div class="d-flex flex-column">
                        <div class="text-md font-bold">No Campaigns</div>
                        <div class="text-md ">No Campaigns</div>
                    </div>
                </div>
                <?php
                endif;
                ?>

            </div>
        </div>
        <div class="d-flex border-radius-10 gap-1 p-1 flex-column border-radius-5" style="width: 300px">
            <div class="font-bold text-center bg-white px-2 py-0-5 border-radius-10 text-xl">
                New Blood Requests
            </div>
            <div class="d-flex flex-column gap-0-5">
                <?php
/***
                 * @var $Requests BloodRequest[]
                 */
                if (!empty($Requests)):
                foreach ($Requests as $Request):
                ?>
                <div class="d-flex bg-white justify-content-between gap-0-5 border-1 border-radius-5 flex-center border-dark p-1">
                    <img src="<?=$Request->getBloodTypeImage()?>" width="36" alt="">
                    <div class="d-flex flex-column gap-0-5">
                        <div class="text-md font-bold"><?=$Request->getRequestedBy()?></div>
                        <div class="text-md font-bold"><?= Date::GetProperDate($Request->getRequestedAt())?></div>
                    </div>
                    <a href="/manager/mngRequests" class="btn btn-sm btn-outline-primary">View</a>
                </div>
                <?php
                endforeach;
                else:
                ?>
                <div class="d-flex bg-white justify-content-between gap-1 border-1 border-radius-5 flex-center border-dark p-1">
                    <div class="d-flex flex-column gap-0-5">
                        <div class="text-md font-bold">No Requests</div>
                    </div>
                </div>
                <?php
                endif;
                ?>
            </div>
        </div>
        <div class="d-flex border-radius-10 gap-1 p-1 flex-column border-radius-5" style="max-width: 40vw">
            <div class="font-bold text-center bg-white px-2 py-0-5 border-radius-10 text-xl">
                Important Notices
            </div>
            <div class="d-flex flex-column gap-0-5">
                <?php
                /***
                 * @var $Notices ManagerNotice[]
                 */
                if (!empty($Notices)):
                foreach ($Notices as $Notice):
                ?>
                <div class="d-flex bg-white flex-column gap-0-5 border-2 border-radius-5 flex-center border-dark p-1" id="<?=$Notice->getNoticeID()?>">
                    <div class="text-md font-bold bg-dark text-white px-2 py-0-5 w-100 text-center"><?=$Notice->getNoticeTitle()?></div>
                    <div class="text-md text-center"> <?=$Notice->getNoticeContent()?> </div>
                    <div class="d-flex flex-center gap-1">
                        <button class="btn btn-sm btn-outline-info" onclick="UpdateNotice('<?=$Notice->getNoticeID()?>',2)">
                            <i class="fa fa-check-double"></i> Mark As Resolve
                        </button>
                        <button class="btn btn-sm btn-outline-primary" onclick="UpdateNotice('<?=$Notice->getNoticeID()?>',3)">
                            <i class="fa fa-circle-minus"></i> Ignore
                        </button>
                    </div>
                </div>
                <?php
                endforeach;
                else:
                ?>
                <div class="d-flex bg-white flex-column gap-0-5 border-2 border-radius-5 flex-center border-dark p-1">
                    <div class="text-md font-bold bg-dark text-white px-2 py-0-5 w-100 text-center">No Notices</div>
                </div>
                <?php
                endif;
                ?>




            </div>
        </div>

    </div>
</div>
<style>
    @media only screen and (max-width: 1000px){
        #Charts{
            flex-direction: column;
            gap: 2rem;
        }
        #Notify{
            flex-direction: column;
            gap: 2rem;
        }
        #Charts div, #Notify div{
            width: 100% !important;
            max-width: 100% !important;
        }

    }
</style>

<script>

    const UpdateNotice = (NoticeID,action)=>{
        let text = "Are you sure you want to mark this notice as resolved?";
        if(action === 3){
            text = "Are you sure you want to ignore this notice?";
        }
        OpenDialogBox({
            id:"UpdateNotice",
            title:"Update Notice",
            content:`<div class="text-center font-bold text-xl">${text}</div>`,
            successBtnText:"Yes",
            cancelBtnText:"No",
            titleClass:"text-center bg-dark text-white",
            successBtnAction: ()=>{
                const  url ="/manager/updateNotice";
                const form = new FormData();
                form.append("ID",NoticeID);
                form.append("Action",action.toString());
                fetch(url,{
                    method:"POST",
                    body:form
                }).then(response=>response.json())
                    .then(data=>{
                        console.log(data);
                        if(data.status){
                            ShowToast({
                                type:"success",
                                message:data.message
                            })
                            CloseDialogBox("UpdateNotice");
                            document.getElementById(NoticeID).remove();
                        }
                    })
            }
        })

    }

    var barColors = [
        "#b90209",
    ];
    const url = "/manager/stat";
    fetch(url, {
        method: "POST",
    }).then(response => response.json())
        .then(data => {
            console.log(data)
            if (data.status) {
                const TotalAssignmentsInMonth = data.data.TotalAssignmentsInMonth;
                const TotalBloodDonations = data.data.BloodGroups;
                const BloodTypes = Object.keys(TotalBloodDonations);
                const BloodValues = Object.values(TotalBloodDonations);
                const Months = Object.keys(TotalAssignmentsInMonth);
                const Values = Object.values(TotalAssignmentsInMonth);
                const ctx = document.getElementById("myChart").getContext("2d");
                const ctx2 = document.getElementById("myChart2").getContext("2d");
                const colors = [
                    "rgba(255, 0, 0, 1)",       // Red
                    "rgba(220, 20, 60, 1)",     // Crimson
                    "rgba(178, 34, 34, 1)",     // Fire Brick
                    "rgba(165, 42, 42, 1)",     // Brown
                    "rgba(139, 0, 0, 1)",       // Dark Red
                    "rgba(128, 0, 0, 1)",       // Maroon
                    "rgba(255, 0, 0, 0.8)",     // Red with alpha
                    "rgba(220, 20, 60, 0.8)",   // Crimson with alpha
                    "rgba(178, 34, 34, 0.8)",   // Fire Brick with alpha
                    "rgba(165, 42, 42, 0.8)",   // Brown with alpha
                    "rgba(139, 0, 0, 0.8)",     // Dark Red with alpha
                    "rgba(128, 0, 0, 0.8)"      // Maroon with alpha
                ];
                const pcolors = [
                    "rgba(255, 0, 0, 1)",       // Red
                    "rgba(220, 20, 60, 1)",     // Crimson
                    "rgba(178, 34, 34, 1)",     // Fire Brick
                    "rgba(165, 42, 42, 1)",     // Brown
                    "rgba(139, 0, 0, 1)",       // Dark Red
                    "rgba(128, 0, 0, 1)"        // Maroon
                ];


                const myChart2 = new Chart(ctx, {
                    type: "bar",
                    data: {
                        labels: Months,
                        datasets: [{
                            axis: 'y',
                            fill: false,
                            backgroundColor: colors,
                            data: Values,
                            label: "Donation Campaigns in " + new Date().getFullYear(),
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                },
                                min: 0,
                            }
                        }
                    }

                });
                const myChart3 = new Chart(ctx2, {
                    type: "doughnut",
                    data: {
                        labels: BloodTypes,
                        datasets: [{
                            axis: 'y',
                            fill: false,
                            backgroundColor: pcolors,
                            data: BloodValues,
                            label: "Blood Types",
                            hoverBorderColor: "#fff",
                            hoverOffset: 10
                        }],

                    },

                });
            }
        })
        .catch(error => {
            console.log(error);
        });
</script>

