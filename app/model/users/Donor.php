<?php

namespace App\model\users;

class Donor extends Person
{
    protected string $Donor_ID = '';
    protected string $Nearest_Bank = '';
    protected int $Donation_Availability = 0;
    protected int $Verified=0;
    protected ?string $Verified_At='';
    protected ?string $Verified_By=Null;
    protected ?string $Verification_Remarks='';
    protected ?string $BloodPacket_ID='';
    protected string $Created_At='';
    protected string $Updated_At='';

    public function getID(): string
    {
        return $this->Donor_ID;
    }
    /**
     * @return string
     */
    public function getRole():string
    {
        return 'Donor';
    }



    public function labels(): array
    {
        return [
            'Donor_ID'=>'Donor ID',
            'Nearest_Bank'=>'Nearest Bank',
            'Donation_Availability'=>'Donation Availability',
            'Verified'=>'Verified',
            'Verified_At'=>'Verified At',
            'Verified_By'=>'Verified By',
            'Verification_Remarks'=>'Verification Remarks',
            'BloodPacket_ID'=>'Blood Packet ID',
            'Created_At'=>'Created At',
            'Updated_At'=>'Updated At'
        ];
    }

    public function rules(): array
    {
        return [
            'Donor_ID'=>[self::RULE_REQUIRED,self::RULE_UNIQUE],
            'Nearest_Bank'=>[self::RULE_REQUIRED],
            'Donation_Availability'=>[self::RULE_REQUIRED],
            'Verified'=>[self::RULE_REQUIRED],
            'Verified_At'=>[self::RULE_OLDER_DATE]
        ];
    }

    public static function getTableShort(): string
    {
        return 'donor';
    }

    public static function tableName(): string
    {
        return 'Donors';
    }

    public static function PrimaryKey(): string
    {
        return 'Donor_ID';
    }

    public function attributes(): array
    {
        return ['Donor_ID','Nearest_Bank','Donation_Availability','Verified','Verified_At','Verified_By','Verification_Remarks','BloodPacket_ID','Created_At','Updated_At'];
    }

    public function setID(string $ID): void
    {
        $this->Donor_ID = $ID;
    }
}