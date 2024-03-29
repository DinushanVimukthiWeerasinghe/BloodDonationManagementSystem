<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="apple-touch-icon" sizes="180x180" href="/public/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/public/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/public/favicon/favicon-16x16.png">
    <link rel="manifest" href="/public/favicon/site.webmanifest">


<!--    <link rel="stylesheet" href="/public/css/framework/util/width.css"-->


    <script
        src="https://maps.googleapis.com/maps/api/js?key=<?=$_ENV['MAP_API_KEY'];?>&callback=initMap&v=weekly&libraries=places"
        defer
    ></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.min.js"></script>
    <link rel="stylesheet" href="/public/css/custom/admin/index.css">
    <link rel="stylesheet" href="/public/css/card.css">
    <link rel="stylesheet" href="/public/css/framework/utils.css">
    <script src="https://kit.fontawesome.com/185eb0391e.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js">></script>


    <title>Admin</title>
</head>
<body>

<!--    <div class="dialog-box" id="dialog-1">-->
<!--        <div class="dialog-title">Title</div>-->
<!--        <div class="dialog-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid amet aperiam dicta dolorem esse eum minima natus obcaecati praesentium tempore.</div>-->
<!--        <div class="dialog-action">-->
<!--            <button class="btn btn-success" onclick="run()" data-close>Ok</button>-->
<!--            <button class="btn btn-danger" data-close>Cancel</button>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="dialog-box" id="dialog-2">-->
<!--        <div class="dialog-title">Title 2</div>-->
<!--        <div class="dialog-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid amet aperiam dicta dolorem esse eum minima natus obcaecati praesentium tempore.</div>-->
<!--        <div class="dialog-action">-->
<!--            <button class="btn btn-success" onclick="run()" data-close>Ok</button>-->
<!--            <button class="btn btn-danger" data-close>Cancel</button>-->
<!--        </div>-->
<!--    </div>-->
<script>
    function run(){
    }
</script>
<div class="side-bar">
    <div class="side-bar-header">
        <div class="side-bar-header-image mt-1"><img src="/public/images/logo.png" width="80rem" alt=""></div>
        <div class="side-bar-header-text">Be Positive</div>
    </div>
        <div class="side-bar-links">
            <div onclick="RenderPage()" class="side-bar-link side-bar-link-active" id="adminBoard">
                <a >
                    <img src="/public/images/icons/admin/dashboard/dash.png" width="40rem" alt="">
                    <span class="nav-link-text">DashBoard</span>
                </a>
            </div>
<!--            <div onclick="RenderPage('manageDonors')" class="side-bar-link" id="manageDonors">-->
<!--                <a >-->
<!--                    <img src="/public/images/icons/admin/dashboard/donation.png" width="40rem" alt="">-->
<!--                    <span class="nav-link-text">Donors</span>-->
<!--                </a>-->
<!--            </div>-->
            <div onclick="RenderPage('manageBanks')" class="side-bar-link" id="manageBanks">
                <a >
                    <img src="/public/images/icons/admin/dashboard/blood-bank.png" width="40rem" alt="">
                    <span class="nav-link-text">Blood Bank</span>
                </a>
            </div>
            <div onclick="RenderPage('manageUsers')" class="side-bar-link" id="manageUsers">
                <a>
                    <img src="/public/images/icons/admin/dashboard/users.png" width="40rem" alt="">
                    <span class="nav-link-text">Users</span>
                </a>
            </div>
            <div onclick="RenderPage('manageTransactions')" class="side-bar-link" id="manageTransactions">
                <a>
                    <img src="/public/images/icons/admin/dashboard/transaction.png" width="40rem" alt="">
                    <span class="nav-link-text">Transactions</span>
                </a>
            </div>
            <div onclick="RenderPage('manageAlerts')" class="side-bar-link" id="manageAlerts">
                <a>
                    <img src="/public/images/icons/admin/dashboard/alert.png" width="40rem" alt="">
                    <span class="nav-link-text">Alerts</span>
                </a>
            </div>
            <div onclick="RenderPage('manageSetting')" class="side-bar-link" id="manageSetting">
                <a>
                    <img src="/public/images/icons/admin/dashboard/setting.png" width="40rem" alt="">
                    <span class="nav-link-text">Site Setting</span>
                </a>
            </div>
        </div>
    <div class="nav-footer">
        <div class="footer-text"></div>
    </div>
</div>
<div class="top-bar">
    <div class="top-bar-header">
            <div class="top-bar-header-image pointer" onclick="ToggleSideBar()"><img src="/public/images/icons/topbar/menu.png" alt=""></div>
    </div>
    <div class="top-bar-links">
        <div class="top-bar-link">
            <button onclick="window.location.href='/logout'" class="btn btn-primary mr-1">Logout</button>
        </div>
    </div>
</div>

<div class="content">
    {{content}}
</div>
</body>
<script src="/public/js/components/dialog-box/dialog-box.js"></script>
<script src="/public/js/components/toasts/toast.js"></script>
<script src="/public/js/admin/manageBanks.js"></script>
<script src="/public/js/admin/manageUsers.js"></script>
<script src="/public/js/admin/manageSetting.js"></script>
<script src="/public/js/admin/manageNotifications.js"></script>
<script src="/public/js/admin/admin.js"></script>
</html>
