<?php

namespace Core;


class SessionObject
{
    private static $sessionObject;
    private $createdTime;
    private $lastAccessedTime;
    private $sessionID;
    private $sessionData;
    private $sessionName;
    private $sessionStatus;
    private $sessionTimeOut;

    public function __construct($sessionName,$data,$sessionTimeOut=60)
    {
        self::$sessionObject = $this;
        $this->sessionName = $sessionName;
        $this->sessionTimeOut = $sessionTimeOut;
        $this->sessionStatus = session_status();
        $this->sessionID = session_id();
        $this->createdTime = time();
        $this->lastAccessedTime = time();
        $this->sessionData = $data;
    }

    public function __toString(): string
    {
        return json_decode(json_encode($this->sessionData));
    }

    public function getSessionName()
    {
        return $this->sessionName;
    }

    public function getSessionID()
    {
        return $this->sessionID;
    }

    public function getSessionData()
    {
        return $this->sessionData;
    }

    public function getSessionStatus()
    {
        return $this->sessionStatus;
    }

    public function getSessionTimeOut()
    {
        return $this->sessionTimeOut;
    }

    public function updateLastAccessedTime(): void
    {
        $this->lastAccessedTime=time();
    }

    public function IsSessionExpired(): bool
    {
        return $this->lastAccessedTime + $this->sessionTimeOut < time();
    }

    public function getCreatedTime()
    {
        return $this->createdTime;
    }

    public function getLastAccessedTime()
    {
        return $this->lastAccessedTime;
    }

    public function setSessionName($sessionName)
    {
        $this->sessionName = $sessionName;
    }


}