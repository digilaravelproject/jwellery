@extends('layouts.admin')

@section('title', 'Edit User - Admin Dashboard')
@section('page-title', 'Edit User')

@section('content')
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Manage Users</a></li>
            <li class="breadcrumb-item active">Edit User</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-edit"></i> Edit User: {{ $user->name }}
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $user->name) }}" required 
                                   placeholder="Enter user's full name">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', $user->email) }}" required 
                                   placeholder="Enter user's email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-info" role="alert">
                            <i class="fas fa-info-circle"></i> Leave the password fields empty to keep the current password
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">New Password <span class="text-muted">(Optional)</span></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" 
                                   placeholder="Enter new password (leave empty to keep current)">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">Confirm Password <span class="text-muted">(Optional)</span></label>
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                                   id="password_confirmation" name="password_confirmation" 
                                   placeholder="Confirm new password">
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update User
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
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-user-info"></i> User Information
                </div>
                <div class="card-body">
                    <p><strong>User ID:</strong> #{{ $user->id }}</p>
                    <p><strong>Created:</strong> {{ $user->created_at->format('d M, Y H:i A') }}</p>
                    <p><strong>Last Updated:</strong> {{ $user->updated_at->format('d M, Y H:i A') }}</p>
                    <hr>
                    <p><strong>Status:</strong> <span class="badge" style="background-color: #27ae60; color: white;">Active</span></p>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header" style="background-color: #e74c3c; color: white;">
                    <i class="fas fa-exclamation-triangle"></i> Danger Zone
                </div>
                <div class="card-body">
                    <p style="font-size: 14px; color: #555; margin-bottom: 15px;">Delete this user permanently. This action cannot be undone.</p>
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" 
                          onsubmit="return confirm('Are you absolutely sure you want to delete this user? This cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-trash"></i> Delete User
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
