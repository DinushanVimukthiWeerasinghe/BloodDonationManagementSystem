<?php

namespace App\model\Authentication;

use App\model\database\dbModel;
use App\model\users\User;
use Core\Application;
use PHPMailer\PHPMailer\Exception;

class Login extends dbModel
{

    public const Account_Temporary_Disabled = 1;
    public const Account_Permanently_Disabled = 2;

    protected string $UID = '';
    protected int $Security_Level = 0;

    /**
     * @return string
     */
    public function getID(): string
    {
        return $this->UID;
    }

    /**
     * @param string $ID
     */
    public function setID(string $ID): void
    {
        $this->UID = $ID;
    }

    protected string $Email = '';
    protected string $OTP = '';
    protected string $Password = '';
    protected string $Role='';
    protected int $Status = 1;
    protected int $Account_Status = 0;

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->Email;
    }

    /**
     * @return string
     */
    public function getOTP(): string
    {
        return $this->OTP;
    }

    /**
     * @param string $OTP
     */
    public function setOTP(string $OTP): void
    {
        $this->OTP = $OTP;
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
    public function getPassword(): string
    {
        return $this->Password;
    }

    /**
     * @param string $Password
     */
    public function setPassword(string $Password): void
    {
        $this->Password = $Password;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->Role;
    }

    /**
     * @param string $Role
     */
    public function setRole(string $Role): void
    {
        $this->Role = $Role;
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
     * @return int
     */
    public function getSecurityLevel(): int
    {
        return $this->Security_Level;
    }

    /**
     * @param int $Security_Level
     */
    public function setSecurityLevel(int $Security_Level): void
    {
        $this->Security_Level = $Security_Level;
    }

    public function IsAccountTemporaryBanned(): bool
    {
        return User::findOne(['Email'=>$this->getEmail()])->getAccountStatus() === Login::Account_Temporary_Disabled;
    }

    public function IsAccountPermanentlyBanned(): bool
    {
        return User::findOne(['Email'=>$this->getEmail()])->getAccountStatus() === Login::Account_Permanently_Disabled;
    }

    public function rules(): array
    {
        return [
            'Email' => [
                self::RULE_REQUIRED, self::RULE_EMAIL
            ],
            'Password' => [
                self::RULE_REQUIRED
            ],
        ];
    }


    public function labels():array
    {
        return[
            'UID'=>'User ID',
            'email' => 'Email',
            'password' => 'Password'
        ];
    }
    public function IsManager(): bool
    {
        return $this->Role === User::MANAGER;
    }

    /**
     * @throws Exception
     */
    public function ValidateOTP()
    {
        $user = Login::findOne(['Email' => $this->Email]);
        if (!$user) {
            $this->addError('email', 'Invalid User Credential!');
            return false;
        }
        else if (!password_verify($this->Password, $user->getPassword())) {
            $this->addError('password', 'Incorrect Password!');
            return false;
        }

        else if (!$user->IsManager()){
            Application::$app->login($user);
            return true;
        }


        /* @var OTPCode $OTP */
        $OTP = OTPCode::findOne(['UserID' => $user->getID()], false);

        if ($OTP) {
            if ($OTP->IsExpired()) {

                $OTP->setUserID($user->getID());
                $OTP->setType(1);
                $OTP->GenerateCode('stdinushan@gmail.com');

                $OTP->sendCode();

                $OTP->update($user->getID(), ['Verified_At']);
            }
        }
        if (!$OTP) {
            $OTP = new OTPCode();
            $OTP->setUserID($user->getID());
            $OTP->setType(1);
            $OTP->GenerateCode('stdinushan@gmail.com');
            $OTP->sendCode();
            $OTP->save();
        } else {
            if ($OTP->IsExpired()) {
                $OTP->setUserID($user->getID());
                $OTP->setType(1);
                $OTP->GenerateCode('stdinushan@gmail.com');
                $OTP->sendCode();
                $OTP->update($user->getID(), ['Verified_At']);
            }
        }

        $user->setOTP($OTP->getCode());
        Application::$app->session->set('OTP', $OTP, 5);
        Application::$app->session->set('User', $user, 5);
        return $user;
    }

    public function login(): bool
    {

//            Hashing Algorithm PASSWORD_BCRYPT
        $user= Login::findOne(['Email' => $this->Email]);
        if(!$user)
        {
            $this->addError('email','Invalid User Credential!');
            return false;
        }

        if(!password_verify($this->Password,$user->getPassword()))
        {
            $this->addError('password','Incorrect Password!');
            return false;
        }
        else if ($user->IsAccountTemporaryBanned()) {
            $this->addError('email', 'Your Account is temporarily disabled!');
            return false;
        }
        else if ($user->IsAccountPermanentlyBanned()) {
            $this->addError('email', 'Your Account is permanently disabled!');
            return false;
        }

        Application::$app->login($user);

        Application::$app->session->setFlash('success', 'Login Successful!');
        return true;
    }

    public static function getTableShort(): string
    {
        return 'login';
    }

    public static function tableName(): string
    {
        return 'Users';
    }

    public static function PrimaryKey(): string
    {
        return 'UID';
    }

    public function attributes(): array
    {
        return ['UID', 'Email', 'Password', 'Role', 'Status', 'Security_Level'];
    }

    public function SecurityCheck(): bool
    {
        if ($this->IsAccountTemporaryBanned()) {
            $this->addError('account', 'Your Account is temporarily disabled!');
            return false;
        }
        if ($this->IsAccountPermanentlyBanned()) {
            $this->addError('account', 'Your Account is permanently disabled!');
            return false;
        }
        return true;
    }
}