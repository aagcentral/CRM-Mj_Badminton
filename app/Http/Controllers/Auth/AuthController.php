<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Hash;

class AuthController extends Controller
{

    public function index()
    {
        // dd(hash::make('12345'));
        if (!empty(Auth::check())) {
            return redirect()->route('panel.dashboard');
        }
        return view('auth.login');
    }

    public function auth_login(Request $request)
    {
        $remember = !empty($request->rememeber) ? true : false;
        if (Auth::attempt(['email' => $request->username, 'password' => $request->password], $remember)) {
            return redirect()->route('panel.dashboard');
        } else {
            return back()->with('error', 'Please Enter correct email or password');
        }
    }


    public function update_location(Request $request)
    {
        if ($request->user_location) {
            User::where('id', Auth()->user()->id)->update(['locationID' => $request->user_location]);
        }
        return back()->with('success', 'Location Updated');
    }


    public function logout()
    {
        Auth::logout();

        return redirect(url(''));
    }
}
