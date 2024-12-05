<?php

namespace App\Http\Controllers\Panel\Settings;

use App\Http\Controllers\Controller;
use App\Models\MenuGroup;
use App\Models\Permission;
use App\Models\PermissionRole;
use Illuminate\Http\Request;
use Auth;

class PermissionController extends Controller
{

    protected $permissions = [];
    public function __construct() {
        $permissions = [
            'settings.permission.group',
            'settings.permission',
            'group.insert',
            'permission.insert'
        ];
        
        $this->permissions = array_filter($permissions, function($permission) {
            return PermissionRole::getPermissionRole($permission, Auth::user()->role_id);
        });

        if (empty($this->permissions)) {
            abort('404');
        }
    }
    


    public function index(){
        $data['getRecord'] = MenuGroup::getRecord();
        $data['permissions'] = $this->permissions;
        return view('pages.settings.permission.permission-group',$data);
    }

    public function permission(){
        $data['getRecord'] = MenuGroup::getRecord();
        $data['getPermission'] = MenuGroup::getPermission();
        $data['permissions'] = $this->permissions;
        return view('pages.settings.permission.permission',$data);
    }


    public function insert(Request $request){
         $request->validate([
            'group_name' => 'required'
        ]);
        $save = new MenuGroup;
        $save->name = $request->group_name;
        $save->save();

        return back()->with('success','Saved Successfully');
    }


    public function permissionInsert(Request $request){
         $request->validate([
            'group_id' => 'required',
            'route_name' => 'required',
            'permission_name' => 'required'
        ]);
        $save = new Permission;
        $save->name = $request->permission_name;
        $save->slug = $request->route_name;
        $save->groupBy = $request->group_id;
        $save->save();

        return back()->with('success','Saved Successfully');
    }





}
