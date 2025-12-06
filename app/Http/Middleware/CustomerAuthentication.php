<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Session()->has('customer_session')){
            return $next($request);
        }else{
            session()->flash('showCustomerLoginAlert', true);
            return redirect('/login-registration')->with('alert', 'To access further pages, please login first !');
        }
    }
}
