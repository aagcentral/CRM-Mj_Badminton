<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'location_id',
        'location',
        'status'
    ];

    static function getRecord()
    {
        return Location::all();
    }


    static function getSingle($id)
    {
        return Location::find($id);
    }

    public static function getLocation()
    {
        return self::select('location_id', 'location')->orderBy('location', 'asc')->get();
    }
}
