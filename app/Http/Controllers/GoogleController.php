<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Carbon\Carbon;
use Session;

class GoogleController extends Controller
{
    public function login_by_google()
    {
        return Socialite::driver('google')
            ->scopes(['openid', 'profile', 'email', 'https://www.googleapis.com/auth/user.phonenumbers.read'])
            ->redirect();
    }

    public function callback_from_google_after_authentication()
    {

        $currentDateTime = Carbon::now();
        $currentDateTime->setTimezone('Asia/Kolkata');
        $formattedDateTime = $currentDateTime->format('d/m/y h:i:s A');

        try 
        {
            
            $user = Socialite::driver('google')->user();


            $phone_number = null;

            // Check if phone number exists in user data
            if (isset($user->user['phoneNumbers']) && !empty($user->user['phoneNumbers'])) {
                $phone_number = $user->user['phoneNumbers'][0]['value'];
            }

            $is_user_data_stored = Customer::where('email', $user->getEmail())->first();

            if(!$is_user_data_stored)   // user is not registered [no data stored]
            {
                $saveUser = Customer::updateOrCreate(
                    [
                        'google_id' => $user->getId()
                    ],
                    [
                        'name' => $user->getName(),
                        'email' => $user->getEmail(),
                        'phone_no' => $phone_number,
                        'registration_date_time' => $formattedDateTime,
                    ]
                );
            }
            else
            {
                $saveUser = Customer::where('email', $user->getEmail())->update([
                    'google_id' => $user->getId(),
                ]);

                $saveUser = Customer::where('email', $user->getEmail())->first();
            }

            Auth::guard('customer')->loginUsingId($saveUser->id);

            if($saveUser->user_type == "0")
            {
                Session::put('customer_session', $saveUser);
            }

            if($saveUser->user_type == "1")
            {
                Session::put('admin_session', $saveUser);
            }

            return redirect()->route('main_initial_page');


        }catch (\Throwable $th) 
        {
            throw $th;
        }
    }
}
