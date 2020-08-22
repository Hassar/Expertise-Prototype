<?php
namespace App\Http\Services;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Request;
use App\Http\Expertise\ShippingContract;
use App\Http\Payment\PaymentGetewayContract;
use App\Http\Resources\Order as OrderResource;

class OrderService
{
    private $payment_gateway;
    private $shipping_gateway;
    
    /**
     * Instantiate service
     * 
     * @param \App\Http\Payment\PaymentGetewayContract $payment_gateway
     * @param \App\Http\Payment\ShippingContract $shipping_gateway
     */
    public function __construct(PaymentGetewayContract $payment_gateway, ShippingContract $shipping_gateway)
    {
        $this->payment_gateway = $payment_gateway;
        $this->shipping_gateway = $shipping_gateway;
    }

    /**
     * Orders list.
     * 
     * @return \Illuminate\Http\Response
    */
    public function list()
    {
        try {
            $orders = OrderResource::collection(Order::whereUserId(\Auth::id())->paginate());
            return response()->json([
                'res' => true,
                'order' => $orders
            ], 200);
        } catch (\Throwable $th) {
            \Log::error("Login user error: {$th->getMessage()}");
            return ['res' => false, 'msg' => $th->getMessage()];
        }
    }

    /**
     * updateOrCreate Orders.
     * 
     * @param  array  $data
     * @return \Illuminate\Http\Response
    */
    public function updateOrCreate($data)
    {
        try {
            $order = null;
            \DB::transaction(function () use($data,&$order) {
                /* Update or create order */
                $order = Order::updateOrCreate(
                    ['id' => isset($data['id']) ? $data['id'] : NULL],
                    \Arr::except($data,['id'])
                );

                /* Create payment */
                $payment = $this->payment_gateway->charge($order->total);
                $shipping = $this->shipping_gateway->getRate();
                Payment::create([
                    'token' => $payment['token'], 
                    'shipper' => $shipping['class_name'],
                    'type' => $payment['class_name'], 
                    'amount' => $payment['amount'] + $shipping['rate'],
                    'order_id' => $order->id
                ]);
            }, 5);
            if($order) {
                $is_created = isset($data['id']) ? 'Create' : 'Update';
                \Log::info("$is_created order created : {$order->id}, by user ID : ".\Auth::id().", from IP : ".Request::getClientIp(true));
                return response()->json([
                    'res' => true,
                    'msg' => new OrderResource($order)
                ], 200);
            }
            return response()->json([
                'res' => false,
                'order' => 'HTTP 502 Bad Gateway'
            ], 502);
        } catch (\Throwable $th) {
            \Log::error("Login user error: {$th->getMessage()}");
            return ['res' => false, 'msg' => $th->getMessage()];
        }
    }
}