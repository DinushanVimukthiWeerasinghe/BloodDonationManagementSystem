<?php

namespace App\model\Donor;

use App\model\users\Donor;

class DonorHealthCheckUp extends \App\model\database\dbModel
{
    public const TIME_PERIOD_1_MONTHS = 5;
    public const TIME_PERIOD_3_MONTHS = 1;
    public const TIME_PERIOD_UNTIL_NEXT_CAMPAIGN = 2;
    public const TIME_PERIOD_6_MONTHS = 3;
    public const TIME_PERIOD_12_MONTHS = 4;
    public const TIME_PERIOD_EVER = 6;
    public const Doctor_Recommend = 2;
    public const Doctor_Not_Recommend = 1;
    public const ELIGIBLE = 2;
    public const NOT_ELIGIBLE = 1;
    public const GOOD_HEALTH = 1;
    public const NOT_GOOD_HEALTH = 2;
    public const VACCINATED = 1;
    public const NOT_VACCINATED = 2;
    public const TATTOOED = 1;
    public const NOT_TATTOOED = 2;
    public const PREGNANT = 1;
    public const NOT_PREGNANT = 2;
    public const PIERCED = 1;
    public const NOT_PIERCED = 2;

    public const PRISONED = 1;
    public const NOT_PRISONED = 2;
    public const DONATED_TO_PARTNER = 1;
    public const NOT_DONATED_TO_PARTNER = 2;
    public const WENT_ABROAD = 1;
    public const NOT_WENT_ABROAD = 2;
    public const MALARIA_INFECTED = 1;
    public const NOT_MALARIA_INFECTED = 2;
    public const DENGUE_INFECTED = 1;
    public const NOT_DENGUE_INFECTED = 2;
    public const CFEVER_INFECTED = 1;
    public const NOT_CFEVER_INFECTED = 2;
    public const TEETH_REMOVED = 1;
    public const NOT_TEETH_REMOVED = 2;
    public const ANTIBIOTICS_AND_ASPIRINS = 1;
    public const NOT_ANTIBIOTICS_AND_ASPIRINS = 2;

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
    protected int $Recommendation;
    protected string $Recommend_By;
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

    /**
     * @return int
     */
    public function getRecommendation(): int
    {
        return $this->Recommendation;
    }

    /**
     * @param int $Recommendation
     */
    public function setRecommendation(int $Recommendation): void
    {
        $this->Recommendation = $Recommendation;
    }

    /**
     * @return string
     */
    public function getRecommendBy(): string
    {
        return $this->Recommend_By;
    }

    /**
     * @param string $Recommend_By
     */
    public function setRecommendBy(string $Recommend_By): void
    {
        $this->Recommend_By = $Recommend_By;
    }

    /**
     * @return string|null
     */
    public function getRemarks(): ?string
    {
        return $this->Remarks;
    }

    /**
     * @param string|null $Remarks
     */
    public function setRemarks(?string $Remarks): void
    {
        $this->Remarks = $Remarks;
    }



    public function IsEligible()
    {
        //TODO : Check if the donor is eligible to donate blood
        $this->Eligible = self::ELIGIBLE;
        $TimePeriod = null;
        if(trim($this->getDiseases()) !== "None"){
            $this->setEligible(self::NOT_ELIGIBLE);
        }
        if($this->getGoodHealth() == self::NOT_GOOD_HEALTH){
            $TimePeriod =self::TIME_PERIOD_UNTIL_NEXT_CAMPAIGN;
            $this->setEligible(self::NOT_ELIGIBLE);
        }
        if($this->getVaccinated() == self::VACCINATED){
            $TimePeriod =self::TIME_PERIOD_12_MONTHS;
            $this->setEligible(self::NOT_ELIGIBLE);
        }
        if($this->getTattooed() == self::TATTOOED){
            $TimePeriod =self::TIME_PERIOD_12_MONTHS;
            $this->setEligible(self::NOT_ELIGIBLE);
        }
        if($this->getPregnant() == self::PREGNANT){
            $TimePeriod =self::TIME_PERIOD_12_MONTHS;
            $this->setEligible(self::NOT_ELIGIBLE);
        }
        if($this->getPierced() == self::PIERCED){
            $TimePeriod =self::TIME_PERIOD_12_MONTHS;
            $this->setEligible(self::NOT_ELIGIBLE);
        }
        if($this->getPrisoned() == self::PRISONED){
            $TimePeriod =self::TIME_PERIOD_12_MONTHS;
            $this->setEligible(self::NOT_ELIGIBLE);
        }
        if($this->getDonatedToPartner() == self::DONATED_TO_PARTNER){
            $TimePeriod =self::TIME_PERIOD_12_MONTHS;
            $this->setEligible(self::NOT_ELIGIBLE);
        }
        if($this->getWentAbroad() == self::WENT_ABROAD){
            $TimePeriod =self::TIME_PERIOD_12_MONTHS;
            $this->setEligible(self::NOT_ELIGIBLE);
        }
        if($this->getMalariaInfected() == self::MALARIA_INFECTED){
            $TimePeriod =self::TIME_PERIOD_12_MONTHS;
            $this->setEligible(self::NOT_ELIGIBLE);
        }
        // Time Period for Below Diseases is 6 Months
        if($this->getDengueInfected() == self::DENGUE_INFECTED){
            $TimePeriod =self::TIME_PERIOD_6_MONTHS;
            $this->setEligible(self::NOT_ELIGIBLE);
        }
        if($this->getCFeverInfected() == self::CFEVER_INFECTED){
            $TimePeriod =self::TIME_PERIOD_6_MONTHS;
            $this->setEligible(self::NOT_ELIGIBLE);
        }
        if($this->getTeethRemoved() == self::TEETH_REMOVED){
            $TimePeriod =self::TIME_PERIOD_6_MONTHS;
            $this->setEligible(self::NOT_ELIGIBLE);
        }
        if($this->getAntibioticsAndAspirins() == self::ANTIBIOTICS_AND_ASPIRINS){
            $TimePeriod =self::TIME_PERIOD_6_MONTHS;
            $this->setEligible(self::NOT_ELIGIBLE);
        }
        if($this->getEligible() ===self::ELIGIBLE){
            if ($this->getRecommendation()===self::Doctor_Not_Recommend){
                $TimePeriod =self::TIME_PERIOD_UNTIL_NEXT_CAMPAIGN;
                $this->setEligible(self::NOT_ELIGIBLE);
            }
        }
        if ($this->getEligible()===self::NOT_ELIGIBLE){
            /** @var Donor $Donor */
            $Donor = Donor::findOne(['Donor_ID'=>$this->getDonorID()]);
            if ($TimePeriod === self::TIME_PERIOD_EVER){
                $Donor->setDonationAvailability(Donor::AVAILABILITY_PERMANENT_UNAVAILABLE);
            }else{
                $Donor->setDonationAvailability(Donor::AVAILABILITY_TEMPORARY_UNAVAILABLE);
                $Donor->setDonationAvailabilityDate($this->getDonationAvailableTime($TimePeriod));
            }
            $Donor->update($Donor->getDonorID(),[],['Donation_Availability','Donation_Availability_Date']);
            return false;
        }
        return true;
    }

    public function getDonationAvailableTime($TimePeriod)
    {
        return match ($TimePeriod) {
            self::TIME_PERIOD_6_MONTHS => date('Y-m-d', strtotime('+6 months')),
            self::TIME_PERIOD_12_MONTHS => date('Y-m-d', strtotime('+12 months')),
            self::TIME_PERIOD_3_MONTHS => date('Y-m-d', strtotime('+3 months')),
            self::TIME_PERIOD_1_MONTHS => date('Y-m-d', strtotime('+1 months')),
            self::TIME_PERIOD_EVER => date('Y-m-d', strtotime('+100 years')),
            default => date('Y-m-d', strtotime('+1 days')),
        };
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
            'Recommendation' => 'Recommendation',
            'Recommendation_By' => 'Recommendation By',
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
            'Remarks',
            'Recommendation',
            'Recommend_By',
        ];
    }

    public function getDonor()
    {
        return Donor::findOne(['Donor_ID' => $this->Donor_ID]);
    }
}