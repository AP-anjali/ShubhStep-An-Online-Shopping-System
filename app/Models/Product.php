<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Event;
use App\Models\SubEvent;
use App\Models\Wishlist;
use App\Models\Cart;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'product_title',
        'product_description',
        'price_without_discount',
        'price_with_discount',
        'product_quantity',
        'thumbnail_image',
        'other_images',
        'event_id',
        'product_event_name',
        'sub_event_id',
        'product_sub_event_name',
        'date_time',
        'is_active',
    ];

    protected $casts = [
        'other_images' => 'json',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function sub_event()
    {
        return $this->belongsTo(SubEvent::class, 'sub_event_id');
    }

    public function wishlist_data()
    {
        return $this->hasMany(Wishlist::class, 'product_id');
    }

    public function cart_data()
    {
        return $this->hasMany(Cart::class, 'customer_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
