<?php

namespace App\model\Blood;

class DonorBloodCheck extends \App\model\database\dbModel
{

    protected string $Donor_ID='';
    protected string $Campaign_ID='';
    protected string $BloodGroup='';
    protected float $Hemoglobin_Level=0.0;
    protected float $Blood_Pressure=0.0;
    protected float $Blood_Sugar=0.0;
    protected float $Temperature=0.0;
    protected float $Pulse_Rate=0.0;
    protected string $Infection_Diseases='';

    protected int $Antibodies=1;
    protected float $Weight=0.0;
    protected float $Iron_Level=0.0;
    protected int $Eligible=1;
    protected string $Checked_At='';
    protected string $Checked_By='';
    protected string $Remarks='';

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
    public function getBloodGroup(): string
    {
        return $this->BloodGroup;
    }

    /**
     * @param string $BloodGroup
     */
    public function setBloodGroup(string $BloodGroup): void
    {
        $this->BloodGroup = $BloodGroup;
    }

    /**
     * @return float
     */
    public function getHemoglobinLevel(): float
    {
        return $this->Hemoglobin_Level;
    }

    /**
     * @param float $Hemoglobin_Level
     */
    public function setHemoglobinLevel(float $Hemoglobin_Level): void
    {
        $this->Hemoglobin_Level = $Hemoglobin_Level;
    }

    /**
     * @return float
     */
    public function getBloodPressure(): float
    {
        return $this->Blood_Pressure;
    }

    /**
     * @param float $Blood_Pressure
     */
    public function setBloodPressure(float $Blood_Pressure): void
    {
        $this->Blood_Pressure = $Blood_Pressure;
    }

    /**
     * @return float
     */
    public function getTemperature(): float
    {
        return $this->Temperature;
    }

    /**
     * @param float $Temperature
     */
    public function setTemperature(float $Temperature): void
    {
        $this->Temperature = $Temperature;
    }

    /**
     * @return float
     */
    public function getPulseRate(): float
    {
        return $this->Pulse_Rate;
    }

    /**
     * @param float $Pulse_Rate
     */
    public function setPulseRate(float $Pulse_Rate): void
    {
        $this->Pulse_Rate = $Pulse_Rate;
    }

    /**
     * @return string
     */
    public function getInfectionDiseases(): string
    {
        return $this->Infection_Diseases;
    }

    /**
     * @param string $Infection_Diseases
     */
    public function setInfectionDiseases(string $Infection_Diseases): void
    {
        $this->Infection_Diseases = $Infection_Diseases;
    }

    /**
     * @return int
     */
    public function getHIV(): int
    {
        return $this->HIV;
    }

    /**
     * @param int $HIV
     */
    public function setHIV(int $HIV): void
    {
        $this->HIV = $HIV;
    }

    /**
     * @return int
     */
    public function getHepatitisB(): int
    {
        return $this->Hepatitis_B;
    }

    /**
     * @param int $Hepatitis_B
     */
    public function setHepatitisB(int $Hepatitis_B): void
    {
        $this->Hepatitis_B = $Hepatitis_B;
    }

    /**
     * @return int
     */
    public function getHepatitisC(): int
    {
        return $this->Hepatitis_C;
    }

    /**
     * @param int $Hepatitis_C
     */
    public function setHepatitisC(int $Hepatitis_C): void
    {
        $this->Hepatitis_C = $Hepatitis_C;
    }

    /**
     * @return int
     */
    public function getSyphilis(): int
    {
        return $this->Syphilis;
    }

    /**
     * @param int $Syphilis
     */
    public function setSyphilis(int $Syphilis): void
    {
        $this->Syphilis = $Syphilis;
    }

    /**
     * @return int
     */
    public function getMalaria(): int
    {
        return $this->Malaria;
    }

    /**
     * @param int $Malaria
     */
    public function setMalaria(int $Malaria): void
    {
        $this->Malaria = $Malaria;
    }

    /**
     * @return int
     */
    public function getAntibodies(): int
    {
        return $this->Antibodies;
    }

    /**
     * @param int $Antibodies
     */
    public function setAntibodies(int $Antibodies): void
    {
        $this->Antibodies = $Antibodies;
    }

    /**
     * @return float
     */
    public function getWeight(): float
    {
        return $this->Weight;
    }

    /**
     * @param float $Weight
     */
    public function setWeight(float $Weight): void
    {
        $this->Weight = $Weight;
    }

    /**
     * @return float
     */
    public function getIronLevel(): float
    {
        return $this->Iron_Level;
    }

    /**
     * @param float $Iron_Level
     */
    public function setIronLevel(float $Iron_Level): void
    {
        $this->Iron_Level = $Iron_Level;
    }

    /**
     * @return int
     */
    public function getEligible(): int
    {
        return $this->Eligible;
    }

    /**
     * @param int $Eligible
     */
    public function setEligible(int $Eligible): void
    {
        $this->Eligible = $Eligible;
    }

    /**
     * @return string
     */
    public function getCheckedAt(): string
    {
        return $this->Checked_At;
    }

    /**
     * @param string $Checked_At
     */
    public function setCheckedAt(string $Checked_At): void
    {
        $this->Checked_At = $Checked_At;
    }

    /**
     * @return string
     */
    public function getCheckedBy(): string
    {
        return $this->Checked_By;
    }

    /**
     * @param string $Checked_By
     */
    public function setCheckedBy(string $Checked_By): void
    {
        $this->Checked_By = $Checked_By;
    }

    /**
     * @return string
     */
    public function getRemarks(): string
    {
        return $this->Remarks;
    }

    /**
     * @param string $Remarks
     */
    public function setRemarks(string $Remarks): void
    {
        $this->Remarks = $Remarks;
    }

    public function labels(): array
    {
        return [
            'Donor_ID' => 'Donor ID',
            'Campaign_ID' => 'Campaign ID',
            'BloodGroup' => 'Blood Group',
            'Hemoglobin_Level' => 'Hemoglobin Level',
            'Blood_Pressure' => 'Blood Pressure',
            'Temperature' => 'Temperature',
            'Pulse_Rate' => 'Pulse Rate',
            'Infection_Diseases' => 'Infection Diseases',
            'Antibodies' => 'Antibodies',
            'Weight' => 'Weight',
            'Iron_Level' => 'Iron Level',
            'Eligible' => 'Eligible',
            'Checked_At' => 'Checked At',
            'Checked_By' => 'Checked By',
        ];
    }

    public function rules(): array
    {
        return [
            'Donor_ID' =>[self::RULE_REQUIRED],
            'Campaign_ID' => [self::RULE_REQUIRED],
            'BloodGroup' => [self::RULE_REQUIRED],
            'Hemoglobin_Level' => [self::RULE_REQUIRED],
            'Blood_Pressure' => [self::RULE_REQUIRED],
            'Temperature' => [self::RULE_REQUIRED],
            'Pulse_Rate' => [self::RULE_REQUIRED],
            'Infection_Diseases' => [self::RULE_REQUIRED],
            'Antibodies' => [self::RULE_REQUIRED],
            'Weight' => [self::RULE_REQUIRED],
            'Iron_Level' => [self::RULE_REQUIRED],
            'Eligible' => [self::RULE_REQUIRED],
            'Checked_At' => [self::RULE_REQUIRED],
            'Checked_By' => [self::RULE_REQUIRED],
        ];
    }

    public static function getTableShort(): string
    {
        return 'DBC';
    }

    public static function tableName(): string
    {
        return 'Donor_Blood_Check';
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
            'BloodGroup',
            'Hemoglobin_Level',
            'Blood_Pressure',
            'Temperature',
            'Pulse_Rate',
            'Infection_Diseases',
            'Antibodies',
            'Weight',
            'Iron_Level',
            'Eligible',
            'Checked_At',
            'Checked_By',
            'Remarks',
        ];
    }
}