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
        Schema::create('distributed_stocks', function (Blueprint $table) {
            $table->id();
            $table->string('distributed_id')->nullable();
            $table->string('registration_no')->nullable();
            $table->string('category')->nullable();
            $table->string('product')->nullable();
            $table->string('quantity')->nullable();
            $table->string('unit')->nullable();
            $table->string('notes')->nullable();
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
        Schema::dropIfExists('distributed_stocks');
    }
};
