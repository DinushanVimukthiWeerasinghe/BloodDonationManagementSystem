<?php

namespace App\model\users;

use App\model\database\dbModel;

abstract class Person extends dbModel
{
    protected string $ID='';
    protected string $First_Name='';
    protected string $Last_Name='';
    protected string $Address1='';
    protected string $Address2='';
    protected string $City='';
    protected string $NIC='';
    protected string $Gender='';
    protected string $Nationality='';
    protected string $Contact_No='';
    protected string $Email='';
    protected string $Profile_Image='';
    protected bool $Availability=true;
    protected string $Status='';

    /**
     * @return string
     */
    public function getGender(): string
    {
        return $this->Gender;
    }

    public function getLastActive(): string
    {
        //TODO Implement this
        return 'Last Active';
    }

    /**
     * @param string $Gender
     */
    public function setGender(string $Gender): void
    {
        $this->Gender = $Gender;
    }

    /**
     * @return string
     */
    public function getNationality(): string
    {
        return $this->Nationality;
    }

    /**
     * @param string $Nationality
     */
    public function setNationality(string $Nationality): void
    {
        $this->Nationality = $Nationality;
    }


    public function getAddress(): string
    {
        return $this->Address1.' '.$this->Address2.' '.$this->City;
    }

    public function setID(string $ID): void
    {
        $this->ID = $ID;
    }

    /**
     * @return string
     */
    public function getID(): string
    {
        return $this->ID;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->Status;
    }

    /**
     * @param string $Status
     */
    public function setStatus(string $Status): void
    {
        $this->Status = $Status;
    }

    public function getFullName(): string
    {
        return $this->First_Name.' '.$this->Last_Name;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->First_Name;
    }

    /**
     * @param string $First_Name
     */
    public function setFirstName(string $First_Name): void
    {
        $this->First_Name = $First_Name;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->Last_Name;
    }

    /**
     * @param string $Last_Name
     */
    public function setLastName(string $Last_Name): void
    {
        $this->Last_Name = $Last_Name;
    }

    /**
     * @return string
     */
    public function getAddress1(): string
    {
        return $this->Address1;
    }

    /**
     * @param string $Address1
     */
    public function setAddress1(string $Address1): void
    {
        $this->Address1 = $Address1;
    }

    /**
     * @return string
     */
    public function getAddress2(): string
    {
        return $this->Address2;
    }

    /**
     * @param string $Address2
     */
    public function setAddress2(string $Address2): void
    {
        $this->Address2 = $Address2;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->City;
    }

    /**
     * @param string $City
     */
    public function setCity(string $City): void
    {
        $this->City = $City;
    }

    /**
     * @return string
     */
    public function getNIC(): string
    {
        return $this->NIC;
    }

    /**
     * @param string $NIC
     */
    public function setNIC(string $NIC): void
    {
        $this->NIC = $NIC;
    }

    /**
     * @return string
     */
    public function getContactNo(): string
    {
        return $this->Contact_No;
    }

    /**
     * @param string $Contact_No
     */
    public function setContactNo(string $Contact_No): void
    {
        $this->Contact_No = $Contact_No;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->Email;
    }

    /**
     * @param string $Email
     */
    public function setEmail(string $Email): void
    {
        $this->Email = $Email;
    }

    /**
     * @return string
     */
    public function getProfileImage(): string
    {
        return $this->Profile_Image;
    }

    /**
     * @param string $Profile_Image
     */
    public function setProfileImage(string $Profile_Image): void
    {
        $this->Profile_Image = $Profile_Image;
    }

    /**
     * @return bool
     */
    public function isAvailability(): bool
    {
        return $this->Availability;
    }

    /**
     * @param bool $Availability
     */
    public function setAvailability(bool $Availability): void
    {
        $this->Availability = $Availability;
    }




}