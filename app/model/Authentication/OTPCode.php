<?php

namespace App\model\Authentication;

use App\model\database\dbModel;
use Core\Application;
use PHPMailer\PHPMailer\Exception;

class OTPCode extends dbModel
{
    public const STATUS_PENDING = 0;
    public const STATUS_VERIFIED = 1;
    public const STATUS_EXPIRED = 2;
    public const NO_OF_ATTEMPTS_EXCEEDED = 3;

    public const OTP_REGENERATED = 4;
    public const OTP_Temporary_Blocked = 5;
    public const OTP_Unknown_Action = 9;

    protected string $Code = '';
    protected string $UserID = '';
    protected string $Target = '';
    protected int $Type = 0;
    protected int $Attempts = 0;
    protected int $Status = 0;
    protected string $Created_At = '';
    protected ?string $Updated_At = '';
    protected string $Expired_At = '';
    protected ?string $Verified_At = null;
    protected ?string $Deleted_At = '';

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
    public function getTarget(): string
    {
        return $this->Target;
    }

    /**
     * @param string $Target
     */
    public function setTarget(string $Target): void
    {
        $this->Target = $Target;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->Type;
    }

    /**
     * @param int $Type
     */
    public function setType(int $Type): void
    {
        $this->Type = $Type;
    }

    /**
     * @return int
     */
    public function getAttempts(): int
    {
        return $this->Attempts;
    }

    /**
     * @param int $Attempts
     */
    public function setAttempts(int $Attempts): void
    {
        $this->Attempts = $Attempts;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->Status;
    }

    /**
     * @param int $Status
     */
    public function setStatus(int $Status): void
    {
        $this->Status = $Status;
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
     * @return string
     */
    public function getExpiredAt(): string
    {
        return $this->Expired_At;
    }

    /**
     * @param string $Expired_At
     */
    public function setExpiredAt(string $Expired_At): void
    {
        $this->Expired_At = $Expired_At;
    }

    /**
     * @return string
     */
    public function getVerifiedAt(): string
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
     * @return string
     */
    public function getDeletedAt(): string
    {
        return $this->Deleted_At;
    }

    /**
     * @param string $Deleted_At
     */
    public function setDeletedAt(string $Deleted_At): void
    {
        $this->Deleted_At = $Deleted_At;
    }


    public function labels(): array
    {
        return [
            'Code' => 'Code',
            'UserID' => 'UserID',
            'Type' => 'Type',
            'Target' => 'Target',
            'Attempts' => 'Attempts',
            'Status' => 'Status',
            'Created_At' => 'Created_At',
            'Updated_At' => 'Updated_At',
            'Expired_At' => 'Expired_At',
            'Verified_At' => 'Verified_At',
            'Deleted_At' => 'Deleted_At',
        ];
    }

    public function rules(): array
    {
        return [
            'Code' => [self::RULE_REQUIRED],
            'UserID' => [self::RULE_REQUIRED],
            'Type' => [self::RULE_REQUIRED],
            'Attempts' => [self::RULE_REQUIRED],
            'Status' => [self::RULE_REQUIRED],
            'Created_At' => [self::RULE_REQUIRED],
            'Expired_At' => [self::RULE_REQUIRED],
            'Target' => [self::RULE_REQUIRED],
        ];
    }

    public static function getTableShort(): string
    {
        return 'OTP';
    }

    public static function tableName(): string
    {
        return 'OTP_Code';
    }

    public static function PrimaryKey(): string
    {
        return 'UserID';
    }

    public function attributes(): array
    {
        return [
            'Code',
            'UserID',
            'Type',
            'Target',
            'Attempts',
            'Status',
            'Created_At',
            'Expired_At',
            'Verified_At',
        ];
    }

    /**
     * @throws Exception
     */
    public function sendCode()
    {
        $OTPCodeEmail = Application::$app->email;
        $OTPCodeEmail->setTo($this->Target);
        $OTPCodeEmail->setFrom('bdmsgroupcs46@gmail.com');
        $OTPCodeEmail->setSubject('OTP Code');
        $OTPCodeEmail->AddImage(Application::$ROOT_DIR.'/public/images/logo.png','logo-img','Logo');
        $body ="";
        ob_start();
        include_once Application::$ROOT_DIR . "/app/view/Email/OTPAuthentication.php";
        $body = ob_get_clean();
        $body = str_replace('{{OTP1}}', $this->Code[0], $body);
        $body = str_replace('{{OTP2}}', $this->Code[1], $body);
        $body = str_replace('{{OTP3}}', $this->Code[2], $body);
        $body = str_replace('{{OTP4}}', $this->Code[3], $body);
        $body = str_replace('{{OTP5}}', $this->Code[4], $body);
        $OTPCodeEmail->setBody($body);
//        $OTPCodeEmail->setBody('Your OTP Code is: ' . $this->Code);

        try {
            $OTPCodeEmail->send();
        } catch (\Exception $e) {
            echo '<pre>';
            print_r($OTPCodeEmail);
            exit();
        }
    }

    public function IsExpired(): bool
    {
        $CurrentTime = date('Y-m-d H:i:s');
        if ($CurrentTime > $this->Expired_At || $this->getStatus() == self::STATUS_EXPIRED) {
            Application::$app->session->setFlash('error', 'OTP Code Expired');
            return true;
        }
        return false;
    }

    public function IsExceedAttempts($allowedAttempts = 5): bool
    {
        if ($this->Attempts >= $allowedAttempts || $this->getStatus() == self::NO_OF_ATTEMPTS_EXCEEDED) {
            return true;
        }
        return false;
    }

    public function GenerateCode($Target, $len = 5, $expire = 5)
    {
        $this->Code = substr(str_shuffle(str_repeat($x = '0123456789', ceil($len / strlen($x)))), 1, $len);
        $this->Created_At = date('Y-m-d H:i:s');
        $this->Expired_At = date('Y-m-d H:i:s', strtotime('+5 minutes'));
        $this->Target = $Target;
    }

    public function getCode(): string
    {
        return $this->Code;
    }


}