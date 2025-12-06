<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Customer;
use App\Models\CustomerAddress;
use Illuminate\Support\Facades\Session;

class customerAddressAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $customer_session = Session::get('customer_session');

        if(Session()->has('customer_session')){

            $customer_to_get_address = Customer::find($customer_session->id);

            if ($customer_to_get_address->addresses->isNotEmpty()) 
            {
                return $next($request);
            }
            else
            {
                return redirect()->route('go_to_register_address');
            }

        }else{
            session()->flash('showCustomerLoginAlert', true);
            return redirect('/login-registration')->with('alert', 'To access further pages, please login first !');
        }
    }
}
