<?php
;
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



require_once __DIR__ . '/../public/config.php';


$config=[
    'db'=>[
        'dsn'=>DB_DSN,
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
    ],
    'map'=>[
        'key'=>$_ENV['MAP_API_KEY']
    ],
];
//Set Env Variables
$MAP_API_KEY=$_ENV['MAP_API_KEY'];


try {
    $app = new Application(dirname(__DIR__), $config);
    $app->forbiddenRoute->setForbiddenRotes([
        'manager'=>['/manager/dashboard']
    ]);

//$app->db->applyMigrations();
    $app->router->get('/', [siteController::class, 'home']);
    $app->router->get('/home', [siteController::class, 'home']);
    $app->router->post('/donate', [siteController::class, 'Donate']);
    $app->router->get('/donate', [siteController::class, 'Donate']);
    $app->router->get('/about', [siteController::class, 'about']);
    $app->router->get('/loader', [siteController::class, 'Loader']);
    $app->router->get('/contact', [siteController::class, 'contact']);
    $app->router->post('/contact', [siteController::class, 'contact']);
    $app->router->get('/register', [authController::class, 'UserRegister']);
    $app->router->post('/register', [authController::class, 'UserRegister']);
    $app->router->post('/register/send-otp', [authController::class, 'SendRegistrationOTP']);
    $app->router->post('/register/validate-otp', [authController::class, 'ValidateOTP']);
    $app->router->post('/register/validateuser', [authController::class, 'ValidateUser']);
    $app->router->get('/organization/register', [authController::class, 'OrganizationRegister']);
    $app->router->post('/organization/register', [authController::class, 'OrganizationRegister']);

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
    $app->router->post('/forgot-password', [authController::class, 'ForgotPassword']);


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
    $app->router->post('/admin/dashboard/manageBanks/edit', [adminController::class, 'editBank']);
    $app->router->post('/admin/dashboard/manageBanks/delete', [adminController::class, 'deleteBank']);
    $app->router->post('/admin/dashboard/manageBanks/add', [adminController::class, 'addNewBank']);
    $app->router->post('/admin/dashboard/manageBanks/search', [adminController::class, 'searchBank']);

    $app->router->post('/admin/manageBanks/addManager', [authController::class, 'managerRegister']);
    $app->router->get('/admin/manageBanks/addManager', [authController::class, 'managerRegister']);
    $app->router->post('/admin/manageHospital/addHospital', [authController::class, 'hospitalRegister']);

    $app->router->post('/admin/dashboard/manageAlerts/add/managerNotification', [adminController::class, 'addManagerNotification']);

    $app->router->post('/user/resetPassword', [adminController::class, 'ResetPassword']);
    $app->router->post('/user/removeUser', [adminController::class, 'RemoveUser']);
    $app->router->post('/user/reActivateUser', [adminController::class, 'ReactivateUser']);
    $app->router->post('/user/deactivateUser', [adminController::class, 'DeactivateUser']);
    $app->router->post('/user/activateUser', [adminController::class, 'ActivateUser']);
    $app->router->post('/user/searchUser', [adminController::class, 'SearchUser']);
    $app->router->get('/user/searchUser', [adminController::class, 'SearchUser']);

    $app->router->post('/upload', [fileController::class, 'upload']);

    $app->router->get('/test',[siteController::class,'Test']);

//$app->router->get('/organization/register', [OrganizationController::class, 'register']);
//$app->router->post('/organization/register', [OrganizationController::class, 'register']);
$app->router->get('/organization/dashboard', [OrganizationController::class, 'dashboard']);
$app->router->get('/organization/create', [OrganizationController::class, 'CreateCampaign']);
$app->router->get('/organization/history', [OrganizationController::class, 'history']);
$app->router->get('/organization/home', [OrganizationController::class, 'home']);
$app->router->get('/organization/inform', [OrganizationController::class, 'inform']);
$app->router->post('/organization/inform', [OrganizationController::class, 'inform']);
$app->router->get('/organization/manage', [OrganizationController::class, 'manage']);
$app->router->get('/organization/create', [OrganizationController::class, 'CreateCampaign']);
$app->router->post('/organization/create', [OrganizationController::class, 'CreateCampaign']);
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
$app->router->get('/organization/campaign/updateCampaign', [OrganizationController::class, 'updateCampaign']);
$app->router->post('/organization/campaign/updateCampaign', [OrganizationController::class, 'updateCampaign']);
$app->router->get('/organization/campaign/view', [OrganizationController::class, 'ViewCampaign']);
$app->router->get('/organization/campaign/deleteCampaign', [OrganizationController::class, 'delete']);
$app->router->post('/organization/getCampaignCoordinate', [OrganizationController::class, 'GetCampaignCoordinate']);
$app->router->post('/organization/getBankDetails', [OrganizationController::class, 'GetOrganizationBankAccountDetails']);
$app->router->post('/organization/addBankDetails', [OrganizationController::class, 'AddOrganizationBankAccountDetails']);
$app->router->post('/organization/changeProfile', [OrganizationController::class, 'ChangeProfileImage']);
$app->router->post('/organization/notification', [OrganizationController::class, 'GetNotification']);
$app->router->post('/organization/requestSponsorship', [OrganizationController::class, 'RequestSponsorship']);
$app->router->post('/organization/resetPassword', [OrganizationController::class, 'ResetPassword']);

$app->router->post('/user/change-password', [authController::class, 'ChangePassword']);

//sponsor

    $app->router->get('/sponsor/dashboard', [sponsorController::class, 'dashboard']);
    $app->router->get('/sponsor/test', [sponsorController::class, 'Test']);
    $app->router->get('/sponsor/makePayment', [sponsorController::class, 'MakePayment']);
    $app->router->post('/sponsor/makePayment', [sponsorController::class, 'MakePayment']);
    $app->router->get('/sponsor/history', [sponsorController::class, 'history']);
    $app->router->get('/sponsor/manage', [sponsorController::class, 'manage']);
    $app->router->get('/sponsor/sponsor', [sponsorController::class, 'MakeDonation']);
    $app->router->get('/sponsor/campDetails', [sponsorController::class, 'campDetails']);
//    $app->router->post('/sponsor/campaign/view', [sponsorController::class, 'GetCampaignDetails']);
    $app->router->post('/sponsor/ViewCampaigns', [sponsorController::class, 'GetCampaignDetails']);
    $app->router->get('/sponsor/guideline', [sponsorController::class, 'guideline']);
    $app->router->post('/sponsor/notification', [SponsorController::class, 'GetNotification']);
    $app->router->post('/sponsor/changeProfile', [SponsorController::class, 'ChangeProfileImage']);
    $app->router->post('/sponsor/resetPassword', [SponsorController::class, 'ResetPassword']);
    $app->router->get('/gmp', [siteController::class, 'gmap']);



// Manager Register
    $app->router->get('/manager/register', [managerController::class, 'register']);
    $app->router->post('/manager/notification', [managerController::class, 'ManageNotification']);
    $app->router->post('/manager/register', [managerController::class, 'register']);

//Manager Dashboard
    $app->router->get('/manager/dashboard', [managerController::class, 'dashboard']);
    $app->router->post('/manager/updateNotice', [managerController::class, 'ManagerNotice']);
    $app->router->get('/manager/profile', [managerController::class, 'Profile']);


    $app->router->get('/manager/mngMedicalOfficer', [managerController::class, 'ManageMedicalOfficer']);
    $app->router->post('/manager/changeProfile', [managerController::class, 'ChangeProfileImage']);
    $app->router->post('/manager/changePassword', [managerController::class, 'ChangePassword']);

    $app->router->get('/manager/mngMedicalOfficer/add', [managerController::class, 'AddMedicalOfficer']);
    $app->router->post('/manager/mngMedicalOfficer/add', [managerController::class, 'AddMedicalOfficer']);
    $app->router->post('/manager/mngMedicalOfficer/delete', [managerController::class, 'DeleteMedicalOfficer']);
    $app->router->get('/manager/mngCampaign/assignTeam', [managerController::class, 'AssignTeam']);
    $app->router->post('/manager/mngCampaign/assignTeam', [managerController::class, 'AssignTeam']);

    $app->router->post('/manager/mngMedicalOfficer/search', [managerController::class, 'SearchMedicalOfficer']);
    $app->router->post('/manager/mngMedicalOfficer/search-for-team', [managerController::class, 'SearchMedicalOfficerForTeam']);

    $app->router->get('/manager/mngRequests', [managerController::class, 'ManageRequests']);
    $app->router->post('/manager/mngRequests', [managerController::class, 'ManageRequests']);
    $app->router->post('/manager/mngRequests/find', [managerController::class, 'FindRequest']);
    $app->router->post('/manager/mngRequest/search', [managerController::class, 'SearchRequest']);
    $app->router->get('/manager/mngRequests/er', [managerController::class, 'ManageEmergencyRequests']);
    $app->router->get('/manager/mngRequests/er', [managerController::class, 'ManageEmergencyRequests']);
    $app->router->post('/manager/mngRequests/send-to-donor', [managerController::class, 'SendBloodRequestToDonor']);
    $app->router->post('/manager/mngRequests/supply', [managerController::class, 'SupplyBloodRequest']);

    $app->router->post('/manager/mngCampaign/view', [managerController::class, 'ViewCampaign']);
    $app->router->post('/manager/mngCampaign/reject', [managerController::class, 'RejectCampaign']);
    $app->router->post('/manager/mngCampaign/accept', [managerController::class, 'AcceptCampaign']);
    $app->router->get('/manager/mngCampaign/assign-team', [managerController::class, 'AssignTeam']);
    $app->router->post('/manager/mngCampaign/assign-team/get-members', [managerController::class, 'getTeamMembers']);
    $app->router->post('/manager/mngCampaign/assign-team/assign-leader', [managerController::class, 'AssignTeamLeader']);
    $app->router->post('/manager/mngCampaign/assignTeam/assign', [managerController::class, 'AssignTeamMember']);
    $app->router->post('/manager/mngCampaign/assignTeam/remove', [managerController::class, 'RemoveTeamMember']);


    $app->router->get('/manager/mngSponsors', [managerController::class, 'ManageSponsors']);
    $app->router->post('/manager/mngSponsors', [managerController::class, 'ManageSponsors']);
    $app->router->post('/manager/mngSponsors/search', [managerController::class, 'SearchSponsors']);
    $app->router->post('/manager/mngSponsors/find', [managerController::class, 'FindSponsors']);

    $app->router->get('/manager/mngSponsorship', [managerController::class, 'ManageSponsorship']);
    $app->router->post('/manager/mngSponsorship', [managerController::class, 'ManageSponsorship']);
    $app->router->post('/manager/mngSponsorship/viewRequest', [managerController::class, 'GetSponsorshipRequest']);
    $app->router->post('/manager/mngSponsorship/approveRequest', [managerController::class, 'ApproveSponsorshipRequest']);
    $app->router->post('/manager/mngSponsorship/rejectRequest', [managerController::class, 'RejectSponsorshipRequest']);
    $app->router->post('/manager/mngSponsorship/sendEmail', [managerController::class, 'SendEmailToOrganization']);


    $app->router->get('/manager/mngDonors', [managerController::class, 'ManageDonors']);
    $app->router->post('/manager/mngDonors', [managerController::class, 'ManageDonors']);

    $app->router->get('/manager/mngCampaigns', [managerController::class, 'ManageCampaigns']);
    $app->router->get('/manager/mngCampaigns/ViewReport', [managerController::class, 'CampaignReport']);
    $app->router->post('/manager/mngCampaigns/ViewCampaignReport', [managerController::class, 'FinishedCampaignReport']);
    $app->router->post('/manager/mngReport/DonationReport', [managerController::class, 'DonationReport']);
    $app->router->post('/manager/mngReport/SponsorshipReport', [managerController::class, 'SponsorshipReport']);
    $app->router->get('/manager/mngReport/OfficerReport', [managerController::class, 'OfficerReport']);

    $app->router->post('/manager/mngCampaigns', [managerController::class, 'ManageCampaigns']);
    $app->router->post('/manager/mngCampaigns/search', [managerController::class, 'SearchCampaign']);

    $app->router->get('/manager/mngReport', [managerController::class, 'ManageReport']);
    $app->router->post('/manager/mngReport', [managerController::class, 'ManageReport']);
    $app->router->get('/manager/mngReport/save-pdf', [managerController::class, 'SaveAsPDF']);


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
    $app->router->post('/manager/mngDonors/Search', [managerController::class, 'SearchDonor']);
    $app->router->post('/manager/mngDonors/find', [managerController::class, 'FindDonor']);
    $app->router->post('/manager/mngDonors/isExist', [managerController::class, 'IsDonorExist']);
    $app->router->get('/manager/mngDonors/reportedDonor', [managerController::class, 'ReportedDonor']);
    $app->router->get('/manager/mngDonors/informDonor', [managerController::class, 'InformDonor']);
    $app->router->post('/manager/mngDonors/informDonor', [managerController::class, 'InformDonor']);
//$app->router->post('/manager/mngDonors/find', [managerController::class, 'FindDonor']);
    $app->router->get('/manager/mngRequests/emergency', [managerController::class, 'ManageEmergencyRequests']);
    $app->router->post('/manager/stat', [managerController::class, 'GetStatistics']);

    $app->router->post('/mofficer/stat', [medicalOfficerController::class, 'GetStatistics']);


//Medical Officer
    $app->router->get('/medicalofficer/dashboard', [medicalOfficerController::class, 'Dashboard']);
    $app->router->get('/medicalofficer/notification', [medicalOfficerController::class, 'getNotification']);

//Manage Requests

$app->router->get('/mofficer/campaigns', [medicalOfficerController::class, 'ManageCampaigns']);
$app->router->post('/mofficer/campaigns/endCampaign', [medicalOfficerController::class, 'EndCampaigns']);
$app->router->post('/mofficer/changepassword', [medicalOfficerController::class, 'ChangePassword']);
$app->router->post('/mofficer/stat', [medicalOfficerController::class, 'GetStatistics']);
$app->router->post('/mofficer/changeProfile', [medicalOfficerController::class, 'ChangeProfileImage']);
$app->router->get('/mofficer/history', [medicalOfficerController::class, 'ManageHistory']);
$app->router->get('/mofficer/donors', [medicalOfficerController::class, 'ManageDonors']);
$app->router->get('/mofficer/take-donation', [medicalOfficerController::class, 'ManageDonation']);
$app->router->post('/mofficer/take-donation', [medicalOfficerController::class, 'ManageDonation']);
$app->router->get('/mofficer/donation', [medicalOfficerController::class, 'ManageDonation']);
$app->router->post('/mofficer/startBloodDonation', [medicalOfficerController::class, 'StartDonation']);
$app->router->post('/mofficer/rejectBloodDonation', [medicalOfficerController::class, 'RejectDonation']);
$app->router->post('/mofficer/medicalteam/allocateTask', [medicalOfficerController::class, 'AssignTasks']);
$app->router->post('/mofficer/CompleteDonation', [medicalOfficerController::class, 'CompleteDonation']);
$app->router->post('/mofficer/AbortDonation', [medicalOfficerController::class, 'AbortDonation']);
$app->router->get('/mofficer/searchdonor', [medicalOfficerController::class, 'SearchDonor']);
$app->router->post('/mofficer/registerDonor', [medicalOfficerController::class, 'RegisterDonor']);
$app->router->post('/mofficer/registerDonorForCampaign', [medicalOfficerController::class, 'RegisterDonorForCampaign']);
$app->router->post('/mofficer/uploadNICFront', [medicalOfficerController::class, 'UploadDonorNICFront']);
$app->router->post('/mofficer/uploadNICBack', [medicalOfficerController::class, 'UploadDonorNICBack']);
$app->router->post('/mofficer/campaigns/verifyOrganization', [medicalOfficerController::class, 'VerifyOrganization']);
$app->router->post('/mofficer/campaigns/ReportCampaign', [medicalOfficerController::class, 'ReportCampaign']);
$app->router->post('/mofficer/campaigns/UndoReportCampaign', [medicalOfficerController::class, 'UndoReportCampaign']);
$app->router->get('/mofficer/campaigns/overview', [medicalOfficerController::class, 'CampaignOverview']);

//$app->router->get('/mofficer/campaigns', [medicalOfficerController::class, 'VerifyDonor']);
    $app->router->post('/medicalofficer/get-donor', [medicalOfficerController::class, 'FindDonor']);
    $app->router->post('/medicalOfficer/ViewReport', [medicalOfficerController::class, 'ViewReport']);
    $app->router->get('/medicalOfficer/ViewReport', [medicalOfficerController::class, 'ViewReport']);
    $app->router->post('/medicalOfficer/ViewTeam', [medicalOfficerController::class, 'ViewTeam']);
//$app->router->post('/manager/mngRequests/emergency', [managerController::class, 'FindRequests']);


    $app->router->get('/api/bbank/getall', [apiController::class, 'getBloodBanks']);
    $app->router->get('/api/managers/getall', [apiController::class, 'getManagers']);
    $app->router->get('/api/bloodGroups/getall', [apiController::class, 'getBloodGroups']);
    $app->router->get('/api/campaign/checkattendance', [apiController::class, 'checkAttendance']);

//Hospital login
    $app->router->get('/hospital/login', [hospitalController::class, 'login']);
    $app->router->post('/hospital/login', [hospitalController::class, 'login']);
    $app->router->get('/hospital/dashboard', [hospitalController::class, 'dashboard']);
    $app->router->post('/hospital/dashboard', [hospitalController::class, 'dashboard']);
    $app->router->get('/hospital/emergencyRequest', [hospitalController::class, 'emergencyRequest']);
    $app->router->post('/hospital/emergencyRequest', [hospitalController::class, 'emergencyRequest']);
    $app->router->get('/hospital/bloodRequest', [hospitalController::class, 'bloodRequest']);
    $app->router->post('/hospital/bloodRequest', [hospitalController::class, 'bloodRequest']);
$app->router->get('/hospital/login', [hospitalController::class, 'login']);
$app->router->post('/hospital/login', [hospitalController::class, 'login']);
$app->router->get('/hospital/dashboard', [hospitalController::class, 'dashboard']);
$app->router->post('/hospital/dashboard', [hospitalController::class, 'dashboard']);
$app->router->post('/hospital/addRequest', [hospitalController::class, 'AddRequest']);
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
$app->router->get('/hospital/emergencyRequest/addRequest', [hospitalController::class, 'addEmergencyRequest']);
$app->router->post('/hospital/emergencyRequest/addRequest', [hospitalController::class, 'addEmergencyRequest']);
$app->router->get('/hospital/emergencyRequest/history', [hospitalController::class, 'emergencyRequestHistory']);
$app->router->post('/hospital/emergencyRequest/history', [hospitalController::class, 'emergencyRequestHistory']);
$app->router->post('/hospital/request', [hospitalController::class, 'addRequest']);
// Donor
$app->router->get('/donor/dashboard', [donorController::class, 'dashboard']);
$app->router->get('/about', [siteController::class, 'about']);
$app->router->get('/donor', [donorController::class, 'home']);
$app->router->get('/donor/login', [donorController::class, 'login']);
$app->router->post('/donor/login', [donorController::class, 'login']);
$app->router->get('/donor/signup', [donorController::class, 'signup']);
$app->router->post('/donor/signup', [donorController::class, 'signup']);
$app->router->get('/donor/profile', [donorController::class, 'profile']);
$app->router->get('/donor/register', [authController::class, 'DonorRegister']);
$app->router->post('/donor/register', [authController::class, 'DonorRegister']);
$app->router->post('/donor/sendEmailChangeOTP', [donorController::class, 'ChangeEmailOTP']);
$app->router->post('/donor/changeEmail', [donorController::class, 'ChangeEmail']);

//$app->router->get('/donor/register',[donorController::class, 'register']);
//$app->router->post('/donor/register', [donorController::class, 'register']);
$app->router->get('/donor/guideline', [donorController::class, 'guideline']);
$app->router->get('/donor/history', [donorController::class, 'history']);
$app->router->get('/donor/nearby', [donorController::class, 'nearby']);
$app->router->post('/donor/profile/edit', [donorController::class, 'editDetails']);
    $app->router->get('/donor/dashboard', [donorController::class, 'dashboard']);
    $app->router->get('/about', [siteController::class, 'about']);
    $app->router->get('/donor', [donorController::class, 'home']);
    $app->router->get('/donor/login', [donorController::class, 'login']);
    $app->router->post('/donor/login', [donorController::class, 'login']);
    $app->router->get('/donor/signup', [donorController::class, 'signup']);
    $app->router->post('/donor/signup', [donorController::class, 'signup']);
    $app->router->get('/donor/profile', [donorController::class, 'profile']);
//    $app->router->get('/donor/register',[donorController::class, 'register']);
$app->router->post('/donor/profile/loginPrompt', [donorController::class, 'loginPrompt']);
    //$app->router->get('/donor/dashboard', [donorController::class, 'dashboard']);
    //$app->router->get('/about', [siteController::class, 'about']);
    //$app->router->get('/donor', [donorController::class, 'home']);
    //$app->router->get('/donor/login', [donorController::class, 'login']);
    //$app->router->post('/donor/login', [donorController::class, 'login']);
    //$app->router->get('/donor/signup', [donorController::class, 'signup']);
    //$app->router->post('/donor/signup', [donorController::class, 'signup']);
    //$app->router->get('/donor/profile', [donorController::class, 'profile']);
    //$app->router->get('/donor/register',[donorController::class, 'register']);
//    $app->router->post('/donor/register', [donorController::class, 'register']);
    $app->router->get('/donor/guideline', [donorController::class, 'guideline']);
    $app->router->get('/donor/history', [donorController::class, 'history']);
    $app->router->get('/donor/nearby', [donorController::class, 'nearby']);
    $app->router->get('/donor/verify', [donorController::class, 'nearby']);
$app->router->post('/donor/profile/loginPrompt', [donorController::class, 'loginPrompt']);

    $app->router->get('/donor/campaign/markAttendance', [donorController::class, 'markAttendance']);
    $app->router->get('/donor/campaign/removeAttendance',[donorController::class, 'removeAttendance']);








    $app->router->get('/hospital/bloodRequest/addRequest', [hospitalController::class, 'addBloodRequest']);
    $app->router->post('/hospital/bloodRequest/addRequest', [hospitalController::class, 'addBloodRequest']);
    $app->router->get('/hospital/bloodRequest/history', [hospitalController::class, 'bloodRequestHistory']);
    $app->router->post('/hospital/bloodRequest/history', [hospitalController::class, 'bloodRequestHistory']);


//Blogs
    $app->router->post('/blog/add', [blogController::class, 'AddBlog']);
    $app->router->post('/blog/delete', [blogController::class, 'DeleteBlog']);
    $app->router->post('/blog/update', [blogController::class, 'UpdateBlog']);


    $app->run();

} catch (\PHPMailer\PHPMailer\Exception|Exception $e) {
    echo $e->getMessage();
}
//Application::CreateDirectories(['public/upload/Profile/Donors','public/upload/Profile/Managers','public/upload/Profile/MedicalOfficers','public/upload/Profile/Receivers']);
