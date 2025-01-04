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
        Schema::create('package_update_tracks', function (Blueprint $table) {
            $table->id();
            $table->string('registration_no');
            $table->string('package')->nullable();
            $table->string('training_program')->nullable();
            $table->string('session')->nullable();
            $table->string('time_slot')->nullable();
            $table->string('package_fee')->nullable();
            $table->string('date')->nullable();
            $table->string('package_notes')->nullable();
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
        Schema::dropIfExists('package_update_tracks');
    }
};