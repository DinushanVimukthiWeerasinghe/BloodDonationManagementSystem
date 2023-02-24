<?php

namespace App\controller;

use App\middleware\donorMiddleware;
use App\model\Authentication\Login;
use App\model\Campaigns\Campaign;
use App\model\Donations\AcceptedDonations;
use App\model\Donations\Donation;
use App\model\Report\Report;
use App\model\users\Donor;
use App\model\users\User;
use App\view\components\Card\donationDetailsCard;
use Core\Application;
use Core\BaseMiddleware;
use Core\Controller;
use Core\middleware\AuthenticationMiddleware;
use Core\Request;
use Core\Response;

class donorController extends Controller
{
    public function __construct(){
        $this->layout = "Donor";
        $this->registerMiddleware(new donorMiddleware(['dashboard'], BaseMiddleware::FORBIDDEN_ROUTES));
    }

    public function dashboard(): string
    {
        /* @var Donor $donor*/
        $donor = Donor::findOne(['Donor_ID' => Application::$app->getUser()->getID()]);
        $data=[
            'firstName'=>$donor->getFirstName(),
            'lastName'=>$donor->getLastName()
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
        $this->usrCheck($response);
        $user = Application::$app->getUser();
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};

        if (Donor::findOne(['Donor_ID' => $primaryValue])) {
            $response->redirect('/donor/profile');
        }
        if ($request->isPost()) {
            $donor = new Donor();
            $donor->loadData($request->getBody());
            $donor->setDonorId($user->$primaryKey);
            $donor->setId($donor->getId());
            print_r($donor);

            if ($donor->validate() && $donor->save()) {
                $response->redirect('/donor/profile');
            }
        }

        return $this->render('Donor/register');
    }

    public function guideline(Request $request, Response $response)
    {
        return $this->render('Donor/donationGuideline');
    }

    public function history(Request $request, Response $response){
        $donor = Donor::findOne(['Donor_ID' => Application::$app->getUser()->getID()]);
        $data = AcceptedDonations::RetrieveAll(false,[],true,['Donor_ID' => Application::$app->getUser()->getID()]);
        //print_r($data);
        return $this->render('Donor/donationHistory',['data' => $data]);
    }

    public function nearby(Request $request, Response $response){
        $data = Campaign::RetrieveAll();
        print_r($data);
        exit();
        return $this->render('Donor/nearbyCampaigns');
    }
}