<?php

namespace Unit;

use App\model\Campaigns\Campaign;
use App\model\Requests\SponsorshipRequest;
use Codeception\Template\Unit;
use Codeception\Test\Test;
use Core\Application;
use Dotenv\Dotenv;
use PHPMailer\PHPMailer\Exception;
use Tests\Support\FunctionalTester;
use Unit\SponsorshipRequestTest;

class RequestSponsorshipTest extends \Codeception\Test\Unit
{
    /**
     * @var FunctionalTester
     */
    protected FunctionalTester $tester;



    protected function _before()
    {
    }

    /**
     * @throws Exception
     */
    private function getApp(): Application
    {
        require_once __DIR__ . '/../../vendor/autoload.php';
        $dotenv = Dotenv::createImmutable(dirname(__DIR__).'/../');
        $dotenv->load();



        require_once __DIR__ . '/../../public/config.php';


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

        return new Application(dirname(__DIR__), $config);
    }

    /**
     * @dataprovider  ValidRequestIDProvider
     * @param $sponsorship_ID
     * @param bool $expected
     * @return void
     * @throws Exception
     */
    public function stestSponsorshipRequest($sponsorship_ID,bool $expected){
        session_abort();
        $app = $this->getApp();
        $sponsorship = new SponsorshipRequest();
        $sponsorship->setSponsorshipID($sponsorship_ID);
        $sponsorship->setCampaignID('Camp_645b4ebc92123');
        $sponsorship->setSponsorshipAmount(50000);
        $sponsorship->setSponsorshipStatus(SponsorshipRequest::STATUS_PENDING);
        $sponsorship->setSponsorshipDate(date('Y-m-d'));
        $sponsorship->setDescription('This is a test Description');
        $this->assertEquals($expected,$sponsorship->save());

    }

    public function ValidRequestIDProvider(): array
    {
        return [
            ['',false],
            ['spn_005',true],
        ];
    }

}