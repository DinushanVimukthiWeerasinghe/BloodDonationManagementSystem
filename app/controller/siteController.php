<?php

namespace App\controller;


use App\model\Blog\Blog;
use App\model\Campaigns\Campaign;
use App\model\sponsor\AnonymousSponsor;
use App\model\sponsor\CampaignsSponsor;
use App\model\Utils\Security;
use Core\Application;
use Core\middleware\AuthenticationMiddleware;
use Core\Request;
use Core\Response;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;

class siteController extends \Core\Controller
{

    public function Loader()
    {
        return $this->render('Utils/Loader');
    }
    public function __construct()
    {
        $this->registerMiddleware( new AuthenticationMiddleware(['homes']));
    }

    /**
     * @throws ApiErrorException
     */
    public function Donate(Request $request, Response $response)
    {
        if ($request->isPost()){
            $CampaignID = $request->getBody()['CampaignID'];
            $Email = $request->getBody()['email'];
            $Amount = $request->getBody()['amount'];
            /** @var Campaign $Campaign */
            $Campaign = Campaign::findOne(['Campaign_ID'=>$CampaignID]);
            $Email = $request->getBody()['email'];
            if (!$Campaign) return json_encode(['status'=>false,'message'=>'Campaign not found']);
            $SponsorshipRequest = $Campaign->getSponsorshipRequest();
            if (!$SponsorshipRequest) return json_encode(['status'=>false,'message'=>'Sponsorship request not found']);
            if ($SponsorshipRequest->getToBeSponsoredAmount() <= 0) return json_encode(['status'=>false,'message'=>'Campaign is already sponsored']);
            $RequestID = $SponsorshipRequest->getSponsorshipID();
            $CampaignName = $Campaign->getCampaignName();
            if ($Amount < 1000) return json_encode(['status'=>false,'message'=>'Minimum amount is 1000 LKR']);
            if ($Amount > $SponsorshipRequest->getToBeSponsoredAmount()){
                $Amount = $SponsorshipRequest->getToBeSponsoredAmount();
            }
            $line_items[] = [
                'price_data' => [
                    'currency' => 'lkr',
                    'unit_amount' => $Amount * 100,
                    'product_data' => [
                        'name' => 'Sponsorship for '.$CampaignName,
                    ],
                ],
                'quantity' => 1,
            ];
            $EncAmount = Security::Encrypt($Amount);
            $EncAmount = urlencode($EncAmount);
            $EncRequestID = Security::Encrypt($RequestID);
            $EncRequestID = urlencode($EncRequestID);
            $AnonymousSponsorID = uniqid('ASP_');
            $EncAnonymousSponsorID = Security::Encrypt($AnonymousSponsorID);
            $EncAnonymousSponsorID = urlencode($EncAnonymousSponsorID);

            Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);
            $checkout_session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => $line_items,
                'mode' => 'payment',
                'success_url' => HOST . '/donate?success=true&RequesterID='.$EncAnonymousSponsorID.'&Amount='.$EncAmount.'&session_id='.'{CHECKOUT_SESSION_ID}' ,
                'cancel_url' => HOST . '/donate?success=false',
                'custom_text'=>[
                    'submit' =>[
                        'message' => 'We\'ll send you an email with a link to download your receipt.'
                    ]
                ]
            ]);
            $SessionID = $checkout_session->id;
            $Sponse = AnonymousSponsor::CreateAnonymousSponsor($SponsorshipRequest->getSponsorshipID(),$AnonymousSponsorID,$Email,$Amount,$SessionID);

+            $Sponse->save();

            $Amount = $request->getBody()['amount'];
            return json_encode(['status'=>true,'CampaignID'=>$CampaignID,'Amount'=>$Amount,'redirect'=>$checkout_session->url]);
        }
        else{
            $status = $request->getBody()['success'];

             if ($status === 'true'){
                 $RequesterID = $request->getBody()['RequesterID'];
                 $Amount = $request->getBody()['Amount'];
                 $SessionID = $request->getBody()['session_id'];
                 $requestID = Security::Decrypt($RequesterID);
                 $Amount = Security::Decrypt($Amount);
                 if ($requestID && $Amount){
                     /** @var AnonymousSponsor $AnonymousSponsor */
                     $AnonymousSponsor = AnonymousSponsor::findOne(['Sponsor_ID'=>$requestID]);
                     $AnonymousSponsorSessionID = $AnonymousSponsor->getSessionID();

                     if ($AnonymousSponsorSessionID === $SessionID) {
                         $AnonymousSponsor->setStatus(AnonymousSponsor::PAYMENT_STATUS_PAID);
                         $AnonymousSponsor->update($requestID, [], ['Status']);
                         $this->setFlashMessage('success', 'Thank you for your donation');
                         Application::Redirect('/');
                     }else{
                         $this->setFlashMessage('error','Something went wrong');
                         Application::Redirect('/');
                     }
                 }else{
                     $this->setFlashMessage('error','Something went wrong');
                     Application::Redirect('/');
                 }
             }
        }
     }

    public function home(): string
    {
        $Blogs = Blog::RetrieveAll();
        /** @var Campaign[] $AllCampaigns */
        $AllCampaigns = Campaign::getActiveCampaigns();
        usort($AllCampaigns,function ($a,$b){
            return $a->getCampaignDate() > $b->getCampaignDate();
        });
        $SponsoredCampaigns = [];
        if ($AllCampaigns) {
            foreach ($AllCampaigns as $Campaign) {
                if ($Campaign->IsRequestedSponsorship() && $Campaign->getSponsorshipRequest()->getToBeSponsoredAmount() > 0) {
                    $SponsoredCampaigns[] = [
                        'id' => $Campaign->getCampaignId(),
                        'name' => $Campaign->getCampaignName(),
                        'location' => $Campaign->getVenue(),
                        'amount' => $Campaign->getSponsorshipRequest()->getSponsorshipAmount(),
                        'latitude' => $Campaign->getLatitude(),
                        'longitude' => $Campaign->getLongitude(),
                    ];
                }
            }
        }
        $SponsoredCampaigns = array_merge(...array_fill(0,100,$SponsoredCampaigns));
//        $Blogs = array_merge(...array_fill(0,10,$Blogs));
        $params=[
            'name'=>['first'=>'Mohamed','last'=>'Ali'],
            'Author'=>'Dinushan Vimukthi',
            'campaigns'=>$SponsoredCampaigns,

        ];
        return $this->render('home',['params'=>$params,'Blogs'=>$Blogs,'campaigns'=>$SponsoredCampaigns]);
    }

//    public function gmap(Request $request,Response $response)
//    {
//        $this->layout='none';
//        return $this->render('gmap');
//    }

    public function userRegister(Request $request, Response $response)
    {
        return $this->render('Authentication/UserRegister');
    }

    public function userLogin(Request $request, Response $response)
    {
        return $this->render('Authentication/UserLogin');
    }

    public function about(Request $request,Response $response)
    {
        if($request->isPost()){
            require_once Application::$ROOT_DIR.'/API/adduser.php';
        }
        return $this->render('about');
    }
    public function contact(Request $request,Response $response)
    {
        if($request->isPost()){
            require_once Application::$ROOT_DIR.'/API/adduser.php';
        }
        return $this->render('contact');
    }

    public function ManagerLogin()
    {
        
    }

    public function Test(): string
    {
        $this->layout='none';
        return $this->render('Email/PasswordReset');
    }

}