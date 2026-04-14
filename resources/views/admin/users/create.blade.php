@extends('layouts.admin')

@section('title', 'Create New User - Admin Dashboard')
@section('page-title', 'Create New User')

@section('content')
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Manage Users</a></li>
            <li class="breadcrumb-item active">Create New User</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-user-plus"></i> Add New User
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required 
                                   placeholder="Enter user's full name">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required 
                                   placeholder="Enter user's email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required 
                                   placeholder="Enter password (minimum 6 characters)">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                                   id="password_confirmation" name="password_confirmation" required 
                                   placeholder="Confirm password">
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Create User
                            </button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card" style="background-color: #f8f9fa;">
                <div class="card-body">
                    <h6 style="color: #2c3e50; font-weight: 700; margin-bottom: 15px;">
                        <i class="fas fa-info-circle"></i> Information
                    </h6>
                    <ul style="color: #555; font-size: 14px; list-style: none; padding: 0;">
                        <li class="mb-2">
                            <i class="fas fa-check" style="color: #27ae60;"></i>
                            <strong>Name:</strong> Must be unique and contain letters only
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check" style="color: #27ae60;"></i>
                            <strong>Email:</strong> Must be a valid email and unique
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check" style="color: #27ae60;"></i>
                            <strong>Password:</strong> Must be at least 6 characters long
                        </li>
                        <li>
                            <i class="fas fa-check" style="color: #27ae60;"></i>
                            <strong>Required:</strong> All fields are mandatory
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header" style="background-color: #27ae60; color: white;">
                    <i class="fas fa-shield-alt"></i> Password Requirements
                </div>
                <div class="card-body">
                    <ul style="color: #555; font-size: 13px; padding-left: 15px;">
                        <li>Minimum 6 characters</li>
                        <li>Must match confirmation</li>
                        <li>Should be strong</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
