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
        'interested_branch',
        'transport',
        'hostel',
        'is_converted',
        'assigned',
        'address',
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

    public function interestedlocation()
    {
        return $this->belongsTo(Location::class, 'interested_branch', 'location_id');
    }


    // booting
    protected static function boot()
    {
        parent::boot();

        // Automatically set 'locationID' when saving (only if it's not explicitly set)
        static::saving(function ($model) {
            if (!$model->isDirty('locationID')) { // Only set locationID if it's not manually changed
                $model->locationID = Auth::user()->locationID ?? 'L1';
            }
        });

        // Add global scope to filter by 'locationID'
        static::addGlobalScope('locationID', function (Builder $builder) {
            if (Auth::check()) {
                $builder->where('locationID', Auth::user()->locationID ?? 'L1');
            }
        });

        static::deleting(function ($enquiry_Id) {

            $enquiry_Id->LeadStatusTrackers()->forceDelete();
        });
    }
}
