@extends('layouts.app')

@section('title', 'Admin Login - Jewellery Store')

@section('content')
<div class="admin-login-container">
    <div class="login-card-wrapper">
        <!-- Login Card -->
        <div class="login-section">
            <div class="login-card">
                <div class="login-header">
                    <div class="header-icon">
                        <i class="fas fa-crown"></i>
                    </div>
                    <h2 class="header-title">Admin Panel</h2>
                    <p class="header-subtitle">Secure Admin Access</p>
                </div>
                <div class="login-body">
                    <form action="{{ route('admin.login') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="email" class="form-label">Admin Email</label>
                            <div class="input-wrapper">
                                <i class="fas fa-envelope input-icon"></i>
                                <input type="email" class="form-input" id="email" name="email" 
                                       value="{{ old('email') }}" required placeholder="admin@example.com">
                            </div>
                            @error('email')
                                <small class="error-text"><i class="fas fa-exclamation-circle"></i> {{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-wrapper">
                                <i class="fas fa-lock input-icon"></i>
                                <input type="password" class="form-input" id="password" name="password" 
                                       required placeholder="Enter your password">
                            </div>
                            @error('password')
                                <small class="error-text"><i class="fas fa-exclamation-circle"></i> {{ $message }}</small>
                            @enderror
                        </div>

                        <div class="checkbox-group">
                            <input type="checkbox" class="form-checkbox" id="remember" name="remember">
                            <label class="checkbox-label" for="remember">Remember me</label>
                        </div>

                        <button type="submit" class="btn-login">
                            <i class="fas fa-sign-in-alt"></i> Admin Login
                        </button>
                    </form>

                    <div class="divider"></div>

                    <div class="info-alert">
                        <i class="fas fa-info-circle"></i> 
                        <small>Admin access only. Unauthorized access is prohibited.</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Demo Credentials Info -->
        <?php /*<div class="credentials-card">
            <div class="credentials-header">
                <i class="fas fa-key"></i> Demo Admin Credentials
            </div>
            <div class="credentials-body">
                <p class="credential-item"><strong>Email:</strong> admin@example.com</p>
                <p class="credential-item"><strong>Password:</strong> password</p>
                <small class="credential-hint">* First create an admin account using artisan command or by seeding</small>
            </div>
        </div> */?>
    </div>
</div>

<style>
    .admin-login-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: linear-gradient(135deg, #F9F7F2 0%, #E8E2D6 100%);
        width: 100%;
    }

    .login-card-wrapper {
        width: 100%;
        max-width: 450px;
        display: flex;
        flex-direction: column;
        gap: 25px;
    }

    .login-card {
        background: white;
        border-radius: 40px;
        overflow: hidden;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
    }

    .login-header {
        background: linear-gradient(135deg, #FFD966 0%, #f2cc5b 100%);
        padding: 50px 30px;
        text-align: center;
        color: #2D2D2D;
    }

    .header-icon {
        font-size: 60px;
        margin-bottom: 15px;
        color: #2D2D2D;
    }

    .header-title {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 8px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: #2D2D2D;
    }

    .header-subtitle {
        font-size: 14px;
        color: rgba(45, 45, 45, 0.7);
        margin: 0;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .login-body {
        padding: 40px;
    }

    .form-group {
        margin-bottom: 24px;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: #2D2D2D;
        margin-bottom: 10px;
        font-size: 14px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-icon {
        position: absolute;
        left: 16px;
        color: #FFD966;
        font-size: 16px;
        pointer-events: none;
    }

    .form-input {
        width: 100%;
        background: #f5f5f5;
        border: 2px solid transparent;
        border-radius: 25px;
        padding: 12px 16px 12px 45px;
        font-size: 14px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        transition: all 0.3s ease;
        color: #2D2D2D;
    }

    .form-input::placeholder {
        color: #999;
    }

    .form-input:focus {
        outline: none;
        background: white;
        border-color: #FFD966;
        box-shadow: 0 0 12px rgba(255, 217, 102, 0.3);
    }

    .error-text {
        color: #dc3545;
        display: block;
        margin-top: 6px;
        font-size: 12px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .checkbox-group {
        display: flex;
        align-items: center;
        margin-bottom: 28px;
        gap: 8px;
    }

    .form-checkbox {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: #FFD966;
    }

    .checkbox-label {
        font-size: 14px;
        color: #666;
        cursor: pointer;
        margin: 0;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .btn-login {
        width: 100%;
        background: linear-gradient(135deg, #FFD966 0%, #f2cc5b 100%);
        border: none;
        border-radius: 25px;
        padding: 14px;
        font-size: 16px;
        font-weight: 600;
        color: #2D2D2D;
        cursor: pointer;
        transition: all 0.3s ease;
        font-family: 'Plus Jakarta Sans', sans-serif;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 4px 15px rgba(255, 217, 102, 0.3);
    }

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(255, 217, 102, 0.4);
    }

    .divider {
        height: 1px;
        background: linear-gradient(to right, transparent, #FFD966, transparent);
        margin: 24px 0;
        opacity: 0.3;
    }

    .info-alert {
        background: rgba(255, 217, 102, 0.1);
        border: 2px solid rgba(255, 217, 102, 0.3);
        border-radius: 20px;
        padding: 14px 16px;
        color: #666;
        font-size: 12px;
        display: flex;
        align-items: flex-start;
        gap: 10px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .info-alert i {
        color: #FFD966;
        margin-top: 2px;
        flex-shrink: 0;
    }

    .credentials-card {
        background: #F5F5F5;
        border: 2px dashed #FFD966;
        border-radius: 30px;
        margin-top: 25px;
        overflow: hidden;
    }

    .credentials-header {
        background: rgba(255, 217, 102, 0.15);
        padding: 18px 24px;
        font-weight: 600;
        color: #2D2D2D;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .credentials-header i {
        color: #FFD966;
    }

    .credentials-body {
        padding: 20px 24px;
    }

    .credential-item {
        margin-bottom: 8px;
        color: #2D2D2D;
        font-size: 13px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .credential-item strong {
        color: #FFD966;
        font-weight: 600;
    }

    .credential-hint {
        display: block;
        margin-top: 12px;
        color: #999;
        font-size: 12px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    @media (max-width: 480px) {
        .login-header {
            padding: 40px 20px;
        }

        .header-icon {
            font-size: 50px;
        }

        .header-title {
            font-size: 28px;
        }

        .login-body {
            padding: 30px 20px;
        }

        .btn-login {
            font-size: 15px;
            padding: 12px;
        }
    }
</style>
@endsection
