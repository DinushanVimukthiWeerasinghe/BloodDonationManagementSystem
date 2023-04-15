<?php

namespace App\model\Requests;

//TODO : Create Blood Request Model
use App\model\database\dbModel;
use App\model\users\Hospital;

class BloodRequest extends dbModel
{
    public const NORMAL_REQUEST = 1;
    public const CRITICAL_REQUEST = 2;
    public const REQUEST_STATUS_PENDING = 1;
    public const REQUEST_STATUS_FULFILLED = 2;
    protected string $Request_ID;
    protected string $BloodGroup;
    protected string $Requested_By;
    protected string $Requested_At;
    protected int $Status=1;
    protected int $Type=1;
    protected float $Volume = 0.0;

    /**
     * @return int
     */
    public function getType(): string
    {
        return match ($this->Type) {
            self::NORMAL_REQUEST => 'Normal Request',
            self::CRITICAL_REQUEST => 'Emergency Request',
        };
    }



    /**
     * @param int $Type
     */
    public function setType(int $Type): void
    {
        $this->Type = $Type;
    }

    /**
     * @return float
     */
    public function getVolume(): float
    {
        return $this->Volume;
    }

    /**
     * @param float $Volume
     */
    public function setVolume(float $Volume): void
    {
        $this->Volume = $Volume;
    }



    /**
     * @return string
     */
    public function getRequestID(): string
    {
        return $this->Request_ID;
    }

    public function getBloodTypeImage()
    {
        switch ($this->BloodGroup) {
            case 'A+':
                return '/public/images/icons/BloodType/A+.png';
            case 'A-':
                return '/public/images/icons/BloodType/A-.png';
            case 'B+':
                return '/public/images/icons/BloodType/B+.png';
            case 'B-':
                return '/public/images/icons/BloodType/B-.png';
            case 'AB+':
                return '/public/images/icons/BloodType/AB+.png';
            case 'AB-':
                return '/public/images/icons/BloodType/AB-.png';
            case 'O+':
                return '/public/images/icons/BloodType/O+.png';
            case 'O-':
                return '/public/images/icons/BloodType/O-.png';
        }
    }

    /**
     * @param string $Request_ID
     */
    public function setRequestID(string $Request_ID): void
    {
        $this->Request_ID = $Request_ID;
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
    public function getRequestedBy(): string
    {
        $Hospital = Hospital::findOne(['Hospital_ID' => $this->Requested_By]);
        return $Hospital->getHospitalName();
    }

    /**
     * @param string $RequestedBy
     */
    public function setRequestedBy(string $RequestedBy): void
    {
        $this->RequestedBy = $RequestedBy;
    }

    /**
     * @return string
     */
    public function getRequestedAt(): string
    {
        return $this->Requested_At;
    }

    /**
     * @param string $Requested_At
     */
    public function setRequestedAt(string $Requested_At): void
    {
        $this->Requested_At = $Requested_At;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->Status;
    }

    public function getRequestStatus()
    {
        return match ($this->Status) {
            self::REQUEST_STATUS_PENDING => 'Pending',
            self::REQUEST_STATUS_FULFILLED => 'Fulfilled',
        };
    }

    /**
     * @param string $Status
     */
    public function setStatus(string $Status): void
    {
        $this->Status = $Status;
    }




    public function labels(): array
    {
        return [
            'Request_ID' => 'Request ID',
            'BloodGroup' => 'Blood Group',
            'RequestedBy' => 'Requested By',
            'Requested_At' => 'Requested At',
            'Status' => 'Status',
            'Type' => 'Type',
            'Volume' => 'Volume'
        ];
    }

    public function rules(): array
    {
        return [
            'Request_ID' => [self::RULE_REQUIRED],
            'BloodGroup' => [self::RULE_REQUIRED],
            'RequestedBy' => [self::RULE_REQUIRED],
            'Requested_At' => [self::RULE_REQUIRED],
            'Status' => [self::RULE_REQUIRED],
            'Type' => [self::RULE_REQUIRED],
            'Volume' => [self::RULE_REQUIRED]
        ];
    }

    public static function getTableShort(): string
    {
        return 'br';
    }

    public static function tableName(): string
    {
        return 'Blood_Requests';
    }

    public static function PrimaryKey(): string
    {
        return 'Request_ID';
    }

    public function attributes(): array
    {
        return [
            'Request_ID',
            'BloodGroup',
            'RequestedBy',
            'Requested_At',
            'Status',
            'Type',
            'Volume'
        ];
    }

}