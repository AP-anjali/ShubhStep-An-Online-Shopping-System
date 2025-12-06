<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Session;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

use App\Models\OrdersInvoice;
use App\Models\Order;
use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\Cart;
use App\Models\Product;
use App\Mail\OrderPaymentSuccessfulMail;

class RazorpayPaymentController extends Controller
{
    
    public function payment_of_single_product(Request $request)
    {
        $input = $request->all();

        $api = new Api(env('RAZORPAY_API_KEY'), env('RAZORPAY_API_SECRET'));
        $payment = $api->payment->fetch($input['razorpay_payment_id']);
        if (count($input) && !empty($input['razorpay_payment_id'])) 
        {
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture([
                    'amount' => $payment['amount']
                ]);

                $currentDateTime = Carbon::now();
                $currentDateTime->setTimezone('Asia/Kolkata'); 
                $formattedDateTime = $currentDateTime->format('d/m/y h:i:s A');

                $order = new OrdersInvoice;

                $customer_session = Session::get('customer_session');
                $customer_id = $customer_session->id;

                $order->customer_id = $customer_id;
                $actual_amount = $payment['amount'] / 100;
                $order->total_amount = $actual_amount;
                $order->transaction_id = $payment->id;
                $order->payment_id = $payment->id;
                $order->payment_status = $payment->status;
                $order->payment_method = $payment->method;
                $order->payment_info = json_encode($payment->toArray());
                $order->date_time = $formattedDateTime;

                $order->save();

                // -----------------------------

                $customer = Customer::find($customer_id);
                $customer_address = $customer->addresses->first();
                $customer_address_id = $customer_address->id;

                $product_id = $request->input('product_id');
                $product_quantity = $request->input('product_quantity');

                $orderInfo = new Order;
                $orderInfo->orders_invoice_id = $order->id;
                $orderInfo->customer_id = $customer_id;
                $orderInfo->customer_address_id = $customer_address_id;
                $orderInfo->product_id = $product_id;
                $orderInfo->product_quantity = $product_quantity;
                $orderInfo->product_price = $actual_amount;
                $orderInfo->order_payment_status = $order->payment_status;

                $orderInfo->is_order_placed = 1; 
                $orderInfo->order_placed_date = $formattedDateTime;

                $orderInfo->save();

                // --------------------------
                
                if ($request->has('fromCart')) 
                {
                    $condition = $request->input('fromCart');

                    if($condition == 1)
                    {
                        $cartRecordID = $request->input('cartRecordID');
                        $product_to_remove_from_cart = Cart::find($cartRecordID);
                        $product_to_remove_from_cart->delete();
                    }
                }

                $this->sendOrderPaymentDoneMail($customer->email);

            } catch (Exception $e) {
                Log::info($e->getMessage());
                return back()->withError($e->getMessage());
            }
        }
        return redirect()->route('customer_orders')->with('success', 'Payment Done, And Order Placed Successfully !');
    }

    public function payment_of_wholesale_product(Request $request)
    {
        $input = $request->all();
    
        $api = new Api(env('RAZORPAY_API_KEY'), env('RAZORPAY_API_SECRET'));
        $payment = $api->payment->fetch($input['razorpay_payment_id']);
    
        if (count($input) && !empty($input['razorpay_payment_id'])) 
        {
            try 
            {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture([
                    'amount' => $payment['amount']
                ]);
    
                $currentDateTime = Carbon::now();
                $currentDateTime->setTimezone('Asia/Kolkata'); 
                $formattedDateTime = $currentDateTime->format('d/m/y h:i:s A');

                $customer_session = Session::get('customer_session');
                $customer_id = $customer_session->id;

                $customer = Customer::find($customer_id);
                $customer_address = $customer->addresses->first();
                $customer_address_id = $customer_address->id;


                $product_ids = $request->input('product_id');
                $product_quantities = $request->input('product_quantity');
    
                foreach ($product_ids as $index => $product_id) 
                {

                    $product = Product::find($product_id);
                    $product_total_price = $product->price_with_discount * $product_quantities[$index];

                    $order = new OrdersInvoice;
    
                    $order->customer_id = $customer_id;
                    $order->total_amount = $product_total_price;
                    $order->transaction_id = $payment->id;
                    $order->payment_id = $payment->id;
                    $order->payment_status = $payment->status;
                    $order->payment_method = $payment->method;
                    $order->payment_info = json_encode($payment->toArray());
                    $order->date_time = $formattedDateTime;
                    $order->save();

                    $orderInfo = new Order;
                    $orderInfo->orders_invoice_id = $order->id;
                    $orderInfo->customer_id = $customer_id;
                    $orderInfo->customer_address_id = $customer_address_id;
                    $orderInfo->product_id = $product_id;
                    $orderInfo->product_quantity = $product_quantities[$index];
                    $orderInfo->order_payment_status = $order->payment_status;    
                    $orderInfo->product_price = $product_total_price;
                    $orderInfo->is_order_placed = 1; 
                    $orderInfo->order_placed_date = $formattedDateTime;
    
                    $orderInfo->save();
                }
    
                if ($request->has('fromCart')) 
                {
                    $condition = $request->input('fromCart');
    
                    if($condition == 1)
                    {
                        $cartRecords = Cart::where('customer_id', $customer_id)->get();

                        foreach ($cartRecords as $cartRecord) {
                            $cartRecord->delete();
                        }
                    }
                }
    
                $this->sendOrderPaymentDoneMail($customer->email);
    
            } 
            catch (Exception $e) 
            {
                Log::info($e->getMessage());
                return back()->withError($e->getMessage());
            }
        }
    
        return redirect()->route('customer_orders')->with('success', 'Payment Done, And Order Placed Successfully!');
    }    

    private function sendOrderPaymentDoneMail($email)
    {
        Mail::to($email)->send(new OrderPaymentSuccessfulMail($email));
    }

    public function cancelOrder(Request $request, $id)  
    {
        try
        {
            $order = Order::find($id);
            
            if (!$order) {
                return redirect()->route('customer_orders')->with('error', 'Order not found.');
            }
    
            $customer_session = Session::get('customer_session');
            $customer_id = $customer_session->id;
    
            if ($order->customer_id != $customer_id) {
                return redirect()->route('customer_orders')->with('error', 'Unauthorized action.');
            }

            $cancellationFeePercentage = env('ORDER_CANCELLATION_CHARGE_PERCENTAGE');
            $totalAmount = $order->product_price;
            $cancellationFee = ($totalAmount * $cancellationFeePercentage) / 100;
            $refundAmount = $totalAmount - $cancellationFee;

            $api = new Api(env('RAZORPAY_API_KEY'), env('RAZORPAY_API_SECRET'));
            $refund = $api->payment->fetch($order->OrdersInvoice->payment_id)->refund(['amount' => $refundAmount * 100]);    
    
            // Update order status
            $order->is_order_cancelled = 1;
            $order->order_cancelled_date = Carbon::now()->setTimezone('Asia/Kolkata')->format('d/m/y h:i:s A');
            $order->order_cancel_reason = $request->input('order_cancel_reason');
            $order->save();

            $order->OrdersInvoice->is_money_refunded = 1;
            $order->OrdersInvoice->save();
    
            return redirect()->route('cancelled_orders')->with('success', 'Order cancelled and refund initiated successfully, [ Razorpay takes 5 to 7 business days for refund ] !');
    
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('customer_orders')->with('error', 'Failed to cancel the order. Please try again.');
        }
    }

    public function payment_of_single_product_COD(Request $request)
    {
        $product_id = $request->input('product_id');
        $product_quantity = $request->input('product_quantity');

        $productData = Product::find($product_id);

        $actual_amount =  ($productData->price_with_discount * $product_quantity);

        $currentDateTime = Carbon::now();
        $currentDateTime->setTimezone('Asia/Kolkata'); 
        $formattedDateTime = $currentDateTime->format('d/m/y h:i:s A');

        $order = new OrdersInvoice;

        $customer_session = Session::get('customer_session');
        $customer_id = $customer_session->id;

        $order->customer_id = $customer_id;
        $order->total_amount = $actual_amount;
        $order->payment_method = "COD";
        $order->payment_status = "unpaid";
        $order->date_time = $formattedDateTime;

        $order->save();

        // -----------------------------

        $customer = Customer::find($customer_id);
        $customer_address = $customer->addresses->first();
        $customer_address_id = $customer_address->id;

        $orderInfo = new Order;
        $orderInfo->orders_invoice_id = $order->id;
        $orderInfo->customer_id = $customer_id;
        $orderInfo->customer_address_id = $customer_address_id;
        $orderInfo->product_id = $product_id;
        $orderInfo->product_quantity = $product_quantity;
        $orderInfo->product_price = $actual_amount; 
        $orderInfo->order_payment_status = $order->payment_status;

        $orderInfo->is_order_placed = 1; 
        $orderInfo->order_placed_date = $formattedDateTime;

        $orderInfo->save();

        // --------------------------
                
        if ($request->has('fromCart')) 
        {
            $condition = $request->input('fromCart');

            if($condition == 1)
            {
                $cartRecordID = $request->input('cartRecordID');
                $product_to_remove_from_cart = Cart::find($cartRecordID);
                $product_to_remove_from_cart->delete();
            }
        }

        $this->sendOrderPaymentDoneMail($customer->email);

        return redirect()->route('customer_orders')->with('success', 'Order Placed Successfully, with "cash on delivery" payment method !');
    }

    public function order_cancel_COD(Request $request, $id)
    {
        $order = Order::find($id);
            
        if (!$order) {
            return redirect()->route('customer_orders')->with('error', 'Order not found.');
        }
    
        $customer_session = Session::get('customer_session');
        $customer_id = $customer_session->id;
    
        if ($order->customer_id != $customer_id) {
            return redirect()->route('customer_orders')->with('error', 'Unauthorized action.');
        }
    
        $order->is_order_cancelled = 1;
        $order->order_cancelled_date = Carbon::now()->setTimezone('Asia/Kolkata')->format('d/m/y h:i:s A');
        $order->order_cancel_reason = $request->input('order_cancel_reason');
        $order->save();
    
        return redirect()->route('cancelled_orders')->with('success', 'Order cancelled successfully, [ Cash-on-delivery payment method ] !');  
    }

    public function payment_of_wholesale_product_COD(Request $request)
    {
        $product_ids = $request->input('product_id');
        $product_quantities = $request->input('product_quantity');

        $actual_amount =  $request->input('totalAmountWithDiscount');

        $currentDateTime = Carbon::now();
        $currentDateTime->setTimezone('Asia/Kolkata'); 
        $formattedDateTime = $currentDateTime->format('d/m/y h:i:s A');

        $customer_session = Session::get('customer_session');
        $customer_id = $customer_session->id;

        $customer = Customer::find($customer_id);
        $customer_address = $customer->addresses->first();
        $customer_address_id = $customer_address->id;

        foreach ($product_ids as $index => $product_id) {
            $product = Product::find($product_id);
            $product_total_price = $product->price_with_discount * $product_quantities[$index];
    
            $order = new OrdersInvoice;
            $order->customer_id = $customer_id;
            $order->total_amount = $product_total_price;
            $order->payment_method = "COD";
            $order->payment_status = "unpaid";
            $order->date_time = $formattedDateTime;
    
            $order->save();
    
            $orderInfo = new Order;
            $orderInfo->orders_invoice_id = $order->id;
            $orderInfo->customer_id = $customer_id;
            $orderInfo->customer_address_id = $customer_address_id;
            $orderInfo->product_id = $product_id;
            $orderInfo->product_quantity = $product_quantities[$index];
            $orderInfo->order_payment_status = $order->payment_status;
            $orderInfo->product_price = $product_total_price;
            $orderInfo->is_order_placed = 1; 
            $orderInfo->order_placed_date = $formattedDateTime;
    
            $orderInfo->save();
        }

        // --------------------------
                
        if ($request->has('fromCart')) 
        {
            $condition = $request->input('fromCart');
    
            if($condition == 1)
            {
                $cartRecords = Cart::where('customer_id', $customer_id)->get();

                foreach ($cartRecords as $cartRecord) {
                    $cartRecord->delete();
                }
            }
        }

        $this->sendOrderPaymentDoneMail($customer->email);

        return redirect()->route('customer_orders')->with('success', 'Order Placed Successfully, with "cash on delivery" payment method !');
    }

}
