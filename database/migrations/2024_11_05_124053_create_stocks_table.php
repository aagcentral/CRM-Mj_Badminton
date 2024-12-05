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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->string('stock_id')->nullable();
            $table->string('product_id')->nullable();
            $table->string('category')->nullable();
            $table->string('quantity')->nullable();
            $table->string('unit')->nullable();
            $table->string('single_price')->nullable();
            $table->string('total_price')->nullable();
            $table->string('added_on')->nullable();
            $table->string('vender_name')->nullable();
            $table->enum('product_type', ['0', '1'])->default('0')->comment('0 -> Non Perishable , 1->Perishable');
            $table->string('expiry_date')->nullable();
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
        Schema::dropIfExists('stocks');
    }
};
