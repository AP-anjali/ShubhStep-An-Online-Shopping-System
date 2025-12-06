<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'total_amount',
        'transaction_id',
        'payment_id',
        'payment_status',
        'payment_method',
        'is_money_refunded',
        'payment_info',
        'date_time',
    ];
}
