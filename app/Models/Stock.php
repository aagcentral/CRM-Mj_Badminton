<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\belongsTo;

class Stock extends Model
{
    use HasFactory;
    protected $fillable = [
        'stock_id',
        'product_id',
        'category',
        'quantity',
        'unit',
        'single_price',
        'total_price',
        'added_on',
        'vender_name',
        'product_type',
        'expiry_date',
        'notes',
        'locationID',
        'date',
        'status',

    ];

    public function Category()
    {
        return $this->belongsTo(Category::class, 'category', 'category_id');
    }


    public function products(): HasOne
    {
        return $this->hasOne(Product::class, 'product_id', 'product_id');
    }



    // check product
    public function distribute($distributedQuantity)
    {
        if ($distributedQuantity > $this->quantity) {
            return "Insufficient stock. Available: {$this->quantity}, Requested: {$distributedQuantity}.";
        }

        $this->quantity -= $distributedQuantity;
        $this->save();

        return "Distributed {$distributedQuantity} units. Remaining stock: {$this->quantity}.";
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
