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
        if (!Schema::hasTable('register_status_trackers')) {
            Schema::create('register_status_trackers', function (Blueprint $table) {
                $table->id();
                $table->string('registration_no');
                $table->string('package')->nullable();
                $table->string('training_program')->nullable();
                $table->string('session')->nullable();
                $table->string('time_slot')->nullable();
                $table->string('payment_module')->nullable();
                $table->string('payment_date')->nullable();
                $table->string('payment_method')->nullable();
                $table->string('utr_no')->nullable();
                $table->string('registration_fees')->nullable();
                $table->string('total_amt')->nullable();
                $table->string('submitted_amt')->nullable();
                $table->string('pending_amt')->nullable();
                $table->string('payment_status')->nullable();
                $table->string('payment_notes')->nullable();
                $table->string('locationID')->nullable();
                $table->timestamps();
                $table->softDeletes();

                // Define foreign key after the column
                $table->foreign('registration_no')
                    ->references('registration_no')
                    ->on('registrations')
                    ->onDelete('cascade');
            });
        }
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('register_status_trackers');
    }
};
