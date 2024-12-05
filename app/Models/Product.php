<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\belongsTo;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'category_id',
        'category',
        'product',
        'product_type',
        'unit',
        'expiry_date',
        'notes',
        'locationID',
        'date',
        'status',
    ];
    public function categories()
    {
        return $this->hasone(Category::class, 'category_id', 'category');
    }

    public function stock()
    {
        return $this->hasOne(Stock::class, 'product_id', 'product_id');
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
