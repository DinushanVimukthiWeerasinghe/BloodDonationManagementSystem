<?php
namespace Core;
use App\model\Authentication\LoggingHistory;

class Session
{
    protected const FLASH_KEY='flash_messages';
    protected const SESSION_OBJECT='session_object';
    private array $sessionObject=[];
    public function __construct()
    {
        session_start();
        if (isset($_SESSION[self::SESSION_OBJECT])) {
            $this->sessionObject = $_SESSION[self::SESSION_OBJECT];
        }
        /** @var SessionObject $value*/
        foreach ($this->sessionObject as $key=>$value)
        {
            if($value->IsSessionExpired())
            {
                $sessionID=$this->sessionObject[$key]->getSessionID();
                LoggingHistory::updateOne(['Session_ID'=>$sessionID],['Session_End'=>date('Y-m-d H:i:s'),'Session_End_Type'=>LoggingHistory::Timeout]);
                unset($this->sessionObject[$key]);
                unset($_SESSION[self::SESSION_OBJECT][$key]);
                unset($_SESSION[$key]);
            }else{
                $value->updateLastAccessedTime();
            }
        }

        $flashMessages=$_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flashMessages as $key=>&$flashMessage) {
            //Mark TO be Removed
            $flashMessage['remove']=true;
        }
        $_SESSION[self::FLASH_KEY]=$flashMessages;
    }

    public function __destruct()
    {
        //Iterate Over marked to be removed
        $flashMessages=$_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flashMessages as $key=>&$flashMessage) {
            if ($flashMessage['remove']) {
                unset($flashMessages[$key]);
            }
        }
        $_SESSION[self::FLASH_KEY]=$flashMessages;

    }

    public function setFlash($key,$message): void
    {
        $_SESSION[self::FLASH_KEY][$key] = [
            'remove'=>false,
            'value'=>$message
        ];
    }

    private function setSession($key,$value): void
    {
        $_SESSION[self::SESSION_OBJECT][$key]=$value;
    }

    public function getFlash($key)
    {
        return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
    }

    public function get($key)
    {
        return $_SESSION[$key] ?? false;
    }
    public function set($key,$value,int $min=1): void
    {
        $session=new SessionObject($key,$value,$min*60);
        $_SESSION[$key]=$session;
        $this->setSession($key,$session);
    }

    public function setPermanant($key,$value): void
    {
        $_SESSION[$key]=$value;
    }

    public function RemovePermanant($key)
    {
        if(isset($_SESSION[$key]))
        {
            unset($_SESSION[$key]);
        }

    }

    public function remove($key): void
    {
        if(isset($_SESSION[$key]))
        {
            unset($_SESSION[$key]);
            unset($_SESSION[self::SESSION_OBJECT][$key]);
        }
    }

}