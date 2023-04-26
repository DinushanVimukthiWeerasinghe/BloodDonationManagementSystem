<?php

namespace App\model\Payment;

class Payment
{
    public $Payment;
    public function __construct()
    {
        $this->Payment = new \Stripe\StripeClient($_ENV["STRIPE_SECRET_KEY"]);
    }

}