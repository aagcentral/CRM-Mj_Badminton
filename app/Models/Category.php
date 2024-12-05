<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'category',
        'locationID',
        'date',
        'status',

    ];
    public function stocks()
    {
        return $this->hasMany(Stock::class, 'category', 'category');
    }


    public function products(): HasOne
    {
        return $this->hasOne(Product::class, 'category', 'category_id');
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
