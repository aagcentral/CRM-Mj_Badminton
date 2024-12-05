<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';
    protected $fillable = [
        'id',
        'name'
    ];

    static function getRecord()
    {
        return Role::where('id', '!=', '9')->get();
    }


    static function getSingle($id)
    {
        return Role::find($id);
    }
}
