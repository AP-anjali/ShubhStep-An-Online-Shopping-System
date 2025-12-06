<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

use App\Models\Customer;
use Illuminate\Support\Facades\Mail;
use App\Mail\OTPverificationMail;
use App\Models\Customer_otp;
use App\Models\CustomerAddress;
use App\Models\Wishlist;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Event;
use App\Models\SubEvent;
use App\Models\Order;
use App\Models\OrdersInvoice;
use Illuminate\Support\Facades\DB;

use Razorpay\Api\Api;
use Illuminate\Support\Facades\Log;
use Exception;

class CustomerController extends Controller
{
    public function customer_login_registration_page()
    {
        return view('customer_login_registration_page');
    }

    public function customer_registration(Request $request)
    {
        try{
            $validatedData = $request->validate([
                'name' => 'required|string|max:200',
                'email' => 'required|email|max:100|unique:customers,email',
                'phone_no' => 'required|digits:10|max:20|unique:customers,phone_no',
            ],[
                'phone_no.digits' => 'The phone number must be 10 digits.',
                'phone_no.unique' => 'The phone number has already been taken.',
            ]);
        }catch (\Illuminate\Validation\ValidationException $e) {
            $errorMessages = $e->validator->getMessageBag()->all();

            return redirect()->back()->withErrors($errorMessages)->withInput();
        }

        $currentDateTime = Carbon::now();
        $currentDateTime->setTimezone('Asia/Kolkata');
        $formattedDateTime = $currentDateTime->format('d/m/y h:i:s A');

        $Customer = new Customer();
        $Customer->name = $validatedData['name'];
        $Customer->email = $validatedData['email'];
        $Customer->phone_no = $validatedData['phone_no'];
        $Customer->registration_date_time = $formattedDateTime;
        $Customer->save();

        return redirect()->back()->with('success', 'Your account has been created successfully!');
    }

    public function email_verification_and_sending_otp(Request $request)
    {
        $input_email = $request->input('input_email');
        Session::put('input_email', $input_email);

        $user = Customer::where('email', $input_email)->first();
        if ($user) 
        {
            $userOTP = Customer_otp::where('customer_id',$user->id)->latest('OTP_created_at')->first();

            $now = now();

            if($userOTP && $now->isBefore($userOTP->OTP_expires_at))
            {
                $OTP = $userOTP->OTP;
            }
            else
            {
                $OTP = rand(100000, 999999);
            }

            $this->sendOTPEmailToCustomer($user->email, $OTP);
            
            Customer_otp::updateOrCreate(['customer_id'=>$user->id],[
                'customer_id' => $user->id,
                'OTP' => $OTP,
                'OTP_expires_at' => $now->addMinutes(10)
            ]);

            Session::put('mail_has_been_sent_to_user', true);

            return redirect()->back()->with('success', 'OTP has been sent !');
        } 
        else
        {
            return redirect()->back()->with('error', 'This E-mail address is not registered !')->withInput();
        }
    }

    private function sendOTPEmailToCustomer($email, $OTP)
    {
        Mail::to($email)->send(new OTPverificationMail($OTP));
    }

    public function otp_verification(Request $request)
    {
        $user = Customer::where('email', $request->registered_email)->first();
        $userID = $user->id;

        $userOtp = Customer_otp::where('customer_id', $userID)->where('OTP', $request->input_otp)->first();

        $now = now();

        if(!$userOtp)
        {
            Session::forget('input_email');
            Session::forget('mail_has_been_sent_to_user');
            return redirect()->back()->with('error', 'OTP does not match, please try again !')->withInput();
        }
        else if($userOtp && $now->isAfter($userOtp->OTP_expires_at))
        {
            Session::forget('input_email');
            Session::forget('mail_has_been_sent_to_user');
            return redirect()->back()->with('error', 'OTP has been expired, please try again !')->withInput();
        }


        if($user)
        {
            $userOtp->update([
                'OTP_expires_at' => now()
            ]);
            
            // echo "<br><h1>OTP CORRECT...</h1>";
            Session::forget('input_email');
            Session::forget('mail_has_been_sent_to_user');

            if($user->user_type == "0")
            {
                Session::put('customer_session', $user);
            }

            if($user->user_type == "1")
            {
                Session::put('admin_session', $user);
            }

            return redirect()->route('main_initial_page');

        }  
       
    }

    /* ------------------------------------------- product Display [start] --------------------------------------- */

    public function product_details($product_id)
    {
        $product_data =  Product::find($product_id);

        if(!$product_data)
        {
            return redirect()->route('page_not_found');
        }

        $other_product_data = Product::where('products.is_active', '1')
        ->where('id', '!=', $product_data->id)->whereHas('event', function($query) {
            $query->where('is_active', '1');
        })->whereHas('sub_event', function($query) {
            $query->where('is_active', '1');
        })->get();

        $customer_session = Session::get('customer_session');
        $admin_session = Session::get('admin_session');


        $allEvents = Event::where('is_active', '1')->whereHas('subEvents', function ($query) {
            $query->where('is_active', '1');
        })->with(['subEvents' => function ($query) {
            $query->where('is_active', '1');
        }])->get();

        $EventsWithLimit = Event::where('is_active', '1')->whereHas('subEvents', function ($query) {
            $query->where('is_active', '1');})->with(['subEvents' => function ($query) {
                $query->where('is_active', '1');}])->take(7)->get();

        $allProducts = Product::where('products.is_active', '1')->whereHas('event', function($query) {$query->where('is_active', '1');})->whereHas('sub_event', function($query) {$query->where('is_active', '1');})->orderBy('id', 'desc')->get();
        $latestProducts = Product::where('is_active', '1')->orderBy('created_at', 'desc')->take(5)->get();

        $topSoldProducts = Product::withCount(['orders as total_quantity_sold' => function ($query) {
            $query->select(DB::raw('SUM(product_quantity)'));
        }])->where('products.is_active', '1')->whereHas('event', function($query) {
            $query->where('is_active', '1');
        })->whereHas('sub_event', function($query) {
            $query->where('is_active', '1');
        })->orderBy('total_quantity_sold', 'desc')->take(5)->get();

        $userWishlistProducts = [];
        $userCartProducts = [];

        if($customer_session)
        {
            $userWishlistProducts = Wishlist::where('customer_id', $customer_session->id)->pluck('product_id')->toArray();
            $userCartProducts = Cart::where('customer_id', $customer_session->id)->pluck('product_id')->toArray();
            $productCount = count($userCartProducts);
            $productCountWhishlist = count($userWishlistProducts);

            $customer_to_get_address = Customer::find($customer_session->id);
        
            if ($customer_to_get_address->addresses->isNotEmpty()) 
            {
                $address_stored = true;
            }
            else
            {
                $address_stored = false;
            }

            return view('main_pages.product_details', compact('product_data', 'topSoldProducts', 'productCountWhishlist', 'other_product_data', 'productCount', 'allEvents', 'allProducts', 'userCartProducts', 'latestProducts', 'EventsWithLimit', 'admin_session', 'customer_session', 'userWishlistProducts', 'address_stored'));

        }

        return view('main_pages.product_details', compact('product_data', 'topSoldProducts', 'other_product_data', 'allEvents', 'allProducts', 'latestProducts', 'EventsWithLimit', 'admin_session', 'customer_session'));

    }

    public function product_of_specific_sub_event($event_name, $sub_event_name, $sub_event_id)
    {
        $sub_event_data =  SubEvent::find($sub_event_id);

        if(!$sub_event_data)
        {
            return redirect()->route('page_not_found');
        }

        $subEventProducts = Product::where('products.is_active', '1')->where('sub_event_id', $sub_event_id)->whereHas('event', function($query) {
            $query->where('is_active', '1');
        })->whereHas('sub_event', function($query) {
            $query->where('is_active', '1');
        })->get();

        $allEvents = Event::where('is_active', '1')->whereHas('subEvents', function ($query) {
            $query->where('is_active', '1');
        })->with(['subEvents' => function ($query) {
            $query->where('is_active', '1');
        }])->get();

        $EventsWithLimit = Event::where('is_active', '1')->whereHas('subEvents', function ($query) {
            $query->where('is_active', '1');})->with(['subEvents' => function ($query) {
                $query->where('is_active', '1');}])->take(7)->get();
        
        $allProducts = Product::where('products.is_active', '1')->whereHas('event', function($query) {$query->where('is_active', '1');})->whereHas('sub_event', function($query) {$query->where('is_active', '1');})->orderBy('id', 'desc')->get();
        $latestProducts = Product::where('is_active', '1')->orderBy('created_at', 'desc')->take(5)->get();

        $topSoldProducts = Product::withCount(['orders as total_quantity_sold' => function ($query) {
            $query->select(DB::raw('SUM(product_quantity)'));
        }])->where('products.is_active', '1')->whereHas('event', function($query) {
            $query->where('is_active', '1');
        })->whereHas('sub_event', function($query) {
            $query->where('is_active', '1');
        })->orderBy('total_quantity_sold', 'desc')->take(5)->get();

        $customer_session = Session::get('customer_session');
        $admin_session = Session::get('admin_session');

        $userWishlistProducts = [];
        $userCartProducts = [];

        if($customer_session)
        {
            $userWishlistProducts = Wishlist::where('customer_id', $customer_session->id)->pluck('product_id')->toArray();
            $userCartProducts = Cart::where('customer_id', $customer_session->id)->pluck('product_id')->toArray();
            $productCount = count($userCartProducts);
            $productCountWhishlist = count($userWishlistProducts);

            $customer_to_get_address = Customer::find($customer_session->id);
        
            if ($customer_to_get_address->addresses->isNotEmpty()) 
            {
                $address_stored = true;
            }
            else
            {
                $address_stored = false;
            }

            return view('product_of_specific_sub_event', compact('allEvents', 'topSoldProducts', 'subEventProducts', 'sub_event_data', 'productCountWhishlist','productCount', 'allProducts', 'userCartProducts', 'latestProducts', 'EventsWithLimit', 'admin_session', 'customer_session', 'userWishlistProducts', 'address_stored'));

        }

        return view('product_of_specific_sub_event', compact('allEvents', 'topSoldProducts', 'subEventProducts', 'sub_event_data', 'allProducts', 'latestProducts', 'EventsWithLimit', 'admin_session', 'customer_session'));
    }

    /* ------------------------------------------- product Display [end] --------------------------------------- */



    /* ------------------------------------------- product manipulation [start] --------------------------------------- */

    public function add_to_wishlist(Request $request)
    {
        $currentDateTime = Carbon::now();
        $currentDateTime->setTimezone('Asia/Kolkata');
        $formattedDateTime = $currentDateTime->format('d/m/y h:i:s A');

        $Customer = Customer::where('id', $request->customer_id)->first();
        $Product = Product::where('id', $request->product_id)->first();

        $Record = new Wishlist();
        $Record->customer_id = $Customer->id;
        $Record->product_id = $Product->id;
        $Record->date_time = $formattedDateTime;
        $Record->save();

        return redirect()->back()->with('success', 'product added to wishlist !');

    }

    public function add_to_cart(Request $request)
    {
        $currentDateTime = Carbon::now();
        $currentDateTime->setTimezone('Asia/Kolkata');
        $formattedDateTime = $currentDateTime->format('d/m/y h:i:s A');

        $Customer = Customer::where('id', $request->customer_id)->first();
        $Product = Product::where('id', $request->product_id)->first();

        $Record = new Cart();
        $Record->customer_id = $Customer->id;
        $Record->product_id = $Product->id;
        $Record->quantity = $request->input('quantity');

        $Record->total_products_price_without_discount = $Product->price_without_discount * $request->quantity;
        $Record->total_products_price_with_discount = $Product->price_with_discount * $request->quantity;
        
        $Record->date_time = $formattedDateTime;
        $Record->save();

        return redirect()->back()->with('success', 'Product added to cart !');

    }

    public function buy_now(Request $request)
    {
        $product_data = Product::where('id', $request->product_id)->first();
        $Customer = Customer::where('id', $request->customer_id)->first();
        $quantity = $request->input('quantity');
        $totalAmountWithoutDiscount = number_format((float)$product_data->price_without_discount * $quantity, 2, '.', '');
        $totalAmountWithDiscount = number_format((float)$product_data->price_with_discount * $quantity, 2, '.', '');

        $other_product_data = Product::where('products.is_active', '1')
        ->where('id', '!=', $product_data->id)->whereHas('event', function($query) {
            $query->where('is_active', '1');
        })->whereHas('sub_event', function($query) {
            $query->where('is_active', '1');
        })->get();

        $customer_session = Session::get('customer_session');
        $admin_session = Session::get('admin_session');

        $allEvents = Event::where('is_active', '1')->whereHas('subEvents', function ($query) {
            $query->where('is_active', '1');
        })->with(['subEvents' => function ($query) {
            $query->where('is_active', '1');
        }])->get();

        $EventsWithLimit = Event::where('is_active', '1')->whereHas('subEvents', function ($query) {
            $query->where('is_active', '1');})->with(['subEvents' => function ($query) {
                $query->where('is_active', '1');}])->take(7)->get();

        $allProducts = Product::where('products.is_active', '1')->whereHas('event', function($query) {$query->where('is_active', '1');})->whereHas('sub_event', function($query) {$query->where('is_active', '1');})->orderBy('id', 'desc')->get();
        $latestProducts = Product::where('is_active', '1')->orderBy('created_at', 'desc')->take(5)->get();

        $topSoldProducts = Product::withCount(['orders as total_quantity_sold' => function ($query) {
            $query->select(DB::raw('SUM(product_quantity)'));
        }])->where('products.is_active', '1')->whereHas('event', function($query) {
            $query->where('is_active', '1');
        })->whereHas('sub_event', function($query) {
            $query->where('is_active', '1');
        })->orderBy('total_quantity_sold', 'desc')->take(5)->get();

        $userWishlistProducts = [];
        $userCartProducts = [];

        if($customer_session)
        {
            $userWishlistProducts = Wishlist::where('customer_id', $customer_session->id)->pluck('product_id')->toArray();
            $userCartProducts = Cart::where('customer_id', $customer_session->id)->pluck('product_id')->toArray();
            $productCount = count($userCartProducts);
            $productCountWhishlist = count($userWishlistProducts);

            $customer_to_get_address = Customer::find($customer_session->id);
        
            if ($customer_to_get_address->addresses->isNotEmpty()) 
            {
                $address_stored = true;
            }
            else
            {
                $address_stored = false;
            }

            if ($request->has('fromCart')) 
            {
                $condition = $request->input('fromCart');

                if($condition == 1)
                {
                    $cartRecordID = $request->input('cartRecordID');
                    $product_to_remove_from_cart = Cart::find($cartRecordID);
                    $cartRecordID = $product_to_remove_from_cart->id;

                    return view('payment_of_single_product', compact('product_data', 'topSoldProducts', 'cartRecordID', 'Customer', 'quantity', 'totalAmountWithoutDiscount', 'totalAmountWithDiscount', 'productCountWhishlist', 'other_product_data', 'productCount', 'allEvents', 'allProducts', 'userCartProducts', 'latestProducts', 'EventsWithLimit', 'admin_session', 'customer_session', 'userWishlistProducts', 'address_stored'));
                }
            }

            return view('payment_of_single_product', compact('product_data', 'topSoldProducts', 'Customer', 'quantity', 'totalAmountWithoutDiscount', 'totalAmountWithDiscount', 'productCountWhishlist', 'other_product_data', 'productCount', 'allEvents', 'allProducts', 'userCartProducts', 'latestProducts', 'EventsWithLimit', 'admin_session', 'customer_session', 'userWishlistProducts', 'address_stored'));

        }

        return view('payment_of_single_product', compact('product_data', 'topSoldProducts', 'Customer', 'quantity', 'totalAmountWithoutDiscount', 'totalAmountWithDiscount', 'other_product_data', 'allEvents', 'allProducts', 'latestProducts', 'EventsWithLimit', 'admin_session', 'customer_session'));

    }

    public function checkout(Request $request)
    {
        $cart_data = [];

        if ($request->has('products')) {
            $cart_data = $request->input('products');
        }

        $Customer = Customer::where('id', $request->customer_id)->first();

        $totalAmountWithoutDiscount = 0;
        $totalAmountWithDiscount = 0;

        foreach ($cart_data as $product) {
            $totalAmountWithoutDiscount += isset($product['product_price_without_discount']) ? $product['product_price_without_discount'] : 0;
            $totalAmountWithDiscount += isset($product['product_price_with_discount']) ? $product['product_price_with_discount'] : 0;
        }

        $cartProductIds = collect($cart_data)->pluck('product_id')->toArray();

        $other_product_data = Product::where('products.is_active', '1')->whereNotIn('id', $cartProductIds)->whereHas('event', function($query) {
            $query->where('is_active', '1');
        })->whereHas('sub_event', function($query) {
            $query->where('is_active', '1');
        })->get();

        $customer_session = Session::get('customer_session');
        $admin_session = Session::get('admin_session');

        $allEvents = Event::where('is_active', '1')->whereHas('subEvents', function ($query) {
            $query->where('is_active', '1');
        })->with(['subEvents' => function ($query) {
            $query->where('is_active', '1');
        }])->get();

        $EventsWithLimit = Event::where('is_active', '1')->whereHas('subEvents', function ($query) {
            $query->where('is_active', '1');})->with(['subEvents' => function ($query) {
                $query->where('is_active', '1');}])->take(7)->get();

        $allProducts = Product::where('products.is_active', '1')->whereHas('event', function($query) {$query->where('is_active', '1');})->whereHas('sub_event', function($query) {$query->where('is_active', '1');})->orderBy('id', 'desc')->get();
        $latestProducts = Product::where('is_active', '1')->orderBy('created_at', 'desc')->take(5)->get();

        $topSoldProducts = Product::withCount(['orders as total_quantity_sold' => function ($query) {
            $query->select(DB::raw('SUM(product_quantity)'));
        }])->where('products.is_active', '1')->whereHas('event', function($query) {
            $query->where('is_active', '1');
        })->whereHas('sub_event', function($query) {
            $query->where('is_active', '1');
        })->orderBy('total_quantity_sold', 'desc')->take(5)->get();

        $userWishlistProducts = [];
        $userCartProducts = [];

        if($customer_session)
        {
            $userWishlistProducts = Wishlist::where('customer_id', $customer_session->id)->pluck('product_id')->toArray();
            $userCartProducts = Cart::where('customer_id', $customer_session->id)->pluck('product_id')->toArray();
            $productCount = count($userCartProducts);
            $productCountWhishlist = count($userWishlistProducts);

            $customer_to_get_address = Customer::find($customer_session->id);
        
            if ($customer_to_get_address->addresses->isNotEmpty()) 
            {
                $address_stored = true;
            }
            else
            {
                $address_stored = false;
            }

            if ($request->has('fromCart')) 
            {
                $condition = $request->input('fromCart');

                if($condition == 1)
                {
                    return view('payment_of_wholesale_product', compact('cart_data', 'topSoldProducts', 'totalAmountWithoutDiscount', 'totalAmountWithDiscount', 'condition', 'Customer', 'productCountWhishlist', 'other_product_data', 'productCount', 'allEvents', 'allProducts', 'userCartProducts', 'latestProducts', 'EventsWithLimit', 'admin_session', 'customer_session', 'userWishlistProducts', 'address_stored'));
                }
            }

            return view('payment_of_wholesale_product', compact('cart_data', 'topSoldProducts', 'totalAmountWithoutDiscount', 'totalAmountWithDiscount', 'Customer', 'productCountWhishlist', 'other_product_data', 'productCount', 'allEvents', 'allProducts', 'userCartProducts', 'latestProducts', 'EventsWithLimit', 'admin_session', 'customer_session', 'userWishlistProducts', 'address_stored'));

        }

        return view('payment_of_wholesale_product', compact('cart_data', 'topSoldProducts', 'totalAmountWithoutDiscount', 'totalAmountWithDiscount', 'Customer', 'other_product_data', 'allEvents', 'allProducts', 'latestProducts', 'EventsWithLimit', 'admin_session', 'customer_session'));

    }

    /* ------------------------------------------- product manipulation [end] --------------------------------------- */


    /* ------------------------------------------- Dashboard [start] --------------------------------------- */
    public function customer_dashboard()
    {
        $customer_session = Session::get('customer_session');
        $customer_address_data = CustomerAddress::where('customer_id', $customer_session->id)->first();
        return view('customer_dashboard', compact('customer_session', 'customer_address_data'));
    }

    public function customer_account()
    {
        $customer_session = Session::get('customer_session');
        $customer_address_data = CustomerAddress::where('customer_id', $customer_session->id)->first();
        return view('customer_account', compact('customer_session', 'customer_address_data'));
    }

    public function customer_cart()
    {
        $customer_session = Session::get('customer_session');
        $cart_data = Cart::where('customer_id', $customer_session->id)->get();
        return view('customer_cart', compact('customer_session', 'cart_data'));
    }

    public function customer_wishlist()
    {
        $customer_session = Session::get('customer_session');
        $wishlist_data = Wishlist::where('customer_id', $customer_session->id)->get();
        return view('customer_wishlist', compact('customer_session', 'wishlist_data'));
    }

    public function customer_orders()
    {
        $customer_session = Session::get('customer_session');
        $orders_data = Order::where('customer_id', $customer_session->id)->where('is_order_placed', '=', 1)->where('is_order_cancelled', '=', NULL)->where('is_order_rejected', '=', NULL)->where('is_order_delivered', '=', NULL)->orderBy('id', 'desc')->get();
        return view('customer_orders', compact('customer_session', 'orders_data'));
    }

    public function cancelled_orders()
    {
        $customer_session = Session::get('customer_session');
        $orders_data = Order::where('customer_id', $customer_session->id)->where('is_order_cancelled', '=', 1)->orderBy('id', 'desc')->get();
        return view('cancelled_orders', compact('customer_session', 'orders_data'));
    }

    public function rejected_orders()
    {
        $customer_session = Session::get('customer_session');
        $orders_data = Order::where('customer_id', $customer_session->id)->where('is_order_rejected', '=', 1)->orderBy('id', 'desc')->get();
        return view('rejected_orders', compact('customer_session', 'orders_data'));
    }

    public function remove_order(Request $request)
    {
        $orderID = $request->input('order_id');
        $orders_record_to_delete = Order::find($orderID);
        $orders_record_to_delete->delete();

        return redirect()->route('rejected_orders')->with('success', 'Order record removed !');
    }

    public function completed_orders()
    {
        $customer_session = Session::get('customer_session');
        $orders_data = Order::where('customer_id', $customer_session->id)->where('is_order_delivered', '=', 1)->where('is_requested_for_exchange', '=', NULL)->where('is_requested_for_return', '=', NULL)->orderBy('id', 'desc')->get();
        return view('completed_orders', compact('customer_session', 'orders_data'));
    }

    public function order_feedback_form(Request $request)
    {
        $orderID = $request->input('order_id');
        $FeedbackOrderData = Order::find($orderID);

        $customerID = $request->input('customer_id');
        $FeedbackCustomer = Customer::find($customerID);

        $customer_session = Session::get('customer_session');
        $orders_data = Order::where('customer_id', $customer_session->id)->where('is_order_delivered', '=', 1)->where('is_requested_for_exchange', '=', NULL)->where('is_requested_for_return', '=', NULL)->orderBy('id', 'desc')->get();
        return view('order_feedback_form', compact('customer_session', 'orders_data', 'FeedbackOrderData', 'FeedbackCustomer'));
    }

    public function storing_feedback(Request $request)
    {
        $currentDateTime = Carbon::now();
        $currentDateTime->setTimezone('Asia/Kolkata'); 
        $formattedDateTime = $currentDateTime->format('d/m/y h:i:s A');

        $feedbackOrder = Order::find($request->order_id);
        $feedbackOrder->star_rating = $request->input('star_rating');
        $feedbackOrder->feedback_text = $request->input('feedback_text');
        $feedbackOrder->feedback_date = $formattedDateTime;
        $feedbackOrder->save();

        return redirect()->route('completed_orders')->with('success', 'Your feedback has been received, THANK YOU !');
    }

    public function return_request_reason_form(Request $request)
    {
        $orderID = $request->input('order_id');
        $returnOrderData = Order::find($orderID);
        $customer_session = Session::get('customer_session');
        return view('return_request_reason_form', compact('customer_session', 'returnOrderData'));
    }

    public function return_request(Request $request)
    {
        $returnRequestOrder = Order::find($request->order_id);
        $returnRequestOrder->is_requested_for_return = 1;
        $returnRequestOrder->requested_for_return_date = Carbon::now()->setTimezone('Asia/Kolkata')->format('d/m/y h:i:s A');
        $returnRequestOrder->return_request_reason = $request->input('return_request_reason');

        if($request->has('COD'))
        {
            if($request->COD == 1)
            {

                try{
                    $validatedData = $request->validate([
                        'Bank_Account_Holder_Name' => 'required|string|max:255',
                        'Bank_Account_Number' => 'required|digits_between:9,20',
                        'IFSC_Code' => 'required|string|max:11',
                    ], [
                        'Bank_Account_Number.digits_between' => 'Account number must be between 9 and 20 digits.',
                        'IFSC_Code.max' => 'IFSC code cannot exceed 11 characters.',
                    ]);
                }catch (\Illuminate\Validation\ValidationException $e) {
                    $errorMessages = $e->validator->getMessageBag()->all();
        
                    return redirect()->back()->withErrors($errorMessages)->withInput();
                }
                
                $returnRequestOrder->Bank_Account_Holder_Name = $request->input('Bank_Account_Holder_Name');
                $returnRequestOrder->Bank_Account_Number = $request->input('Bank_Account_Number');
                $returnRequestOrder->Bank_Name = $request->input('Bank_Name');
                $returnRequestOrder->IFSC_Code = $request->input('IFSC_Code');
            }
        }

        $returnRequestOrder->save();

        return redirect()->route('customer_new_returne_request')->with('success', 'Your order return request has been sent successfully !');
    }

    public function canceling_return_request(Request $request)
    {
        $returnRequestOrder = Order::find($request->order_id);
        $returnRequestOrder->is_requested_for_return = NULL;
        $returnRequestOrder->requested_for_return_date = NULL;
        $returnRequestOrder->return_request_reason = Null;
        $returnRequestOrder->save();

        return redirect()->route('customer_new_returne_request')->with('success', 'Your order return request has been cancelled successfully !');
    }

    public function exchange_request_reason_form(Request $request)
    {
        $orderID = $request->input('order_id');
        $ExchangeOrderData = Order::find($orderID);
        $customer_session = Session::get('customer_session');
        return view('exchange_request_reason_form', compact('customer_session', 'ExchangeOrderData'));
    }

    public function exchange_request(Request $request)
    {
        $returnRequestOrder = Order::find($request->order_id);
        $returnRequestOrder->is_requested_for_exchange = 1;
        $returnRequestOrder->requested_for_exchange_date = Carbon::now()->setTimezone('Asia/Kolkata')->format('d/m/y h:i:s A');
        $returnRequestOrder->exchange_request_reason = $request->input('exchange_request_reason');
        $returnRequestOrder->save();

        return redirect()->route('customer_new_exchange_request')->with('success', 'Your order exchange request has been sent successfully !');
    }

    public function canceling_exchange_request(Request $request)
    {
        $returnRequestOrder = Order::find($request->order_id);
        $returnRequestOrder->is_requested_for_exchange = NULL;
        $returnRequestOrder->requested_for_exchange_date = NULL;
        $returnRequestOrder->exchange_request_reason = Null;
        $returnRequestOrder->save();

        return redirect()->route('customer_new_exchange_request')->with('success', 'Your order exchange request has been cancelled successfully !');
    }

    public function customer_new_exchange_request()
    {
        $customer_session = Session::get('customer_session');
        $orders_data = Order::where('customer_id', $customer_session->id)->where('is_order_delivered', '=', 1)->where('is_requested_for_exchange', '=', 1)->where('is_exchange_completed', '=', NULL)->orderBy('id', 'desc')->get();
        return view('customer_new_exchange_request', compact('customer_session', 'orders_data'));
    }

    public function exchanged_orders()
    {
        $customer_session = Session::get('customer_session');
        $orders_data = Order::where('customer_id', $customer_session->id)->where('is_order_delivered', '=', 1)->where('is_requested_for_exchange', '=', 1)->where('is_exchange_completed', '=', 1)->orderBy('id', 'desc')->get();
        return view('exchanged_orders', compact('customer_session', 'orders_data'));
    }

    public function customer_new_returne_request()
    {
        $customer_session = Session::get('customer_session');
        $orders_data = Order::where('customer_id', $customer_session->id)->where('is_order_delivered', '=', 1)->where('is_requested_for_return', '=', 1)->where('is_return_completed', '=', NULL)->orderBy('id', 'desc')->get();
        return view('customer_new_returne_request', compact('customer_session', 'orders_data'));
    }

    public function returned_orders()
    {
        $customer_session = Session::get('customer_session');
        $orders_data = Order::where('customer_id', $customer_session->id)->where('is_order_delivered', '=', 1)->where('is_requested_for_return', '=', 1)->where('is_return_completed', '=', 1)->orderBy('id', 'desc')->get();
        return view('returned_orders', compact('customer_session', 'orders_data'));
    }

    public function cancel_order_reason_form(Request $request)
    {
        $orderID = $request->input('order_id');
        $cancelledOrderData = Order::find($orderID);
        $customer_session = Session::get('customer_session');
        return view('cancel_order_reason_form', compact('customer_session', 'cancelledOrderData'));
    }

    public function cancel_order_reason_form2(Request $request)
    {
        $orderID = $request->input('order_id');
        $cancelledOrderData = Order::find($orderID);
        $customer_session = Session::get('customer_session');
        return view('cancel_order_reason_form2', compact('customer_session', 'cancelledOrderData'));
    }

    public function remove_from_cart($cart_id)
    {
        $record_to_remove_from_cart = Cart::where('id', $cart_id)->first();
        $record_to_remove_from_cart->delete();
        return redirect()->back()->with('success', 'Changes saved successfully !');
    }

    public function remove_from_wishlist($wishlist_id)
    {
        $record_to_remove_from_wishlist = Wishlist::where('id', $wishlist_id)->first();
        $record_to_remove_from_wishlist->delete();
        return redirect()->back()->with('success', 'Changes saved successfully !');
    }

    public function updating_cart_record(Request $request)
    {
        $cart_record_to_update = Cart::where('id', $request->input('product_id'))->first();

        $cart_record_to_update->quantity = $request->input('quantity');

        $cart_record_to_update->total_products_price_without_discount = $cart_record_to_update->Product->price_without_discount * $request->quantity;
        $cart_record_to_update->total_products_price_with_discount = $cart_record_to_update->Product->price_with_discount * $request->quantity;

        $cart_record_to_update->save();
        return redirect()->back()->with('success', 'Changes saved successfully !');

    }

    public function adding_address(Request $request)
    {
        try{
            $validatedData = $request->validate([
                'country' => 'required|string|max:50',
                'state' => 'required|string|max:50',
                'city' => 'required|string|max:50',
                'area_or_village' => 'required|string|max:50',
                'pincode' => 'required|numeric',
                'landmark' => 'required|string|max:50',
                'full_address' => 'required|string|max:150',
            ],[
                'pincode.numeric' => 'Pin-code must be a number',
            ]);
        }catch (\Illuminate\Validation\ValidationException $e) {
            $errorMessages = $e->validator->getMessageBag()->all();

            return redirect()->back()->withErrors($errorMessages)->withInput();
        }

        $customer_id_to_store_address = $request->input('customer_id');
        $customer_to_store_address = Customer::find($customer_id_to_store_address);

        $Data = new CustomerAddress();
        $Data->customer_id = $customer_to_store_address->id;
        $Data->country = $request->input('country');
        $Data->state = $request->input('state');
        $Data->city = $request->input('city');
        $Data->area_or_village = $request->input('area_or_village');
        $Data->pincode = $request->input('pincode');
        $Data->landmark = $request->input('landmark');
        $Data->full_address = $request->input('full_address');
        $Data->save();

        return redirect()->back()->with('success', 'Address details saved successfully !');
    }

    public function updating_address(Request $request)
    {
        try{
            $validatedData = $request->validate([
                'country' => 'required|string|max:50',
                'state' => 'required|string|max:50',
                'city' => 'required|string|max:50',
                'area_or_village' => 'required|string|max:50',
                'pincode' => 'required|numeric',
                'landmark' => 'required|string|max:50',
                'full_address' => 'required|string|max:150',
            ],[
                'pincode.numeric' => 'Pin-code must be a number',
            ]);
        }catch (\Illuminate\Validation\ValidationException $e) {
            $errorMessages = $e->validator->getMessageBag()->all();

            return redirect()->back()->withErrors($errorMessages)->withInput();
        }

        $customer_id_to_update_address = $request->input('customer_id');
        $customer_to_update_address = Customer::find($customer_id_to_update_address);

        $addressData = CustomerAddress::where('customer_id', $customer_to_update_address->id)->first();

        $addressData->country = $request->input('country');
        $addressData->state = $request->input('state');
        $addressData->city = $request->input('city');
        $addressData->area_or_village = $request->input('area_or_village');
        $addressData->pincode = $request->input('pincode');
        $addressData->landmark = $request->input('landmark');
        $addressData->full_address = $request->input('full_address');        
        $addressData->save();

        return redirect()->back()->with('success', 'Address details changed successfully !');
    }

    public function updating_profile(Request $request)
    {
        $customer_id_to_update_address = $request->input('customer_id');
        $customer_to_update = Customer::find($customer_id_to_update_address);
        $customer_id = $customer_to_update->id;

        try{
            $validatedData = $request->validate([
                'name' => 'nullable|string|max:200',
                'email' => 'nullable|email|max:100|unique:customers,email,' . $customer_id,
                'phone_no' => 'nullable|string|digits:10|max:20|unique:customers,phone_no,' . $customer_id,
                'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg',
            ],[
                'email.unique' => 'E-mail address is already registered !',
                'phone_no.unique' => 'Phone number address is already registered !',
                'phone_no.digits' => 'The phone number must be 10 digits.',
                'profile_pic.image' => 'The profile pic must be an image !',
                'profile_pic.mimes' => 'The profile pic must be a file of type: jpeg, png, jpg !',
            ]);
        }catch (\Illuminate\Validation\ValidationException $e) {
            $errorMessages = $e->validator->getMessageBag()->all();

            return redirect()->back()->withErrors($errorMessages)->withInput();
        }

        if ($request->has('name')) 
        {
            $customer_to_update->name = $request->input('name');
        }

        if ($request->has('email')) 
        {
            $customer_to_update->email = $request->input('email');
        }

        if ($request->has('phone_no')) 
        {
            $customer_to_update->phone_no = $request->input('phone_no');
        }
        
        if ($request->hasFile('profile_pic')) {
            $fileNameWithExt = $request->file('profile_pic')->getClientOriginalName();
            
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            
            $extension = $request->file('profile_pic')->getClientOriginalExtension();
            
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
    
            $path = $request->file('profile_pic')->storeAs('public/img', $fileNameToStore);
    
            $customer_to_update->profile_pic = 'img/'.$fileNameToStore;
        }

        $customer_to_update->save();

        Session::forget('customer_session');

        return redirect()->route('customer_login_registration_page')->with('success', 'Login with new credentials !');
    }

    public function updating_profile2(Request $request)
    {
        $customer_id_to_update_address = $request->input('customer_id');
        $customer_to_update = Customer::find($customer_id_to_update_address);
        $customer_id = $customer_to_update->id;

        try{
            $validatedData = $request->validate([
                'name' => 'nullable|string|max:200',
                'email' => 'nullable|email|max:100|unique:customers,email,' . $customer_id,
                'phone_no' => 'nullable|string|digits:10|max:20|unique:customers,phone_no,' . $customer_id,
                'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg',
            ],[
                'email.unique' => 'E-mail address is already registered !',
                'phone_no.unique' => 'Phone number address is already registered !',
                'phone_no.digits' => 'The phone number must be 10 digits.',
                'profile_pic.image' => 'The profile pic must be an image !',
                'profile_pic.mimes' => 'The profile pic must be a file of type: jpeg, png, jpg !',
            ]);
        }catch (\Illuminate\Validation\ValidationException $e) {
            $errorMessages = $e->validator->getMessageBag()->all();

            return redirect()->back()->withErrors($errorMessages)->withInput();
        }

        if ($request->has('name')) 
        {
            $customer_to_update->name = $request->input('name');
        }

        if ($request->has('email')) 
        {
            $customer_to_update->email = $request->input('email');
        }

        if ($request->has('phone_no')) 
        {
            $customer_to_update->phone_no = $request->input('phone_no');
        }
        
        if ($request->hasFile('profile_pic')) {
            $fileNameWithExt = $request->file('profile_pic')->getClientOriginalName();
            
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            
            $extension = $request->file('profile_pic')->getClientOriginalExtension();
            
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
    
            $path = $request->file('profile_pic')->storeAs('public/img', $fileNameToStore);
    
            $customer_to_update->profile_pic = 'img/'.$fileNameToStore;
        }

        $customer_to_update->save();

        Session::forget('customer_session');
        Session::put('customer_session', $customer_to_update);

        return redirect()->route('customer_account')->with('success', 'Changes saved successfully !');
    }
    /* ------------------------------------------- Dashboard [end] --------------------------------------- */



    /* ------------------------------------------- Dashboard [end] --------------------------------------- */

    public function go_to_register_address()
    {
        return redirect()->route('customer_account')->with('addressError', 'Please register your address first !');
    }

    public function go_to_register_only_phone_number()
    {
        return redirect()->route('customer_account')->with('PhoneError', 'Please register your phone number first !');
    }

    public function both()
    {
        return redirect()->route('customer_account')->with('PhoneError', 'Please register your phone number first!')
        ->with('addressError', 'Please register your address first!');
    }

    /* ------------------------------------------- Dashboard [end] --------------------------------------- */

    public function customer_logout()
    {
        if(Session::has('customer_session')){
            Session::pull('customer_session');
            return redirect('/');
        }
    }
}
