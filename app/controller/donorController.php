<?php

namespace App\controller;

use App\middleware\donorMiddleware;
use App\model\Authentication\Login;
use App\model\Blood\BloodPackets;
use App\model\Campaigns\Campaign;
use App\model\Donations\AcceptedDonations;
use App\model\Donations\Donation;
use App\model\Report\Report;
use App\model\users\Donor;
use App\model\users\User;
use Core\Application;
use Core\BaseMiddleware;
use Core\Controller;
use Core\Email;
use Core\middleware\AuthenticationMiddleware;
use Core\Request;
use Core\Response;


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
            'firstName'=>$donor->getFirstName(),
            'lastName'=>$donor->getLastName(),
            'state' => $donor->getDonationAvailability()
        ];
      //  print_r($data);
      //  exit();
        return $this->render('Donor/Dashboard', $data );
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
        return $this->render('Donor/donationGuideline');
    }

    public function history(Request $request, Response $response){
//        $donor = Donor::findOne(['Donor_ID' => Application::$app->getUser()->getID()]);
        $donations = AcceptedDonations::RetrieveAll(false,[],true,['Donor_ID' => Application::$app->getUser()->getID()]);
        $data = [];
        foreach ($donations as $donation) {
            $bloodPacket = BloodPackets::findOne(['Packet_ID' => $donation->getPacketId()]);
            $data[] = [
                    'DateTime' => $donation->getDonationDateTime(),
                    'Remark' => $bloodPacket->getRemarks(),

                ];
        }
//        print_r($data);
//        exit();
        return $this->render('Donor/donationHistory',['data' => $data]);
    }

    public function nearby(Request $request, Response $response){
        $data = Campaign::RetrieveAll();
        //exit();
        //echo $data;
        return $this->render('Donor/nearbyCampaigns',["data"=> $data]);
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
}