<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    // Show admin login form
    public function showLogin()
    {
        return view('admin.login');
    }

    // Handle admin login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::guard('admin')->attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard')->with('success', 'Admin logged in successfully!');
        }

        return back()->withErrors([
            'email' => 'Invalid admin credentials',
        ])->onlyInput('email');
    }

    // Admin dashboard
    public function dashboard()
    {
        $admin = Auth::guard('admin')->user();
        $userCount = \App\Models\User::count();
        
        return view('admin.dashboard', [
            'admin' => $admin,
            'userCount' => $userCount
        ]);
    }

    // Admin logout
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login')->with('success', 'Admin logged out successfully!');
    }

    // Show edit profile form (in modal data)
    public function editProfile()
    {
        $admin = Auth::guard('admin')->user();
        return response()->json([
            'admin' => $admin
        ]);
    }

    // Update admin profile
    public function updateProfile(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            'current_password' => 'nullable|string',
            'password' => 'nullable|confirmed|min:6',
        ], [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.unique' => 'Email is already in use',
            'password.confirmed' => 'Passwords do not match',
            'password.min' => 'Password must be at least 6 characters',
        ]);

        // Check current password if new password is provided
        if (!empty($validated['password'])) {
            if (!isset($validated['current_password'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Current password is required to set a new password'
                ], 422);
            }

            if (!Hash::check($validated['current_password'], $admin->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Current password is incorrect'
                ], 422);
            }

            $admin->password = Hash::make($validated['password']);
        }

        $admin->name = $validated['name'];
        $admin->email = $validated['email'];
        $admin->save();

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully!'
        ]);
    }
}

