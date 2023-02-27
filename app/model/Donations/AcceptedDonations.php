<?php


namespace App\model\Donations;

use App\model\database\dbModel;

class AcceptedDonations extends dbModel
{
    protected string $Donation_ID = '';
    protected string $Donor_ID = '';
    protected string $Packet_ID = '';
    protected string $Donated_At = '';
    protected string $Retrieved_By = '';
    protected string $In_Time = '';
    protected string $Out_Time = '';
    protected string $Verified_By = '';

    public function labels(): array
    {
        // TODO: Implement labels() method.
        return [
            "Donation_ID" => "Donation ID",
            "Donor_ID" => "Donor ID",
            "Packet_ID" => "Packet ID",
            "Donated_At" => "Donated At",
            "Retrieved_By" => "Retrieved By",
            "In_Time" => "In Time",
            "Out_Time" => "Out Time",
            "Verified_By" => "Verified By",
        ];

    }

    public function rules(): array
    {
        // TODO: Implement rules() method.
        return [
            "Donation_ID" => [self::RULE_REQUIRED],
            "Donor_ID" => [self::RULE_REQUIRED],
            'Packet_ID' => [self::RULE_REQUIRED],
            "Donated_At" => [self::RULE_REQUIRED],
            "Retrieved_By" => [self::RULE_REQUIRED],
            "In_Time" => [self::RULE_REQUIRED],
            "Out_Time" => [self::RULE_REQUIRED],
            "Verified_By" => [self::RULE_REQUIRED],
        ];
    }

    public static function getTableShort(): string
    {
        // TODO: Implement getTableShort() method.
        return 'Accepted_Donations';
    }

    public static function tableName(): string
    {
        // TODO: Implement tableName() method.
        return 'Accepted_Donations';
    }

    public static function PrimaryKey(): string
    {
        // TODO: Implement PrimaryKey() method.
        return 'Donation_ID';
    }

    public function attributes(): array
    {
        // TODO: Implement attributes() method.
        return [
            'Donation_ID',
            'Donor_ID',
            'Packet_ID',
            'Donated_At',
            'Retrieved_By',
            'In_Time',
            'Out_Time',
            'Verified_By'
        ];
    }

    public function getPacketId(): string{
        return $this->Packet_ID;
    }

    public function getDonationId(): string{
        return $this->Donation_ID;
    }

    public function getDonationDateTime(): string
    {
        return $this->Donated_At;
    }

}
