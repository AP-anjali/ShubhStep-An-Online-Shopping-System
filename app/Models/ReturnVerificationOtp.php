<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;

class ReturnVerificationOtp extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'OTP',
        'OTP_created_at',
        'OTP_expires_at',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}

