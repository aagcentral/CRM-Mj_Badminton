<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'role_id',
        'permission_id'
    ];

    static function InsertUpdateRecord($permission_ids, $role_id)
    {
        if (is_null($permission_ids) || !is_array($permission_ids)) {
            return;
        }

        PermissionRole::where('role_id', $role_id)->delete();

        foreach ($permission_ids as $pid) {
            PermissionRole::updateOrCreate(
                ['permission_id' => $pid, 'role_id' => $role_id],
                ['permission_id' => $pid, 'role_id' => $role_id]
            );
        }
    }


    static function getRolePermission($role_id)
    {
        return PermissionRole::where('role_id', $role_id)->get();
    }

    static function getPermissionRole($slug, $role_id)
    {
        return PermissionRole::select('permission_roles.id')
            ->join('permissions', 'permissions.id', 'permission_roles.permission_id')
            ->where('role_id', $role_id)
            ->where('permissions.slug', $slug)
            ->count();
    }


    // public static function getPermissionRole($route, $roleId)
    // {
    //     // Retrieve the permissions for the given role and check if the route exists in that permission list
    //     $permissions = self::where('role_id', $roleId)->pluck('permission_route')->toArray();

    //     // Check if the route is in the list of permissions
    //     return in_array($route, $permissions);
    // }
}
