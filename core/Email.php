<?php

namespace Core;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

abstract class Email
{
    public const PASSWORD_RESET = 'password_reset';
    public string $from;
    public mixed $to;
    public string $subject;
    public string $body;
    private PHPMailer $mailer;

    /**
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * @param string $from
     */
    public function setFrom(string $from): void
    {
        $this->from = $from;
    }

    /**
     * @return string
     */
    public function getTo(): string
    {
        return $this->to;
    }

    /**
     * @param string $to
     */
    public function setTo(string $to): void
    {
        $this->to = $to;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    /**
     * @throws Exception
     */
    public function AddAttachment($file)
    {
        $this->mailer->addAttachment($file);

    }


    /**
     * @throws Exception
     */
    protected function __construct(array $config)
    {
        try {
            $this->mailer = new PHPMailer(true);
            $this->mailer->isSMTP();
//            $this->mailer->SMTPDebug = 0;
            $this->mailer->Host = $config['host'];
            $this->mailer->Port = $config['port'];
            $this->mailer->ContentType = 'text/html';
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
    public function AddImage($image, $cid, $name)
    {
        $this->mailer->addEmbeddedImage($image,$cid,$name);
    }

    /**
     * @throws Exception
     */
    public function send(): bool
    {
        $this->mailer->setFrom($this->from);
        if (is_array($this->to)) {
            foreach ($this->to as $item) {
                $this->mailer->addAddress($item);
            }
        } else {
            $this->mailer->addAddress($this->to);
        }
        $this->mailer->Subject = $this->subject;
        $this->mailer->Body = $this->body;
        return $this->mailer->send();
    }
}