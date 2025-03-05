<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\belongsTo;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'package_id',
        'package',
        'fees',
        'locationID',
        'date',
        'status',

    ];


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
            if (!$model->locationID) {
                $model->locationID = Auth::user()->locationID ?? null;
            }
        });

        static::updating(function ($model) {
            if (!$model->locationID) {
                $model->locationID = Auth::user()->locationID ?? null;
            }
        });

        // Add global scope to filter by 'locationID' unless it is null or 0
        static::addGlobalScope('locationID', function (Builder $builder) {
            if (Auth::check()) {
                $builder->where(function ($query) {
                    $query->where('locationID', Auth::user()->locationID)
                        ->orWhereNull('locationID') // Allow records with no location restriction
                        ->orWhere('locationID', 0); // Allow global records
                });
            }
        });
    }
}
