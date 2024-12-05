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
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('groupBy')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        // Update timestamps to set the current date and time for 'created_at' and 'updated_at'
        DB::statement('ALTER TABLE permissions MODIFY created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP');
        DB::statement('ALTER TABLE permissions MODIFY updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};