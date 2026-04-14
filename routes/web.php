<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\JewelryDesignController;

// Public routes
// Route::get('/', function () {
//     return view('welcome');
// });

// User Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup');
    Route::post('/signup', [AuthController::class, 'signup']);
    Route::get('/signin', [AuthController::class, 'showSignin'])->name('signin');
    Route::post('/signin', [AuthController::class, 'signin']);
});

// User Dashboard Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Jewelry Design Routes
    Route::post('/design/generate', [JewelryDesignController::class, 'generateDesign'])->name('design.generate');
    Route::get('/design/designs', [JewelryDesignController::class, 'getDesigns'])->name('design.list');
});

// Admin Authentication Routes
Route::middleware('guest')->prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login']);
});

// Admin Dashboard Routes
Route::middleware('admin')->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminAuthController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    
    // User Management Routes
    Route::resource('users', AdminUserController::class, ['as' => 'admin']);
});

