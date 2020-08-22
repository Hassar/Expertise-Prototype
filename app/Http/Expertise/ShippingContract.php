<?php

namespace App\Http\Expertise;

interface ShippingContract {
    public function getRate();
    public function createShipping($data);
}