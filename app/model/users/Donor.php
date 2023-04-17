<?php

namespace App\model\users;

use App\model\Donor\ReportedDonor;
use App\model\Notification\DonorNotification;
use Core\Request;
use Core\Response;

class Donor extends Person
{
    public const REPORTED_DONOR=1;
    public const AVAILABLE = 1;
    public const UNAVAILABLE = 2;
    const VERIFIED = 2;
    const PENDING = 1;
    const NOT_VERIFIED = 3;
    const ACTIVE = 1;
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
    protected ?string $NIC_Front=null;
    protected ?string $NIC_Back=null;
    protected ?string $BloodDonation_Book_1=null;
    protected ?string $BloodDonation_Book_2=null;
    protected ?string $BloodGroup = null;


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

    /**
     * @param string|null $BloodGroup
     */
    public function setBloodGroup(?string $BloodGroup): void
    {
        $this->BloodGroup = $BloodGroup;
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
     * @return int
     */
    public function getDonationAvailability(): int
    {
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
     * @return string|null
     */
    public function getNICFront(): ?string
    {
        return $this->NIC_Front;
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
            'Donation_Availability'=>[self::RULE_REQUIRED],
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
            'BloodGroup'
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

    public function getVerificationStatus()
    {
        return $this->Verified ? "Verified" : "Not Verified";
    }

    public function setDonationAvailability(int $x):void
    {
        $this->Donation_Availability = $x;
    }
    public function getDonationAvailability():int
    {
        return $this->Donation_Availability;
    }
}