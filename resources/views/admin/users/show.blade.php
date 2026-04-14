@extends('layouts.admin')

@section('title', 'View User - Admin Dashboard')
@section('page-title', 'User Details')

@section('content')
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Manage Users</a></li>
            <li class="breadcrumb-item active">User Details</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-user"></i> User Profile #{{ $user->id }}</h5>
                        <div>
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-edit">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline;" 
                                  onsubmit="return confirm('Are you sure you want to delete this user?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-delete">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-2 text-center">
                            <div style="width: 100px; height: 100px; border-radius: 50%; background: linear-gradient(135deg, #2c3e50, #34495e); color: white; display: flex; align-items: center; justify-content: center; font-size: 50px; font-weight: bold; margin: 0 auto;">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        </div>
                        <div class="col-md-10">
                            <h3 style="color: #2c3e50;">{{ $user->name }}</h3>
                            <p style="color: #7f8c8d; font-size: 16px;">{{ $user->email }}</p>
                            <span class="badge" style="background-color: #27ae60; color: white; padding: 8px 12px; font-size: 12px;">
                                <i class="fas fa-check-circle"></i> Active
                            </span>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 style="color: #2c3e50; font-weight: 700; margin-bottom: 10px;">Personal Information</h6>
                            <table class="table table-sm" style="border: none;">
                                <tr style="border: none;">
                                    <td style="border: none;"><strong>Full Name:</strong></td>
                                    <td style="border: none;">{{ $user->name }}</td>
                                </tr>
                                <tr style="border: none;">
                                    <td style="border: none;"><strong>Email:</strong></td>
                                    <td style="border: none;">{{ $user->email }}</td>
                                </tr>
                                <tr style="border: none;">
                                    <td style="border: none;"><strong>Email Verified:</strong></td>
                                    <td style="border: none;">
                                        @if($user->email_verified_at)
                                            <span class="badge" style="background-color: #27ae60; color: white;">Yes</span>
                                        @else
                                            <span class="badge" style="background-color: #e74c3c; color: white;">No</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6 mb-3">
                            <h6 style="color: #2c3e50; font-weight: 700; margin-bottom: 10px;">Account Details</h6>
                            <table class="table table-sm" style="border: none;">
                                <tr style="border: none;">
                                    <td style="border: none;"><strong>User ID:</strong></td>
                                    <td style="border: none;">#{{ $user->id }}</td>
                                </tr>
                                <tr style="border: none;">
                                    <td style="border: none;"><strong>Account Status:</strong></td>
                                    <td style="border: none;">
                                        <span class="badge" style="background-color: #27ae60; color: white;">Active</span>
                                    </td>
                                </tr>
                                <tr style="border: none;">
                                    <td style="border: none;"><strong>Registered:</strong></td>
                                    <td style="border: none;">{{ $user->created_at->format('d M, Y') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <h6 style="color: #2c3e50; font-weight: 700; margin-bottom: 10px;">Timestamps</h6>
                            <p><strong>Created At:</strong> <br><small class="text-muted">{{ $user->created_at->format('d M, Y H:i A') }}</small></p>
                            <p><strong>Updated At:</strong> <br><small class="text-muted">{{ $user->updated_at->format('d M, Y H:i A') }}</small></p>
                        </div>
                        <div class="col-md-6">
                            <h6 style="color: #2c3e50; font-weight: 700; margin-bottom: 10px;">Activity</h6>
                            <p><strong>Last Login:</strong> <br><small class="text-muted">—</small></p>
                            <p><strong>Last Updated:</strong> <br><small class="text-muted">{{ $user->updated_at->diffForHumans() }}</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Quick Actions Card -->
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-bolt"></i> Quick Actions
                </div>
                <div class="card-body d-grid gap-2">
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit User
                    </a>
                    <button class="btn btn-info" disabled>
                        <i class="fas fa-envelope"></i> Send Email
                    </button>
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" 
                          onsubmit="return confirm('Are you absolutely sure?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-trash"></i> Delete User
                        </button>
                    </form>
                </div>
            </div>

            <!-- Status Card -->
            <div class="card mb-3">
                <div class="card-header" style="background-color: #27ae60; color: white;">
                    <i class="fas fa-check-circle"></i> Status
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Account Status:</strong><br>
                        <span class="badge" style="background-color: #27ae60; color: white; padding: 8px 12px;">Active</span>
                    </div>
                    <div class="mb-3">
                        <strong>Email Status:</strong><br>
                        @if($user->email_verified_at)
                            <span class="badge" style="background-color: #27ae60; color: white; padding: 8px 12px;">Verified</span>
                        @else
                            <span class="badge" style="background-color: #e74c3c; color: white; padding: 8px 12px;">Not Verified</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Info Card -->
            <div class="card" style="background-color: #f1f3f5;">
                <div class="card-body">
                    <h6 style="color: #2c3e50; font-weight: 700; margin-bottom: 15px;">
                        <i class="fas fa-info-circle"></i> Information
                    </h6>
                    <ul style="color: #555; font-size: 14px; list-style: none; padding: 0;">
                        <li class="mb-2">
                            <i class="fas fa-check" style="color: #27ae60;"></i>
                            Member since {{ $user->created_at->format('d M, Y') }}
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check" style="color: #27ae60;"></i>
                            Account is active and in good standing
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check" style="color: #27ae60;"></i>
                            All account permissions available
                        </li>
                        <li>
                            <i class="fas fa-check" style="color: #27ae60;"></i>
                            Can be edited or deleted anytime
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
