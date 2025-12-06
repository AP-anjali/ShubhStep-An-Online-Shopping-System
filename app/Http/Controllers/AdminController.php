<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Event;
use App\Models\SubEvent;
use App\Models\Product;
use Carbon\Carbon;

use App\Models\Customer;
use Illuminate\Support\Facades\Mail;
use App\Mail\ADMINverificationMail;
use App\Mail\ExchangeVerificationOtpMail;
use App\Mail\DeliveryVerificationOtpMail;
use App\Mail\ReturnVerificationOtpMail;
use App\Models\Customer_otp;
use App\Mail\OTPverificationMail;
use App\Models\CustomerAddress;
use App\Models\Wishlist;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrdersInvoice;

use App\Models\DeliveryVerificationOtp;
use App\Models\ExchangeVerificationOtp;
use App\Models\ReturnVerificationOtp;

use App\Models\ContactFormMail;
use App\Models\FeedbackFormMail;
use App\Models\CustomerSupportFormMail;

use Razorpay\Api\Api;
use Razorpay\Api\Payout;
use Razorpay\Api\Errors\BadRequestError;
use Illuminate\Support\Facades\Log;
use Exception;
use GuzzleHttp\Client;

class AdminController extends Controller
{
    public function admin_dashboard()
    {
        $admin_session = Session::get('admin_session');
        return view('admin_dashboard', compact('admin_session'));
    }

    public function admin_dashboard2()
    {
        $admin_session = Session::get('admin_session');
        return view('admin_dashboard2', compact('admin_session'));
    }

    /* -------------------------------------------------- admin profile [start] -------------------------------------------------- */
    public function admin_settings_page()
    {
        $admin_session = Session::get('admin_session');
        return view('admin_settings_page', compact('admin_session'));
    }

    public function admin_account()
    {
        $admin_session = Session::get('admin_session');
        return view('admin_account', compact('admin_session'));
    }

    public function send_otp_to_admin()
    {
        $admin_session = Session::get('admin_session');

        $input_email = $admin_session->email;

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

            $this->sendOTPEmailToAdmin($user->email, $OTP);
            
            Customer_otp::updateOrCreate(['customer_id'=>$user->id],[
                'customer_id' => $user->id,
                'OTP' => $OTP,
                'OTP_expires_at' => $now->addMinutes(10)
            ]);

            return redirect()->back()->with('OTP_SENT', 'OTP has been sent on your registered email : ' . $user->email . ', This OTP is valid of 10 minutes !');
        } 
        else
        {
            return redirect()->back()->with('error', 'This E-mail address is not registered, please register Yourself first !')->withInput();
        }
    }

    private function sendOTPEmailToAdmin($email, $OTP)
    {
        Mail::to($email)->send(new ADMINverificationMail($OTP));
    }

    public function verify_admin_otp(Request $request)
    {
        $admin_session = Session::get('admin_session');

        $user = Customer::where('email', $admin_session->email)->first();
        $userID = $user->id;

        $userOtp = Customer_otp::where('customer_id', $userID)->where('OTP', $request->input_otp)->first();

        $now = now();

        if(!$userOtp)
        {
            Session::forget('mail_has_been_sent_to_user2');
            return redirect()->back()->with('error', 'OTP does not match, please try again !')->withInput();
        }
        else if($userOtp && $now->isAfter($userOtp->OTP_expires_at))
        {
            Session::forget('mail_has_been_sent_to_user2');
            return redirect()->back()->with('error', 'OTP has been expired, please try again !')->withInput();
        }


        if($user)
        {
            $userOtp->update([
                'OTP_expires_at' => now()
            ]);
            
            return redirect()->back()->with('UserVerified', 'E-mail address has been verified, now you can change your details [do not refresh page] !');

        }  
       
    }

    public function updating_admin_details(Request $request)
    {
        $admin_session = Session::get('admin_session');
        $admin_id = $admin_session->id;

        $admin_data_to_update = Customer::find($admin_id);

        try{
            $validatedData = $request->validate([
                'name' => 'required|string|max:200',
                'email' => 'required|email|max:100|unique:customers,email,' . $admin_id,
                'phone_no' => 'required|string|max:20|unique:customers,phone_no,' . $admin_id,
            ]);
        }catch (\Illuminate\Validation\ValidationException $e) {
            $errorMessages = $e->validator->getMessageBag()->all();

            return redirect()->back()->withErrors($errorMessages);
        }

        $admin_data_to_update->name = $request->input('name');
        $admin_data_to_update->email = $request->input('email');
        $admin_data_to_update->phone_no = $request->input('phone_no');

        if ($request->hasFile('profile_pic')) {
            $profile_pic = $request->file('profile_pic')->store('img', 'public');
            $admin_data_to_update->update(['profile_pic' => $profile_pic]);
        }

        $admin_data_to_update->save();

        Session::forget('admin_session');

        return redirect()->route('customer_login_registration_page')->with('success', 'Login with new credentials !');

    }

    public function updating_admin_details2(Request $request)
    {
        $admin_session = Session::get('admin_session');
        $admin_id = $admin_session->id;

        $admin_data_to_update = Customer::find($admin_id);

        try{
            $validatedData = $request->validate([
                'name' => 'required|string|max:200',
                'email' => 'required|email|max:100|unique:customers,email,' . $admin_id,
                'phone_no' => 'required|string|max:20|unique:customers,phone_no,' . $admin_id,
            ]);
        }catch (\Illuminate\Validation\ValidationException $e) {
            $errorMessages = $e->validator->getMessageBag()->all();

            return redirect()->back()->withErrors($errorMessages);
        }

        $admin_data_to_update->name = $request->input('name');
        $admin_data_to_update->email = $request->input('email');
        $admin_data_to_update->phone_no = $request->input('phone_no');

        if ($request->hasFile('profile_pic')) {
            $profile_pic = $request->file('profile_pic')->store('img', 'public');
            $admin_data_to_update->update(['profile_pic' => $profile_pic]);
        }

        $admin_data_to_update->save();

        Session::forget('admin_session');
        Session::put('admin_session', $admin_data_to_update);

        return redirect()->route('admin_account')->with('success', 'Changes saved successfully !');

    }
    /* -------------------------------------------------- admin profile [end] -------------------------------------------------- */

    /* -------------------------------------------------- Events [start] -------------------------------------------------- */
    public function admin_dahboard_events_page()
    {
        $admin_session = Session::get('admin_session');
        $allEvents = Event::all();
        return view('admin_dahboard_events_page', compact('admin_session', 'allEvents'));
    }

    public function admin_dahboard_events_page2()
    {
        $admin_session = Session::get('admin_session');
        $allEvents = Event::all();
        return view('admin_dahboard_events_page2', compact('admin_session', 'allEvents'));
    }

    public function adding_event(Request $request)
    {
        try{
            $validatedData = $request->validate([
                'event_name' => 'required|string|unique:events,event_name',
                'description' => 'required',
            ], 
            [
                'event_name.required' => 'Please enter data for event name',
                'event_name.unique' => 'Entered event name is already registered',
                'description.required' => 'Please enter data for event description',
            ]);
        }catch (\Illuminate\Validation\ValidationException $e) {
            $errorMessages = $e->validator->getMessageBag()->all();

            return redirect()->back()->withErrors($errorMessages)->withInput();
        }

        $currentDateTime = Carbon::now();
        $currentDateTime->setTimezone('Asia/Kolkata');
        $formattedDateTime = $currentDateTime->format('d/m/y h:i:s A');

        Event::create([
            'event_name' => $validatedData['event_name'],
            'description' => $validatedData['description'],
            'date_time' => $formattedDateTime,
        ]);

        return redirect()->back()->with('success', 'Event Added successfully!');
    }

    public function deactivating_event($id)
    {
        $event_to_deactivate = Event::find($id);
        $event_to_deactivate->is_active = "0";
        $event_to_deactivate->save();
        return redirect()->route('admin_dahboard_events_page')->with('success', 'Event deactivated successfully!');
    }

    public function activating_event($id)
    {
        $event_to_activate = Event::find($id);
        $event_to_activate->is_active = "1";
        $event_to_activate->save();
        return redirect()->route('admin_dahboard_events_page')->with('success', 'Event activated successfully!');
    }

    public function deleting_event($id)
    {
        $event_to_delete = Event::find($id);
        $event_to_delete->delete();
        return redirect()->back()->with('success', 'Event Deleted successfully!');
    }

    public function updating_event(Request $request)
    {   
        $eventID = $request->input('event_id');
        $event_to_update = Event::find($eventID);

        $currentDateTime = Carbon::now();
        $currentDateTime->setTimezone('Asia/Kolkata');
        $formattedDateTime = $currentDateTime->format('d/m/y h:i:s A');

        try{
            $validatedData = $request->validate([
                'event_name' => 'required|string|unique:events,event_name,' . $eventID,
                'description' => 'required',
            ], 
            [
                'event_name.required' => 'Please enter data for event name',
                'event_name.unique' => 'Entered event name is already registered, please try another one !',
                'description.required' => 'Please enter data for event description',
            ]);
        }catch (\Illuminate\Validation\ValidationException $e) {
            $errorMessages = $e->validator->getMessageBag()->all();

            return redirect()->back()->withErrors($errorMessages);
        }

        $event_to_update->event_name = $request->input('event_name');
        $event_to_update->description = $request->input('description');
        $event_to_update->date_time = $formattedDateTime;
        $event_to_update->save();
        return redirect()->back()->with('success', 'Event updated successfully!');
    }
    /* -------------------------------------------------- Events [end] -------------------------------------------------- */


    /* -------------------------------------------------- Sub-events [start] -------------------------------------------------- */
    public function admin_dahboard_sub_events_page()
    {
        $admin_session = Session::get('admin_session');
        $allEvents = Event::where('is_active', '1')->get();
        return view('admin_dahboard_sub_events_page', compact('admin_session', 'allEvents'));
    }

    public function adding_sub_event(Request $request)
    {
        $event = Event::where('event_name', $request->event_name)->first();

        try{
            $validatedData = $request->validate([
                'sub_event_name' => 'required|string|unique:sub_events,sub_event_name',
            ], 
            [
                'sub_event_name.required' => 'Please enter data for sub event name',
                'sub_event_name.unique' => 'Entered sub event name is already registered',
            ]);
        }catch (\Illuminate\Validation\ValidationException $e) {
            $errorMessages = $e->validator->getMessageBag()->all();

            return redirect()->back()->withErrors($errorMessages)->withInput();
        }

        $currentDateTime = Carbon::now();
        $currentDateTime->setTimezone('Asia/Kolkata');
        $formattedDateTime = $currentDateTime->format('d/m/y h:i:s A');

        SubEvent::create([
            'event_id' => $event->id,
            'sub_event_name' => $validatedData['sub_event_name'],
            'date_time' => $formattedDateTime,
        ]);

        return redirect()->back()->with('success', 'Sub-event Added successfully!');
    }

    public function updating_sub_event(Request $request, $id)
    {
        $sub_event_to_update = SubEvent::find($id);

        try{
            $validatedData = $request->validate([
                'sub_event_name' => 'required|string|unique:sub_events,sub_event_name,' . $id,
            ], 
            [
                'sub_event_name.required' => 'Please enter data for sub event name',
                'sub_event_name.unique' => 'Entered sub event name is already registered',
            ]);
        }catch (\Illuminate\Validation\ValidationException $e) {
            $errorMessages = $e->validator->getMessageBag()->all();

            return redirect()->back()->withErrors($errorMessages);
        }

        $currentDateTime = Carbon::now();
        $currentDateTime->setTimezone('Asia/Kolkata');
        $formattedDateTime = $currentDateTime->format('d/m/y h:i:s A');

        $sub_event_to_update->event_id = $request->event_id;
        $sub_event_to_update->sub_event_name = $request->sub_event_name;
        $sub_event_to_update->date_time = $formattedDateTime;
        $sub_event_to_update->save();

        return redirect()->back()->with('success', 'Changes saved successfully!');
    }

    public function deactivating_sub_event($id)
    {
        $sub_event_to_deactivate = SubEvent::find($id);
        $sub_event_to_deactivate->is_active = "0";
        $sub_event_to_deactivate->save();
        return redirect()->back()->with('success', 'Sub-event deactivated successfully !');
    }

    public function activating_sub_event($id)
    {
        $sub_event_to_activate = SubEvent::find($id);
        $sub_event_to_activate->is_active = "1";
        $sub_event_to_activate->save();
        return redirect()->back()->with('success', 'Sub-event activated successfully !');
    }

    public function deleting_sub_event($id)
    {
        $sub_event_to_delete = SubEvent::find($id);
        $sub_event_to_delete->delete();
        return redirect()->back()->with('success', 'Sub-event Deleted successfully!');
    }
    /* -------------------------------------------------- Sub-events [end] -------------------------------------------------- */

    /* -------------------------------------------------- Products [start] -------------------------------------------------- */
    public function admin_dashboard_products_page()
    {
        $admin_session = Session::get('admin_session');
        $allEvents = Event::where('is_active', '1')->get();
        $allSubEventsWithEvents = SubEvent::with('event')->where('is_active', '1')->get();
        return view('admin_dashboard_products_page', compact('allSubEventsWithEvents', 'admin_session', 'allEvents'));
    }

    public function admin_dashboard_add_products_page()
    {
        $admin_session = Session::get('admin_session');
        $allEvents = Event::where('is_active', '1')->get();
        $allSubEventsWithEvents = SubEvent::with('event')->where('is_active', '1')->get();
        return view('admin_dashboard_add_products_page', compact('allSubEventsWithEvents', 'admin_session', 'allEvents'));
    }

    function getSubEvents($eventId)
    {
        $subEvents = SubEvent::where('event_id', $eventId)->get();
        $options = '<option value="" disabled style="text-align: center;">Select product sub event</option>';
        foreach ($subEvents as $subEvent) {
            $options .= '<option value="' . $subEvent->id . '">' . $subEvent->sub_event_name . '</option>';
        }
        return $options;
    }

    public function adding_product(Request $request)
    {

        try {
            $validatedData = $request->validate([
                'product_name' => 'required|string',
                'product_title' => 'required|string',
                'product_description' => 'required|string',
                'price_without_discount' => 'required|numeric',
                'price_with_discount' => 'required|numeric',

                'thumbnail_image' => 'required|image|mimes:jpeg,png,jpg,gif',
                'other_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            ], [
                'product_name.required' => 'Please enter Product name.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errorMessages = $e->validator->getMessageBag()->all();

            return redirect()->back()->withErrors($errorMessages)->withInput();
        }

        $eventID = $request->input('event_id');
        $subEventID = $request->input('sub_event_id');

        $selectedEvent = Event::find($eventID);
        $selectedSubEvent = SubEvent::find($subEventID);

        $e_id = $selectedEvent->id;
        $se_id = $selectedSubEvent->id;

        if($selectedSubEvent->event_id == $selectedEvent->id)
        {
            $productMainImage = $request->file('thumbnail_image')->store('product_thumbnail_images', 'public');

            $productOtherImages = [];
            if ($request->hasFile('other_images')) {
                foreach ($request->file('other_images') as $otherImage) {
                    $productOtherImages[] = $otherImage->store('product_other_images', 'public');
                }
            }

            $currentDateTime = Carbon::now();
            $currentDateTime->setTimezone('Asia/Kolkata');
            $formattedDateTime = $currentDateTime->format('d/m/y h:i:s A');


            Product::create([
                'product_name' => $request->input('product_name'),
                'product_title' => $request->input('product_title'),
                'product_description' => $request->input('product_description'),
                'price_without_discount' => $request->input('price_without_discount'),
                'price_with_discount' => $request->input('price_with_discount'),

                'product_quantity' => $request->input('product_quantity'),

                'thumbnail_image' => $productMainImage,
                'other_images' => $productOtherImages,

                'event_id' => $e_id,
                'product_event_name' => $selectedEvent->event_name,
                'sub_event_id' => $se_id,
                'product_sub_event_name' => $selectedSubEvent->sub_event_name,
                'date_time' => $formattedDateTime,
            ]);

            return redirect()->back()->with('success', 'Product Added Successfully...!');

        }
        else
        {
            return redirect()->back()->with('unmatch_event_subEvent', 'You have selected the unmatched Event and Sub Event, please be careful and select appropriate Events and Sub Events...!')->withInput();
            // return "wrong selection";
        }
    }

    public function admin_dashboard_all_products_page()
    {
        $allProducts = Product::all();
        $admin_session = Session::get('admin_session');
        return view('admin_dashboard_all_products_page', compact('allProducts', 'admin_session'));
    }

    public function deactivating_product($id)
    {
        $product_to_deactivate = Product::find($id);
        $product_to_deactivate->is_active = "0";
        $product_to_deactivate->save();
        return redirect()->back()->with('success', 'Product deactivated successfully!');
    }

    public function activating_product($id)
    {
        $product_to_activate = Product::find($id);
        $product_to_activate->is_active = "1";
        $product_to_activate->save();
        return redirect()->back()->with('success', 'Product activated successfully!');
    }

    public function deleting_product($id)
    {
        $product_to_delete = Product::find($id);
        $product_to_delete->delete();
        return redirect()->back()->with('success', 'Product Deleted successfully!');
    }

    public function admin_dashboard_edit_product_page(Request $request)
    {
        $productID = $request->input('product_id');
        $product_to_update = Product::find($productID);

        if(!$product_to_update)
        {
            return redirect()->route('page_not_found');
        }

        $admin_session = Session::get('admin_session');
        $allEvents = Event::where('is_active', '1')->get();
        return view('admin_dashboard_edit_product_page', compact('admin_session', 'allEvents', 'product_to_update'));
    }

    public function updating_product(Request $request, $id)
    {
        $product_to_update = Product::find($id);

        try {

            try {
                $validatedData = $request->validate([
                    'product_name' => 'required|string',
                    'product_title' => 'required|string',
                    'product_description' => 'required|string',
                    'price_without_discount' => 'required|numeric',
                    'price_with_discount' => 'required|numeric',

                    'thumbnail_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                    'other_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                ], [
                    'product_name.required' => 'Please enter Product name.',
                ]);
            } catch (\Illuminate\Validation\ValidationException $e) {
                $errorMessages = $e->validator->getMessageBag()->all();

                return redirect()->back()->withErrors($errorMessages)->withInput();
            } 

            if ($request->hasFile('thumbnail_image')) {
                $thumbnail_image = $request->file('thumbnail_image')->store('product_thumbnail_images', 'public');
                $product_to_update->update(['thumbnail_image' => $thumbnail_image]);
            }

            if ($request->hasFile('other_images')) {
                $productOtherImages = [];
                foreach ($request->file('other_images') as $otherImage) {
                    $productOtherImages[] = $otherImage->store('product_other_images', 'public');
                }
                $product_to_update->update(['other_images' => $productOtherImages]);
            }

            $eventID = $request->input('event_id');
            $subEventID = $request->input('sub_event_id');

            $selectedEvent = Event::find($eventID);
            $selectedSubEvent = SubEvent::find($subEventID);

            $product_to_update->update([
                'product_name' => $request->input('product_name'),
                'product_title' => $request->input('product_title'),
                'product_description' => $request->input('product_description'),
                'price_without_discount' => $request->input('price_without_discount'),
                'price_with_discount' => $request->input('price_with_discount'),

                'product_quantity' => $request->input('product_quantity'),

                'event_id' => $selectedEvent->id,
                'product_event_name' => $selectedEvent->event_name,
                'sub_event_id' => $selectedSubEvent->id,
                'product_sub_event_name' => $selectedSubEvent->sub_event_name,
            ]);

            return redirect()->route('admin_dashboard_all_products_page')->with('success', 'Product Updated Successfully...!');
        } catch (\Illuminate\Database\QueryException $e) {

            return redirect()->back()->with('unmatch_event_subEvent', 'You have selected the unmatched Event and Sub Event, please be careful and select appropriate Events and Sub Events...!')->withInput();
        }
    }
    /* -------------------------------------------------- Products [end] -------------------------------------------------- */



    /* ------------------------------------ Order manipulation [start] ------------------------------------ */

    public function admin_new_orders()
    {
        $admin_session = Session::get('admin_session');
        $allNewOrders = Order::where('is_order_placed', '=', 1)->where('is_order_cancelled', '=', NULL)->where('is_order_rejected', '=', NULL)->where('is_order_ready', '=', NULL)->where('is_order_accepted', '=', NULL)->where('is_order_delivered', '=', NULL)->get();
        return view('admin_new_orders', compact('admin_session', 'allNewOrders'));
    }

    public function customer_details_for_order(Request $request)
    {
        $customer_id = $request->input('customer_id');
        $customer = Customer::find($customer_id);

        $customerAddress = CustomerAddress::where('customer_id', $customer_id)->first();

        $admin_session = Session::get('admin_session');

        return view('customer_details_for_order', compact('customer', 'admin_session', 'customerAddress'));
    }

    public function accepting_order($id)
    {
        $currentDateTime = Carbon::now();
        $currentDateTime->setTimezone('Asia/Kolkata');
        $formattedDateTime = $currentDateTime->format('d/m/y h:i:s A');

        $OrderToAccept = Order::find($id);
        $OrderToAccept->is_order_accepted = 1;
        $OrderToAccept->order_accepted_date = $formattedDateTime;
        $OrderToAccept->save();

        return redirect()->back()->with('success', 'Order accepted successfully !');
    }

    public function order_reject_reason_form(Request $request)
    {
        $OrderID = $request->input('order_id');
        $rejectOrderData = Order::find($OrderID);
        $admin_session = Session::get('admin_session');
        return view('order_reject_reason_form', compact('admin_session', 'rejectOrderData'));
    }

    public function order_reject(Request $request, $id)  
    {
        $rejectOrder = Order::find($id);

        if($rejectOrder->OrdersInvoice->payment_method !== 'COD')
        {
            try
            {
                $order = Order::find($id);

                $api = new Api(env('RAZORPAY_API_KEY'), env('RAZORPAY_API_SECRET'));
                $payment = $api->payment->fetch($order->OrdersInvoice->payment_id)->refund();

                $order->is_order_rejected = 1;
                $order->order_rejected_date = Carbon::now()->setTimezone('Asia/Kolkata')->format('d/m/y h:i:s A');
                $order->order_reject_reason = $request->input('order_reject_reason');
                $order->save();

                $order->OrdersInvoice->is_money_refunded = 1;
                $order->OrdersInvoice->save();
        
                return redirect()->route('admin_new_orders')->with('success', 'Order rejected [refund process initiated] !');
        
            } catch (Exception $e) {
                Log::error($e->getMessage());
                return redirect()->route('admin_new_orders')->with('error', 'Failed to cancel the order. Please try again. !');
            }

        }

        if($rejectOrder->OrdersInvoice->payment_method === 'COD')
        {
            $rejectOrder = Order::find($request->order_id);
            $rejectOrder->is_order_rejected = 1;
            $rejectOrder->order_rejected_date = Carbon::now()->setTimezone('Asia/Kolkata')->format('d/m/y h:i:s A');
            $rejectOrder->order_reject_reason = $request->input('order_reject_reason');
            $rejectOrder->save();

            return redirect()->route('admin_new_orders')->with('success', 'Order rejected [it was COD payment] !');
        }

    }

    public function admin_cancelled_orders()
    {
        $admin_session = Session::get('admin_session');
        $allCancelledOrders = Order::where('is_order_cancelled', '=', 1)->orderBy('id', 'desc')->get();
        return view('admin_cancelled_orders', compact('admin_session', 'allCancelledOrders'));
    }

    public function admin_rejected_orders()
    {
        $admin_session = Session::get('admin_session');
        $allRejectedOrders = Order::where('is_order_rejected', '=', 1)->orderBy('id', 'desc')->get();
        return view('admin_rejected_orders', compact('admin_session', 'allRejectedOrders'));
    }

    public function order_reject_undo($id)
    {
        $rejectUndoOrder = Order::find($id);
        $rejectUndoOrder->is_order_rejected = NULL;
        $rejectUndoOrder->order_rejected_date = NULL;
        $rejectUndoOrder->order_reject_reason = NULL;
        $rejectUndoOrder->save();

        return redirect()->back()->with('success', 'Order rejection undoed successfully !');
    }

    public function admin_accepted_orders()
    {
        $admin_session = Session::get('admin_session');
        $allAcceptedOrders = Order::where('is_order_accepted', '=', 1)->where('is_order_ready', '=', NULL)->where('is_order_delivered', '=', NULL)->get();
        return view('admin_accepted_orders', compact('admin_session', 'allAcceptedOrders'));
    }

    public function undo_order_acceptance($id)
    {
        $OrderToAccept = Order::find($id);
        $OrderToAccept->is_order_accepted = NULL;
        $OrderToAccept->order_accepted_date = NULL;
        $OrderToAccept->save();

        return redirect()->back()->with('success', 'Order acceptance undoed successfully !');
    }

    public function mark_order_as_ready($id)
    {
        $currentDateTime = Carbon::now();
        $currentDateTime->setTimezone('Asia/Kolkata');
        $formattedDateTime = $currentDateTime->format('d/m/y h:i:s A');

        $OrderToAccept = Order::find($id);
        $OrderToAccept->is_order_ready = 1;
        $OrderToAccept->order_ready_date = $formattedDateTime;
        $OrderToAccept->save();

        return redirect()->back()->with('success', 'Order marked as ready successfully !');
    }

    public function admin_ready_orders()
    {
        $admin_session = Session::get('admin_session');
        $allReadyOrders = Order::where('is_order_accepted', '=', 1)->where('is_order_ready', '=', 1)->where('is_order_delivered', '=', NULL)->get();
        return view('admin_ready_orders', compact('admin_session', 'allReadyOrders'));
    }

    public function undo_order_ready_mark($id)
    {
        $OrderToMarkAsReady = Order::find($id);
        $OrderToMarkAsReady->is_order_ready = NULL;
        $OrderToMarkAsReady->order_ready_date = NULL;
        $OrderToMarkAsReady->save();

        return redirect()->back()->with('success', 'Order ready mark undoed successfully !');
    }

    public function send_otp_to_customer_for_verification($id)
    {
        $OrderToMarkAsDelivered = Order::find($id);

        $input_email = $OrderToMarkAsDelivered->customer->email;

        $user = Customer::where('email', $input_email)->first();

        if ($user) 
        {
            $userOTP = DeliveryVerificationOtp::where('customer_id',$user->id)->latest('OTP_created_at')->first();

            $now = now();

            if($userOTP && $now->isBefore($userOTP->OTP_expires_at))
            {
                $OTP = $userOTP->OTP;
            }
            else
            {
                $OTP = rand(100000, 999999);
            }

            $this->sendOTPEmailToCustomerForDeliveryVerification($user->email, $OTP);
            
            DeliveryVerificationOtp::updateOrCreate(['customer_id'=>$user->id],[
                'customer_id' => $user->id,
                'OTP' => $OTP,
                'OTP_expires_at' => $now->addMinutes(10)
            ]);

            Session::put('Order_id', $OrderToMarkAsDelivered->id);

            return redirect()->route('delivery_otp_verification_form')->with('OTP_SENT', "OTP has been sent on customer's registered email : " . $user->email . "!");
        }
        else
        {
            return redirect()->back()->with('error', 'This E-mail address is not registered !');
        }
    }

    private function sendOTPEmailToCustomerForDeliveryVerification($email, $OTP)
    {
        Mail::to($email)->send(new DeliveryVerificationOtpMail($OTP));
    }

    public function delivery_otp_verification_form()
    {
        $admin_session = Session::get('admin_session');
        $order_id = Session::get('Order_id');
        $Order = Order::find($order_id);
        return view('delivery_otp_verification_form', compact('admin_session', 'Order'));
    }

    public function delivery_otp_verification_process(Request $request)
    {
        try{
            $validatedData = $request->validate([
                'input_otp' => 'required|digits:6',
            ], [
                'input_otp.digits' => 'The OTP must be a number of exactly 6 digits.',
            ]);
        }catch (\Illuminate\Validation\ValidationException $e) {
            $errorMessages = $e->validator->getMessageBag()->all();

            return redirect()->back()->withErrors($errorMessages)->withInput();
        }

        $customerID = $request->customer_id;
        $customer = Customer::find($customerID);

        $user = Customer::where('email', $customer->email)->first();
        $userID = $user->id;

        $userOtp = DeliveryVerificationOtp::where('customer_id', $userID)->where('OTP', $request->input_otp)->first();

        $now = now();

        if(!$userOtp)
        {
            Session::forget('Order_id');
            return redirect()->route('admin_ready_orders')->with('error', 'OTP does not match, please try again !')->withInput();
        }
        else if($userOtp && $now->isAfter($userOtp->OTP_expires_at))
        {
            Session::forget('Order_id');
            return redirect()->route('admin_ready_orders')->with('error', 'OTP has been expired, please try again !')->withInput();
        }


        if($user)
        {
            $userOtp->update([
                'OTP_expires_at' => now()
            ]);

            $currentDateTime = Carbon::now();
            $currentDateTime->setTimezone('Asia/Kolkata');
            $formattedDateTime = $currentDateTime->format('d/m/y h:i:s A');

            $OrderID = Session::get('Order_id');
            $OrderToMarkAsDelivered = Order::find($OrderID);
            $OrderToMarkAsDelivered->is_order_delivered = 1;
            $OrderToMarkAsDelivered->order_delivered_date = $formattedDateTime;

            if ($request->has('payment_status')) {
                $paymentStatus = $request->input('payment_status');
                $OrderToMarkAsDelivered->order_payment_status = $paymentStatus;
            }

            $OrderToMarkAsDelivered->save();

            Session::forget('Order_id');
            
            return redirect()->route('admin_completed_orders')->with('success', 'Order marked as delivered !');

        }  
       
    }

    public function admin_completed_orders()
    {
        $admin_session = Session::get('admin_session');
        $allCompletedOrders = Order::where('is_order_accepted', '=', 1)->where('is_order_ready', '=', 1)->where('is_order_delivered', '=', 1)->where('is_requested_for_exchange', '=', NULL)->where('is_requested_for_return', '=', NULL)->get();
        return view('admin_completed_orders', compact('admin_session', 'allCompletedOrders'));
    }

    public function admin_new_exchange_request()
    {
        $admin_session = Session::get('admin_session');
        $allExchangeRequests = Order::where('is_order_accepted', '=', 1)->where('is_order_ready', '=', 1)->where('is_order_delivered', '=', 1)->where('is_requested_for_exchange', '=', 1)->where('is_request_for_exchange_accepted', '=', NULL)->where('is_exchange_completed', '=', NULL)->get();
        return view('admin_new_exchange_request', compact('admin_session', 'allExchangeRequests'));
    }

    public function accepting_exchange_request($id)
    {
        $currentDateTime = Carbon::now();
        $currentDateTime->setTimezone('Asia/Kolkata');
        $formattedDateTime = $currentDateTime->format('d/m/y h:i:s A');

        $OrderToAccept = Order::find($id);
        $OrderToAccept->is_request_for_exchange_accepted = 1;
        $OrderToAccept->request_for_exchange_accepted_date = $formattedDateTime;
        $OrderToAccept->save();

        return redirect()->back()->with('success', 'Exchange request accepted !');
    }

    public function admin_accepted_exchange_request()
    {
        $admin_session = Session::get('admin_session');
        $AcceptedExchangeRequests = Order::where('is_order_accepted', '=', 1)->where('is_order_ready', '=', 1)->where('is_order_delivered', '=', 1)->where('is_requested_for_exchange', '=', 1)->where('is_request_for_exchange_accepted', '=', 1)->where('is_exchange_completed', '=', NULL)->get();
        return view('admin_accepted_exchange_request', compact('admin_session', 'AcceptedExchangeRequests'));
    }

    public function undo_order_exchange_request_acceptance($id)
    {
        $OrderToAccept = Order::find($id);
        $OrderToAccept->is_request_for_exchange_accepted = NULL;
        $OrderToAccept->request_for_exchange_accepted_date = NULL;
        $OrderToAccept->save();

        return redirect()->back()->with('success', 'Exchange request acceptance undoed !');
    }

    public function send_otp_to_customer_for_exchange_verification($id)
    {
        $OrderToMarkAsDelivered = Order::find($id);

        $input_email = $OrderToMarkAsDelivered->customer->email;

        $user = Customer::where('email', $input_email)->first();

        if ($user) 
        {
            $userOTP = ExchangeVerificationOtp::where('customer_id',$user->id)->latest('OTP_created_at')->first();

            $now = now();

            if($userOTP && $now->isBefore($userOTP->OTP_expires_at))
            {
                $OTP = $userOTP->OTP;
            }
            else
            {
                $OTP = rand(100000, 999999);
            }

            $this->sendOTPEmailToCustomerForExchangeVerification($user->email, $OTP);
            
            ExchangeVerificationOtp::updateOrCreate(['customer_id'=>$user->id],[
                'customer_id' => $user->id,
                'OTP' => $OTP,
                'OTP_expires_at' => $now->addMinutes(10)
            ]);

            Session::put('Order_id_E', $OrderToMarkAsDelivered->id);

            return redirect()->route('exchange_otp_verification_form')->with('OTP_SENT', "OTP has been sent on customer's registered email : " . $user->email . "!");
        }
        else
        {
            return redirect()->back()->with('error', 'This E-mail address is not registered !');
        }
    }

    private function sendOTPEmailToCustomerForExchangeVerification($email, $OTP)
    {
        Mail::to($email)->send(new ExchangeVerificationOtpMail($OTP));
    }

    public function exchange_otp_verification_form()
    {
        $admin_session = Session::get('admin_session');
        $order_id = Session::get('Order_id_E');
        $Order = Order::find($order_id);
        return view('exchange_otp_verification_form', compact('admin_session', 'Order'));
    }

    public function exchange_otp_verification_process(Request $request)
    {
        try{
            $validatedData = $request->validate([
                'input_otp' => 'required|digits:6',
            ], [
                'input_otp.digits' => 'The OTP must be a number of exactly 6 digits.',
            ]);
        }catch (\Illuminate\Validation\ValidationException $e) {
            $errorMessages = $e->validator->getMessageBag()->all();

            return redirect()->back()->withErrors($errorMessages)->withInput();
        }

        $customerID = $request->customer_id;
        $customer = Customer::find($customerID);

        $user = Customer::where('email', $customer->email)->first();
        $userID = $user->id;

        $userOtp = ExchangeVerificationOtp::where('customer_id', $userID)->where('OTP', $request->input_otp)->first();

        $now = now();

        if(!$userOtp)
        {
            Session::forget('Order_id_E');
            return redirect()->route('admin_accepted_exchange_request')->with('error', 'OTP does not match, please try again !')->withInput();
        }
        else if($userOtp && $now->isAfter($userOtp->OTP_expires_at))
        {
            Session::forget('Order_id_E');
            return redirect()->route('admin_accepted_exchange_request')->with('error', 'OTP has been expired, please try again !')->withInput();
        }


        if($user)
        {
            $userOtp->update([
                'OTP_expires_at' => now()
            ]);

            $currentDateTime = Carbon::now();
            $currentDateTime->setTimezone('Asia/Kolkata');
            $formattedDateTime = $currentDateTime->format('d/m/y h:i:s A');

            $OrderID = Session::get('Order_id_E');
            $OrderToMarkAsExchanged = Order::find($OrderID);
            $OrderToMarkAsExchanged->is_exchange_completed = 1;
            $OrderToMarkAsExchanged->exchange_completed_date = $formattedDateTime;

            if ($request->has('payment_status')) {
                $paymentStatus = $request->input('payment_status');
                $OrderToMarkAsExchanged->order_payment_status = $paymentStatus;
            }

            $OrderToMarkAsExchanged->save();

            Session::forget('Order_id_E');
            
            return redirect()->route('admin_exchanged_orders')->with('success', 'Order marked as exchanged !');

        }  
       
    }

    public function admin_exchanged_orders()
    {
        $admin_session = Session::get('admin_session');
        $ExchangedOrders = Order::where('is_order_accepted', '=', 1)->where('is_order_ready', '=', 1)->where('is_order_delivered', '=', 1)->where('is_requested_for_exchange', '=', 1)->where('is_request_for_exchange_accepted', '=', 1)->where('is_exchange_completed', '=', 1)->get();
        return view('admin_exchanged_orders', compact('admin_session', 'ExchangedOrders'));
    }

    public function admin_new_return_request()
    {
        $admin_session = Session::get('admin_session');
        $allReturnRequests = Order::where('is_order_accepted', '=', 1)->where('is_order_ready', '=', 1)->where('is_order_delivered', '=', 1)->where('is_requested_for_return', '=', 1)->where('is_request_for_return_accepted', '=', NULL)->where('is_return_completed', '=', NULL)->where('is_payment_refunded_for_return', '=', NULL)->get();
        return view('admin_new_return_request', compact('admin_session', 'allReturnRequests'));
    }

    public function accepting_return_request($id)
    {
        $currentDateTime = Carbon::now();
        $currentDateTime->setTimezone('Asia/Kolkata');
        $formattedDateTime = $currentDateTime->format('d/m/y h:i:s A');

        $OrderToAccept = Order::find($id);
        $OrderToAccept->is_request_for_return_accepted = 1;
        $OrderToAccept->request_for_return_accepted_date = $formattedDateTime;
        $OrderToAccept->save();

        return redirect()->back()->with('success', 'Return request accepted !');
    }

    public function admin_accepted_return_request()
    {
        $admin_session = Session::get('admin_session');
        $AcceptedReturnRequests = Order::where('is_order_accepted', '=', 1)->where('is_order_ready', '=', 1)->where('is_order_delivered', '=', 1)->where('is_requested_for_return', '=', 1)->where('is_request_for_return_accepted', '=', 1)->where('is_return_completed', '=', NULL)->where('is_payment_refunded_for_return', '=', NULL)->get();
        return view('admin_accepted_return_request', compact('admin_session', 'AcceptedReturnRequests'));
    }

    public function undo_order_return_request_acceptance($id)
    {
        $OrderToAccept = Order::find($id);
        $OrderToAccept->is_request_for_return_accepted = NULL;
        $OrderToAccept->request_for_return_accepted_date = NULL;
        $OrderToAccept->save();

        return redirect()->back()->with('success', 'Return request acceptance undoed !');
    }

    public function send_otp_to_customer_for_return_verification($id)
    {
        $OrderToMarkAsDelivered = Order::find($id);

        $input_email = $OrderToMarkAsDelivered->customer->email;

        $user = Customer::where('email', $input_email)->first();

        if ($user) 
        {
            $userOTP = ReturnVerificationOtp::where('customer_id',$user->id)->latest('OTP_created_at')->first();

            $now = now();

            if($userOTP && $now->isBefore($userOTP->OTP_expires_at))
            {
                $OTP = $userOTP->OTP;
            }
            else
            {
                $OTP = rand(100000, 999999);
            }

            $this->sendOTPEmailToCustomerForReturnVerification($user->email, $OTP);
            
            ReturnVerificationOtp::updateOrCreate(['customer_id'=>$user->id],[
                'customer_id' => $user->id,
                'OTP' => $OTP,
                'OTP_expires_at' => $now->addMinutes(10)
            ]);

            Session::put('Order_id_R', $OrderToMarkAsDelivered->id);

            return redirect()->route('return_otp_verification_form')->with('OTP_SENT', "OTP has been sent on customer's registered email : " . $user->email . "!");
        }
        else
        {
            return redirect()->back()->with('error', 'This E-mail address is not registered !');
        }
    }

    private function sendOTPEmailToCustomerForReturnVerification($email, $OTP)
    {
        Mail::to($email)->send(new ReturnVerificationOtpMail($OTP));
    }

    public function return_otp_verification_form()
    {
        $admin_session = Session::get('admin_session');
        $order_id = Session::get('Order_id_R');
        $Order = Order::find($order_id);
        return view('return_otp_verification_form', compact('admin_session', 'Order'));
    }

    public function return_otp_verification_process(Request $request)
    {
        try{
            $validatedData = $request->validate([
                'input_otp' => 'required|digits:6',
            ], [
                'input_otp.digits' => 'The OTP must be a number of exactly 6 digits.',
            ]);
        }catch (\Illuminate\Validation\ValidationException $e) {
            $errorMessages = $e->validator->getMessageBag()->all();

            return redirect()->back()->withErrors($errorMessages)->withInput();
        }

        $customerID = $request->customer_id;
        $customer = Customer::find($customerID);

        $user = Customer::where('email', $customer->email)->first();
        $userID = $user->id;

        $userOtp = ReturnVerificationOtp::where('customer_id', $userID)->where('OTP', $request->input_otp)->first();

        $now = now();

        if(!$userOtp)
        {
            Session::forget('Order_id_R');
            return redirect()->route('admin_accepted_return_request')->with('error', 'OTP does not match, please try again !')->withInput();
        }
        else if($userOtp && $now->isAfter($userOtp->OTP_expires_at))
        {
            Session::forget('Order_id_R');
            return redirect()->route('admin_accepted_return_request')->with('error', 'OTP has been expired, please try again !')->withInput();
        }


        if($user)
        {
            $userOtp->update([
                'OTP_expires_at' => now()
            ]);

            $currentDateTime = Carbon::now();
            $currentDateTime->setTimezone('Asia/Kolkata');
            $formattedDateTime = $currentDateTime->format('d/m/y h:i:s A');

            $OrderID = Session::get('Order_id_R');
            $OrderToMarkAsReturned = Order::find($OrderID);

            if($OrderToMarkAsReturned->OrdersInvoice->payment_method !== 'COD')
            {
                try {
                    $api = new Api(env('RAZORPAY_API_KEY'), env('RAZORPAY_API_SECRET'));
                    $payment = $api->payment->fetch($OrderToMarkAsReturned->OrdersInvoice->payment_id)->refund();
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                    return redirect()->route('admin_accepted_return_request')->with('error', 'Failed to process the refund !')->withInput();
                }
            }

            if ($OrderToMarkAsReturned->OrdersInvoice->payment_method === 'COD') 
            {
                $api = new \Razorpay\Api\Api(env('RAZORPAY_API_KEY'), env('RAZORPAY_API_SECRET'));

                $transfer = $api->transfer->create(array(
                    'account' => $OrderToMarkAsReturned->Bank_Account_Number,
                    'amount' => $OrderToMarkAsReturned->product_price * 100,  
                    'currency' => 'INR',
                    'mode' => 'NEFT', // Transfer mode (NEFT/IMPS/RTGS)
                    'purpose' => 'Return Refund',
                    'notes' => array(
                        'order_id' => $OrderID, 
                    )
                ));
                
                print_r($transfer);
            }
    
            $OrderToMarkAsReturned->is_return_completed = 1;
            $OrderToMarkAsReturned->return_completed_date = $formattedDateTime;

            if ($request->has('payment_status')) {
                $paymentStatus = $request->input('payment_status');
                $OrderToMarkAsReturned->order_payment_status = $paymentStatus;
            }

            $OrderToMarkAsReturned->save();

            $OrderToMarkAsReturned->OrdersInvoice->is_money_refunded = 1;
            $OrderToMarkAsReturned->OrdersInvoice->save();

            Session::forget('Order_id_R');
            
            return redirect()->route('admin_returned_orders')->with('success', 'Order marked as returned !');

        }  
       
    }

    // if ($OrderToMarkAsReturned->OrdersInvoice->payment_method === 'COD') 
    //         {
    //             $api = new \Razorpay\Api\Api(env('RAZORPAY_API_KEY'), env('RAZORPAY_API_SECRET'));

    //             $order = $api->order->create(array(
    //                 'amount' => $OrderToMarkAsReturned->product_price * 100, // रुपये में राशि
    //                 'currency' => 'INR',
    //                 'payment_capture' => 1
    //             ));

    //             $orderId = $order->id;
    //             $payment = $api->payment->fetch($orderId);

    //             $transfer = $api->transfer->create(array(
    //                 'source' => env('RAZORPAY_BANK_ACCOUNT_NUMBER'), // यहाँ आपके बैंक खाते का डिटेल होना चाहिए
    //                 'account' => $OrderToMarkAsReturned->Bank_Account_Number,
    //                 'amount' => $OrderToMarkAsReturned->product_price * 100, // रुपये में राशि
    //                 'currency' => 'INR',
    //                 'purpose' => 'refund',
    //                 'beneficiary_id' => $payment->id
    //             ));

    //             print_r($transfer);
    //         }

    public function admin_returned_orders()
    {
        $admin_session = Session::get('admin_session');
        $ReturnedOrders = Order::where('is_order_accepted', '=', 1)->where('is_order_ready', '=', 1)->where('is_order_delivered', '=', 1)->where('is_requested_for_return', '=', 1)->where('is_request_for_return_accepted', '=', 1)->where('is_return_completed', '=', 1)->get();
        return view('admin_returned_orders', compact('admin_session', 'ReturnedOrders'));
    }

    public function orders_feedback()
    {
        $admin_session = Session::get('admin_session');
        $OrderFeedback = Order::where('is_order_delivered', '=', 1)->where('star_rating', '!=', NULL)->where('feedback_text', '!=', NULL)->where('feedback_date', '!=', NULL)->orderBy('id', 'desc')->get();
        return view('orders_feedback', compact('admin_session', 'OrderFeedback'));
    }

    public function contact_mails()
    {
        $admin_session = Session::get('admin_session');
        $AllContactMails = ContactFormMail::all();
        return view('contact_mails', compact('admin_session', 'AllContactMails'));
    }

    public function customer_support_mails()
    {
        $admin_session = Session::get('admin_session');
        $AllCustomerSupportMails = CustomerSupportFormMail::all();
        return view('customer_support_mails', compact('admin_session', 'AllCustomerSupportMails'));
    }

    public function platform_feedback()
    {
        $admin_session = Session::get('admin_session');
        $AllPlatformFeedbackMails = FeedbackFormMail::all();
        return view('platform_feedback', compact('admin_session', 'AllPlatformFeedbackMails'));
    }

    /* ------------------------------------ Order manipulation [end] ------------------------------------ */

    public function admin_logout()
    {
        if(Session::has('admin_session')){
            Session::pull('admin_session');
            return redirect('/');
        }
    }
}
