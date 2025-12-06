<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CustomerAddress;
use App\Models\Wishlist;
use App\Models\Cart;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone_no',
        'registration_date_time',
        'is_active',
        'profile_pic',
        'user_type',
        'google_id',
    ];

    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public function addresses()
    {
        return $this->hasMany(CustomerAddress::class, 'customer_id');
    }

    public function wishlist_data()
    {
        return $this->hasMany(Wishlist::class, 'customer_id');
    }

    public function cart_data()
    {
        return $this->hasMany(Cart::class, 'customer_id');
    }
}
