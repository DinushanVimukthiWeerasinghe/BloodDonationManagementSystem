<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;

class FeatureContext implements Context
{
    private $driver;
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
//        Set Capability values
        $this->setCapability();
    }

    private function setCapability()
    {
        $host = 'http://localhost:4444/wd/hub'; // this is the default
//        Get Capability on php-webdriver
        $capabilities = DesiredCapabilities::chrome();
        $driver = RemoteWebDriver::create($host, $capabilities, 5000);
        $this->driver = $driver;
        $driver->manage()->window()->maximize();
    }
}
