<?php

namespace Unit;

use App\model\users\Donor;
use Couchbase\Role;

class DonorTest extends \PHPUnit\Framework\TestCase
{

    public function testGetDonorBloodGroup(){
        $donor = new Donor();
        $donor->setBloodGroup('A+');
        $this->assertEquals($donor->getBloodGroup(),'A+');
    }

    public function testGetDonorID() {
        $donor = new Donor();
        $donor->setDonorID('Dnr_001');
        $this->assertEquals($donor->getDonorID(),'Dnr_001');
    }

    public function testGetDonorAvailability(){
        $donor = new Donor();
        $donor->setDonationAvailability(Donor::AVAILABILITY_AVAILABLE);
        $this->assertEquals($donor->getDonationAvailability() ,Donor::AVAILABILITY_AVAILABLE);
    }

    public function testGetBloodDonationBook1() {
        $donor = new Donor();
        $donor->setBloodDonationBook1('Blood Donation Book 1');
        $this->assertEquals($donor->getBloodDonationBook1(),'Blood Donation Book 1');
    }

    public function testGetBloodDonationBook2() {
        $donor = new Donor();
        $donor->setBloodDonationBook2('Blood Donation Book 2');
        $this->assertEquals($donor->getBloodDonationBook2(),'Blood Donation Book 2');
    }

    public function testGetDonationAvailabilityDate() {
        $donor = new Donor();
        $donor->setDonationAvailabilityDate('2023-05-14');
        $this->assertEquals($donor->getDonationAvailabilityDate(),'2023-05-14');
    }

    public function testGetRole() {
        $donor = new Donor();
        $this->assertEquals($donor->getRole(),'Donor');
    }

    public function testGetNearestBank() {
        $donor = new Donor();
        $donor->setNearestBank('Nearest Bank');
        $this->assertEquals($donor->getNearestBank(),'Nearest Bank');
    }

    public function testGetVerified()
    {
        $donor = new Donor();
        $donor->setVerified(Donor::VERIFIED);
        $this->assertEquals($donor->getVerified(),Donor::VERIFIED);
    }

    public function testGetVerifiedAt() {
        $donor = new Donor();
        $donor->setVerifiedAt('Verified At');
        $this->assertEquals($donor->getVerifiedAt(), 'Verified At');
    }

    public function testGetVerifiedBy() {
        $donor = new Donor();
        $donor->setVerifiedBy('Verified By');
        $this->assertEquals($donor->getVerifiedBy(), 'Verified By');
    }

    public function testGetVerificationRemarks() {
        $donor = new Donor();
        $donor->setVerificationRemarks('Remarks');
        $this->assertEquals($donor->getVerificationRemarks(), 'Remarks');
    }
    public function testGetBloodPacketID() {
        $donor = new Donor();
        $donor->setBloodPacketID('BloodPacketID');
        $this->assertEquals($donor->getBloodPacketID(), 'BloodPacketID');
    }

    public function testGetCreatedAt() {
        $donor = new Donor();
        $donor->setCreatedAt('Created At');
        $this->assertEquals($donor->getCreatedAt(), 'Created At');
    }

    public function testGetUpdatedAt() {
        $donor = new Donor();
        $donor->setUpdatedAt('Updated At');
        $this->assertEquals($donor->getUpdatedAt(), 'Updated At');
    }

    public function testGetNICFront() {
        $donor = new Donor();
        $donor->setNICFront('NIC Front');
        $this->assertEquals($donor->getNICFront(), 'NIC Front');
    }

    public function testGetNICBack() {
        $donor = new Donor();
        $donor->setNICBack('NIC Back');
        $this->assertEquals($donor->getNICBack(), 'NIC Back');
    }

//    public function testGet

}