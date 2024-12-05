<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class callleads extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',
        'date',
        'locationID',
        'status',
        'added_by',
        'name',
        'email',
        'phone',
        'college',
        'course',
        'training_type',
        'lead_source',
        'enquiry_date',
        'follow_date',
        'notes',
        'year',
    ];


    /**
     * Boot method for the model.
     */
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
