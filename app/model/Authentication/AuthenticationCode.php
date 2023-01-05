<?php

namespace App\model\Authentication;

use App\model\database\dbModel;
use App\model\users\Person;
use Core\Application;

class AuthenticationCode extends dbModel
{
    public const Change_Password=0;
    public const Reset_Password=1;
    public const Authenticated=1;
    public const Pending=2;
    public const ExceedLimit=3;
    protected string $Code='';
    protected string $UserID='';
    protected int $Type=0;
    protected int $Attempts=0;

    /**
     * @return int
     */
    public function getAttempts(): int
    {
        return $this->Attempts;
    }

    public function IncrementAttempts()
    {
        $this->Attempts+=1;
    }

    /**
     * @param int $Attempts
     */
    public function setAttempts(int $Attempts): void
    {
        $this->Attempts = $Attempts;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->Code;
    }

    /**
     * @param string $Code
     */
    public function setCode(string $Code): void
    {
        $this->Code = $Code;
    }


    /**
     * @return string
     */
    public function getUserID(): string
    {
        return $this->UserID;
    }

    /**
     * @param string $UserID
     */
    public function setUserID(string $UserID): void
    {
        $this->UserID = $UserID;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->Type;
    }

    /**
     * @param string $Type
     */
    public function setType(string $Type): void
    {
        $this->Type = $Type;
    }

    /**
     * @return string
     */
    public function getTimestamp(): string
    {
        return $this->Timestamp;
    }

    /**
     * @param string $Timestamp
     */
    public function setTimestamp(string $Timestamp): void
    {
        $this->Timestamp = $Timestamp;
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
    protected string $Timestamp='';
    protected string $Status='';
    public function labels(): array
    {
        return [
            'Code'=>'Code',
            'UserID'=>'User ID',
            'Type'=>'User Type',
            'Timestamp'=>'Sent Time',
            'Status'=>'Code Status'
        ];
    }

    public function rules(): array
    {
        return [
            'Code'=>[self::RULE_REQUIRED],
            'UserID'=>[self::RULE_REQUIRED],
            'Type'=>[self::RULE_REQUIRED],
            'Timestamp'=>[self::RULE_REQUIRED],
            'Status'=>[self::RULE_REQUIRED]
        ];
    }

    public static function getTableShort(): string
    {
        return 'AC';
    }

    public static function tableName(): string
    {
            return 'Authentication_Code';
    }

    public static function PrimaryKey(): string
    {
        return 'Code';
    }

    public function attributes(): array
    {
        return [
            'Code',
            'UserID',
            'Type',
            'Timestamp',
            'Status'
        ];
    }

    public function Send()
    {
        self::save();
    }
    private function GenerateCode($n =6){
        $Generator='123456789';
        $result='';
        for ($i=0;$i<$n;$i++){
                $result.=substr($Generator,(rand()%strlen($Generator)),1);
        }
        return $result;
    }

    public function Generate(int $Type,string $UserID=''): bool
    {
        if ($Type===self::Change_Password){

            $this->UserID=Application::$app->getUser()->getID();

        }else if ($Type===self::Reset_Password){
            $this->UserID=$UserID;
        }
        $timestamp=date("Y-m-d").' '.date("H:i:s");
        $this->Timestamp=$timestamp;
        $this->Code=$this->GenerateCode();
        $this->Type=$Type;
        $this->Status=self::Pending;
        return true;
    }

    public static function Verify(string $code,string $user_id)
    {
        $res=self::findOne([['User_ID'=>$user_id]]);
        /* @var AuthenticationCode $res*/
        if ($res)
        {
            $res->IncrementAttempts();
            self::updateOne(['UserID'=>$user_id],['Attempts'=>$res->getAttempts()]);
            if($res->getCode()===$code){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

}