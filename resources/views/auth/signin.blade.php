@extends('layouts.app')

@section('title', 'Sign In - Jewellery Store')

@section('content')
<div class="row justify-content-center my-5">
    <div class="col-md-6">
        <div class="card shadow-lg">
            <div class="card-header text-center">
                <h2><i class="fas fa-sign-in-alt"></i> Welcome Back</h2>
                <p class="mb-0" style="color: var(--dark-bg); opacity: 0.8; font-size: 14px;">Sign in to your account</p>
            </div>
            <div class="card-body p-5">
                <form action="{{ route('signin') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="email" class="form-label">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text" style="background:none; border-right:none;">
                                <i class="fas fa-envelope" style="color: var(--primary-color);"></i>
                            </span>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="{{ old('email') }}" required placeholder="your@email.com"
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
                                <i class="fas fa-lock" style="color: var(--primary-color);"></i>
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

                    <button type="submit" class="btn btn-primary w-100 py-2 mb-3">
                        <i class="fas fa-sign-in-alt"></i> Sign In
                    </button>
                </form>

                <hr style="border-color: var(--primary-color); opacity: 0.3;">

                <p class="text-center mb-0">
                    Don't have an account? 
                    <a href="{{ route('signup') }}" style="color: var(--primary-color); text-decoration: none; font-weight: 600;">
                        Create One Here
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>

<style>
    .card-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, #c69e2e 100%);
    }

    .input-group-text {
        border: 1px solid #ddd;
        background-color: transparent;
    }

    .form-control {
        border: 1px solid #ddd;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25);
    }

    .form-check-input {
        border-color: #ddd;
    }

    .form-check-input:checked {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }
</style>
@endsection
