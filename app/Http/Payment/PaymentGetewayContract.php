<?php

namespace App\Http\Payment;

interface PaymentGetewayContract {
    public function charge($amount);
}