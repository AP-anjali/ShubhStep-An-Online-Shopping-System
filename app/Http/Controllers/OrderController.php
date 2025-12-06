<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;
use Razorpay\Api\Api;
use Exception;
use Log;

class OrderController extends Controller
{
    public function checkRefundStatus()
    {
        Log::info('checkRefundStatus started at ' . Carbon::now()->toDateTimeString());

        try {
            $orders = Order::where(function($query) {
                $query->where('is_order_cancelled', 1)
                      ->orWhere('is_order_rejected', 1);
            })->whereNull('is_payment_refunded')->get();

            $api = new Api(env('RAZORPAY_API_KEY'), env('RAZORPAY_API_SECRET'));

            foreach ($orders as $order) {
                $paymentId = $order->OrdersInvoice->payment_id ?? null;

                if (!$paymentId) {
                    Log::error('Payment ID is null for Order ID: ' . $order->id);
                    continue;
                }

                Log::info('Fetching payment ID: ' . $paymentId);

                try {
                    $payment = $api->payment->fetch($paymentId);

                    $refunds = $payment->refunds();

                    foreach ($refunds['items'] as $refund) {
                        if ($refund['status'] == 'processed') {
                            $order->is_payment_refunded = 1;
                            $order->payment_refunded_date = Carbon::parse($refund['created_at'])->setTimezone('Asia/Kolkata')->format('d/m/y h:i:s A');
                            $order->save();

                            Log::info('Refund processed for Order ID: ' . $order->id);
                        }
                    }
                } catch (Exception $e) {
                    Log::error('Error fetching payment or processing refund for Order ID: ' . $order->id . ' - ' . $e->getMessage());
                }
            }
        } catch (Exception $e) {
            Log::error('General error in checkRefundStatus: ' . $e->getMessage());
        }

        Log::info('checkRefundStatus ended at ' . Carbon::now()->toDateTimeString());
    }

}
