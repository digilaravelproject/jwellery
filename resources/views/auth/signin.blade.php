@extends('layouts.app')

@section('title', 'Sign In - Jewellery Store')

@section('content')
<div class="login-side-content d-flex flex-column p-5 justify-content-center">
    <!-- <div class="brand-logo">
        <div class="logo-circle">Crextio</div>
    </div> -->

    <div class="form-wrapper mx-auto" style="width: 100%; max-width: 380px;">
        <h1 class="fw-bold mb-1">Welcome Back</h1>
        <p class="text-muted mb-4">Sign in to access your dashboard</p>

        <form action="{{ route('signin') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label small fw-semibold text-muted">Email</label>
                <input type="email" name="email" class="form-control custom-input" 
                       placeholder="Enter your email" value="{{ old('email') }}" required>
            </div>

            <div class="mb-4">
                <label class="form-label small fw-semibold text-muted">Password</label>
                <div class="position-relative">
                    <input type="password" name="password" class="form-control custom-input" 
                           placeholder="••••••••••••••••" required>
                    <i class="far fa-eye position-absolute top-50 end-0 translate-middle-y me-3 text-muted" style="cursor: pointer;"></i>
                </div>
            </div>

            <button type="submit" class="btn btn-primary-custom w-100 mb-4">Submit</button>
        </form>
        <div class="text-center">
            <span class="small text-muted">Don't have an account? 
                <a href="{{ route('signup') }}" class="text-dark fw-bold text-decoration-none">Sign up</a>
            </span>
        </div>
    </div>
</div>

<div class="image-side-content position-relative d-none d-lg-block">
    <div class="image-side-content">
        <img src="{{ asset('Silver-Jewellery.png') }}" class="jewellery-img">
    </div>
</div>

<style>
    .login-side-content {
        flex: 1;
        background: transparent;
        z-index: 2;
    }

    /* .image-side-content {
        flex: 1.1;
        background-image: url('/Silver-Jewellery.png');
        background-size: cover;
        background-position: center;
        margin: 20px;
        border-radius: 30px;
    } */

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

    .logo-circle {
        border: 1px solid #ccc;
        padding: 8px 20px;
        border-radius: 50px;
        display: inline-block;
        font-weight: 500;
        color: #666;
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

    .social-btn {
        border-radius: 50px;
        border: 1px solid #ddd;
        font-weight: 500;
        background: white;
    }

    /* Floating UI Elements */
    .floating-widget {
        position: absolute;
        border-radius: 15px;
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.8);
        padding: 15px;
    }

    .widget-top {
        top: 40px; left: 40px;
        background: #FFD966;
        min-width: 200px;
        border-radius: 12px;
    }

    .widget-calendar {
        bottom: 180px; right: 40px;
        width: 250px;
        background: rgba(255,255,255,0.2);
        color: white;
        border: 1px solid rgba(255,255,255,0.3);
    }

    .widget-meeting {
        bottom: 60px; left: 50%;
        transform: translateX(-50%);
        width: 80%;
        background: white;
    }

    .mini-avatar {
        width: 30px; height: 30px;
        background: #ddd;
        border-radius: 50%;
        border: 2px solid white;
    }

    .ms-n2 { margin-left: -10px; }
</style>
@endsection