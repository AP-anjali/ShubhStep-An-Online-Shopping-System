<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) 
        {
            $table->id();

            $table->unsignedBigInteger('orders_invoice_id');
            $table->foreign('orders_invoice_id')->references('id')->on('orders_invoices')->onDelete('cascade');

            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');

            $table->unsignedBigInteger('customer_address_id');
            $table->foreign('customer_address_id')->references('id')->on('customer_addresses')->onDelete('cascade');

            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            $table->string('product_quantity');
            $table->string('product_price');

            $table->string('order_payment_status')->nullable();

            $table->string('is_order_placed')->nullable();
            $table->string('order_placed_date')->nullable();

            $table->string('is_order_cancelled')->nullable();
            $table->string('order_cancelled_date')->nullable();
            $table->string('order_cancel_reason')->nullable();

            $table->string('is_order_accepted')->nullable();
            $table->string('order_accepted_date')->nullable();
            $table->string('is_order_rejected')->nullable();
            $table->string('order_rejected_date')->nullable();
            $table->string('order_reject_reason')->nullable();

            $table->string('is_payment_refunded')->nullable();
            $table->string('payment_refunded_date')->nullable();

            $table->string('is_order_ready')->nullable();
            $table->string('order_ready_date')->nullable();
            
            $table->string('is_order_delivered')->nullable();
            $table->string('order_delivered_date')->nullable();

            $table->string('is_seven_days_complte_to_delivery')->default('0');

            $table->string('star_rating')->nullable();
            $table->string('feedback_text')->nullable();
            $table->string('feedback_date')->nullable();

            $table->string('is_requested_for_exchange')->nullable();
            $table->string('requested_for_exchange_date')->nullable();
            $table->string('exchange_request_reason')->nullable();
            $table->string('is_request_for_exchange_accepted')->nullable();
            $table->string('request_for_exchange_accepted_date')->nullable();
            $table->string('is_exchange_completed')->nullable();
            $table->string('exchange_completed_date')->nullable();

            $table->string('is_requested_for_return')->nullable();
            $table->string('requested_for_return_date')->nullable();
            $table->string('return_request_reason')->nullable();

            $table->string('is_request_for_return_accepted')->nullable();
            $table->string('request_for_return_accepted_date')->nullable();

            $table->string('is_return_completed')->nullable();
            $table->string('return_completed_date')->nullable();

            /* --------------- for refund of COD payments orders, which is returned ----------------- */
            $table->string('Bank_Account_Holder_Name')->nullable();
            $table->string('Bank_Account_Number')->nullable();
            $table->string('Bank_Name')->nullable();
            $table->string('IFSC_Code')->nullable();

            /* ----------- after successful refund -------- */
            $table->string('Refund_payment_id')->nullable();
            $table->string('Refund_payment_method')->nullable();
            $table->string('is_payment_refunded_for_return')->nullable();
            $table->string('payment_refunded_for_return_date')->nullable();
            /* -------------------------------- */            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
