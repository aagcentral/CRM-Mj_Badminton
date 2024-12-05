<?php

namespace App\Http\Controllers\Panel\Settings;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\PermissionRole;
use App\Models\Role;
use Auth;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected $permissions = [];
    public function __construct() {
        $permissions = [
            'settings.role.list',
            'panel.add',
            'panel.insert',
            'panel.edit',
            'panel.update',
            'panel.delete'
        ];
        
        $this->permissions = array_filter($permissions, function($permission) {
            return PermissionRole::getPermissionRole($permission, Auth::user()->role_id);
        });

        if (empty($this->permissions)) {
            abort('404');
        }
    }
    
    
    
    public function index(){
        $data['getRecord'] = Role::getRecord();
        $data['permissions'] = $this->permissions;
        return view('pages.role.list',$data);
    }


    public function add(){
        $getPermission = Permission::getRecord();
        $data['getPermission'] = $getPermission;
        $data['permissions'] = $this->permissions;
        return view('pages.role.add',$data);
    }
    

    public function insert(Request $request){
        $request->validate([
            'role' => 'required'
        ]);
        $save = new Role;
        $save->name = $request->role;
        $save->save();
        PermissionRole::InsertUpdateRecord($request->permisssion_id,$save->id);
        return back()->with('success','Saved Successfully');
    }
    

    public function edit($id){
        $data['getSingle'] = Role::getSingle($id);
        $data['permissions'] = $this->permissions;
        $getPermission = Permission::getRecord();
        $data['getPermission'] = $getPermission;
        $data['getRolePermission'] = PermissionRole::getRolePermission($id);

        return view('pages.role.edit',$data);
    }
    

    public function update($id, Request $request){
        $save = Role::getSingle($id);
        $save->name = $request->role;
        $save->save();
        PermissionRole::InsertUpdateRecord($request->permisssion_id,$save->id);
        return back()->with('success','Updated Successfully');
    }


    
    public function delete($id){
        $save = Role::getSingle($id);
        $save->delete();
        return back()->with('success','Deleted Successfully');
    }
    



    
}
