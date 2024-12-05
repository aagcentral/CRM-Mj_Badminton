<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\belongsTo;

class DistributedStock extends Model
{
    use HasFactory;
    protected $fillable = [
        'distributed_id',
        'registration_no',
        'category',
        'product',
        'quantity',
        'unit',
        'notes',
        'locationID',
        'date',
        'status',

    ];
    public function Category()
    {
        return $this->belongsTo(Category::class, 'category', 'category_id');
    }


    public function products(): belongsTo
    {
        return $this->belongsTo(Product::class, 'product', 'product_id');
    }
    public function units(): belongsTo
    {
        return $this->belongsTo(Unit::class, 'unit', 'unit_id');
    }
    public function register(): belongsTo
    {
        return $this->belongsTo(Registration::class, 'registration_no', 'registration_no');
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
