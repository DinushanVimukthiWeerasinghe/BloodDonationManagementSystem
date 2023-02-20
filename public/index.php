<?php

use App\controller\adminController;
use App\controller\apiController;
use App\controller\authController;
use App\controller\blogController;
use App\controller\donorController;
use App\controller\fileController;
use App\controller\OrganizationController;
use App\controller\hospitalController;
use App\controller\managerController;
use App\controller\medicalOfficerController;
use App\controller\siteController;
use App\controller\sponsorController;
use Core\Application;


require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();
$config=[
    'db'=>[
        'dsn'=>$_ENV['DB_DSN'],
        'user'=>$_ENV['DB_USER'],
        'password'=>$_ENV['DB_PASSWORD'] ?? ''
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
$app->router->get('/register', [authController::class, 'UserRegister']);
$app->router->post('/register', [authController::class, 'UserRegister']);

//Logout
$app->router->get('/logout', [authController::class, 'logout']);
$app->router->get('/login', [authController::class, 'UserLogin']);
$app->router->post('/login', [authController::class, 'UserLogin']);
$app->router->get('/otp', [authController::class, 'OTP']);
$app->router->get('/otp/validate', [authController::class, 'OTPValidation']);
$app->router->get('/otp/resend', [authController::class, 'ResendOTP']);
$app->router->post('/otp/validate', [authController::class, 'OTPValidation']);
$app->router->get('/resetPassword', [authController::class, 'ResetPassword']);
$app->router->post('/resetPassword', [authController::class, 'ResetPassword']);


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

$app->router->post('/user/resetPassword', [adminController::class, 'ResetPassword']);
$app->router->post('/user/removeUser', [adminController::class, 'RemoveUser']);
$app->router->post('/user/reActivateUser', [adminController::class, 'ReactivateUser']);
$app->router->post('/user/deactivateUser', [adminController::class, 'DeactivateUser']);
$app->router->post('/user/activateUser', [adminController::class, 'ActivateUser']);
$app->router->post('/user/searchUser', [adminController::class, 'SearchUser']);
$app->router->get('/user/searchUser', [adminController::class, 'SearchUser']);

$app->router->post('/upload', [fileController::class, 'upload']);

$app->router->get('/test',[siteController::class,'test']);

$app->router->get('/organization/register', [OrganizationController::class, 'register']);
$app->router->post('/organization/register', [OrganizationController::class, 'register']);
$app->router->get('/organization/dashboard', [OrganizationController::class, 'dashboard']);
$app->router->get('/organization/create', [OrganizationController::class, 'create']);
$app->router->get('/organization/history', [OrganizationController::class, 'history']);
$app->router->get('/organization/home', [OrganizationController::class, 'home']);
$app->router->get('/organization/inform', [OrganizationController::class, 'inform']);
$app->router->post('/organization/inform', [OrganizationController::class, 'inform']);
$app->router->get('/organization/manage', [OrganizationController::class, 'manage']);
$app->router->get('/organization/campaign/create', [OrganizationController::class, 'CreateCampaign']);
$app->router->post('/organization/campaign/create', [OrganizationController::class, 'CreateCampaign']);
$app->router->get('/organization/campaign/view', [OrganizationController::class, 'ViewCampaign']);
$app->router->post('/organization/campaign/view', [OrganizationController::class, 'ViewCampaign']);
$app->router->get('/organization/near', [OrganizationController::class, 'near']);
$app->router->get('/organization/report', [OrganizationController::class, 'report']);
$app->router->get('/organization/history', [OrganizationController::class, 'history']);
$app->router->get('/organization/guideline', [OrganizationController::class, 'guideline']);
$app->router->get('/organization/request', [OrganizationController::class, 'request']);
$app->router->post('/organization/request', [OrganizationController::class, 'request']);
$app->router->get('/organization/campDetails', [OrganizationController::class, 'campDetails']);
$app->router->get('/organization/received', [OrganizationController::class, 'received']);
$app->router->get('/organization/accepted', [OrganizationController::class, 'accepted']);
$app->router->get('/organization/profile', [OrganizationController::class, 'profile']);
$app->router->get('/organization/campaign/view', [OrganizationController::class, 'view']);

//sponsor

$app->router->get('/sponsors/dashboard', [sponsorController::class, 'dashboard']);
$app->router->get('/sponsors/history', [sponsorController::class, 'history']);
$app->router->get('/sponsors/manage', [sponsorController::class, 'manage']);
$app->router->get('/sponsors/donation', [sponsorController::class, 'donation']);
$app->router->get('/sponsors/campDetails', [sponsorController::class, 'campDetails']);
$app->router->get('/sponsors/guideline', [sponsorController::class, 'guideline']);



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
$app->router->post('/manager/mngMedicalOfficer/delete', [managerController::class, 'DeleteMedicalOfficer']);

$app->router->post('/manager/mngMedicalOfficer/search', [managerController::class, 'SearchMedicalOfficer']);

$app->router->get('/manager/mngRequests', [managerController::class, 'ManageRequests']);
$app->router->post('/manager/mngRequests', [managerController::class, 'ManageRequests']);
$app->router->post('/manager/mngRequests/find', [managerController::class, 'FindRequest']);
$app->router->get('/manager/mngRequests/er', [managerController::class, 'ManageEmergencyRequests']);

$app->router->post('/manager/mngCampaign/view', [managerController::class, 'ViewCampaign']);
$app->router->post('/manager/mngCampaign/reject', [managerController::class, 'RejectCampaign']);
$app->router->post('/manager/mngCampaign/view', [managerController::class, 'ViewCampaign']);
$app->router->get('/manager/mngCampaign/assign-team', [managerController::class, 'AssignTeam']);


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
//$app->router->get('/manager/mngMedicalOfficer/view', [managerController::class, 'ViewMedicalOfficer']);
$app->router->post('/manager/mngMedicalOfficer/get', [managerController::class, 'ViewMedicalOfficer']);
$app->router->post('/manager/mngMedicalOfficer/update', [managerController::class, 'UpdateMedicalOfficer']);
$app->router->post('/manager/mngMedicalOfficer/sendEmail', [managerController::class, 'SendEmail']);
$app->router->get('/manager/mngMedicalOfficer/sendEmail', [managerController::class, 'SendEmail']);

//Manage Donors

//Find Donor
$app->router->get('/manager/mngDonors/find', [managerController::class, 'FindDonor']);
$app->router->post('/manager/mngDonors/find', [managerController::class, 'FindDonor']);
$app->router->post('/manager/mngDonors/isExist', [managerController::class, 'IsDonorExist']);
$app->router->get('/manager/mngDonors/reportedDonor', [managerController::class, 'ReportedDonor']);
$app->router->get('/manager/mngDonors/informDonor', [managerController::class, 'InformDonor']);
$app->router->post('/manager/mngDonors/informDonor', [managerController::class, 'InformDonor']);
//$app->router->post('/manager/mngDonors/find', [managerController::class, 'FindDonor']);


//Medical Officer
$app->router->get('/medicalofficer/dashboard', [medicalOfficerController::class, 'Dashboard']);

//Manage Requests
$app->router->get('/manager/mngRequests/emergency', [managerController::class, 'ManageEmergencyRequests']);
$app->router->get('/medicalofficer/assignedCampaign', [medicalOfficerController::class, 'CampaignAssignment']);
$app->router->get('/medicalofficer/verifyDonor', [medicalOfficerController::class, 'VerifyDonor']);
$app->router->post('/medicalofficer/get-donor', [medicalOfficerController::class, 'FindDonor']);
//$app->router->post('/manager/mngRequests/emergency', [managerController::class, 'FindRequests']);


$app->router->get('/api/bbank/getall', [apiController::class, 'getBloodBanks']);

//Hospital login
$app->router->get('/hospital/login', [hospitalController::class, 'login']);
$app->router->post('/hospital/login', [hospitalController::class, 'login']);
$app->router->get('/hospital/dashboard', [hospitalController::class, 'dashboard']);
$app->router->post('/hospital/dashboard', [hospitalController::class, 'dashboard']);
$app->router->get('/hospital/emergencyRequest', [hospitalController::class, 'emergencyRequest']);
$app->router->post('/hospital/emergencyRequest', [hospitalController::class, 'emergencyRequest']);
$app->router->get('/hospital/bloodRequest', [hospitalController::class, 'bloodRequest']);
$app->router->post('/hospital/bloodRequest', [hospitalController::class, 'bloodRequest']);

$app->router->get('/hospital/donors', [hospitalController::class, 'donors']);
$app->router->post('/hospital/donors', [hospitalController::class, 'donors']);
$app->router->get('/hospital/donors/find', [hospitalController::class, 'FindDonor']);

$app->router->get('/hospital/emergencyRequest/addRequest', [hospitalController::class, 'addEmergencyRequest']);
$app->router->post('/hospital/emergencyRequest/addRequest', [hospitalController::class, 'addEmergencyRequest']);
$app->router->get('/hospital/emergencyRequest/history', [hospitalController::class, 'emergencyRequestHistory']);
$app->router->post('/hospital/emergencyRequest/history', [hospitalController::class, 'emergencyRequestHistory']);
// Donor
$app->router->get('/donor/dashboard', [donorController::class, 'dashboard']);
$app->router->get('/about', [siteController::class, 'about']);
$app->router->get('/donor', [donorController::class, 'home']);
$app->router->get('/donor/login', [donorController::class, 'login']);
$app->router->post('/donor/login', [donorController::class, 'login']);
$app->router->get('/donor/signup', [donorController::class, 'signup']);
$app->router->post('/donor/signup', [donorController::class, 'signup']);
$app->router->get('/donor/profile', [donorController::class, 'profile']);
$app->router->get('/donor/register',[donorController::class, 'register']);
$app->router->post('/donor/register', [donorController::class, 'register']);
$app->router->get('/donor/guideline', [donorController::class, 'guideline']);
$app->router->get('/donor/history', [donorController::class, 'history']);
$app->router->get('/donor/nearby', [donorController::class, 'nearby']);


$app->router->get('/hospital/bloodRequest/addRequest', [hospitalController::class, 'addBloodRequest']);
$app->router->post('/hospital/bloodRequest/addRequest', [hospitalController::class, 'addBloodRequest']);
$app->router->get('/hospital/bloodRequest/history', [hospitalController::class, 'bloodRequestHistory']);
$app->router->post('/hospital/bloodRequest/history', [hospitalController::class, 'bloodRequestHistory']);


//Blogs
$app->router->post('/blog/add', [blogController::class, 'AddBlog']);
$app->router->post('/blog/delete', [blogController::class, 'DeleteBlog']);
$app->router->post('/blog/update', [blogController::class, 'UpdateBlog']);


$app->run();