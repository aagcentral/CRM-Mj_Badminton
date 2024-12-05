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
        Schema::create('callleads', function (Blueprint $table) {
            $table->id();
            $table->string('lead_id')->nullable();
            $table->string('date')->nullable();
            $table->enum('status', ['0', '1', '2', '3', '4','5','6','7','8','9'])->default('0')->comment('0 -> recieved, 1->Not Recieved, 2->Followup Date, 3->Enrolled,  4->Not Interested, 5->Failed, 6->Brochure Sent, 7->Insititute Visit, 8->Invalid, 9->Rejected,');
            $table->string('added_by')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('college')->nullable();
            $table->string('course')->nullable();
            $table->string('training_type')->nullable();
            $table->string('lead_source')->nullable();
            $table->string('enquiry_date')->nullable();
            $table->string('follow_date')->nullable();
            $table->string('notes')->nullable();
            $table->string('year')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('callleads');
    }
};
