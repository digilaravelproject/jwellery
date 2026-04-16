@extends('layouts.app')

@section('title', 'Sign Up - Jewellery Store')

@section('content')
<div class="login-side-content d-flex flex-column p-5 justify-content-center">
    <div class="form-wrapper mx-auto" style="width: 100%; max-width: 380px;">
        <h1 class="fw-bold mb-1">Create Account</h1>
        <p class="text-muted mb-4">Join our jewellery family today</p>

        <form action="{{ route('signup') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label class="form-label small fw-semibold text-muted">Full Name</label>
                <input type="text" name="name" class="form-control custom-input @error('name') is-invalid @enderror" 
                       placeholder="Enter your full name" value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback ps-3">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label small fw-semibold text-muted">Email</label>
                <input type="email" name="email" class="form-control custom-input @error('email') is-invalid @enderror" 
                       placeholder="your@email.com" value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback ps-3">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label small fw-semibold text-muted">Password</label>
                <div class="position-relative">
                    <input type="password" name="password" class="form-control custom-input @error('password') is-invalid @enderror" 
                           placeholder="••••••••••••••••" required>
                    <i class="far fa-eye position-absolute top-50 end-0 translate-middle-y me-3 text-muted" style="cursor: pointer;"></i>
                </div>
                @error('password')
                    <div class="text-danger small ps-3 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="form-label small fw-semibold text-muted">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control custom-input" 
                       placeholder="••••••••••••••••" required>
            </div>

            <button type="submit" class="btn btn-primary-custom w-100 mb-4">Create Account</button>
        </form>

        <div class="text-center">
            <span class="small text-muted">Already have an account? 
                <a href="{{ route('signin') }}" class="text-dark fw-bold text-decoration-none">Sign In</a>
            </span>
        </div>
    </div>
</div>

<div class="image-side-content position-relative d-none d-lg-block">
    <div class="image-side-content">
        <img src="{{ asset('public/Silver-Jewellery.png') }}" class="jewellery-img" alt="Jewellery">
    </div>
</div>

<style>
    .login-side-content {
        flex: 1;
        background: transparent;
        z-index: 2;
    }

    .image-side-content {
        flex: 1.1;
        margin: 20px;
        border-radius: 30px;
        overflow: hidden;
    }

    .jewellery-img {
        margin-top: 12% !important;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: right center;
    }

    .custom-input {
        background-color: rgba(255,255,255,0.5);
        border: 1.5px solid transparent;
        border-radius: 50px;
        padding: 12px 20px;
        transition: all 0.3s;
    }

    .custom-input:focus {
        background-color: white;
        border-color: var(--primary-yellow);
        box-shadow: none;
    }

    .btn-primary-custom {
        background-color: #FFD966;
        border: none;
        color: #333;
        font-weight: 600;
        border-radius: 50px;
        padding: 12px;
        transition: all 0.3s ease;
    }

    .btn-primary-custom:hover {
        background-color: #f2cc5b;
        transform: translateY(-2px);
    }

    .floating-widget {
        position: absolute;
        border-radius: 15px;
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.8);
        padding: 15px;
    }

    .widget-top {
        top: 40px; 
        right: 40px; /* Swapped to right for variety on signup */
        background: rgba(255, 255, 255, 0.7);
        min-width: 220px;
    }

    /* Error Styling */
    .invalid-feedback {
        font-size: 0.75rem;
    }
</style>
@endsection