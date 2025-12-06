<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Carbon\Carbon;

class CreateAdminController extends Controller
{
    public function createAdmin()
    {
        try {
            $currentDateTime = Carbon::now();
            $currentDateTime->setTimezone('Asia/Kolkata');
            $formattedDateTime = $currentDateTime->format('d/m/y h:i:s A');
    
            $AdminData = new Customer();
            $AdminData->name = "Anjali Patel";
            $AdminData->email = "anjalipatel3074@gmail.com";
            $AdminData->phone_no = "7046106554";
            $AdminData->registration_date_time = $formattedDateTime;
            $AdminData->user_type = "1";
            $AdminData->save();
    
            return redirect()->route('main_initial_page')->with('adminCreatedMsg', 'Admin created successfully!');
        } catch (\Illuminate\Database\QueryException $ex) {
            if ($ex->errorInfo[1] == 1062) 
            {
                return redirect()->route('main_initial_page')->with('adminCreatedMsg', 'Please do not try to mess with high access area !');
            } else {
                return redirect()->route('main_initial_page')->with('adminCreatedMsg', 'Admin creation failed. Please try again later.');
            }
        }
    }
}
