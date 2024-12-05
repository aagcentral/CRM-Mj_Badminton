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
        Schema::create('lead_status_trackers', function (Blueprint $table) {
            $table->id();
            $table->string('enquiry_Id')->nullable();
            $table->string('leads_status')->nullable();
            $table->string('leads_notes')->nullable();
            $table->dateTime('date')->nullable();
            $table->string('locationID')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_status_trackers');
    }
};
