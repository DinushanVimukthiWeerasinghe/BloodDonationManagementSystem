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

    /**
     * @param string $Donation_ID
     */
    public function setDonationID(string $Donation_ID): void
    {
        $this->Donation_ID = $Donation_ID;
    }

    /**
     * @param string $Donor_ID
     */
    public function setDonorID(string $Donor_ID): void
    {
        $this->Donor_ID = $Donor_ID;
    }

    /**
     * @param string $Packet_ID
     */
    public function setPacketID(string $Packet_ID): void
    {
        $this->Packet_ID = $Packet_ID;
    }

    /**
     * @param string $Donated_At
     */
    public function setDonatedAt(string $Donated_At): void
    {
        $this->Donated_At = $Donated_At;
    }

    /**
     * @param string $Retrieved_By
     */
    public function setRetrievedBy(string $Retrieved_By): void
    {
        $this->Retrieved_By = $Retrieved_By;
    }

    /**
     * @param string $In_Time
     */
    public function setInTime(string $In_Time): void
    {
        $this->In_Time = $In_Time;
    }

    /**
     * @param string $Out_Time
     */
    public function setOutTime(string $Out_Time): void
    {
        $this->Out_Time = $Out_Time;
    }

    /**
     * @param string $Verified_By
     */
    public function setVerifiedBy(string $Verified_By): void
    {
        $this->Verified_By = $Verified_By;
    }

    /**
     * @return string
     */
    public function getDonorID(): string
    {
        return $this->Donor_ID;
    }

    /**
     * @return string
     */
    public function getDonatedAt(): string
    {
        return $this->Donated_At;
    }

    /**
     * @return string
     */
    public function getRetrievedBy(): string
    {
        return $this->Retrieved_By;
    }

    /**
     * @return string
     */
    public function getInTime(): string
    {
        return $this->In_Time;
    }

    /**
     * @return string
     */
    public function getOutTime(): string
    {
        return $this->Out_Time;
    }

    /**
     * @return string
     */
    public function getVerifiedBy(): string
    {
        return $this->Verified_By;
    }



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
