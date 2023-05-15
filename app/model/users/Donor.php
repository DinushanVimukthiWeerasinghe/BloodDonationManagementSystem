<?php

namespace App\model\users;

use App\model\Donations\Donation;
use App\model\Donor\ReportedDonor;
use App\model\Notification\DonorNotification;
use Core\Request;
use Core\Response;
use DateTime;

class Donor extends Person
{

    public const AVAILABILITY_AVAILABLE = 1;
    public const AVAILABILITY_TEMPORARY_UNAVAILABLE = 2;
    public const AVAILABILITY_PERMANENT_UNAVAILABLE = 3;

    public const REPORTED_DONOR=1;
    public const AVAILABLE = 1;
    public const UNAVAILABLE = 2;
    const DEFAULT_NIC_FRONT = '/public/upload/NIC/NIC_Upload_Front.png';
    const DEFAULT_NIC_BACK = '/public/upload/NIC/NIC_Upload_Back.png';
    const VERIFIED = 2;
    const PENDING = 1;
    const NOT_VERIFIED = 3;
    const ACTIVE = 1;
    const DEFAULT_PROFILE_IMAGE_LOCATION = 'Profile/Donor';
    protected string $Donor_ID = '';
    protected string $Nearest_Bank = '';
    protected int $Donation_Availability = 1;
    protected ?string $Donation_Availability_Date=null;
    protected int $Verified=1;
    protected ?string $Verified_At=null;
    protected ?string $Verified_By=Null;
    protected ?string $Verification_Remarks=null;
    protected ?string $BloodPacket_ID='';
    protected string $Created_At='';
    protected string $Updated_At='';
    protected ?string $NIC_Front=null;
    protected ?string $NIC_Back=null;
    protected ?string $BloodDonation_Book_1=null;
    protected ?string $BloodDonation_Book_2=null;
    protected string $BloodGroup = "Unknown";


    public static function ReportedDonors($q=''): bool|array
    {
        if($q!='')
        {
            $donors = Donor::RetrieveAll(false,[],true,['Status'=>self::REPORTED_DONOR]);
            return array_filter($donors,function ($donor) use ($q){
                return stripos($donor->getNIC(),$q)!==false;
            });
        }
        return Donor::RetrieveAll(false,[],true,['Status'=>self::REPORTED_DONOR]);
    }

    public static function InformDonors(mixed $q): bool
    {
        $notification = new DonorNotification();
        $notification->setNotificationType(DonorNotification::INFORM_ALL_DONOR);
        $notification->setNotificationTitle($q['title']);
        $notification->setNotificationMessage($q['message']);
        if (isset($q['valid_until']) && trim($q['valid_until']) !== ''):
            $notification->setValidUntil($q['valid_until']);
        endif;
        $notification->setNotificationDate(date('Y-m-d H:i:s'));
        $notification->setNotificationState(DonorNotification::NOTIFICATION_STATE_UNREAD);
        $notification->save();
        return true;
    }

    public function GetLatestSuccessfulDonation() : ?Donation
    {
        $Donations = Donation::RetrieveAll(false,[],true,['Donor_ID'=>$this->getDonorID(),'Status'=>Donation::STATUS_BLOOD_STORED],['End_At'=>'DESC']);
        if(count($Donations)>0)
        {
            return $Donations[0];
        }else{
            return null;
        }
    }

    /**
     * @param string|null $BloodGroup
     */
    public function setBloodGroup(?string $BloodGroup): void
    {
        $this->BloodGroup = $BloodGroup;
    }

    /**
     * @throws \Exception
     */
    public function getAge(): ?int
    {
        return 18;
        $nicNumber=$this->getNIC();
        $nicNumber = preg_replace('/\D/', '', $nicNumber);

        // Extract the year, month, and date from the NIC number
        $year = substr($nicNumber, 0, 4);
        $days = substr($nicNumber, 4, 3);
        $days = ltrim($days, '0');
        $days = (int)$days;
        $days = $days - 1;
        $month = 0;
        $year = (int)$year;
        while ($days > 0) {
            $month++;
            if ($days <= 31) {
                break;
            }
            if ($days <= 59) {
                if ($year % 4 == 0) {
                    $days -= 29;
                } else {
                    $days -= 28;
                }
            } else if ($days <= 90) {
                $days -= 31;
            } else if ($days <= 120) {
                $days -= 30;
            } else if ($days <= 151) {
                $days -= 31;
            } else if ($days <= 181) {
                $days -= 30;
            } else if ($days <= 212) {
                $days -= 31;
            } else if ($days <= 243) {
                $days -= 31;
            } else if ($days <= 273) {
                $days -= 30;
            } else if ($days <= 304) {
                $days -= 31;
            } else if ($days <= 334) {
                $days -= 30;
            } else if ($days <= 365) {
                $days -= 31;
            }
        }
        $DateOfBirth = $year . '-' . $month . '-' . $days;
        $DateOfBirth = new DateTime($DateOfBirth);
        $today = new DateTime('today');
        return $DateOfBirth->diff($today)->y;


    }

    /**
     * @return string|null
     */
    public function getDonationAvailabilityDate(): ?string
    {
        return $this->Donation_Availability_Date;
    }

    /**
     * @param string|null $Donation_Availability_Date
     */
    public function setDonationAvailabilityDate(?string $Donation_Availability_Date): void
    {
        $this->Donation_Availability_Date = $Donation_Availability_Date;
    }



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

    public function getReportCause(): string
    {
        return ReportedDonor::findOne(['Donor_ID'=>$this->Donor_ID])->getReason();
    }

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
    public function getNearestBank(): string
    {
        return $this->Nearest_Bank;
    }

    /**
     * @param string $Nearest_Bank
     */
    public function setNearestBank(string $Nearest_Bank): void
    {
        $this->Nearest_Bank = $Nearest_Bank;
    }

    /**
     * @param bool $Readable
     * @return int|string
     */
    public function getDonationAvailability(bool $Readable=false): int | string
    {
        if ($Readable):
            return $this->Donation_Availability == 1? "Available":"Not Available";
        endif;
        return $this->Donation_Availability;
    }

    /**
     * @param int $Donation_Availability
     */
    public function setDonationAvailability(int $Donation_Availability): void
    {
        $this->Donation_Availability = $Donation_Availability;
    }

    /**
     * @return int
     */
    public function getVerified(): int
    {
        return $this->Verified;
    }

    /**
     * @param int $Verified
     */
    public function setVerified(int $Verified): void
    {
        $this->Verified = $Verified;
    }

    /**
     * @return string|null
     */
    public function getVerifiedAt(): ?string
    {
        return $this->Verified_At;
    }

    /**
     * @param string|null $Verified_At
     */
    public function setVerifiedAt(?string $Verified_At): void
    {
        $this->Verified_At = $Verified_At;
    }

    /**
     * @return string|null
     */
    public function getVerifiedBy(): ?string
    {
        return $this->Verified_By;
    }

    /**
     * @param string|null $Verified_By
     */
    public function setVerifiedBy(?string $Verified_By): void
    {
        $this->Verified_By = $Verified_By;
    }

    /**
     * @return string|null
     */
    public function getVerificationRemarks(): ?string
    {
        return $this->Verification_Remarks;
    }

    /**
     * @param string|null $Verification_Remarks
     */
    public function setVerificationRemarks(?string $Verification_Remarks): void
    {
        $this->Verification_Remarks = $Verification_Remarks;
    }

    /**
     * @return string|null
     */
    public function getBloodPacketID(): ?string
    {
        return $this->BloodPacket_ID;
    }

    /**
     * @param string|null $BloodPacket_ID
     */
    public function setBloodPacketID(?string $BloodPacket_ID): void
    {
        $this->BloodPacket_ID = $BloodPacket_ID;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->Created_At;
    }

    /**
     * @param string $Created_At
     */
    public function setCreatedAt(string $Created_At): void
    {
        $this->Created_At = $Created_At;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->Updated_At;
    }

    /**
     * @param string $Updated_At
     */
    public function setUpdatedAt(string $Updated_At): void
    {
        $this->Updated_At = $Updated_At;
    }

    /**
     * @return string|null| bool
     */
    public function getNICFront(): string | bool | null
    {
        return $this->NIC_Front ?? false;
    }

    /**
     * @param string|null $NIC_Front
     */
    public function setNICFront(?string $NIC_Front): void
    {
        $this->NIC_Front = $NIC_Front;
    }

    /**
     * @return string|null
     */
    public function getNICBack(): ?string
    {
        return $this->NIC_Back;
    }

    /**
     * @param string|null $NIC_Back
     */
    public function setNICBack(?string $NIC_Back): void
    {
        $this->NIC_Back = $NIC_Back;
    }

    /**
     * @return string|null
     */
    public function getBloodDonationBook1(): ?string
    {
        return $this->BloodDonation_Book_1;
    }

    /**
     * @param string|null $BloodDonation_Book_1
     */
    public function setBloodDonationBook1(?string $BloodDonation_Book_1): void
    {
        $this->BloodDonation_Book_1 = $BloodDonation_Book_1;
    }

    /**
     * @return string|null
     */
    public function getBloodDonationBook2(): ?string
    {
        return $this->BloodDonation_Book_2;
    }

    /**
     * @param string|null $BloodDonation_Book_2
     */
    public function setBloodDonationBook2(?string $BloodDonation_Book_2): void
    {
        $this->BloodDonation_Book_2 = $BloodDonation_Book_2;
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
            'Verified'=>[self::RULE_REQUIRED],
            'Verified_At'=>[self::RULE_TODAY_OR_OLDER_DATE]
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
        return [
            'First_Name',
            'Last_Name',
            'Email',
            'Address1',
            'Address2',
            'City',
            'Contact_No',
            'Nationality',
            'NIC',
            'Gender',
            'Status',
            'Donor_ID',
            'Nearest_Bank',
            'Donation_Availability',
            'Verified',
            'Verified_At',
            'Verified_By',
            'Verification_Remarks',
            'Created_At',
            'Updated_At',
            'NIC_Front',
            'NIC_Back',
            'BloodDonation_Book_1',
            'BloodDonation_Book_2',
            'BloodGroup',
            'Donation_Availability_Date',
            'Profile_Image'
        ];
    }

    public function setID(string $ID): void
    {
        $this->Donor_ID = $ID;
    }

    public function getBloodGroup(): ?string
    {
        return $this->BloodGroup ?? "Unknown";
    }

    public function getVerificationStatus($bool=true)
    {
        if (!$bool)
            return $this->Verified;
        return match ($this->Verified){
            1=>"Pending",
            2=>"Verified",
            3=>"Not Verified",
            default=>"Unknown"
        };
    }

    public function generateGenderByNIC()
    {
        if (!empty($this->getNIC())){
            $Token = substr($this->getNIC(),3,3);
            $Token=intval($Token);

            if ($Token<500){
                $this->setGender("M");
            }else{
                $this->setGender("F");
            }
        }
    }

    public function getLastDonation()
    {
        $Donation = Donation::findOne(['Donor_ID'=>$this->getDonorID()]);
        if ($Donation){
            return $Donation->getDonationDate();
        }else{
            return "No Donation";
        }
    }

    public function getSuccessRate()
    {
        /** @var Donation[] $Donations */
        $Donations = Donation::RetrieveAll(false,[],true,['Donor_ID'=>$this->getDonorID()]);
        $Success = 0;
        $Total = 0;
        foreach ($Donations as $Donation){
            $Total++;
            if ($Donation->getStatus()===Donation::STATUS_BLOOD_STORED){
                $Success++;
            }
        }
        if ($Total==0){
            return 0;
        }else{
            return round(($Success/$Total)*100,2)."%";
        }
    }

    public function getTotalSuccessfulDonations()
    {
        /** @var Donation[] $Donations */
        $Donations = Donation::RetrieveAll(false,[],true,['Donor_ID'=>$this->getDonorID()]);
        $Success = 0;
        foreach ($Donations as $Donation){
            if ($Donation->getStatus()===Donation::STATUS_BLOOD_STORED){
                $Success++;
            }
        }
        return $Success;
    }

}