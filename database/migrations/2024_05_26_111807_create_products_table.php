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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->string('product_title');
            $table->text('product_description');

            $table->decimal('price_without_discount', 10, 2);
            $table->decimal('price_with_discount', 10, 2);
            
            $table->string('product_quantity');

            $table->string('thumbnail_image');
            $table->text('other_images')->nullable();

            $table->unsignedBigInteger('event_id');
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->string('product_event_name');

            $table->unsignedBigInteger('sub_event_id');
            $table->foreign('sub_event_id')->references('id')->on('sub_events')->onDelete('cascade');
            $table->string('product_sub_event_name');

            $table->string('date_time');
            $table->string('is_active')->default('1');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
