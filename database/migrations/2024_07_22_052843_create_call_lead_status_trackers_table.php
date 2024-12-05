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
        Schema::create('call_lead_status_trackers', function (Blueprint $table) {
            $table->id();
            $table->string('lead_id')->nullable();
            $table->string('date')->nullable();
            $table->string('locationID')->nullable();
            $table->string('lead_status')->nullable();
            $table->string('lead_notes')->nullable();
            $table->string('added_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('call_lead_status_trackers');
    }
};
