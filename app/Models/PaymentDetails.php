<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Carbon\Carbon;

class PaymentDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'payment_id',
        'registration_no',
        'registration_fees',
        'program_fee',
        'rooms_fees',
        'meals_fees',
        'utr_no',
        'payment_module',
        'payment_date',
        'upcoming_date',
        'payment_method',
        'payment_status',
        'payment_notes',
        'discount',
        'total_amt',
        'submitted_amt',
        'pending_amt',
        'locationID',
        'date',
        'status',
    ];


    public function paymentmodule(): belongsTo
    {
        return $this->belongsTo(PaymentModule::class, 'payment_module', 'module_id');
    }

    public function registration()
    {
        return $this->belongsTo(Registration::class, 'registration_no', 'registration_no');
    }


    // * Boot method for the model.
    //  */
    protected static function boot()
    {
        parent::boot();

        // Automatically set 'locationID' when saving or updating
        static::saving(function ($model) {
            $model->locationID = Auth::user()->locationID ?? null;
        });

        static::updating(function ($model) {
            $model->locationID = Auth::user()->locationID ?? null;
        });

        // Add global scope to filter by 'locationID'
        static::addGlobalScope('locationID', function (Builder $builder) {
            if (Auth::check()) {
                $builder->where('locationID', Auth::user()->locationID);
            }
        });
    }
}
