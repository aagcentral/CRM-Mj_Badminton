<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'status'
    ];

    static function getRecord()
    {
        return MenuGroup::orderBy('name', 'asc')->get();
    }


    public function permissions()
    {
        return $this->hasMany(Permission::class, 'groupBy', 'id');
    }

    static function getPermission()
    {
        $permissions = MenuGroup::with('permissions')->orderBy('name', 'asc')->get();
        return $permissions;
    }
}
