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

class Registration extends Model
{
    use HasFactory;
    protected $fillable = [
        'registration_no',
        'enquiry_Id',
        'name',
        'father',
        'gender',
        'image',
        'dob',
        'email',
        'phone',
        'state',
        'city',
        'pincode',
        'address',
        'package',
        'training_program',
        'session',
        'time_slot',
        'lead_source',
        // 'registration_fee',
        'transport',
        'start_date',
        'end_date',
        'room_allotment',
        'room_type',
        // 'room_fees',
        'meal_subscription',
        'meal_type',
        // 'meal_fees',
        'checking_date',
        'checkout_date',
        'notes',
        'locationID',
        'date',
        'status',
    ];
    // Global date format for all date attributes
    public function getAttribute($key)
    {
        $dateFields = ['dob', 'checking_date', 'checkout_date', 'date'];

        if (in_array($key, $dateFields)) {
            $value = parent::getAttribute($key);
            return $value ? Carbon::parse($value)->format('d-m-y') : null;
        }

        return parent::getAttribute($key);
    }



    public function leads(): HasOne
    {
        return $this->hasOne(LeadSource::class, 'leadsource_id', 'lead_source');
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
    public function PaymentDetail(): HasOne
    {
        return $this->hasOne(PaymentDetails::class, 'registration_no', 'registration_no');
    }
    public function Packages(): HasOne
    {
        return $this->hasOne(Package::class, 'package_id', 'package');
    }

    public function meals(): HasOne
    {
        return $this->hasOne(Meal::class, 'meal_id', 'meal_type');
    }
    public function rooms(): HasOne
    {
        return $this->hasOne(Room::class, 'room_id', 'room_type');
    }


    public function registerStatusTracker()
    {
        return $this->hasMany(RegisterStatusTracker::class, 'registration_no', 'registration_no');
    }


    public function userPackageTracker()
    {
        return $this->hasMany(PackageUpdateTrack::class, 'registration_no', 'registration_no');
    }

    public function enquiry()
    {
        return $this->belongsTo(Enquiry::class, 'enquiry_id');
    }




    // * Boot method for the model.

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

        // Automatically apply the `locationID` to all saving operations
        static::saving(function ($model) {
            $model->locationID = Auth::user()->locationID ?? null;

            static::updating(function ($model) {
                $model->locationID = Auth::user()->locationID ?? null;
            });

            // Generate the `registration_no` if not already set
            if (!$model->registration_no) {
                $locationID = $model->locationID ?? 'DEFAULT';
                $lastRegistration = Registration::where('locationID', $locationID)
                    ->lockForUpdate()
                    ->max('id');
                $newNumber = $lastRegistration ? $lastRegistration + 1 : 1;
                $model->registration_no = strtoupper($locationID) . '-RID' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
            }
        });

        // Automatically apply a global scope to filter by `locationID`
        static::addGlobalScope('location', function ($builder) {
            $builder->where('locationID', Auth::user()->locationID ?? null);
        });
    }
}
