<?php

namespace App\model\Requests;

use App\model\database\dbModel;
use App\model\users\Hospital;

class BloodRequest extends dbModel
{
    public const NORMAL_REQUEST = 1;
    public const CRITICAL_REQUEST = 2;
    public const REQUEST_STATUS_PENDING = 1;
    public const REQUEST_STATUS_FULFILLED = 2;
    public const REQUEST_STATUS_SENT_TO_DONOR = 3;
    protected string $Request_ID;
    protected string $BloodGroup;
    protected string $Requested_By;
    protected string $Requested_At;
    protected ?string $FullFilled_By = null;
    protected ?string $Remarks = null;
    protected int $Status=1;

    protected int $Type=1;
    protected int $Action = 0;
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
     * @return string|null
     */
    public function getFullFilledBy(): ?string
    {
        return $this->FullFilled_By;
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


    /**
     * @param string|null $FullFilled_By
     */
    public function setFullFilledBy(?string $FullFilled_By): void
    {
        $this->FullFilled_By = $FullFilled_By;
    }


    /**
     * @return string
     */
    public function getActionText(): string
    {
        return match ($this->Action) {
            self::REQUEST_STATUS_PENDING => 'Pending',
            self::REQUEST_STATUS_FULFILLED => 'Fulfilled',
            self::REQUEST_STATUS_SENT_TO_DONOR => 'Sent to Donor',
            default => 'Unknown',
        };
    }

    public function getAction(): int
    {
        return $this->Action;
    }



    /**
     * @param int $Action
     */
    public function setAction(int $Action): void
    {
        $this->Action = $Action;
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
        $this->Requested_By = $RequestedBy;
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
        return match ($this->Status) {
            self::REQUEST_STATUS_PENDING => 'Pending',
            self::REQUEST_STATUS_FULFILLED => 'Fulfilled',
            self::REQUEST_STATUS_APPROVED => 'Approved',
        };
    }

    public function getRequestStatus()
    {
        return match ($this->Status) {
            self::REQUEST_STATUS_PENDING => 'Pending',
            self::REQUEST_STATUS_APPROVED => 'Approved',
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
            'Requested_By' => 'Requested By',
            'Requested_At' => 'Requested At',
            'Status' => 'Status',
            'Quantity' => 'Quantity',
            'Remark' => 'Remarks',
            'Type' => 'Type',
            'Volume' => 'Volume',
            'Action' => 'Action'
        ];
    }

    public function rules(): array
    {
        return [
            'Request_ID' => [self::RULE_REQUIRED],
            'BloodGroup' => [self::RULE_REQUIRED],
            'Requested_By' => [self::RULE_REQUIRED],
            'Requested_At' => [self::RULE_REQUIRED],
            'Status' => [self::RULE_REQUIRED],
            'Type' => [self::RULE_REQUIRED],
            'Remarks' => [self::RULE_REQUIRED],
            'Volume' => [self::RULE_REQUIRED],

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
            'Requested_By',
            'Requested_At',
            'Status',
            'Type',
            'Remarks',
            'Volume',
            'Action'
        ];
    }

    public function getNewPrimaryKey($Type)
    {
        if($Type==2){
            $newKey = 'Req_'.rand(0,999);
        }else{
            $newKey = 'Req_'.rand(1000,9999);
        }
     if (self::findOne(['Request_ID' => $newKey])){
         return $newKey = $this->getNewPrimaryKey($Type);
     }else{
         return $newKey;
     }
    }

    public static function NavigationFooter(int $total_pages,int $current_page)
    {
        $pages="";
        $next=$current_page+1;
        $prev=$current_page-1;
        if ($next > $total_pages)
        {
            $next=$total_pages;
        }
        if ($prev < 1)
        {
            $prev=1;
        }
        for($i=1;$i<=$total_pages;$i++)
        {
            if ($i == $current_page){
                $pages.= "<a href='?page=$i'  class='nav-number bg-primary text-white px-1 py-0-5 border-radius-10 active' style='margin: 1vw'>$i</a>";
                continue;
            }
            $pages.= "<a href='?page=$i'  class='nav-number bg-white px-1 py-0-5 border-radius-10'>$i</a>";
        }
        return <<<HTML
            <div class="notifications-footer mt-1">
                <div class="navigations d-flex gap-1">
                    <a href="?page=$prev" class="previous nav-btn"><img src="/public/images/icons/previous.png" alt=""></a>
                    <div class="nav-numbers text-white gap-2">
                        $pages
                    </div>
                    <a href="?page=$next" class="next nav-btn"> <img src="/public/images/icons/next.png" alt=""> </a>
                </div>
            </div>
        HTML;

    }

}