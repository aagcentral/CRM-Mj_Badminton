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
        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('enquiry_Id')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('mobile')->nullable();
            $table->string('lead_source')->nullable();
            $table->string('package')->nullable();
            $table->string('training_program')->nullable();
            $table->string('session')->nullable();
            $table->string('time_slot')->nullable();
            $table->string('enquiry_date')->nullable();
            $table->string('followup_date')->nullable();
            $table->string('interested_branch')->nullable();
            $table->enum('transport', ['0', '1'])->default('0')->comment('0 -> No, 1->Yes');
            $table->enum('hostel', ['0', '1'])->default('0')->comment('0 -> No, 1->Yes');
            $table->enum('is_converted', ['0', '1'])->default('0')->comment('0 -> Revert, 1->Converted');
            $table->string('assigned')->nullable();
            $table->string('address')->nullable();
            $table->string('notes')->nullable();
            $table->enum('lead_status', ['0', '1', '2', '3', '4', '5'])->default('0')->comment('0 -> New, 1->Assigned, 2->Inprocess, 3->Converted, 4->Dead,5->Recycle');
            $table->string('locationID')->nullable();
            $table->dateTime('date')->nullable();
            $table->enum('status', ['0', '1'])->default('0')->comment('0 -> Active, 1->Inactive');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enquiries');
    }
};
