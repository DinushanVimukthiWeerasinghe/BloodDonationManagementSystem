<?php

?>
<div class="bg-white-0-3 p-1 border-radius-6 flex-wrap w-60 align-self-center d-flex justify-content-center ">
    <div class="card nav-card" onclick="BranchReport()">
        <div class="card-header">
            <img src="/public/images/icons/manager/manageReport/generateReport2.png" alt="">
            <div class="header-title"> Campaign Report</div>
        </div>
    </div>
    <div class="card nav-card">
        <div class="card-header">
            <img src="/public/images/icons/manager/manageReport/health-report.png" alt="">
            <div class="header-title"> Donation Report</div>
        </div>
    </div>
    <div class="card nav-card">
        <div class="card-header">
            <img src="/public/images/icons/manager/manageReport/health-report.png" alt="">
            <div class="header-title">Sponsorship Reports</div>
        </div>
    </div>
    <div class="card nav-card">
        <div class="card-header">
            <img src="/public/images/icons/manager/manageReport/health-report.png" alt="">
            <div class="header-title">Campaign Reports</div>
        </div>
    </div>
   <div class="card nav-card">
        <div class="card-header">
            <img src="/public/images/icons/manager/manageReport/health-report.png" alt="">
            <div class="header-title">Transfusion Reports</div>
        </div>

   </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script>
<script src="/public/js/html2canvas.min.js"></script>
<script>
    const BranchReport = ()=>{
        OpenDialogBox({
            id:'branch-report',
            title:'Donation Campaign Report',
            titleClass:'text-center bg-dark text-white',
            minWidth:'85vw',
            content:`
                <div id="branch-report" xmlns="http://www.w3.org/1999/html">
                    <div class="d-flex gap-1  justify-content-center">
                        <div class="d-flex border-2 flex-column">
                            <div class="d-flex">
                                <table class="">
                                    <thead>
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
                                            <th  style="border: 1px solid black">Date</th>
                                            <th  style="border: 1px solid black">Venue</th>
                                            <th  style="border: 1px solid black">Name</th>
                                            <th  style="border: 1px solid black">Type</th>
                                            <th  style="border: 1px solid black">Successful</th>
                                            <th  style="border: 1px solid black">Unsuccessful</th>
                                            <th  style="border: 1px solid black">Total</th>
                                            <th  style="border: 1px solid black">ID</th>
                                            <th  style="border: 1px solid black">Leader</th>
                                            <th  style="border: 1px solid black">No Members</th>
                                            <th  style="border: 1px solid black">Amount</th>
                                            <th  style="border: 1px solid black">By</th>
                                            <th  style="border: 1px solid black">Tr. Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Donation Campaign 1</td>
                                            <td>2021-01-01</td>
                                            <td>Colombo</td>
                                            <td>Org 1</td>
                                            <td>NGO</td>
                                            <td>100</td>
                                            <td>50</td>
                                            <td>150</td>
                                            <td>400</td>
                                            <td>Team 01</td>
                                            <td>200017800595</td>
                                            <td>5</td>
                                            <td>20000</td>
                                            <td>Sahana Pvt</td>
                                            <td>2023-03-24</td>
                                        </tr>
                                        <tr>
                                            <td>Donation Campaign 1</td>
                                            <td>2021-01-01</td>
                                            <td>Colombo</td>
                                            <td>Org 1</td>
                                            <td>NGO</td>
                                            <td>100</td>
                                            <td>50</td>
                                            <td>150</td>
                                            <td>400</td>
                                            <td>Team 01</td>
                                            <td>200017800595</td>
                                            <td>5</td>
                                            <td>20000</td>
                                            <td>Sahana Pvt</td>
                                            <td>2023-03-24</td>
                                        </tr>
                                        <tr>
                                            <td>Donation Campaign 1</td>
                                            <td>2021-01-01</td>
                                            <td>Colombo</td>
                                            <td>Org 1</td>
                                            <td>NGO</td>
                                            <td>100</td>
                                            <td>50</td>
                                            <td>150</td>
                                            <td>400</td>
                                            <td>Team 01</td>
                                            <td>200017800595</td>
                                            <td>5</td>
                                            <td>20000</td>
                                            <td>Sahana Pvt</td>
                                            <td>2023-03-24</td>
                                        </tr>
                                        <tr>
                                            <td>Donation Campaign 1</td>
                                            <td>2021-01-01</td>
                                            <td>Colombo</td>
                                            <td>Org 1</td>
                                            <td>NGO</td>
                                            <td>100</td>
                                            <td>50</td>
                                            <td>150</td>
                                            <td>400</td>
                                            <td>Team 01</td>
                                            <td>200017800595</td>
                                            <td>5</td>
                                            <td>20000</td>
                                            <td>Sahana Pvt</td>
                                            <td>2023-03-24</td>
                                        </tr>
                                        <tr>
                                            <td>Donation Campaign 1</td>
                                            <td>2021-01-01</td>
                                            <td>Colombo</td>
                                            <td>Org 1</td>
                                            <td>NGO</td>
                                            <td>100</td>
                                            <td>50</td>
                                            <td>150</td>
                                            <td>400</td>
                                            <td>Team 01</td>
                                            <td>200017800595</td>
                                            <td>5</td>
                                            <td>20000</td>
                                            <td>Sahana Pvt</td>
                                            <td>2023-03-24</td>
                                        </tr>
                                        <tr>
                                            <td>Donation Campaign 1</td>
                                            <td>2021-01-01</td>
                                            <td>Colombo</td>
                                            <td>Org 1</td>
                                            <td>NGO</td>
                                            <td>100</td>
                                            <td>50</td>
                                            <td>150</td>
                                            <td>400</td>
                                            <td>Team 01</td>
                                            <td>200017800595</td>
                                            <td>5</td>
                                            <td>20000</td>
                                            <td>Sahana Pvt</td>
                                            <td>2023-03-24</td>
                                        </tr>
                                        <tr>
                                            <td>Donation Campaign 1</td>
                                            <td>2021-01-01</td>
                                            <td>Colombo</td>
                                            <td>Org 1</td>
                                            <td>NGO</td>
                                            <td>100</td>
                                            <td>50</td>
                                            <td>150</td>
                                            <td>400</td>
                                            <td>Team 01</td>
                                            <td>200017800595</td>
                                            <td>5</td>
                                            <td>20000</td>
                                            <td>Sahana Pvt</td>
                                            <td>2023-03-24</td>
                                        </tr>
                                        <tr>
                                            <td>Donation Campaign 1</td>
                                            <td>2021-01-01</td>
                                            <td>Colombo</td>
                                            <td>Org 1</td>
                                            <td>NGO</td>
                                            <td>100</td>
                                            <td>50</td>
                                            <td>150</td>
                                            <td>400</td>
                                            <td>Team 01</td>
                                            <td>200017800595</td>
                                            <td>5</td>
                                            <td>20000</td>
                                            <td>Sahana Pvt</td>
                                            <td>2023-03-24</td>
                                        </tr>
                                        <tr>
                                            <td>Donation Campaign 1</td>
                                            <td>2021-01-01</td>
                                            <td>Colombo</td>
                                            <td>Org 1</td>
                                            <td>NGO</td>
                                            <td>100</td>
                                            <td>50</td>
                                            <td>150</td>
                                            <td>400</td>
                                            <td>Team 01</td>
                                            <td>200017800595</td>
                                            <td>5</td>
                                            <td>20000</td>
                                            <td>Sahana Pvt</td>
                                            <td>2023-03-24</td>
                                        </tr>
                                        <tr>
                                            <td>Donation Campaign 1</td>
                                            <td>2021-01-01</td>
                                            <td>Colombo</td>
                                            <td>Org 1</td>
                                            <td>NGO</td>
                                            <td>100</td>
                                            <td>50</td>
                                            <td>150</td>
                                            <td>400</td>
                                            <td>Team 01</td>
                                            <td>200017800595</td>
                                            <td>5</td>
                                            <td>20000</td>
                                            <td>Sahana Pvt</td>
                                            <td>2023-03-24</td>
                                        </tr>
                                        <tr>
                                            <td>Donation Campaign 1</td>
                                            <td>2021-01-01</td>
                                            <td>Colombo</td>
                                            <td>Org 1</td>
                                            <td>NGO</td>
                                            <td>100</td>
                                            <td>50</td>
                                            <td>150</td>
                                            <td>400</td>
                                            <td>Team 01</td>
                                            <td>200017800595</td>
                                            <td>5</td>
                                            <td>20000</td>
                                            <td>Sahana Pvt</td>
                                            <td>2023-03-24</td>
                                        </tr>
                                        <tr>
                                            <td>Donation Campaign 1</td>
                                            <td>2021-01-01</td>
                                            <td>Colombo</td>
                                            <td>Org 1</td>
                                            <td>NGO</td>
                                            <td>100</td>
                                            <td>50</td>
                                            <td>150</td>
                                            <td>400</td>
                                            <td>Team 01</td>
                                            <td>200017800595</td>
                                            <td>5</td>
                                            <td>20000</td>
                                            <td>Sahana Pvt</td>
                                            <td>2023-03-24</td>
                                        </tr>
                                        <tr>
                                            <td>Donation Campaign 1</td>
                                            <td>2021-01-01</td>
                                            <td>Colombo</td>
                                            <td>Org 1</td>
                                            <td>NGO</td>
                                            <td>100</td>
                                            <td>50</td>
                                            <td>150</td>
                                            <td>400</td>
                                            <td>Team 01</td>
                                            <td>200017800595</td>
                                            <td>5</td>
                                            <td>20000</td>
                                            <td>Sahana Pvt</td>
                                            <td>2023-03-24</td>
                                        </tr>
                                        <tr>
                                            <td>Donation Campaign 1</td>
                                            <td>2021-01-01</td>
                                            <td>Colombo</td>
                                            <td>Org 1</td>
                                            <td>NGO</td>
                                            <td>100</td>
                                            <td>50</td>
                                            <td>150</td>
                                            <td>400</td>
                                            <td>Team 01</td>
                                            <td>200017800595</td>
                                            <td>5</td>
                                            <td>20000</td>
                                            <td>Sahana Pvt</td>
                                            <td>2023-03-24</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            `,
                   successBtnText:'Print',
                   successBtnAction:()=>{
                       console.log('Print')
                       PrintReport('donation--report','Branch Report')
                   },
               })
           }
           const PrintReport = (reportID,title)=>{
               printJS({
                   printable: 'branch-report', // ID of the HTML element to be printed
                   type: 'html', // Type of content to be printed
                   documentTitle: title, // Optional document title
                   targetStyles: ['/public/css/framework/utils.cs'], // Optional CSS file to be included
                   style: 'table {border-collapse: collapse; width: 100%;} table, th, td {border: 1px solid black; padding: 5px; text-align: center;} table tbody tr:nth-child(even){background-color:#f2f2f2}', // Optional inline CSS
               });

    }
</script>
