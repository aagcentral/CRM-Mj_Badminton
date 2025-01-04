<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    public function directReset()
    {
        // Return the reset password view directly
        return view('pages.reset');
    }

    public function update(Request $request)
    {
        // Validate the input
        $request->validate([
            'email' => 'required|email|exists:users,email',  // Check if email exists
            'password' => 'required|string|min:5|confirmed', // Validate password and confirmation
        ]);

        // Find the user by email
        $user = User::where('email', $request->email)->first();

        // If user exists, update the password
        if ($user) {
            $user->password = Hash::make($request->password); // Hash the new password
            $user->save(); // Save the updated user

            // Redirect to login page with a success message
            return redirect()->route('password.direct-reset')->with('success', 'Password successfully updated.');
        }

        // If user not found, redirect back with an error message
        return back()->withErrors(['email' => 'User not found or email is incorrect.']);
    }
}
