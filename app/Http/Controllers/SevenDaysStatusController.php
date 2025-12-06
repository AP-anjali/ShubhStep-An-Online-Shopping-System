<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;
use Razorpay\Api\Api;
use Exception;
use Log;

class SevenDaysStatusController extends Controller
{
    public function updateSevenDaysStatus()
    {
        Log::info('updateSevenDaysStatus started at ' . Carbon::now()->toDateTimeString());

        try 
        {
            $orders = Order::where('is_order_delivered', 1)->where('is_seven_days_complete_to_delivery', 0)->get();

            foreach ($orders as $order) {
                $deliveryDate = Carbon::parse($order->order_delivered_date);
                $sevenDaysAgo = Carbon::now()->subDays(7);

                if ($deliveryDate->lte($sevenDaysAgo)) 
                {
                    $order->is_seven_days_complte_to_delivery = '1';
                    $order->save();
                }
            }

            
        } catch (Exception $e) {
            Log::error('General error in updateSevenDaysStatus: ' . $e->getMessage());
        }

        Log::info('updateSevenDaysStatus ended at ' . Carbon::now()->toDateTimeString());
    }
}
