<?php

namespace App\model\users;

use App\model\BloodBankBranch\BloodBank;
use App\model\Campaigns\Campaign;
use App\model\MedicalTeam\MedicalTeam;
use App\model\MedicalTeam\TeamMembers;
use Core\Application;
use PDO;

class MedicalOfficer extends Person
{

    public const UNAVAILABLE_MEDICAL_OFFICER= 1;
    public const ASSIGNED_FOR_TEAM = 5;
    public const AVAILABLE_MEDICAL_OFFICER = 1;

    protected string $BloodBank_ID = '';
    protected string $Joined_At = '';
    protected string $Position = '';
    protected ?string $Registration_Number = '';
    protected string $Registration_Date = '';

    protected string $Officer_ID = '';
    protected string $Branch_ID = '';



    public function getID():string
    {
        return $this->Officer_ID;
    }

    public function setID(string $ID):void
    {
        $this->Officer_ID=$ID;
    }

    public function getBranchLocation()
    {
//        return BloodBank::findOne(['BloodBank_ID'=>$this->Branch_ID]);
        return BloodBank::findOne(['BloodBank_ID' => $this->Branch_ID])->getLocation() . ' Branch';
    }

    public function getRole(): string
    {
        return Person::MEDICAL_OFFICER;
    }


    public function getFullName(): string
    {
        return $this->First_Name.' '.$this->Last_Name;
    }

    /**
     * @return string
     */
    public function getPosition(): string
    {
        return $this->Position;
    }

    public function getPositionOfTeamByCampaignID($campaignID)
    {
        /** @var MedicalTeam $Team*/
        $Team = MedicalTeam::findOne(['Campaign_ID' => $campaignID, 'Team_Leader' => $this->Officer_ID],false);
        if ($Team) {
            return 'Team Leader';
        }else{
            /** @var MedicalTeam $Team*/
            $Team= MedicalTeam::findOne(['Campaign_ID' => $campaignID],false);
            if ($Team) {
                /** @var TeamMembers $TeamMember*/
                $TeamMember = TeamMembers::findOne(['Team_ID' => $Team->getTeamID(), 'Member_ID' => $this->Officer_ID],false);
                return $TeamMember?->getPosition();
            }else{
                return null;
            }
        }
    }

    /**
     * @param string $Position
     */
    public function setPosition(string $Position): void
    {
        $this->Position = $Position;
    }

    /**
     * @param string $Branch_ID
     */
    public function setBranchID(string $Branch_ID): void
    {
        $this->Branch_ID = $Branch_ID;
    }

    /**
     * @return string
     */
    public function getBranchID(): string
    {
        return $this->Branch_ID;
    }


    /**
     * @param string $Joined_Date
     */
    public function setJoinedDate(string $Joined_Date): void
    {
        $this->Joined_At = $Joined_Date;
    }


    /**
     * @return string
     */
    public function getBloodBankID(): string
    {
        return $this->BloodBank_ID;
    }

    /**
     * @param string $BloodBank_ID
     */
    public function setBloodBankID(string $BloodBank_ID): void
    {
        $this->BloodBank_ID = $BloodBank_ID;
    }

    /**
     * @return string
     */
    public function getJoinedAt($DateOnly = false): string
    {
        if ($DateOnly) {
            return date('Y-m-d', strtotime($this->Joined_At));
        }
        return $this->Joined_At;
    }

    /**
     * @param string $Joined_At
     */
    public function setJoinedAt(string $Joined_At): void
    {
        $this->Joined_At = $Joined_At;
    }

    /**
     * @return string
     */
    public function getRegistrationNumber(): string
    {
        return $this->Registration_Number;
    }

    /**
     * @param string $Registration_Number
     */
    public function setRegistrationNumber(string $Registration_Number): void
    {
        $this->Registration_Number = $Registration_Number;
    }

    /**
     * @return string
     */
    public function getRegistrationDate(): string
    {
        return $this->Registration_Date;
    }

    /**
     * @param string $Registration_Date
     */
    public function setRegistrationDate(string $Registration_Date): void
    {
        $this->Registration_Date = $Registration_Date;
    }

    /**
     * @return string
     */
    public function getOfficerID(): string
    {
        return $this->Officer_ID;
    }

    /**
     * @param string $Officer_ID
     */
    public function setOfficerID(string $Officer_ID): void
    {
        $this->Officer_ID = $Officer_ID;
    }

    public function getBloodBank() : ?BloodBank
    {
        return BloodBank::findOne(['BloodBank_ID' => $this->Branch_ID]);
    }

    public function getAssignedTeam(): ?MedicalTeam
    {
        return MedicalTeam::findOne(['Team_Leader_ID' => $this->Officer_ID]);
    }

    public function getMedicalTeamPosition($TeamID)
    {
        $Team= TeamMembers::findOne(['Member_ID' => $this->Officer_ID, 'Team_ID' => $TeamID,false]);
        if ($Team) {
            return $Team->getPosition();
        }else{
            return null;
        }
    }



    public function getMedicalTeamTask($TeamID)
    {
        $Team= TeamMembers::findOne(['Member_ID' => $this->Officer_ID, 'Team_ID' => $TeamID],false);
        if ($Team) {
            return match ($Team->getTask()) {
                TeamMembers::TASK_NOT_ASSIGNED => 'Not Assigned',
                TeamMembers::TASK_REGISTRATION => 'Registration',
                TeamMembers::TASK_HEALTH_CHECK => 'Health Check',
                TeamMembers::TASK_BLOOD_CHECK => 'Blood CHECK',
                TeamMembers::TASK_BLOOD_RETRIEVAL => 'Blood Retrieval',
                default => 'Unknown',
            };
        }else{
            return null;
        }
    }

    public function getAssignedCampaigns(): array
    {
        $AssignedCampaigns = [];
        /* @var $MedicalTeam TeamMembers*/
        $MedicalTeams = TeamMembers::RetrieveAll(false,[],true,['Member_ID' => $this->Officer_ID]);
        if (count($MedicalTeams) > 0) {
            foreach ($MedicalTeams as $MedicalTeam) {
                $AssignedCampaigns[] = $MedicalTeam->getCampaign();
            }
        }
        return $AssignedCampaigns;
    }

    public function getAssignedCampaignsDate():array
    {
        $AssignedDates = [];
        $AssignedCampaigns = $this->getAssignedCampaigns();
        /* @var Campaign $AssignedCampaign */
        if (count($AssignedCampaigns) > 0) {
            foreach ($AssignedCampaigns as $AssignedCampaign) {
                $AssignedDates[] = $AssignedCampaign->getCampaignDate();
            }
        }
        return $AssignedDates;
    }

    public static function RetrieveAvailableMedicalOfficer(bool $pagination, array $paginationParams,array $Exclude): array
    {
        $tableName = static::tableName();
        $sql = "SELECT * FROM $tableName WHERE Officer_ID NOT IN (";
        foreach ($Exclude as $key => $value) {
            $sql .= "'$value',";
        }
        $sql = rtrim($sql, ',');
        $sql .= ')';
        $sql .= " AND Status = '".self::AVAILABLE_MEDICAL_OFFICER."'";
        $sql .= " ORDER BY First_Name ASC";
        $sql .= " LIMIT {$paginationParams[0]},{$paginationParams[1]}";
        if ($pagination) {
            $sql .= " LIMIT {$paginationParams['offset']},{$paginationParams['limit']}";
        }
        $gp = self::prepare($sql);
        $gp->execute();
        return $gp->fetchAll(PDO::FETCH_CLASS,static::class);


    }



    private function saveRealtion(string $table1,string $table2){
        return $table1.'_'.$table2;
    }
    private function countDigits($MyNum){
        $MyNum = (int)$MyNum;
        $count = 0;

        while($MyNum != 0){
            $MyNum = (int)($MyNum / 10);
            $count++;
        }
        return $count;
    }

    public static function getAssignedCampaign(string $Date='')
    {
        $tableName = static::tableName();
        $AssignedTeams=TeamMembers::RetrieveAll(false,[],true,['Member_ID' => Application::$app->getUser()->getID()]);
        $AssignedCampaigns=[];
        if (count($AssignedTeams) > 0) {
            $Assign_Team=[];
            foreach ($AssignedTeams as $AssignedTeam) {
                $Assign_Team[] = MedicalTeam::findOne(['Team_ID'=>$AssignedTeam->getTeamID()]);
            }
            if (count($Assign_Team) > 0) {
                foreach ($Assign_Team as $AssignedCampaign) {
                    $AssignedCampaigns[] = Campaign::findOne(['Campaign_ID'=>$AssignedCampaign->getCampaignID()]);
                }
            }
        }
        if (count($AssignedCampaigns) > 0) {
            if (trim($Date) == '') {
                // Sort the array by date
                usort($AssignedCampaigns, function ($a, $b) {
                    return strtotime($a->getCampaignDate()) - strtotime($b->getCampaignDate());
                });
                return $AssignedCampaigns;
            }else{
                $out=array_filter($AssignedCampaigns, function ($AssignedCampaign) use ($Date) {
                    return $AssignedCampaign->getCampaignDate() == $Date;
                });
                $out = array_values($out);
                if (count($out) > 0) {
                    return $out[0];
                }else{
                    return null;
                }
            }

        }
    }


    private function getPrimaryKey($table){
        $sql = "SHOW INDEX FROM $table WHERE Key_name = 'PRIMARY'";
        $gp = self::prepare($sql);
        $gp->execute();
        $cgp = $gp->rowCount();
        $PK=[];
        if ($cgp > 0) {
            // Note I'm not using a while loop because I never use more than one prim key column
            $result = $gp->fetchAll();
            foreach ($result as $key => $value) {
                $PK[] = $value['Column_name'];
            }
            return($PK);
        } else {
            return(false);
        }

    }


    public function rules(): array
    {
        return [
            'Officer_ID' => [self::RULE_REQUIRED, self::RULE_UNIQUE],
            'First_Name' => [self::RULE_REQUIRED],
            'Last_Name' => [self::RULE_REQUIRED],
            'NIC' => [self::RULE_REQUIRED, self::RULE_UNIQUE, self::RULE_MIN => 10, self::RULE_MAX => 12],
            'Joined_At' => [self::RULE_REQUIRED, self::RULE_TODAY_OR_OLDER_DATE],
            'Status' => [self::RULE_REQUIRED],
            'Position' => [self::RULE_REQUIRED],
            'Email' => [self::RULE_REQUIRED, self::RULE_UNIQUE, self::RULE_EMAIL],
            'Address1' => [self::RULE_REQUIRED],
            'Address2' => [self::RULE_REQUIRED],
            'City' => [self::RULE_REQUIRED],
            'Profile_Image' => [self::RULE_REQUIRED],
            'Contact_No' => [self::RULE_REQUIRED, self::RULE_MOBILE_NO],
//            'Gender' => [self::RULE_REQUIRED],
            'Nationality' => [self::RULE_REQUIRED],
            'Registration_Number'=>[self::RULE_REQUIRED,self::RULE_UNIQUE],
            'Registration_Date'=>[self::RULE_REQUIRED,self::RULE_TODAY_OR_OLDER_DATE],
        ];
    }

    public static function getTableShort(): string
    {
        return 'mo';
    }

    public static function tableName(): string
    {
        return 'MedicalOfficers';
    }

    public static function PrimaryKey(): string
    {
        return 'Officer_ID';
    }

    public function attributes(): array
    {
        return [
            'Officer_ID',
            'First_Name',
            'Last_Name',
            'NIC',
            'Joined_At',
            'Status',
            'Position',
            'Email',
            'Address1',
            'Address2',
            'City',
            'Profile_Image',
            'Contact_No',
            'Branch_ID',
            'Gender',
            'Nationality',
            'Registration_Number',
            'Registration_Date',
        ];
    }

    public function GetAttributesValue($attributes)
    {
        return $this->{$attributes};
    }

    public function labels(): array
    {
        return [
            'User_ID' => 'Officer ID',
            'First_Name' => 'First Name',
            'Last_Name' => 'Last Name',
            'NIC' => 'NIC',
            'Joined_At' => 'Joined At',
            'Status' => 'Status',
            'Position' => 'Position',
            'Email' => 'Email',
            'Address1' => 'Address1',
            'Address2' => 'Address2',
            'City' => 'City',
            'ImageURL' => 'Image URL',
            'Contact_No' => 'Contact No',
            'Branch_ID' => 'Branch ID',
            'Gender' => 'Gender',
            'Registration_Number' => 'Registration Number',
        ];
    }




}