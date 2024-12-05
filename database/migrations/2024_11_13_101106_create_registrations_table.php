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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('registration_no')->unique();
            $table->string('enquiry_Id')->nullable();
            $table->string('name')->nullable();
            $table->string('father')->nullable();
            $table->enum('gender', ['0', '1', '2'])->comment('0 -> Male, 1 -> Female, 2 -> Other');
            $table->string('image')->nullable();
            $table->string('dob')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('pincode')->nullable();
            $table->string('address')->nullable();
            $table->string('package')->nullable();
            $table->string('training_program')->nullable();
            $table->string('session')->nullable();
            $table->string('time_slot')->nullable();
            $table->string('lead_source')->nullable();
            $table->string('registration_fee')->nullable();
            // $table->enum('room_allotment', ['0', '1'])->comment('0 -> Yes, 1 -> No');
            $table->enum('room_allotment', ['0', '1'])->nullable()->comment('0 -> Yes, 1 -> No');
            $table->string('room_type')->nullable();
            $table->string('room_fees')->nullable();
            $table->enum('meal_subscription', ['0', '1'])->nullable()->comment('0 -> Yes, 1 -> No');
            $table->string('meal_type')->nullable();
            $table->string('meal_fees')->nullable();
            $table->string('checking_date')->nullable();
            $table->string('checkout_date')->nullable();
            $table->string('notes')->nullable();
            $table->string('locationID')->nullable();
            $table->dateTime('date')->nullable();
            $table->enum('status', ['0', '1'])->default('0')->comment('0 -> Active, 1 -> Inactive');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
