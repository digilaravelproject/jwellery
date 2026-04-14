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
}

