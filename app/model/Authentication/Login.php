<?php

namespace App\model\Authentication;

use App\model\database\dbModel;
use App\model\users\Person;
use App\model\users\User;
use Core\Application;
use Core\Model;

class Login extends dbModel
{

    protected string $UID='';
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
    protected string $Email='';
    protected string $Password='';
    protected string $Role='';
    protected int $Status=1;

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


    public function rules(): array
    {
        return [
            'Email' => [
                self::RULE_REQUIRED,self::RULE_EMAIL
            ],
            'Password' => [
                self::RULE_REQUIRED
            ],
        ];
    }


    public function labels():array
    {
        return[
            'ID'=>'ID',
            'email' => 'Email',
            'password' => 'Password'
        ];
    }

    public function login(): bool
    {

        //    Hashing Algorithm PASSWORD_BCRYPT
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
        $_SESSION['Email'] = $this->Email;
        Application::$app->login($user);
        Application::$app->session->setFlash('success','Login Successful!');
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
        return 'ID';
    }

    public function attributes(): array
    {
        return ['ID','Email','Password','Role','Status'];
    }
}