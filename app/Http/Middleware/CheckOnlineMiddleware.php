<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckOnlineMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$this->isConnected()) {
            return response()->view('missing_internet_connection');
        }

        return $next($request);
    }

    private function isConnected()
    {
        $connected = @fsockopen("www.google.com", 80);
        if ($connected){
            fclose($connected);
            return true;
        } else {
            return false;
        }
    }
}
