<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class PackageUpdateTrack extends Model
{
    use HasFactory;
    protected $fillable = [
        'registration_no',
        'package',
        'training_program',
        'session',
        'time_slot',
        'package_fee',
        'date',
        'package_notes',
        'locationID',

    ];



    public function registration()
    {
        return $this->belongsTo(Registration::class, 'registration_no', 'registration_no');
    }

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
