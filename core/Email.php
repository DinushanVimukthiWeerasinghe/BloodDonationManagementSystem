<?php

namespace Core;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

abstract class Email
{
    public string $from;
    public string $to;
    public string $subject;
    public string $body;
    private PHPMailer $mailer;

    /**
     * @throws Exception
     */
    protected function __construct(array $config)
    {
        try {
            $this->mailer = new PHPMailer(true);
            $this->mailer->isSMTP();
            $this->mailer->SMTPDebug = 0;
            $this->mailer->Host = $config['host'];
            $this->mailer->Port = $config['port'];
            $this->mailer->SMTPSecure = $config['encryption'];
            $this->mailer->SMTPAuth = true;
            $this->mailer->Username = $config['username'];
            $this->mailer->Password = $config['password'];
            $this->mailer->setFrom($config['from']);
        }catch (Exception $e){
            throw new Exception('PHPMailer not found');
        }
    }

    /**
     * @throws Exception
     */
    protected function send(mixed $to,string $from, string $subject, string $body): bool
    {
        $this->mailer->setFrom($from);
        if(is_array($to)){
            foreach ($to as $item){
                $this->mailer->addAddress($item);
            }
        }else{
            $this->mailer->addAddress($to);
        }
        $this->mailer->Subject = $subject;
        $this->mailer->Body = $body;
        return $this->mailer->send();
    }
}