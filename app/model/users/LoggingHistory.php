<?php

namespace App\model\users;

class LoggingHistory
{
    private string $id;
    private string $user_id;
    private string $login_time;
    private string $logout_time;
    private string $ip_address;
    private string $user_agent;
    private string $status;
    private string $created_at;

    /**
     * @param string $id
     * @param string $user_id
     * @param string $login_time
     * @param string $logout_time
     * @param string $ip_address
     * @param string $user_agent
     * @param string $status
     * @param string $created_at
     */
    public function __construct(string $id, string $user_id, string $login_time, string $logout_time, string $ip_address, string $user_agent, string $status, string $created_at)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->login_time = $login_time;
        $this->logout_time = $logout_time;
        $this->ip_address = $ip_address;
        $this->user_agent = $user_agent;
        $this->status = $status;
        $this->created_at = $created_at;
    }


}