<link rel="stylesheet" href="/public/css/home.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<div class="dark-bg"></div>
<?php

use App\view\components\ResponsiveComponent\NavbarComponent\AuthNavbar;
use App\view\components\ResponsiveComponent\NavbarComponent\Navbar;

$navbar= new Navbar([
    'Home'=>'/home',
    'Services'=>'#service-panel',
    'Contact'=>'#contact-us-panel',
    'Register'=>'/user/register'
],'#','/public/images/icons/user.png','');
echo AuthNavbar::getNavbarCSS();
echo $navbar;
echo AuthNavbar::getNavbarJS();
?>

<div id="home">
    <section id="welcome-panel" class="panel">
        <div class="sub-panel">
            <div class="intro">
                <div id="caption">
                    <span class="main-tagline">Donate Blood <br>Save Life</span>
                    <span id="description">" The Blood You Donate Gives Someone Another Chance At Life "</span>
                    <span id="description-2">" The Blood You Donate Gives Someone Another Chance At Life "</span>
                    <a id="donate-btn" href="/login" class="btn btn-primary">Donate Now</a>
                </div>
                <div class="image-welcome">
                    <img src="/public/images/bd-home.png" alt="">
                </div>
            </div>
            <div class="nav-card">
                <a href="#intro-panel" class="card btn btn-primary">Why Donation</a>
                <a href="#organize-camp-panel" class="card btn btn-primary">Organize Blood Camp</a>
                <a href="#service-panel" class="card btn btn-primary">Our Services</a>
            </div>

        </div>
    </section>
    <section id="intro-panel" class="panel">
        <div class="sub-panel d-flex-row">
            <div class="intro">
                <div class="desc-image">
                    <img src="/public/images/bd-home.png" alt="">
                </div>
                <div id="caption">
                    <div class="tagline">Why Blood Donation Important ?</div>
                    <div class="desc">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Error ex optio qui ratione ullam. Adipisci amet architecto aut culpa cum delectus dicta dolorem, enim impedit iste itaque placeat possimus quasi qui quidem quod quos rem tempora, unde veniam. Debitis molestias nisi vel? Asperiores, optio, quaerat!</div>
                    <div class="btn-container">
                        <a id="donate-btn" href="#blood-info-panel" class="btn btn-primary">Learn More </a>
                        <a id="donate-btn" href="#donation-report" class="btn btn-primary">View Report </a>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <section id="organize-camp-panel" class="panel">
        <div class="sub-panel d-flex-row">
            <div class="intro">
                <div id="caption">
                    <div class="tagline">Organize Blood Campaign</div>
                    <span class="desc">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Error ex optio qui ratione ullam. Adipisci amet architecto aut culpa cum delectus dicta dolorem, enim impedit iste itaque placeat possimus quasi qui quidem quod quos rem tempora, unde veniam. Debitis molestias nisi vel? Asperiores, optio, quaerat!</span>
                    <a id="donate-btn" href="#donate-panel" class="btn btn-primary">Organize Camp </a>
                </div>
                <div class="desc-image">
                    <img src="/public/images/bd-home.png" alt="">
                </div>
            </div>
        </div>
    </section>
    <section id="blood-info-panel" class="panel">
        <div class="sub-panel d-flex-row">
            <div class="intro">
                <div class="desc-image">
                    <img src="/public/images/blood-cells.jpg" width="600px" alt="">
                </div>
                <div id="caption">
                    <div class="tagline">Importance Of Blood</div>
                    <span class="desc">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Error ex optio qui ratione ullam. Adipisci amet architecto aut culpa cum delectus dicta dolorem, enim impedit iste itaque placeat possimus quasi qui quidem quod quos rem tempora, unde veniam. Debitis molestias nisi vel? Asperiores, optio, quaerat!</span>
                </div>
            </div>
        </div>
    </section>
    <section id="donation-report" class="panel">
        <div class="sub-panel d-flex-row">
            <div class="intro" id="intro">
                <div id="caption">
                    <div class="tagline">Blood Donation Statistics</div>
                </div>
                <div class="chart-panel">
                        <canvas id="myChart"></canvas>
                        <canvas id="myCharts"></canvas>
                </div>

                <script src="/public/scripts/chartjs/chartjs.js"></script>

                <script>
                    const xValues = ["Colombo", "Gampaha", "Galle", "Kandy", "Other"];
                    const yValues = [550, 490, 440, 240, 150];
                    const barColors = [
                        "#b91d47",
                        "#00aba9",
                        "#2b5797",
                        "#e8c3b9",
                        "#1e7145"
                    ];


                    new Chart("myChart", {
                        type: "pie",
                        data: {
                            labels: xValues,
                            datasets: [{
                                backgroundColor: barColors,
                                data: yValues,
                            }],
                        },
                        options: {
                            plugins: {
                                title: {
                                    display: true,
                                    text: 'Blood Donation By District',
                                    padding: {
                                        top: 10,
                                        bottom: 30
                                    },
                                    font: {
                                        size: 20
                                    },
                                    position: 'bottom'
                                }
                            }
                        }
                    });

                    const xfValues = [2012, 2013, 2014, 2015, 2016, 2017, 2018, 2019, 2020, 2021];

                    new Chart("myCharts", {
                        type: "line",
                        data: {
                            labels: xfValues,
                            datasets: [{
                                data: [1200,1400,1800,2000,2800,2900,3200,2800,4500,6000],
                                borderColor: "red",
                                fill: false,
                                label: "Blood Requirement"
                            }, {
                                data: [400,550,750,1000,1200,1600,2000,2600,2400,4800],
                                borderColor: "green",
                                fill: false,
                                label: "Blood Availability"
                            }]
                        },
                        options: {
                            legend: {display: false},
                            plugins: {
                                title: {
                                    display: true,
                                    text: 'Blood Requirement & Availability',
                                    padding: {
                                        top: 10,
                                        bottom: 30
                                    },
                                    font: {
                                        size: 20
                                    },
                                    position: 'bottom'
                                }
                            }
                        }
                    });
                </script>
<!--                <div class="desc-image">-->
<!--                    <img src="/public/images/blood-cells.jpg" width="600px" alt="">-->
<!--                </div>-->
            </div>
        </div>
    </section>

    <section id="service-panel" class="panel">
        <div class="sub-panel d-flex-row">
            <div class="intro">
                <div id="caption">
                    <div class="tagline">Our Services</div>
                    <div class="serv-list">
<!--                        <div class="service">-->
<!--                            <div class="srv-img"><img src="/public/images/campaign.png" alt="" width="200px"></div>-->
<!--                            <div class="srv-desc">Manage Campaign</div>-->
<!--                        </div>-->
                        <div class="service">
                            <div class="srv-img"><img src="/public/images/realtime.png" alt="" width="200px"></div>
                            <div class="srv-desc">Manage Campaign</div>
                        </div>
                        <div class="service">
                            <div class="srv-img"><img src="/public/images/24hour.png" alt="" width="200px"></div>
                            <div class="srv-desc">Manage Campaign</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="contact-us-panel" class="panel">
        <div class="sub-panel d-flex-row">
            <div class="intro">
                <div class="desc-image">
                    <img src="/public/images/contact-us.png" width="400px" alt="">
                </div>
                <div id="caption">
                    <div class="tagline">Contact Us</div>
                    <div class="cu-form">
                        <form action="" method="post">
                            <div class="content">
                                <label for="subject"></label>
                                <input id="subject" type="text" name="subject" placeholder="Subject">
                                <label for="message"></label>
                                <textarea id="message" name="message" placeholder="Message"></textarea>
                                <button type="submit" class="btn btn-primary">Send</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

