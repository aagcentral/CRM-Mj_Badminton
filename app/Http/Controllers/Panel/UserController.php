<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\PermissionRole;
use App\Models\Role;
use App\Models\Location;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function __construct()
    {
        $permissiondashboard = PermissionRole::getPermissionRole('user.list', Auth::user()->role_id);
        if (empty($permissiondashboard)) {
            abort('404');
        }
    }

    // public function index()
    // {
    //     $data['getRecord'] = User::getRecord();
    //     return view('pages.user.list', $data);
    // }

    public function index()
    {
        $data['getRecord'] = User::with(['role', 'Userlocations'])->orderBy('id', 'desc')->get();
        return view('pages.user.list', $data);
    }

    public function add()
    {
        $data['getRole'] = Role::getRecord();
        $data['getLocation'] = Location::getLocation();
        // dd($data['getLocation']);
        return view('pages.user.add', $data);
    }

    // public function insert(Request $request)
    // {
    //     try {
    //         // Validate input data
    //         $request->validate([
    //             'name' => 'required|string|max:255',
    //             'email' => 'required|email|unique:users,email',
    //             'password' => 'required|min:8',
    //             'role_id' => 'required|integer',
    //             'locationID' => 'required|string|max:50',
    //         ]);

    //         // Create a new user
    //         $user = new User;
    //         $user->name = $request->name;
    //         $user->email = $request->email;
    //         $user->password = Hash::make($request->password);
    //         $user->role_id = $request->role_id;
    //         $user->locationID = $request->locationID;
    //         $user->save();

    //         // Return success message
    //         return back()->with('success', 'User saved successfully.');
    //     } catch (\Exception $e) {
    //         // Log the error for debugging
    //         \Log::error('Error saving user: ' . $e->getMessage());

    //         // Return error message
    //         return back()->with('error', 'The email address is already in use.');
    //     }
    // }
    public function insert(Request $request)
    {
        try {
            // Validate input data
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:5',
                'role_id' => 'required|integer',
                'locationID' => 'required|string|max:50',
            ]);

            // Create a new user
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role_id = $request->role_id;
            $user->locationID = $request->locationID;
            $user->save();

            // Return success message
            return back()->with('success', 'User saved successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation exception separately
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error saving user: ' . $e->getMessage());

            // Return a general error message
            return back()->with('error', 'An unexpected error occurred. Please try again.');
        }
    }


    public function edit($id)
    {
        $data['getUser'] = User::getSingle($id);
        $data['getRole'] = Role::getRecord();
        $data['getLocation'] = Location::getLocation();
        return view('pages.user.edit', $data);
    }


    public function update($id, Request $request)
    {
        $save = User::getSingle($id);
        $save->name = $request->name;
        if (!empty($request->password)) {
            $save->password = Hash::make($request->password);
        }
        $save->role_id = $request->role_id;
        $save->locationID = $request->locationID;
        $save->save();
        return back()->with('success', 'Updated Successfully');
    }


    public function delete($id)
    {
        $save = User::getSingle($id);
        $save->delete();
        return back()->with('success', 'Deleted Successfully');
    }
}
