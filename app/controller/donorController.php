<?php

namespace App\controller;

use App\middleware\donorMiddleware;
use App\model\Authentication\Login;
use App\model\Authentication\OTPCode;
use App\model\Blood\BloodPackets;
use App\model\Campaigns\Campaign;
use App\model\database\dbModel;
use App\model\Donations\AcceptedDonations;
use App\model\Donations\Donation;
use App\model\Report\Report;
use App\model\Requests\AttendanceAcceptedRequest;
//use App\model\Report\Report;
use App\model\users\Donor;
use App\model\users\User;
use Core\Application;
use Core\BaseMiddleware;
use Core\Controller;
use Core\Email;
use Core\middleware\AuthenticationMiddleware;
use Core\Request;
use Core\Response;
use PHPMailer\PHPMailer\Exception;


class donorController extends Controller
{

    public function __construct(){
        $this->layout = "Donor";
        $this->registerMiddleware(new donorMiddleware(['dashboard'], BaseMiddleware::FORBIDDEN_ROUTES));
        if(isset($_SESSION['pop']) && $_SESSION['pop'] == 1){
            $_SESSION['pop'] = 1;
        }
        else{
            $_SESSION['pop'] = 0;
        }
    }

    public function dashboard(): string
    {
        /* @var Donor $donor*/
        $donor = Donor::findOne(['Donor_ID' => Application::$app->getUser()->getID()]);

        $data=[
            'User'=>$donor,
            'firstName'=>$donor->getFirstName(),
            'lastName'=>$donor->getLastName(),
            'state' => $donor->getDonationAvailability()
        ];
      //  print_r($data);
      //  exit();
        return $this->render('Donor/Dashboard', $data );
    }

    /**
     * @throws Exception
     */
    public function ChangeEmailOTP(Request $request , Response $response)
    {
        if ($request->isPost()){
            $UserId = Application::$app->getUser()->getID();
            /** @var Donor $donor */
            $donor = Donor::findOne(['Donor_ID' => $UserId]);
            if ($donor){
                $Email = $request->getBody()['Email'];
                /** @var OTPCode $OTP */
                $OTP = OTPCode::findOne(['UserID'=>$UserId,'Type'=>OTPCode::TYPE_EMAIL_CHANGE,'Status'=>OTPCode::STATUS_PENDING]);
                if ($OTP) {
                    $delayTime = "-2 minutes";
                    if(MODE === DEVELOPMENT)
                        $delayTime = "-5 seconds";
                    if ($OTP->getCreatedAt() > date('Y-m-d H:i:s', strtotime($delayTime))) {
                        return json_encode(['status' => false, 'message' => 'OTP Already Sent']);
                    } else {
                        if (MODE !== DEVELOPMENT)
                            $OTP->GenerateCode($Email);
                        else
                            $OTP->GenerateCode(DEV_EMAIL);
                        try {
                            $OTP->sendCode($donor->getFullName());
                            $OTP->update($OTP->getUserID(),[],['Code','Updated_At'],['Type'=>OTPCode::TYPE_EMAIL_CHANGE]);
                            return json_encode(['status' => true, 'message' => 'OTP Sent to your Email']);
                        }catch (Exception $e){
                            return json_encode(['status' => false, 'message' => 'OTP Sending Failed']);
                        }
                    }
                }else {
                    $OTP = new OTPCode();
                    $OTP->setUserID($UserId);
                    $OTP->setType(OTPCode::TYPE_EMAIL_CHANGE);
                    if (MODE !== DEVELOPMENT)
                        $OTP->GenerateCode($Email);
                    else
                        $OTP->GenerateCode(DEV_EMAIL);
                    $DonorName = $donor->getFullName();
                    try {
                        $OTP->sendCode($DonorName);
                        $OTP->save();
                        return json_encode(['status' => true, 'message' => 'OTP Sent to your Email']);
                    } catch (Exception $e) {
                        return json_encode(['status' => false, 'message' => 'OTP Sending Failed']);
                    }
                }
            }
        }

    }

    public function ChangeEmail(Request $request , Response $response)
    {
        if ($request->isPost()){
            /** @var OTPCode $OTPCode */
            $OTPCode = OTPCode::findOne(['UserID'=>Application::$app->getUser()->getID(),'Type'=>OTPCode::TYPE_EMAIL_CHANGE,'Status'=>OTPCode::STATUS_PENDING],false);
            /** @var string $OTP */
            $OTP = $request->getBody()['OTP'];
            if ($OTPCode->getCode()===$OTP){
                $Email = $OTPCode->getTarget();
                $OTPCode->setAttempts($OTPCode->getAttempts()+1);
                $OTPCode->setStatus(OTPCode::STATUS_VERIFIED);
                $OTPCode->update($OTPCode->getUserID(),[],['Status','Updated_At'],['Type'=>OTPCode::TYPE_EMAIL_CHANGE]);
                /** @var Donor $donor */
                $donor = Donor::findOne(['Donor_ID'=>Application::$app->getUser()->getID()]);
                $donor->update($donor->getDonorID(),[],['Email'=>$Email]);
                return json_encode(['status'=>true,'message'=>'Email Changed Successfully']);
            }
        }
    }

    public function usrCheck(Response $response)
    {
        $guest = Application::$app->isGuest();
        if ($guest) {
            $response->redirect('/donor/login');
        }
    }

    public function profile(Request $request ,Response $response){
        $donor = Donor::findOne(['Donor_ID' => Application::$app->getUser()->getID()]);
        //$data=[];
        $data = $donor->toArray();
        //print_r( $donor->toArray() );
        //exit();
        //$data = $donor->profile
//        print_r($data);
//        exit();
        return $this->render('Donor/donorProfile', $data);
    }
    public function profile1(Request $request, Response $response)
    {
        $this->usrCheck($response);
        $donor = new Donor();
        $report = new Report();
        $user = Application::$app->getUser();
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $donor->loadData(Donor::findOne(['Donor_ID' => $primaryValue]));
        if (Report::findOne(['Donor_ID' => $primaryValue])) {
            $report->loadData(Report::findOne(['Donor_ID' => $primaryValue]));
        }
        if ($donor->isNotRegistered()) {
            return $this->render('Donor/register');
        }
//        if ($report->isNotAvailable()){
//            //echo '<script>getEleme</script>'
//            return $this->render('Donor/profile', $donor->getAttributes());
//        }
        return $this->render('Donor/profile', $donor->getAttributes() + $report->getBriefReport());
    }

    public function signup(Request $request, Response $response)
    {
        if ($request->isPost()) {
            $user = new User();
            $user->loadData($request->getBody());
            $user->setId(time());
            $user->setPassword($user->getPassword());
            if (User::findOne(['email' => $user->getEmail()])) {
                echo "<center style='color: red;font-size: x-large'>This Email is already registered <a href='/donor/login'>Try Login</a></center>";
                return $this->render('Donor/signup');
            }

            if ($user->validate() && $user->save()) {
                $response->redirect('/donor/login');
            }

        }
        return $this->render('Donor/signup');
    }

    public function register(Request $request, Response $response)
    {
        // get email address and userID from user Table
        $userID = 12345;
        $email = 'test@example.com';
        if ($request->isPost()) {
            $donor = new Donor();
            $donor->loadData($request->getBody());
            $donor->setDonorId($userID);
            $donor->setId($donor->getId());

            if ($donor->validate() && $donor->save()) {
                $response->redirect('/donor/profile');
            }
        }
        return $this->render('Donor/register',['email'=>$email]);
    }

    public function guideline(Request $request, Response $response)
    {
        $donor = Donor::findOne(['Donor_ID' => Application::$app->getUser()->getID()]);
        return $this->render('Donor/donationGuideline',[
            'User'=>$donor,
        ]);
    }

    public function history(Request $request, Response $response){
        $donor = Donor::findOne(['Donor_ID' => Application::$app->getUser()->getID()]);
        $donations = AcceptedDonations::RetrieveAll(false,[],true,['Donor_ID' => Application::$app->getUser()->getID()]);
        $data = [];
        foreach ($donations as $donation) {
            $donationID = $donation->getDonationId();
            $rawDonation = Donation::findOne(['Donation_ID'=>$donationID]);
            $campaign = Campaign::findOne(['Campaign_ID'=>$rawDonation->getCampaignID()]);
            $bloodPacket = BloodPackets::findOne(['Packet_ID' => $donation->getPacketId()]);
            $timeStamp = $donation->getDonationDateTime();
            $data[] = [
                    'Date' => explode(' ',$timeStamp)[0],
                    'Time' => explode(' ',$timeStamp)[1],
                    'Remark' => $bloodPacket->getRemarks(),
                    'CampaignName' => $campaign->getCampaignName(),
                    'Organization' => $campaign->getOrganizationName()
                ];
        }
//        print_r($data);
//        exit();
        return $this->render('Donor/donationHistory',['data' => $data,'User'=>$donor]);
    }

    public function nearby(Request $request, Response $response){
        $donor = Donor::findOne(['Donor_ID' => Application::$app->getUser()->getID()]);
        $data = Campaign::RetrieveAll();
//        $data = Campaign::RetrieveAll(false,[],true,['Status'=>Campaign::CAMPAIGN_STATUS_APPROVED]);
        //exit();
        //echo $data;
        // $data = Campaign::RetrieveAll();
        // return $this->render('Donor/nearbyCampaigns',["data"=> $data]);
        return $this->render('Donor/nearbyCampaigns',["data"=> $data,'User'=>$donor]);
    }

    public function editDetails(Request $request,Response $response){
        $donor = Donor::findOne(['Donor_ID' => Application::$app->getUser()->getID()]);
        $data = $request->getBody();

        if ($request->isPost()){
            $newEmail = $data['Email'];
            $newContact_No = $data['Contact_No'];
            $donor->updateOne(['Donor_ID' => Application::$app->getUser()->getID()], ['Email' => $newEmail, 'Contact_No' => $newContact_No]);
            $user = User::findOne(['UID' => Application::$app->getUser()->getID()]);
            $user->updateOne(['UID' => Application::$app->getUser()->getID()], ['Email' => $newEmail]);
        }
        $response->redirect('/donor/profile');
    }

    public function loginPrompt(Request $request, Response $response): string
    {
        if ($request->isPost()){
            $donor = Donor::findOne(['Donor_ID' => Application::$app->getUser()->getID()]);
            if (count($request->getBody() ) == 0){
                Donor::updateOne(['Donor_ID' => Application::$app->getUser()->getID()], ['Donation_Availability' => 0]);
            }
        }
        $_SESSION['pop'] = 1;
        return $this->render('Donor/Dashboard', ['formPop' => $this->formPop] );
    }

    public function markAttendance(Request $request, Response $response){
        $data = $request->getBody();
//        $data = $request->getBody();
//        $flag = false;
//        error_log($data['userID']);
//        error_log($data['campaignID']);
        $attendance = new AttendanceAcceptedRequest();
        $attendance->setRequestID(dbModel::generateID('AAR'));
        $attendance->setDonorID($data['userID']);
        $attendance->setCampaignID($data['campaignID']);
        $attendance->setAcceptedAt(date('Y-m-d H:i:s'));
//        $attendance = AttendanceAcceptedRequest::findOne(['Donor_ID'=>$data['userID'],'Campaign_ID'=>$data['campaignID']]);
        if ($attendance->validate()){
            if ($attendance->save()){
                return json_encode(true);
            }
        }
        return json_encode(false);
    }

    public function removeAttendance(Request $request, Response $response){
        $data = $request->getBody();
//        return json_encode($data['userID']);
        $attendanceRecord = AttendanceAcceptedRequest::findOne(['Campaign_ID'=>$data['campaignID'],'Donor_ID'=>$data['userID']]);
        if ($attendanceRecord){
//            AttendanceAcceptedRequest::DeleteOne();
            if (AttendanceAcceptedRequest::DeleteOne(['Campaign_ID'=>$data['campaignID'],'Donor_ID'=>$data['userID']])){
                return json_decode(true);
            }
        }
        return json_encode(false);

    }
}