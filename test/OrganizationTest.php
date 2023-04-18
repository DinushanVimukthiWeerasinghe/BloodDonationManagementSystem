<?php

namespace TEST;

use App\model\users\Organization;
use PHPUnit\Framework\TestCase;

class OrganizationTest extends TestCase
{
    public function testGetOrganizationName():void
    {
        $organization = new Organization();
        $organization->setOrganizationName('Suwasahana');
        $this->assertEquals($organization->getOrganizationName(),'Suwasahana');
    }
    public function testGetOrganizationID():void
    {
        $organization = new Organization();
        $organization->setID('Org_02');
        $this->assertEquals($organization->getID(),'Org_02');
    }
    public function testGetOrganizationEmail():void
    {
        $organization = new Organization();
        $organization->setEmail('amal@gmail.com');
        $this->assertEquals($organization->getEmail(),'amal@gmail.com');
    }

}
