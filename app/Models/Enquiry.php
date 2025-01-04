<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Enquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'enquiry_Id',
        'name',
        'email',
        'mobile',
        'lead_source',
        'package',
        'training_program',
        'session',
        'time_slot',
        'enquiry_date',
        'followup_date',
        'notes',
        'lead_status',
        'locationID',
        'date',
        'status',

    ];

    public function LeadStatusTrackers(): HasMany
    {
        return $this->hasmany(LeadStatusTracker::class, 'enquiry_Id', 'enquiry_Id');
    }

    public function leads(): HasOne
    {
        return $this->hasOne(LeadSource::class, 'leadsource_id', 'lead_source');
    }
    public function Package(): HasOne
    {
        return $this->hasOne(Package::class, 'package_id', 'package');
    }
    public function sesion(): HasOne
    {
        return $this->hasOne(Psession::class, 'session_id', 'session');
    }
    public function Time(): HasOne
    {
        return $this->hasOne(Timings::class, 'timing_id', 'time_slot');
    }
    public function TrainedP(): HasOne
    {
        return $this->hasOne(TrainingProgram::class, 'program_id', 'training_program');
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class, 'enquiry_Id');
    }

    // Relationship to Location model
    public function location()
    {
        return $this->belongsTo(Location::class, 'locationID');  // locationID is the foreign key in Enquiry
    }

    // * Boot method for the model.
    //  */
    // protected static function boot()
    // {
    //     parent::boot();

    //     // Automatically set 'locationID' when saving or updating
    //     static::saving(function ($model) {
    //         $model->locationID = Auth::user()->locationID ?? null;
    //     });

    //     static::updating(function ($model) {
    //         $model->locationID = Auth::user()->locationID ?? null;
    //     });

    //     // Add global scope to filter by 'locationID'
    //     static::addGlobalScope('locationID', function (Builder $builder) {
    //         if (Auth::check()) {
    //             $builder->where('locationID', Auth::user()->locationID);
    //         }
    //     });
    // }


    protected static function boot()
    {
        parent::boot();

        // Automatically set 'locationID' when saving or updating
        static::saving(function ($model) {
            // Set locationID to current user's location or a fallback location ('L1')
            $model->locationID = Auth::user()->locationID ?? 'L1';
        });

        static::updating(function ($model) {
            // Ensure locationID is set on update as well
            $model->locationID = Auth::user()->locationID ?? 'L1';
        });

        // Add global scope to filter by 'locationID'
        static::addGlobalScope('locationID', function (Builder $builder) {
            // Only apply the scope if the user is authenticated
            if (Auth::check()) {
                $builder->where('locationID', Auth::user()->locationID ?? 'L1');
            }
        });
    }
}
