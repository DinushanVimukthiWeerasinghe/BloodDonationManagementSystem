<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

class HomePageTest extends \Codeception\Test\Unit
{

    protected AcceptanceTester $tester;

    protected function _before()
    {
    }

    // tests

    /**
     * @dataProvider navbarComponentsProvider
     * @param $page
     * @param $element
     * @param $excepted
     * @return void
     */
    public function testNavbarComponents($page,$element,$excepted){
        $I = new AcceptanceTester($this->getScenario());
        $this->tester->amOnPage($page);
        $this->tester->seeElement($element);
        $this->tester->click($element);
        $this->tester->seeInCurrentUrl($excepted);
    }

    public function navbarComponentsProvider()
    {
        return [
            ['/', '#BrandIcon', '/'],
            ['/', '#homeLink', '/'],
            ['/', '#service-panelLink', '/'],
            ['/', '#registerLink', '/register'],
            ['/','#donate-btn','/login'],
            ['/', '#reg-org-btn','/register?role=organization']
        ];
    }


}
