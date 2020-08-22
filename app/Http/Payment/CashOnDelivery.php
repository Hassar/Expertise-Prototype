<?php
namespace App\Http\Payment;

use Illuminate\Support\Str;

class CashOnDelivery implements PaymentGetewayContract
{
    private $curency;
    /**
     * Instantiate service
     * 
     * @param string $curency
     */
    public function __construct($curency)
    {
        $this->curency = $curency;
    }

    public function charge($amount)
    {
        // CashOnDelivery Code

        return [
            'token' => Str::random(),
            'amount' => $amount,
            'curency' => $this->curency,
            'class_name' => Str::snake(class_basename($this))
        ];
    }
}