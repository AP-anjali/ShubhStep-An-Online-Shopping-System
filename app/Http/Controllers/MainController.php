<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Event;
use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\SubEvent;
use App\Models\Product;
use App\Models\Wishlist;
use App\Models\Cart;
use App\Models\Order;
use App\Models\ContactFormMail;
use App\Models\CustomerSupportFormMail;
use App\Mail\ContactFormDataMail;
use App\Mail\CustomerSupportFormDataMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\FeedbackFormMail;
use App\Mail\FeedbackFormDataMail;


class MainController extends Controller
{
    public function main_initial_page()
    {

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

            return view('main_pages.home_page', compact('topSoldProducts', 'allEvents', 'productCountWhishlist','productCount', 'allProducts', 'userCartProducts', 'latestProducts', 'EventsWithLimit', 'admin_session', 'customer_session', 'userWishlistProducts', 'address_stored'));

        }

        return view('main_pages.home_page', compact('topSoldProducts', 'allEvents', 'allProducts', 'latestProducts', 'EventsWithLimit', 'admin_session', 'customer_session'));
    }

    public function page_not_found()
    {
        return view('page_not_found');
    }

    public function missing_internet_connection()
    {
        return view('missing_internet_connection');
    }

    /* --------------------------- footer pages --------------------------- */
    public function contact_us()
    {
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

            return view('contact_us', compact('topSoldProducts', 'allEvents', 'productCountWhishlist','productCount', 'allProducts', 'userCartProducts', 'latestProducts', 'EventsWithLimit', 'admin_session', 'customer_session', 'userWishlistProducts', 'address_stored'));

        }

        return view('contact_us', compact('topSoldProducts', 'allEvents', 'allProducts', 'latestProducts', 'EventsWithLimit', 'admin_session', 'customer_session'));
    }

    public function redirect_route()
    {
        return redirect()->route('main_initial_page')->with('MySession', "dummy msg !");
    }

    public function form()
    {
        return view('form');
    }

    public function contact_us_form_submit(Request $request)
    {
        try{
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone_no' => 'required|digits:10',
                'message' => 'required|string',
            ],[
                'phone_no.digits' => 'The phone number must be 10 digits.',
            ]);
        }catch (\Illuminate\Validation\ValidationException $e) {
            $errorMessages = $e->validator->getMessageBag()->all();

            return redirect()->back()->withErrors($errorMessages)->withInput();
        }

        $currentDateTime = Carbon::now();
        $currentDateTime->setTimezone('Asia/Kolkata');
        $formattedDateTime = $currentDateTime->format('d/m/y h:i:s A');

        $data = $request->all();

        $email = env('EMAIL');
        Mail::to($email)->send(new ContactFormDataMail($data));

        $record = new ContactFormMail;
        $record->name = $request->input('name');
        $record->email = $request->input('email');
        $record->phone_no = $request->input('phone_no');
        $record->message = $request->input('message');
        $record->date_time = $formattedDateTime;
        $record->save();

        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }

    public function customer_support()
    {
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

            return view('customer_support', compact('topSoldProducts', 'allEvents', 'productCountWhishlist','productCount', 'allProducts', 'userCartProducts', 'latestProducts', 'EventsWithLimit', 'admin_session', 'customer_session', 'userWishlistProducts', 'address_stored'));

        }

        return view('customer_support', compact('topSoldProducts', 'allEvents', 'allProducts', 'latestProducts', 'EventsWithLimit', 'admin_session', 'customer_session'));
    }

    public function customer_support_form_submit(Request $request)
    {
        try{
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone_no' => 'required|digits:10',
                'message' => 'required|string',
            ],[
                'phone_no.digits' => 'The phone number must be 10 digits.',
            ]);
        }catch (\Illuminate\Validation\ValidationException $e) {
            $errorMessages = $e->validator->getMessageBag()->all();

            return redirect()->back()->withErrors($errorMessages)->withInput();
        }

        $currentDateTime = Carbon::now();
        $currentDateTime->setTimezone('Asia/Kolkata');
        $formattedDateTime = $currentDateTime->format('d/m/y h:i:s A');

        $data = $request->all();

        $email = env('EMAIL');
        Mail::to($email)->send(new CustomerSupportFormDataMail($data));

        $record = new CustomerSupportFormMail;
        $record->name = $request->input('name');
        $record->email = $request->input('email');
        $record->phone_no = $request->input('phone_no');
        $record->message = $request->input('message');
        $record->date_time = $formattedDateTime;
        $record->save();

        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }

    public function feedback_form()
    {
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

            return view('feedback_form', compact('topSoldProducts', 'allEvents', 'productCountWhishlist','productCount', 'allProducts', 'userCartProducts', 'latestProducts', 'EventsWithLimit', 'admin_session', 'customer_session', 'userWishlistProducts', 'address_stored'));

        }

        return view('feedback_form', compact('topSoldProducts', 'allEvents', 'allProducts', 'latestProducts', 'EventsWithLimit', 'admin_session', 'customer_session'));
    }

    public function feedback_form_submit(Request $request)
    {
        try{
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone_no' => 'required|digits:10',
                'message' => 'required|string',
            ],[
                'phone_no.digits' => 'The phone number must be 10 digits.',
            ]);
        }catch (\Illuminate\Validation\ValidationException $e) {
            $errorMessages = $e->validator->getMessageBag()->all();

            return redirect()->back()->withErrors($errorMessages)->withInput();
        }

        $currentDateTime = Carbon::now();
        $currentDateTime->setTimezone('Asia/Kolkata');
        $formattedDateTime = $currentDateTime->format('d/m/y h:i:s A');

        $data = $request->all();

        $email = env('EMAIL');
        Mail::to($email)->send(new FeedbackFormDataMail($data));

        $record = new FeedbackFormMail;
        $record->name = $request->input('name');
        $record->email = $request->input('email');
        $record->phone_no = $request->input('phone_no');
        $record->start_rating = $request->input('start_rating');
        $record->message = $request->input('message');
        $record->date_time = $formattedDateTime;
        $record->save();

        return redirect()->back()->with('success', 'Your feedback has been sent successfully!');
    }

    public function anjali_patel()
    {
        return view('anjali_patel');
    }

    public function about_us()
    {
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

            return view('about_us', compact('topSoldProducts', 'allEvents', 'productCountWhishlist','productCount', 'allProducts', 'userCartProducts', 'latestProducts', 'EventsWithLimit', 'admin_session', 'customer_session', 'userWishlistProducts', 'address_stored'));

        }

        return view('about_us', compact('topSoldProducts', 'allEvents', 'allProducts', 'latestProducts', 'EventsWithLimit', 'admin_session', 'customer_session'));
    }

    public function redirecting_short_service()
    {
        return redirect()->route('about_us')->with('MySession', "dummy msg !");
    }

    public function redirecting_payment_methods()
    {
        return redirect()->route('terms_and_conditions')->with('paymentMethod', "dummy msg !");
    }

    public function redirecting_return_policy()
    {
        return redirect()->route('terms_and_conditions')->with('returnPolicy', "dummy msg !");
    }

    public function redirecting_refund_policy()
    {
        return redirect()->route('terms_and_conditions')->with('refundPolicy', "dummy msg !");
    }

    public function redirecting_exchange_policy()
    {
        return redirect()->route('terms_and_conditions')->with('exchangePolicy', "dummy msg !");
    }

    public function terms_and_conditions()
    {
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

            return view('terms_and_conditions', compact('topSoldProducts', 'allEvents', 'productCountWhishlist','productCount', 'allProducts', 'userCartProducts', 'latestProducts', 'EventsWithLimit', 'admin_session', 'customer_session', 'userWishlistProducts', 'address_stored'));

        }

        return view('terms_and_conditions', compact('topSoldProducts', 'allEvents', 'allProducts', 'latestProducts', 'EventsWithLimit', 'admin_session', 'customer_session'));
    }

    public function privacy_policy()
    {
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

            return view('privacy_policy', compact('topSoldProducts', 'allEvents', 'productCountWhishlist','productCount', 'allProducts', 'userCartProducts', 'latestProducts', 'EventsWithLimit', 'admin_session', 'customer_session', 'userWishlistProducts', 'address_stored'));

        }

        return view('privacy_policy', compact('topSoldProducts', 'allEvents', 'allProducts', 'latestProducts', 'EventsWithLimit', 'admin_session', 'customer_session'));
    }

    public function FAQs()
    {
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

            return view('FAQs', compact('topSoldProducts', 'allEvents', 'productCountWhishlist','productCount', 'allProducts', 'userCartProducts', 'latestProducts', 'EventsWithLimit', 'admin_session', 'customer_session', 'userWishlistProducts', 'address_stored'));

        }

        return view('FAQs', compact('topSoldProducts', 'allEvents', 'allProducts', 'latestProducts', 'EventsWithLimit', 'admin_session', 'customer_session'));
    }

}
