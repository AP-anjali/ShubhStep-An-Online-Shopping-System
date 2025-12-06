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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone_no')->nullable(); 
            $table->string('registration_date_time');
            $table->string('is_active')->default('1');      // 1 -> active | 0 -> deactivated by self | -1 -> deactivated by admin
            $table->text('profile_pic')->default('img/default_profile_pic.png');
            $table->string('user_type')->default('0');      // 0 -> customer | 1 -> admin
            $table->string('google_id')->nullable();      
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
