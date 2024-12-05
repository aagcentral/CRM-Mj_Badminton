<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $table = 'permissions';

    protected $fillable = [
        'id',
        'name',
        'slug',
        'groupBy'
    ];


    // Define the relationship with PermissionGroup
    public function groups()
    {
        return $this->hasMany(MenuGroup::class, 'id', 'groupBy');
    }

    static function getRecord()
    {
        $permissions =  Permission::groupBy('groupBy')->get();

        foreach ($permissions as $value) {
            $getPermissionGroup = Permission::getPermissionGroup($value->groupBy);
            $data = array();
            $data['id'] = $value->id;
            $data['name'] = $value->name;
            $group = array();
            foreach ($getPermissionGroup as $gp) {
                $dataG = array();
                $dataG['id'] = $gp->id;
                $dataG['name'] = $gp->name;
                $group[] = $dataG;
            }
            $data['group'] = $group;
            $result[] = $data;
        }
        return $result;
    }

    // static function getRecord()
    // {
    // $permissions = Permission::with('groups')->groupBy('groupBy')->get();
    // $result = [];

    // foreach ($permissions as $permission) {
    //     $data = [
    //         'id' => $permission->id,
    //         'name' => $permission->name,
    //         'group' => $permission->groups->map(function($group) {
    //             return [
    //                 'id' => $group->id,
    //                 'name' => $group->name,
    //             ];
    //         })->toArray(),
    //     ];
    //     $result[] = $data;
    // }

    // return $permissions;
    // }



    static function getPermissionGroup($groupBy)
    {
        return Permission::where('groupBy', $groupBy)->get();
    }
}
