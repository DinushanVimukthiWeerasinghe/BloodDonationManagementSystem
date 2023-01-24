<?php

use App\controller\adminController;
use App\controller\apiController;
use App\controller\authController;
use App\controller\donorController;
use App\controller\fileController;
use App\controller\managerController;
use App\controller\siteController;
use Core\Application;


require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();
$config=[
    'db'=>[
        'dsn'=>$_ENV['DB_DSN'],
        'user'=>$_ENV['DB_USER'],
        'password'=>$_ENV['DB_PASSWORD']
    ],
    'email'=>[
        'host'=>$_ENV['EMAIL_HOST'],
        'port'=>$_ENV['EMAIL_PORT'],
        'username'=>$_ENV['EMAIL_USERNAME'],
        'password'=>$_ENV['EMAIL_PASSWORD'],
        'encryption'=>$_ENV['EMAIL_ENCRYPTION'],
        'from'=>$_ENV['EMAIL_FROM']
    ]
];


try {
    $app = new Application(dirname(__DIR__), $config);
} catch (\PHPMailer\PHPMailer\Exception $e) {
    echo $e->getMessage();
}
//Application::CreateDirectories(['public/upload/Profile/Donors','public/upload/Profile/Managers','public/upload/Profile/MedicalOfficers','public/upload/Profile/Receivers']);
$app->forbiddenRoute->setForbiddenRotes([
    'manager'=>['/manager/dashboard']
]);

//$app->db->applyMigrations();
$app->router->get('/', [siteController::class, 'home']);
$app->router->get('/home', [siteController::class, 'home']);
$app->router->get('/about', [siteController::class, 'about']);
$app->router->get('/loader', [siteController::class, 'Loader']);
$app->router->get('/contact', [siteController::class, 'contact']);
$app->router->post('/contact', [siteController::class, 'contact']);
$app->router->get('/user/register', [siteController::class, 'userRegister']);
$app->router->post('/user/register', [siteController::class, 'userRegister']);

//Logout
$app->router->get('/logout', [authController::class, 'logout']);
$app->router->get('/login', [authController::class, 'UserLogin']);
$app->router->post('/login', [authController::class, 'UserLogin']);


$app->router->get('/admin/login', [adminController::class, 'login']);
$app->router->post('/admin/login', [adminController::class, 'login']);
$app->router->get('/admin/register', [adminController::class, 'register']);
$app->router->post('/admin/register', [adminController::class, 'register']);
$app->router->get('/admin/dashboard', [adminController::class, 'adminBoard']);
$app->router->get('/admin/dashboard/adminBoard', [adminController::class, 'adminBoard']);
$app->router->post('/admin/dashboard', [adminController::class, 'adminBoard']);
$app->router->get('/admin/dashboard/manageUsers', [adminController::class, 'manageUsers']);
$app->router->get('/admin/dashboard/manageDonors', [adminController::class, 'manageDonors']);
$app->router->get('/admin/dashboard/manageAlerts', [adminController::class, 'manageAlerts']);
$app->router->get('/admin/dashboard/manageSetting', [adminController::class, 'manageSetting']);
$app->router->get('/admin/dashboard/manageTransactions', [adminController::class, 'manageTransactions']);
$app->router->get('/admin/dashboard/manageBanks', [adminController::class, 'manageBanks']);
$app->router->post('/upload', [fileController::class, 'upload']);




// Manager Register
$app->router->get('/manager/register', [managerController::class, 'register']);
$app->router->post('/manager/register', [managerController::class, 'register']);

//Manager Dashboard
$app->router->get('/manager/dashboard', [managerController::class, 'dashboard']);
$app->router->get('/manager/profile', [managerController::class, 'Profile']);
$app->router->get('/manager/notification', [managerController::class, 'Notification']);


$app->router->get('/manager/mngMedicalOfficer', [managerController::class, 'ManageMedicalOfficer']);

$app->router->get('/manager/mngMedicalOfficer/add', [managerController::class, 'AddMedicalOfficer']);
$app->router->post('/manager/mngMedicalOfficer/add', [managerController::class, 'AddMedicalOfficer']);

$app->router->get('/manager/mngMedicalOfficer/search', [managerController::class, 'SearchMedicalOfficer']);

$app->router->get('/manager/mngRequests', [managerController::class, 'ManageRequests']);
$app->router->post('/manager/mngRequests', [managerController::class, 'ManageRequests']);
$app->router->get('/manager/mngRequests/er', [managerController::class, 'ManageEmergencyRequests']);

$app->router->get('/manager/mngCampaign/view', [managerController::class, 'ViewCampaign']);
$app->router->post('/manager/mngCampaign/view', [managerController::class, 'ViewCampaign']);


$app->router->get('/manager/mngSponsorship', [managerController::class, 'ManageSponsors']);
$app->router->post('/manager/mngSponsorship', [managerController::class, 'ManageSponsors']);

$app->router->get('/manager/mngDonors', [managerController::class, 'ManageDonors']);
$app->router->post('/manager/mngDonors', [managerController::class, 'ManageDonors']);

$app->router->get('/manager/mngCampaigns', [managerController::class, 'ManageCampaigns']);
$app->router->post('/manager/mngCampaigns', [managerController::class, 'ManageCampaigns']);

$app->router->get('/manager/mngReport', [managerController::class, 'ManageReport']);
$app->router->post('/manager/mngReport', [managerController::class, 'ManageReport']);


$app->router->post('/manager/upload', [managerController::class, 'upload']);



//View Medical Officer
$app->router->get('/manager/mngMedicalOfficer/view', [managerController::class, 'ViewMedicalOfficer']);
$app->router->post('/manager/mngMedicalOfficer/view', [managerController::class, 'ViewMedicalOfficer']);

//Manage Donors

//Find Donor
$app->router->get('/manager/mngDonors/find', [managerController::class, 'FindDonor']);
//$app->router->post('/manager/mngDonors/find', [managerController::class, 'FindDonor']);

//Manage Requests
$app->router->get('/manager/mngRequests/emergency', [managerController::class, 'ManageEmergencyRequests']);
//$app->router->post('/manager/mngRequests/emergency', [managerController::class, 'FindRequests']);


$app->router->get('/api/bbank/getall', [apiController::class, 'getBloodBanks']);



//print_r($_SESSION);
$app->run();