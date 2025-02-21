<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class FeeCollectionHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'registration_no',
        'transport_fees',
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
        'total_amt',
        'submitted_amt',
        'pending_amt',
        'locationID',
        'date',
    ];



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
