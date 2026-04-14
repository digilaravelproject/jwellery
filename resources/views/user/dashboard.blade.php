@extends('layouts.app')

@section('title', 'Dashboard - Jewellery Store')

@section('content')
<div class="my-5">
    <!-- Welcome Header -->
    <div class="row mb-5">
        <div class="col-md-12">
            <div class="card shadow-lg" style="background: linear-gradient(135deg, var(--primary-color)15 0%, #ffffff 100%); border: 2px solid var(--primary-color);">
                <div class="card-body p-5 text-center">
                    <div style="font-size: 60px; margin-bottom: 20px;">
                        <i class="fas fa-crown" style="color: var(--primary-color);"></i>
                    </div>
                    <h1 class="mb-3" style="font-size: 48px; color: var(--dark-bg);">
                        Welcome, <span style="color: var(--primary-color);">{{ Auth::user()->name }}!</span>
                    </h1>
                    <p class="lead mb-0" style="color: #666; font-size: 18px;">
                        You have successfully signed in to your account
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Account Info Section -->
    <div class="row mb-5">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-header">
                    <i class="fas fa-user-circle"></i> Account Information
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Full Name:</strong>
                        </div>
                        <div class="col-sm-8">
                            <p>{{ Auth::user()->name }}</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Email:</strong>
                        </div>
                        <div class="col-sm-8">
                            <p>{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Member Since:</strong>
                        </div>
                        <div class="col-sm-8">
                            <p>{{ Auth::user()->created_at->format('d M, Y') }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <strong>Status:</strong>
                        </div>
                        <div class="col-sm-8">
                            <span class="badge badge-success">
                                <i class="fas fa-check-circle"></i> Active
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-header">
                    <i class="fas fa-shopping-bag"></i> Quick Stats
                </div>
                <div class="card-body">
                    <div class="row mb-3 text-center">
                        <div class="col-6">
                            <div style="font-size: 36px; color: var(--primary-color); font-weight: bold;">0</div>
                            <p class="text-muted mb-0">Orders</p>
                        </div>
                        <div class="col-6">
                            <div style="font-size: 36px; color: var(--primary-color); font-weight: bold;">0</div>
                            <p class="text-muted mb-0">Wishlist Items</p>
                        </div>
                    </div>
                    <hr>
                    <div class="d-grid gap-2">
                        <a href="#" class="btn btn-outline-primary">
                            <i class="fas fa-shopping-bag"></i> Start Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="row mb-5">
        <div class="col-md-3">
            <div class="card shadow-lg text-center py-4">
                <div style="font-size: 40px; color: var(--primary-color); margin-bottom: 15px;">
                    <i class="fas fa-box"></i>
                </div>
                <h5>My Orders</h5>
                <p class="text-muted mb-0">View your history</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-lg text-center py-4">
                <div style="font-size: 40px; color: var(--primary-color); margin-bottom: 15px;">
                    <i class="fas fa-heart"></i>
                </div>
                <h5>Wishlist</h5>
                <p class="text-muted mb-0">Your favorites</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-lg text-center py-4">
                <div style="font-size: 40px; color: var(--primary-color); margin-bottom: 15px;">
                    <i class="fas fa-user-edit"></i>
                </div>
                <h5>Edit Profile</h5>
                <p class="text-muted mb-0">Update details</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-lg text-center py-4">
                <div style="font-size: 40px; color: var(--primary-color); margin-bottom: 15px;">
                    <i class="fas fa-cog"></i>
                </div>
                <h5>Settings</h5>
                <p class="text-muted mb-0">Manage account</p>
            </div>
        </div>
    </div>

    <!-- Featured Products Section -->
    <div class="row">
        <div class="col-md-12">
            <h3 class="mb-4"><i class="fas fa-gem"></i> Featured Collections</h3>
        </div>
    </div>

    <div class="row">
        @for($i = 1; $i <= 4; $i++)
        <div class="col-md-3 mb-4">
            <div class="card shadow-lg" style="overflow: hidden;">
                <div style="height: 250px; background: linear-gradient(135deg, var(--primary-color), #c69e2e); display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-gem" style="font-size: 80px; color: rgba(255,255,255,0.3);"></i>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Jewellery Collection {{ $i }}</h5>
                    <p class="card-text text-muted">Premium quality jewellery items</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span style="font-size: 20px; color: var(--primary-color); font-weight: bold;">₹{{ rand(5000, 50000) }}</span>
                        <button class="btn btn-sm btn-primary">
                            <i class="fas fa-shopping-cart"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endfor
    </div>
</div>

<style>
    .badge-success {
        background-color: #28a745;
        color: white;
    }
</style>
@endsection
