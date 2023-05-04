<?php

namespace App\model\Donor;

use App\model\users\Donor;

class DonorHealthCheckUp extends \App\model\database\dbModel
{
    protected string $Donor_ID;
    protected string $Campaign_ID;
    protected string $Diseases;
    protected int $GoodHealth;
    protected int $Vaccinated;
    protected int $Tattooed;
    protected int $Pregnant;
    protected int $Pierced;
    protected int $Prisoned;
    protected int $Donated_To_Partner;
    protected int $Went_Abroad;
    protected int $Malaria_Infected;
    protected int $Dengue_Infected;
    protected int $CFever_Infected;
    protected int $Teeth_Removed;
    protected int $Antibiotics_And_Aspirins;
    protected int $Eligible;
    protected ?string $Remarks=null;

    /**
     * @return string
     */
    public function getDonorID(): string
    {
        return $this->Donor_ID;
    }

    /**
     * @param string $Donor_ID
     */
    public function setDonorID(string $Donor_ID): void
    {
        $this->Donor_ID = $Donor_ID;
    }

    /**
     * @return string
     */
    public function getCampaignID(): string
    {
        return $this->Campaign_ID;
    }

    /**
     * @param string $Campaign_ID
     */
    public function setCampaignID(string $Campaign_ID): void
    {
        $this->Campaign_ID = $Campaign_ID;
    }

    /**
     * @return string
     */
    public function getDiseases(): string
    {
        return $this->Diseases;
    }

    /**
     * @param string $Diseases
     */
    public function setDiseases(string $Diseases): void
    {
        $this->Diseases = $Diseases;
    }

    /**
     * @return int
     */
    public function getGoodHealth(): int
    {
        return $this->GoodHealth;
    }

    /**
     * @param int $GoodHealth
     */
    public function setGoodHealth(int $GoodHealth): void
    {
        $this->GoodHealth = $GoodHealth;
    }

    /**
     * @return int
     */
    public function getVaccinated(): int
    {
        return $this->Vaccinated;
    }

    /**
     * @param int $Vaccinated
     */
    public function setVaccinated(int $Vaccinated): void
    {
        $this->Vaccinated = $Vaccinated;
    }

    /**
     * @return int
     */
    public function getTattooed(): int
    {
        return $this->Tattooed;
    }

    /**
     * @param int $Tattooed
     */
    public function setTattooed(int $Tattooed): void
    {
        $this->Tattooed = $Tattooed;
    }

    /**
     * @return int
     */
    public function getPregnant(): int
    {
        return $this->Pregnant;
    }

    /**
     * @param int $Pregnant
     */
    public function setPregnant(int $Pregnant): void
    {
        $this->Pregnant = $Pregnant;
    }

    /**
     * @return int
     */
    public function getPierced(): int
    {
        return $this->Pierced;
    }

    /**
     * @param int $Pierced
     */
    public function setPierced(int $Pierced): void
    {
        $this->Pierced = $Pierced;
    }

    /**
     * @return int
     */
    public function getPrisoned(): int
    {
        return $this->Prisoned;
    }

    /**
     * @param int $Prisoned
     */
    public function setPrisoned(int $Prisoned): void
    {
        $this->Prisoned = $Prisoned;
    }

    /**
     * @return int
     */
    public function getDonatedToPartner(): int
    {
        return $this->Donated_To_Partner;
    }

    /**
     * @param int $Donated_To_Partner
     */
    public function setDonatedToPartner(int $Donated_To_Partner): void
    {
        $this->Donated_To_Partner = $Donated_To_Partner;
    }

    /**
     * @return int
     */
    public function getWentAbroad(): int
    {
        return $this->Went_Abroad;
    }

    /**
     * @param int $Went_Abroad
     */
    public function setWentAbroad(int $Went_Abroad): void
    {
        $this->Went_Abroad = $Went_Abroad;
    }

    /**
     * @return int
     */
    public function getMalariaInfected(): int
    {
        return $this->Malaria_Infected;
    }

    /**
     * @param int $Malaria_Infected
     */
    public function setMalariaInfected(int $Malaria_Infected): void
    {
        $this->Malaria_Infected = $Malaria_Infected;
    }

    /**
     * @return int
     */
    public function getDengueInfected(): int
    {
        return $this->Dengue_Infected;
    }

    /**
     * @param int $Dengue_Infected
     */
    public function setDengueInfected(int $Dengue_Infected): void
    {
        $this->Dengue_Infected = $Dengue_Infected;
    }

    /**
     * @return int
     */
    public function getCFeverInfected(): int
    {
        return $this->CFever_Infected;
    }

    /**
     * @param int $CFever_Infected
     */
    public function setCFeverInfected(int $CFever_Infected): void
    {
        $this->CFever_Infected = $CFever_Infected;
    }

    /**
     * @return int
     */
    public function getTeethRemoved(): int
    {
        return $this->Teeth_Removed;
    }

    /**
     * @param int $Teeth_Removed
     */
    public function setTeethRemoved(int $Teeth_Removed): void
    {
        $this->Teeth_Removed = $Teeth_Removed;
    }

    /**
     * @return int
     */
    public function getAntibioticsAndAspirins(): int
    {
        return $this->Antibiotics_And_Aspirins;
    }

    /**
     * @param int $Antibiotics_And_Aspirins
     */
    public function setAntibioticsAndAspirins(int $Antibiotics_And_Aspirins): void
    {
        $this->Antibiotics_And_Aspirins = $Antibiotics_And_Aspirins;
    }

    public function getEligible(): int
    {
        return $this->Eligible;
    }

    public function setEligible(int $Eligible): void
    {
        $this->Eligible = $Eligible;
    }

    public function IsEligible()
    {
        //TODO : Check if the donor is eligible to donate blood
        $this->setEligible(2);
        return true;
    }

    public function labels(): array
    {
        return [
            'Donor_ID' => 'Donor ID',
            'Campaign_ID' => 'Campaign ID',
            'Diseases' => 'Diseases',
            'GoodHealth' => 'Good Health',
            'Vaccinated' => 'Vaccinated',
            'Tattooed' => 'Tattooed',
            'Pregnant' => 'Pregnant',
            'Pierced' => 'Pierced',
            'Prisoned' => 'Prisoned',
            'Donated_To_Partner' => 'Donated To Partner',
            'Went_Abroad' => 'Went Abroad',
            'Malaria_Infected' => 'Malaria Infected',
            'Dengue_Infected' => 'Dengue Infected',
            'CFever_Infected' => 'CFever Infected',
            'Teeth_Removed' => 'Teeth Removed',
            'Antibiotics_And_Aspirins' => 'Antibiotics And Aspirins',
        ];
    }

    public function rules(): array
    {
        return [
            'Donor_ID' => [self::RULE_REQUIRED],
            'Campaign_ID' => [self::RULE_REQUIRED],
            'Diseases' => [self::RULE_REQUIRED],
            'GoodHealth' => [self::RULE_REQUIRED],
            'Vaccinated' => [self::RULE_REQUIRED],
            'Tattooed' => [self::RULE_REQUIRED],
            'Pregnant' => [self::RULE_REQUIRED],
            'Pierced' => [self::RULE_REQUIRED],
            'Prisoned' => [self::RULE_REQUIRED],
            'Donated_To_Partner' => [self::RULE_REQUIRED],
            'Went_Abroad' => [self::RULE_REQUIRED],
            'Malaria_Infected' => [self::RULE_REQUIRED],
            'Dengue_Infected' => [self::RULE_REQUIRED],
            'CFever_Infected' => [self::RULE_REQUIRED],
            'Teeth_Removed' => [self::RULE_REQUIRED],
            'Antibiotics_And_Aspirins' => [self::RULE_REQUIRED],
        ];
    }

    public static function getTableShort(): string
    {
        return 'dhc';
    }

    public static function tableName(): string
    {
        return 'Donor_Health_Checkup';
    }

    public static function PrimaryKey(): string
    {
        return 'Donor_ID';
    }

    public function attributes(): array
    {
        return [
            'Donor_ID',
            'Campaign_ID',
            'Diseases',
            'GoodHealth',
            'Vaccinated',
            'Tattooed',
            'Pregnant',
            'Pierced',
            'Prisoned',
            'Donated_To_Partner',
            'Went_Abroad',
            'Malaria_Infected',
            'Dengue_Infected',
            'CFever_Infected',
            'Teeth_Removed',
            'Antibiotics_And_Aspirins',
            'Eligible',
            'Remarks'
        ];
    }

    public function getDonor()
    {
        return Donor::findOne(['Donor_ID' => $this->Donor_ID]);
    }
}