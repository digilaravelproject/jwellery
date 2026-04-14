@extends('layouts.app')

@section('title', 'Admin Login - Jewellery Store')

@section('content')
<div class="row justify-content-center my-5">
    <div class="col-md-5">
        <div class="card shadow-lg" style="border-top: 4px solid #2c3e50;">
            <div class="card-header" style="background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%); color: white;">
                <div class="text-center">
                    <i class="fas fa-crown" style="font-size: 40px; margin-bottom: 10px;"></i>
                    <h2 class="mb-0">Admin Panel</h2>
                    <p class="mb-0" style="opacity: 0.8; font-size: 14px;">Secure Admin Access</p>
                </div>
            </div>
            <div class="card-body p-5">
                <form action="{{ route('admin.login') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="email" class="form-label">Admin Email</label>
                        <div class="input-group">
                            <span class="input-group-text" style="background:none; border-right:none;">
                                <i class="fas fa-envelope" style="color: #2c3e50;"></i>
                            </span>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="{{ old('email') }}" required placeholder="admin@example.com"
                                   style="border-left:none;">
                        </div>
                        @error('email')
                            <small class="text-danger"><i class="fas fa-exclamation-circle"></i> {{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text" style="background:none; border-right:none;">
                                <i class="fas fa-lock" style="color: #2c3e50;"></i>
                            </span>
                            <input type="password" class="form-control" id="password" name="password" 
                                   required placeholder="Enter your password"
                                   style="border-left:none;">
                        </div>
                        @error('password')
                            <small class="text-danger"><i class="fas fa-exclamation-circle"></i> {{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-4 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">
                            Remember me
                        </label>
                    </div>

                    <button type="submit" class="btn w-100 py-2 mb-3" 
                            style="background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%); color: white; font-weight: 600;">
                        <i class="fas fa-sign-in-alt"></i> Admin Login
                    </button>
                </form>

                <hr style="border-color: #e74c3c; opacity: 0.3;">

                <div class="alert alert-info mb-0" style="background-color: #d1ecf1; border: none;">
                    <i class="fas fa-info-circle"></i> 
                    <small>Admin access only. Unauthorized access is prohibited.</small>
                </div>
            </div>
        </div>

        <!-- Demo Credentials Info -->
        <div class="card shadow-lg mt-4" style="background-color: #f8f9fa; border: 2px dashed #ddd;">
            <div class="card-body">
                <h6 class="card-title" style="color: #2c3e50;">
                    <i class="fas fa-key"></i> Demo Admin Credentials
                </h6>
                <p class="mb-1"><strong>Email:</strong> admin@example.com</p>
                <p class="mb-0"><strong>Password:</strong> password</p>
                <small class="text-muted d-block mt-2">* First create an admin account using artisan command or by seeding</small>
            </div>
        </div>
    </div>
</div>

<style>
    .form-label {
        color: #2c3e50;
        font-weight: 600;
    }

    .input-group-text {
        border: 1px solid #ddd;
        background-color: transparent;
    }

    .form-control {
        border: 1px solid #ddd;
    }

    .form-control:focus {
        border-color: #2c3e50;
        box-shadow: 0 0 0 0.2rem rgba(44, 62, 80, 0.25);
    }

    .form-check-input {
        border-color: #ddd;
    }

    .form-check-input:checked {
        background-color: #2c3e50;
        border-color: #2c3e50;
    }
</style>
@endsection
