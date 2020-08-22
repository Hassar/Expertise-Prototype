<?php

namespace App\Providers;

use App\Http\Expertise\Dhl;
use App\Http\Payment\Paypal;
use App\Http\Payment\CashOnDelivery;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Http\Expertise\ShippingContract;
use App\Http\Payment\PaymentGetewayContract;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /* Payment Geteway Contract */
        $this->app->singleton(PaymentGetewayContract::class, function($app){
            return new CashOnDelivery('usd');
        });

        /* Shipping Contract */
        $this->app->singleton(ShippingContract::class, function($app){
            return new Dhl();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }
}
