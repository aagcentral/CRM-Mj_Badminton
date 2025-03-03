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
        if (!Schema::hasTable('payment_details')) {
            Schema::create('payment_details', function (Blueprint $table) {
                $table->id();
                $table->string('payment_id');
                $table->string('registration_no');
                $table->string('registration_fees')->nullable();
                $table->string('transport_fees')->nullable();
                $table->string('program_fee')->nullable();
                $table->string('rooms_fees')->nullable();
                $table->string('meals_fees')->nullable();
                $table->string('utr_no')->nullable();
                $table->string('payment_module')->nullable();
                $table->string('payment_date')->nullable();
                $table->string('upcoming_date')->nullable();
                $table->enum('payment_method', ['0', '1'])->comment('0 -> Offline, 1->Online');
                $table->enum('payment_status', ['0', '1', '2', '3', '4', '5'])->default('0')->comment('0 -> Success, 1->Due, 2->Pending, 3->Failed, 4->Refunded, 5->Canclled');
                $table->string('payment_notes')->nullable();
                $table->string('discount')->nullable();
                $table->string('total_amt')->nullable();
                $table->string('submitted_amt')->nullable();
                $table->string('pending_amt')->nullable();
                $table->string('locationID')->nullable();
                $table->dateTime('date')->nullable();
                $table->enum('status', ['0', '1'])->default('0')->comment('0 -> Active, 1->Inactive');
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
        Schema::dropIfExists('payment_details');
    }
};
