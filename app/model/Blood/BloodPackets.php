<?php

namespace App\model\Blood;

use App\model\database\dbModel;

class BloodPackets extends dbModel
{
    const STATUS_STORED = 1;
    protected string $Packet_ID='';
    protected string $Donation_ID='';
    protected string $Packed_By='';
    protected string $BloodGroup='';
    protected string $Status='';
    protected string $Stored_At='';
    protected ?string $Remarks=null;

    /**
     * @return string
     */
    public function getPacketID(): string
    {
        return $this->Packet_ID;
    }

    /**
     * @param string $Packet_ID
     */
    public function setPacketID(string $Packet_ID): void
    {
        $this->Packet_ID = $Packet_ID;
    }

    /**
     * @return string
     */
    public function getPackedBy(): string
    {
        return $this->Packed_By;
    }

    /**
     * @param string $Packed_By
     */
    public function setPackedBy(string $Packed_By): void
    {
        $this->Packed_By = $Packed_By;
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


    /**
     * @return string
     */
    public function getStoredAt(): string
    {
        return $this->Stored_At;
    }

    /**
     * @param string $Stored_At
     */
    public function setStoredAt(string $Stored_At): void
    {
        $this->Stored_At = $Stored_At;
    }

    /**
     * @return string
     */
    public function getDonationID(): string
    {
        return $this->Donation_ID;
    }

    /**
     * @param string $Donation_ID
     */
    public function setDonationID(string $Donation_ID): void
    {
        $this->Donation_ID = $Donation_ID;
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

    public function labels(): array
    {
        return [
            'Packet_ID' => 'Packet ID',
            'Packed_By' => 'Packed By',
            'BloodGroup' => 'Blood Group',
            'Status' => 'Status',
            'Stored_At' => 'Stored At',
            'Remarks' => 'Remarks',
            'Donation_ID' => 'Donation ID',
        ];
    }

    public function rules(): array
    {
        return [
            'Packet_ID' => [self::RULE_REQUIRED,self::RULE_UNIQUE],
            'Packed_By' => [self::RULE_REQUIRED],
            'BloodGroup' => [self::RULE_REQUIRED],
            'Status' => [self::RULE_REQUIRED],
            'Stored_At' => [self::RULE_REQUIRED],
            'Donation_ID' => [self::RULE_REQUIRED],
        ];
    }

    public static function getTableShort(): string
    {
        return 'blood_packets';
    }

    public static function tableName(): string
    {
        return 'Blood_Packets';
    }

    public static function PrimaryKey(): string
    {
        return 'Packet_ID';
    }

    public function attributes(): array
    {
        return ['Packet_ID','Packed_By','BloodGroup','Status','Stored_At','Remarks','Donation_ID'];
    }
}