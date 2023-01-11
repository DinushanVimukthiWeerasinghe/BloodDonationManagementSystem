<?php

namespace App\model\Blood;

use App\model\database\dbModel;

class BloodPackets extends dbModel
{
    protected string $Packet_ID='';
    protected string $Packed_By='';
    protected string $BloodGroup='';
    protected string $Status='';
    protected string $Certified_By='';
    protected string $Stored_At='';
    public function labels(): array
    {
        return [
            'Packet_ID' => 'Packet ID',
            'Packed_By' => 'Packed By',
            'BloodGroup' => 'Blood Group',
            'Status' => 'Status',
            'Certified_By' => 'Certified By',
            'Stored_At' => 'Stored At',
        ];
    }

    public function rules(): array
    {
        return [
            'Packet_ID' => [self::RULE_REQUIRED,self::RULE_UNIQUE],
            'Packed_By' => [self::RULE_REQUIRED],
            'BloodGroup' => [self::RULE_REQUIRED],
            'Status' => [self::RULE_REQUIRED],
            'Certified_By' => [self::RULE_REQUIRED],
            'Stored_At' => [self::RULE_REQUIRED],
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
        return ['Packet_ID','Packed_By','BloodGroup','Status','Certified_By','Stored_At'];
    }
}