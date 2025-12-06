<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrdersInvoice;
use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\Product;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'orders_invoice_id',
        'customer_id',
        'customer_address_id',
        'product_id',
        'seller_id',
        'product_quantity',
        'product_price',
        'order_payment_status',
        'is_order_placed',
        'order_placed_date',
        'is_order_cancelled',
        'order_cancelled_date',
        'order_cancel_reason',
        'is_payment_refunded',
        'payment_refunded_date',
        'is_order_accepted',
        'order_accepted_date',
        'is_order_rejected',
        'order_rejected_date',
        'is_order_ready',
        'order_ready_date',
        'is_order_delivered',
        'order_delivered_date',
        'feedback',
        'is_requested_for_exchange',
        'requested_for_exchange_date',
        'exchange_request_reason',
        'is_request_for_exchange_accepted',
        'request_for_exchange_accepted_date',
        'is_exchange_completed',
        'exchange_completed_date',
        'is_requested_for_return',
        'requested_for_return_date',
        'return_request_reason',
        'is_request_for_return_accepted',
        'request_for_return_accepted_date',
        'is_return_completed',
        'return_completed_date',
        'Bank_Account_Holder_Name',
        'Bank_Account_Number',
        'Bank_Name',
        'IFSC_Code',
        'Refund_payment_id',
        'Refund_payment_method',
        'is_payment_refunded_for_return',
        'payment_refunded_for_return_date',
    ];

    public function OrdersInvoice()
    {
        return $this->belongsTo(OrdersInvoice::class, 'orders_invoice_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function customer_address()
    {
        return $this->belongsTo(CustomerAddress::class, 'customer_address_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
