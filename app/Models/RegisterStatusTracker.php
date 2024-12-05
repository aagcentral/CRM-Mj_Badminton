<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\belongsTo;

class RegisterStatusTracker extends Model
{
    use HasFactory;
    protected $fillable = [
        'registration_no',
        'package',
        'training_program',
        'session',
        'time_slot',
        'payment_module',
        'payment_date',
        'payment_method',
        'utr_no',
        'registration_fees',
        'total_amt',
        'submitted_amt',
        'pending_amt',
        'payment_status',
        'payment_notes',
        'locationID',

    ];
    public function Trackerpackage()
    {
        return $this->belongsTo(Package::class, 'package', 'package_id');
    }

    public function Traintype(): belongsTo
    {
        return $this->belongsTo(TrainingProgram::class, 'training_program', 'program_id');
    }

    public function Trackersession(): belongsTo
    {
        return $this->belongsTo(Psession::class, 'session', 'session_id');
    }
    public function Trackerslot(): belongsTo
    {
        return $this->belongsTo(Timings::class, 'time_slot', 'timing_id');
    }

    public function Trackermodule(): belongsTo
    {
        return $this->belongsTo(PaymentModule::class, 'payment_module', 'module_id');
    }



    // * Boot method for the model.

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
