<?php

namespace App\model\Authentication;

use Core\Application;
use Core\Email;
use PHPMailer\PHPMailer\Exception;

class PasswordReset extends \App\model\database\dbModel
{
    public const STATUS_INACTIVE=1;
    public const STATUS_ACTIVE=2;
    public const STATUS_RESET=3;

    protected string $UID='';
    protected string $Email='';
    protected ?string $Name ='';
    protected string $Token='';
    protected string $Created_At='';
    protected int $Status=2;
    protected string $Device_IP='';
    protected ?string $Reset_At=null;
    protected int $Lifetime=60;

    /**
     * @throws \Exception
     */
    public function GenerateToken(): void
    {
        $this->Created_at=date('Y-m-d H:i:s');
        $this->Token=bin2hex(random_bytes(50));
    }

    public function IsTokenValid(): bool
    {
        return $this->Status===self::STATUS_ACTIVE;
    }

    /**
     * @return string|null
     */
    public function getLifetime(): ?string
    {
        return $this->Lifetime;
    }

    /**
     * @throws \Exception
     */
    public function IsExpired(): bool
    {
        $created_at=new \DateTime($this->Created_At);
        $now=new \DateTime(date('Y-m-d H:i:s'));
        $diff=$created_at->diff($now);
        return $diff->i>$this->Lifetime;
    }

    /**
     * @param int $Lifetime
     */
    public function setLifetime(int $Lifetime): void
    {
        $this->Lifetime = $Lifetime;
    }



    /**
     * @return string
     */
    public function getDeviceIP(): string
    {
        return $this->Device_IP;
    }

    /**
     * @param string $Device_IP
     */
    public function setDeviceIP(string $Device_IP): void
    {
        $this->Device_IP = $Device_IP;
    }



    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->Name;
    }

    /**
     * @param string|null $Name
     */
    public function setName(?string $Name): void
    {
        $this->Name = $Name;
    }


    /**
     * @throws Exception
     */
    public function SendPasswordResetEmail(): void
    {
        $email = Application::$app->email;
        $email->setTo('stdinushan@gmail.com');
        $email->setFrom('bdms@gmail.com');
        $email->setSubject('Password Reset');
        $email->AddImage(Application::$ROOT_DIR.'/public/images/logo.png','logo-img','Logo');
            ob_start();
            include_once Application::$ROOT_DIR."/app/view/Email/PasswordReset.php";
            $body=ob_get_clean();
        $body=str_replace('{{Link}}','http://localhost:5000/resetPassword?token=' . $this->Token,$body);
        $body=str_replace('{{UserName}}',$this->Name,$body);
        $email->setBody($body);
        $email->send();

    }

    public function labels(): array
    {
        return [
            'UID'=>'User ID',
            'Email'=>'Email',
            'Token'=>'Token',
            'Created_at'=>'Created At',
            'Status'=>'Status',
            'Lifetime'=>'Lifetime',
        ];
    }

    public function rules(): array
    {
        return [
            'UID'=>[self::RULE_REQUIRED,self::RULE_UNIQUE],
            'Email'=>[self::RULE_REQUIRED,self::RULE_EMAIL,self::RULE_UNIQUE],
            'Token'=>[self::RULE_REQUIRED,self::RULE_UNIQUE],
            'Created_At'=>[self::RULE_REQUIRED],
            'Status'=>[self::RULE_REQUIRED],
            'Device_IP'=>[self::RULE_REQUIRED],
            'Lifetime'=>[self::RULE_REQUIRED],
        ];
    }

    public static function getTableShort(): string
    {
        return 'password_reset';
    }

    public static function tableName(): string
    {
        return 'Password_Reset';
    }

    public static function PrimaryKey(): string
    {
        return 'UID';
    }

    public function attributes(): array
    {
        return ['UID','Email','Token','Created_at','Status','Device_IP','Lifetime','Reset_At'];
    }

    /**
     * @return string
     */
    public function getUID(): string
    {
        return $this->UID;
    }

    /**
     * @param string $UID
     */
    public function setUID(string $UID): void
    {
        $this->UID = $UID;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->Email;
    }

    /**
     * @param string $Email
     */
    public function setEmail(string $Email): void
    {
        $this->Email = $Email;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->Token;
    }

    /**
     * @param string $Token
     */
    public function setToken(string $Token): void
    {
        $this->Token = $Token;
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
     * @return string|null
     */
    public function getResetPasswordAt(): ?string
    {
        return $this->Reset_At;
    }

    /**
     * @param string|null $ResetPassword_At
     */
    public function setResetPasswordAt(?string $ResetPassword_At): void
    {
        $this->Reset_At = $ResetPassword_At;
    }


}