<?php
namespace App\Http\Expertise;

use Illuminate\Support\Str;

class Dhl implements ShippingContract
{
    /**
     * Instantiate service
     * 
     * @param type $param
     */
    public function __construct()
    {
        // code
    }

    public function getRate()
    {
        /* $response = Http::get('http://expertise.com/get_rate');
        if($response->successful()) return $response->json();
        return $response->serverError(); */

        return [
            'rate' => 50.00,
            'class_name' => Str::snake(class_basename($this))
        ];
    }

    public function createShipping($amount)
    {
        /* $response = Http::post('http://expertise.com/create-shipping', [
                'params1' => 'params1',
                'params2' => 'params2'
            ]);
        if($response->successful()) return $response->json();
        return $response->serverError(); */
    }
}