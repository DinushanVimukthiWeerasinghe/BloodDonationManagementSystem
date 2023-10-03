<?php

namespace Unit;

use App\model\users\Organization;
use PHPUnit\Framework\TestCase;

class OrganizationTest extends TestCase
{
    public function testGetOrganizationName():void
    {
        $organization = new Organization();
        $organization->setOrganizationName('Suwasahana');
        $this->assertEquals('Suwasahana', $organization->getOrganizationName());
    }
    public function testGetOrganizationID():void
    {
        $organization = new Organization();
        $organization->setID('Org_02');
        $this->assertEquals('Org_02', $organization->getID());
    }
    public function testGetOrganizationEmail():void
    {
        $organization = new Organization();
        $organization->setEmail('amal@gmail.com');
        $this->assertEquals('amal@gmail.com', $organization->getEmail());
    }

}
