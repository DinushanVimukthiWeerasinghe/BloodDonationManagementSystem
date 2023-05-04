<?php

?>
<div class="bg-white-0-3 p-1 border-radius-6 flex-wrap w-50 align-self-center d-flex justify-content-center ">
    <div class="card nav-card" onclick="BranchReport()">
        <div class="card-header">
            <img src="/public/images/icons/manager/manageReport/generateReport2.png" alt="">
            <div class="header-title"> Campaign Report</div>
        </div>
    </div>
    <div class="card nav-card" onclick="DonationReport()">
        <div class="card-header">
            <img src="/public/images/icons/manager/manageReport/health-report.png" alt="">
            <div class="header-title"> Donation Report</div>
        </div>
    </div>
    <div class="card nav-card" onclick="SponsorshipReport()">
        <div class="card-header">
            <img src="/public/images/icons/manager/manageReport/health-report.png" alt="">
            <div class="header-title">Sponsorship Reports</div>
        </div>
    </div>
    <div class="card nav-card" onclick="OfficerReport()">
        <div class="card-header">
            <img src="/public/images/icons/manager/manageReport/health-report.png" alt="">
            <div class="header-title">Officer Reports</div>
        </div>
    </div>
    <!--    <div class="card nav-card">-->
    <!--        <div class="card-header">-->
    <!--            <img src="/public/images/icons/manager/manageReport/health-report.png" alt="">-->
    <!--            <div class="header-title">Transfusion Reports</div>-->
    <!--        </div>-->
    <!--    </div>-->
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"
        integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/"
        crossorigin="anonymous"></script>
<script src="/public/js/html2canvas.min.js"></script>

<script>
    let DonationReportChart = null;
    const FilterLastFiveYear = (data) => {
        let year = '';
        const CYear = parseInt(data.year);
        const CurrentYear = new Date().getFullYear();
        for (let i = CYear - 5; i <= CurrentYear; i++) {
            if (CurrentYear - i > 5)
                continue;
            if (i === CYear)
                year += `<option value="${i}" selected>${i}</option>`
            else
                year += `<option value="${i}">${i}</option>`
        }
        return year;
    }
    const Month = (data) => {
        let month = '';
        const CMonth = data.month;
        const monthName = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        for (let i = 0; i < 12; i++) {
            if (i === CMonth - 1)
                month += `<option value="${i + 1}" selected>${monthName[i]}</option>`
            else
                month += `<option value="${i + 1}">${monthName[i]}</option>`
        }
        return month;
    }
    const BranchReport = (year = null, month = "all") => {
        if (year === null) {
            year = new Date().getFullYear();
        }
        const url = "/manager/mngCampaigns/ViewCampaignReport";
        const formData = new FormData();
        formData.append('Year', year.toString());
        formData.append('Month', month);
        console.log(year, month)
        fetch(url, {
            method: 'POST',
            body: formData

        }).then(res => res.json()).then(data => {
            console.log(data)
            if (data.status) {
                let table = '';
                data.data.forEach((item, index) => {
                    table += `
                        <tr>
                            <td data-label="Campaign Name ">${item.CampaignName}</td>
                            <td data-label="Campaign Date ">${item.CampaignDate}</td>
                            <td data-label="Campaign Venue ">${item.CampaignLocation}</td>
                            <td data-label="Organization Name ">${item.OrganizationName}</td>
                            <td data-label="Organization Type ">${item.OrganizationType}</td>
                            <td data-label="No of Successful Donation ">${item.SuccessfulDonation}</td>
                            <td data-label="No Of Rejected Donation ">${item.RejectedDonation}</td>
                            <td data-label="No Of Total Donation ">${item.RejectedDonation + item.SuccessfulDonation}</td>
                            <td data-label="Total Blood Connected ">${item.BloodCollected}</td>
                            <td data-label="Medical Team ID ">${item.TeamID}</td>
                            <td data-label="Team Leader ">${item.TeamLeader}</td>
                            <td data-label="No Of Team Members ">${item.NoTeamMembers}</td>
                            <td data-label="Amount of Requested ">${item.RequestedAmount}</td>
                            <td data-label="Amount Of Sponsored ">${item.SponsorshipAmount}</td>
                            <td class="last-td-child" data-label="Transferred Date ">${item.TransferredDate}</td>
                        </tr>
                    `
                })
                if (table.trim() === "") {
                    table = `
                            <tr>
                                <td colspan="15" class=" text-center text-white" style="background: rgba(0,0,0,0.5);">No Data Available</td>
                            </tr>
                        `
                }
                OpenDialogBox({
                    id: 'branch-report',
                    title: 'Donation Campaign Report - All Over Year',
                    titleClass: 'text-center bg-dark text-white',
                    minWidth: '85vw',
                    maxWidth: '95vw',
                    maxHeight: '85vh',
                    content: `
                        <div class="d-flex flex-column">
                            <div class="d-flex flex-center gap-2 my-1">
                                <div class="d-flex flex-center gap-0-5">
                                    <label for="year" class="form-label">Year</label>
                                    <select class="form-select" id="year" onchange="ChangeReportOnYearAndMonth()" style="width: 150px" aria-label="Default select example">
                                        ${FilterLastFiveYear(data)}
                                    </select>
                                </div>
                                <div class="d-flex flex-center gap-0-5">
                                    <label for="month" class="form-label">Month</label>
                                    <select class="form-select" id="month" onchange="ChangeReportOnYearAndMonth()" style="width: 150px" aria-label="Default select example">
                                        <option value="all">All</option>
                                        ${Month(data)}
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex flex-column w-100 overflow-y-overlay" style="max-height:60vh">
                                <table class="table table-bordered w-100">
                                    <thead class="sticky top-0" style="z-index:9">
                                        <tr>
                                            <th colspan="3" style="border: 1px solid black">Campaign</th>
                                            <th colspan="2"  style="border: 1px solid black">Organization</th>
                                            <th colspan="3"  style="border: 1px solid black"> Donations</th>
                                            <th rowspan="2" style="border: 1px solid black">Blood Collected (Pints)</th>
                                            <th colspan="3"  style="border: 1px solid black">Assigned Team</th>
                                            <th colspan="3" style="border: 1px solid black">Sponsor</th>
                                        </tr>
                                        <tr>
                                            <th  style="border: 1px solid black">Name</th>
                                            <th data-left="20"  style="border: 1px solid black">Date</th>
                                            <th  style="border: 1px solid black">Venue</th>
                                            <th  style="border: 1px solid black">Name</th>
                                            <th  style="border: 1px solid black">Type</th>
                                            <th  style="border: 1px solid black">Successful</th>
                                            <th  style="border: 1px solid black">Unsuccessful</th>
                                            <th  style="border: 1px solid black">Total</th>
                                            <th  style="border: 1px solid black">ID</th>
                                            <th  style="border: 1px solid black">Leader</th>
                                            <th  style="border: 1px solid black">No Members</th>
                                            <th  style="border: 1px solid black">Expected</th>
                                            <th class="mob-th-sticky"  style="border: 1px solid black">Received</th>
                                            <th  style="border: 1px solid black">Transfered Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${table}
                                    </tbody>
                                </table>
                            </div>
                        </div>
            `,
                    successBtnText: 'Print',
                    successBtnAction: () => {
                        console.log('Print')
                        PrintReport('donation--report', 'Branch Report')
                    },
                })
            }
        })
    }
    const ChangeReportOnYearAndMonth = (report = 0) => {
        let year = document.getElementById('year').value;
        const month = document.getElementById('month').value;
        console.log(year, month)
        if (report === 0) {
            CloseDialogBox('branch-report');
            BranchReport(year, month);
        } else if (report === 1) {
            if (year === null)
                year = new Date().getFullYear();

            const url = "/manager/mngReport/DonationReport";
            const Form = new FormData();
            Form.append('Year', year.toString());
            Form.append('Month', month);
            fetch(url, {
                method: 'POST',
                body: Form
            }).then(response => response.json())
                .then((data) => {
                    if (data) {
                        const Values = Object.values(data.data);
                        DonationReportChart.data.datasets[0].data = Values;
                        DonationReportChart.update();
                    }
                })

        }
    }
    const PrintReport = (reportID, title) => {
        printJS({
            printable: 'branch-report', // ID of the HTML element to be printed
            type: 'html', // Type of content to be printed
            documentTitle: title, // Optional document title
            targetStyles: ['/public/css/framework/utils.cs'], // Optional CSS file to be included
            style: 'table {border-collapse: collapse; width: 100%;} table, th, td {border: 1px solid black; padding: 5px; text-align: center;} table tbody tr:nth-child(even){background-color:#f2f2f2}', // Optional inline CSS
        });

    }

    const DonationReport = (year = null, month = "all") => {
        if (year === null)
            year = new Date().getFullYear();

        const url = "/manager/mngReport/DonationReport";
        const Form = new FormData();
        Form.append('Year', year.toString());
        Form.append('Month', month);
        fetch(url, {
            method: 'POST',
            body: Form
        }).then(response => response.json())
            .then((data) => {
                console.log(data)
                if (data.status) {
                    const BloodGroups = Object.keys(data.data)
                    const Values = Object.values(data.data)
                    OpenDialogBox({
                        id: 'donation--report',
                        title: 'Donation Report - All Over Year - ' + year.toString() + (month !== 'all' ? ' - ' + month.toString() : ''),
                        titleClass: 'text-center bg-dark text-white',
                        minWidth: '85vw',
                        maxWidth: '95vw',
                        maxHeight: '85vh',
                        content: `
                        <div class="d-flex flex-column">
                            <div class="d-flex flex-center gap-2 my-1">
                                <div class="d-flex flex-center gap-0-5">
                                    <label for="year" class="form-label">Year</label>
                                    <select class="form-select" id="year" onchange="ChangeReportOnYearAndMonth(1)" style="width: 150px" aria-label="Default select example">
                                        ${FilterLastFiveYear(data)}
                                    </select>
                                </div>
                                <div class="d-flex flex-center gap-0-5">
                                    <label for="month" class="form-label">Month</label>
                                    <select class="form-select" id="month" onchange="ChangeReportOnYearAndMonth(1)" style="width: 150px" aria-label="Default select example">
                                        <option value="all">All</option>
                                        ${Month(data)}
                                    </select>
                                </div>
                            </div>
                            <canvas id="donation-report" width="400" height="400" style="max-height: 600px"></canvas>
                        </div>
                    `
                    })
                    const ctx = document.getElementById('donation-report').getContext('2d');
                    DonationReportChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: BloodGroups,
                            datasets: [{
                                label: 'Donation',
                                data: Values,
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                ],
                                borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        stepSize: 1
                                    }
                                }
                            },
                            height: 400,
                            animation: {
                                duration: 1000,
                                easing: 'easeInQuad'
                            }
                        }
                    });
                }

            })
    }

    function ViewSponsors(index) {
        const url = "/manager/mngReport/SponsorshipReport";
        fetch(url, {
            method: 'GET',

        }).then((response) => response.json())
            .then((data) => {
                if (data.status) {
                    const val = data.data[index];
                    let tbody = "";
                    if (val.SponsoredDetails) {
                        val.SponsoredDetails.forEach((item, index) => {
                            tbody += `
                                <tr>
                                    <td>${item.SponsorName}</td>
                                    <td>${item.SponsorEmail}</td>
                                    <td>${item.SponsorAmount}</td>
                                    <td>${item.SponsorDate}</td>
                                </tr>
                            `
                        })
                    } else {
                        tbody = `
                            <tr>
                                <td colspan="4" class="text-center text-white" style="background: rgba(0,0,0,0.3)">No Sponsors</td>
                            </tr>
                        `
                    }
                    OpenDialogBox({
                        id: "view-sponsors",
                        title: "View Sponsors",
                        titleClass: 'text-center bg-dark text-white',
                        popupOrder: 1,
                        content: `
                            <div class="d-flex">
                                <div class="d-flex">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">Sponsor Name</th>
                                                <th scope="col">Sponsor Email</th>
                                                <th scope="col">Sponsor Amount</th>
                                                <th scope="col">Sponsor Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ${tbody}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        `
                    })
                }
            })
    }

    const mystate = {
        pdf: null,
        currentPage: 1,
        zoom: 1
    }
    const ViewReport = (report) => {
        pdfjsLib.getDocument(report).promise.then((pdf) => {
            mystate.pdf = pdf;
            render();
        });

        OpenDialogBox({
            id: 'ViewReport',
            title: 'View Report',
            titleClass: 'bg-dark text-white text-center px-2 py-1',
            popupOrder: 2,
            content: `<div id="pdf" class="w-100 h-100">
                    <div id="pdfLoader" class="bg-white w-100 h-100 d-flex justify-content-center align-items-center" style="z-index: 999;height: 90%;margin-top: 35px;">
                        <img src="/public/loading2.svg" alt="" width="100px">
                    </div>
                    <canvas id="canvasContainer" class="none w-100 h-80 max-h-80vh"></canvas>
                    <div id="navigation_controls" class="none d-flex justify-content-center">
                        <button id="go_previous" class="btn btn-info" onclick="prev()">Previous</button>
                        <div id="current_page" class="d-fle font-boldx flex-center" style="width: 100px">1</div>
                        <button id="go_next" class="btn btn-info" onclick="next()">Next</button>
                    </div>
                </div>`,
            showSuccessButton: false,
            cancelBtnText: 'Close',
        })

    }
    const prev = () => {
        if (mystate.currentPage <= 1) {
            return;
        }
        mystate.currentPage -= 1;
        document.getElementById('current_page').innerText = mystate.currentPage;
        render();
    }

    const next = () => {
        if (mystate.currentPage >= mystate.pdf._pdfInfo.numPages) {
            return;
        }
        mystate.currentPage += 1;
        document.getElementById('current_page').innerText = mystate.currentPage;
        render();
    }

    const render = () => {
        mystate.pdf.getPage(mystate.currentPage).then((page) => {
            const canvas = document.getElementById('canvasContainer');
            const ctx = canvas.getContext('2d');

            const viewport = page.getViewport({scale: mystate.zoom});

            canvas.height = viewport.height;
            canvas.width = viewport.width;

            page.render({
                canvasContext: ctx,
                viewport: viewport
            });
            const pdfLoader = document.getElementById('pdfLoader');
            const canvasContainer = document.getElementById('canvasContainer');
            const navigation_controls = document.getElementById('navigation_controls');
            pdfLoader.classList.add('none');
            canvasContainer.classList.remove('none');
            navigation_controls.classList.remove('none');
        });
    }


    const SponsorshipReport = () => {
        const url = "/manager/mngReport/SponsorshipReport";
        fetch(url, {
            method: 'POST',
        }).then((response) => response.json())
            .then((data) => {
                console.log(data)
                if (data.status) {
                    let tbody = '';
                    data.data.forEach((item, index) => {
                        tbody += `
                            <tr>
                                <td style="border: 1px solid black">${index + 1}</td>
                                <td style="border: 1px solid black">${item.CampaignName}</td>
                                <td style="border: 1px solid black">${item.CampaignDate}</td>
                                <td style="border: 1px solid black">${item.SponsorshipAmount}</td>
                                <td style="border: 1px solid black">${item.SponsorshipDate}</td>
                                <td style="border: 1px solid black">${item.SponsorshipStatus}</td>
                                <td style="border: 1px solid black">${item.Transferred}</td>
                                <td style="border: 1px solid black">${item.TransferredDate}</td>
                                <td style="border: 1px solid black">${item.TotalSponsoredAmount}</td>
                                <td style="border: 1px solid black">
                                    <button class="btn btn-sm btn-outline-info" onclick="ViewReport('${item.Report}')">View Report</button>
                                    <button class="btn btn-sm btn-outline-info" onclick="ViewSponsors(${index})">View Sponsors</button>
                                </td>
                            </tr>
                        `
                    })

                    OpenDialogBox({
                        id: "sponsorship--report",
                        title: "Sponsorship Report",
                        titleClass: "text-center bg-dark text-white",
                        minWidth: "85vw",
                        maxWidth: "95vw",
                        maxHeight: "85vh",
                        content: `
                <div class="d-flex flex-column w-100">
                    <div class="d-flex flex-column w-100 overflow-y-overlay" style="max-height:60vh">
                        <table class="table table-bordered w-100">
                            <thead class="sticky top-0" style="z-index:9;">
                                <tr style="border-bottom: 2px solid black">
                                    <th  style="border: 1px solid black">No</th>
                                    <th  style="border: 1px solid black">Campaign Name</th>
                                    <th  style="border: 1px solid black">Campaign Date</th>
                                    <th  style="border: 1px solid black">Expected Amount</th>
                                    <th  style="border: 1px solid black">Requested Date</th>
                                    <th  style="border: 1px solid black">Request Status</th>
                                    <th  style="border: 1px solid black">Transferred</th>
                                    <th  style="border: 1px solid black">Transferred Date</th>
                                    <th  style="border: 1px solid black">Total Sponsored Amount</th>
                                    <th  style="border: 1px solid black">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${tbody}
                            </tbody>
                    </div>
                </div>
            `
                    })
                }
            })
    }

    const ViewCampaign = (index)=>{
            const url = "/manager/mngReport/OfficerReport";
            fetch(url,{
                method : "GET"
            }).then(res=>res.json())
                .then(data=>{
                    if (data.status){
                        const val = data.data[index];
                        if (val){
                            let tbody= '';
                            if (val.Campaign.length>0){
                                val.Campaign.forEach((item,index)=>{
                                    tbody += `
                                    <tr>
                                        <td style="border: 1px solid black" data-label="No">${index + 1}</td>
                                        <td style="border: 1px solid black" data-label="Campaign Name">${item.Campaign_Name}</td>
                                        <td style="border: 1px solid black" data-label="Campaign Date">${item.Campaign_Date}</td>
                                        <td style="border: 1px solid black" data-label="Campaign Status">${item.Campaign_Venue}</td>
                                        <td style="border: 1px solid black" data-label="Campaign Role">${item.Role}</td>
                                        <td style="border: 1px solid black" data-label="Campaign Task">${item.Task}</td>
                                    </tr>
                                `
                                })
                            }else{
                                tbody += `
                                    <tr>
                                        <td colspan="6" class="text-center text-white" style="background: rgba(0,0,0,0.3)">No Campaigns</td>
                                    </tr>
                                `

                            }
                            OpenDialogBox({
                                id:"campaign-officer-report",
                                title:"Campaign Of Officer Report",
                                titleClass:"text-center bg-dark text-white",
                                minWidth:"85vw",
                                maxWidth:"95vw",
                                maxHeight:"85vh",
                                popupOrder:1,
                                content:`
                                    <div class="d-flex">
                                        <div class="d-flex w-100">
                                            <table class="table table-bordered w-100">
                                                <thead class="sticky top-0" style="z-index:9;">
                                                    <tr style="border-bottom: 2px solid black">
                                                        <th  style="border: 1px solid black">No</th>
                                                        <th  style="border: 1px solid black">Campaign Name</th>
                                                        <th  style="border: 1px solid black">Campaign Date</th>
                                                        <th  style="border: 1px solid black">Campaign Venue</th>
                                                        <th  style="border: 1px solid black">Campaign Role</th>
                                                        <th  style="border: 1px solid black">Campaign Task</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    ${tbody}
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                `
                            })
                        }
                    }

                })
    }

    const OfficerReport = () => {
        const url = "/manager/mngReport/OfficerReport";
        fetch(url,{
            method : "GET"
        }).then(res=>res.json())
            .then(data=>{
                if (data.status){
                    let tbody = '';
                    if (data.data){
                        data.data.forEach((item, index) => {
                            tbody += `
                                <tr>
                                    <td style="border: 1px solid black" data-label="No">${index + 1}</td>
                                    <td style="border: 1px solid black" data-label="Full Name">${item.FullName}</td>
                                    <td style="border: 1px solid black" data-label="Email">${item.Email}</td>
                                    <td style="border: 1px solid black" data-label="Phone">${item.Phone}</td>
                                    <td style="border: 1px solid black" data-label="Address">${item.Address}</td>
                                    <td style="border: 1px solid black" data-label="NIC">${item.NIC}</td>
                                    <td style="border: 1px solid black" data-label="Gender">${item.Gender}</td>
                                    <td style="border: 1px solid black" data-label="Nationality">${item.Nationality}</td>
                                    <td style="border: 1px solid black" data-label="Position">${item.Position}</td>
                                    <td style="border: 1px solid black" data-label="TotalCampaigns">${item.TotalCampaigns}</td>
                                    <td style="border: 1px solid black">
                                        <button class="btn btn-sm btn-outline-info" onclick="ViewCampaign(${index})">View Campaigns</button>
                                    </td>
                                </tr>
                            `
                        })
                    }else{
                        tbody = `
                            <tr>
                                <td colspan="10" class="text-center">No Data Found</td>
                            </tr>
                        `
                    }
                    OpenDialogBox({
                        id: "officer--report",
                        title: "Officer Report",
                        titleClass: "text-center bg-dark text-white",
                        minWidth: "85vw",
                        maxWidth: "95vw",
                        maxHeight: "85vh",
                        content: `
                            <div class="d-flex flex-column w-100">
                    <div class="d-flex flex-column w-100 overflow-y-overlay" style="max-height:60vh">
                        <table class="table table-bordered w-100">
                            <thead class="sticky top-0" style="z-index:9;">
                                <tr style="border-bottom: 2px solid black">
                                    <th  style="border: 1px solid black">No</th>
                                    <th  style="border: 1px solid black">Full Name</th>
                                    <th  style="border: 1px solid black">Email</th>
                                    <th  style="border: 1px solid black">Contact No</th>
                                    <th  style="border: 1px solid black">Address</th>
                                    <th  style="border: 1px solid black">NIC</th>
                                    <th  style="border: 1px solid black">Gender</th>
                                    <th  style="border: 1px solid black">Nationality</th>
                                    <th  style="border: 1px solid black">Position</th>
                                    <th  style="border: 1px solid black">Total Campaigns</th>

                                    <th  style="border: 1px solid black">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${tbody}
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
