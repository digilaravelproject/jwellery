@extends('layouts.admin')

@section('title', 'Admin Dashboard - Jewellery Store')
@section('page-title', 'Dashboard')

@section('content')
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-number">{{ $userCount }}</div>
                <div class="stat-label">Total Users</div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="stat-card" style="border-left-color: #27ae60;">
                <div class="stat-icon" style="color: #27ae60;">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <div class="stat-number">0</div>
                <div class="stat-label">Total Orders</div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="stat-card" style="border-left-color: #3498db;">
                <div class="stat-icon" style="color: #3498db;">
                    <i class="fas fa-credit-card"></i>
                </div>
                <div class="stat-number">₹0</div>
                <div class="stat-label">Total Revenue</div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="stat-card" style="border-left-color: #f39c12;">
                <div class="stat-icon" style="color: #f39c12;">
                    <i class="fas fa-gem"></i>
                </div>
                <div class="stat-number">0</div>
                <div class="stat-label">Products</div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-bolt"></i> Quick Actions
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-primary w-100">
                                <i class="fas fa-users"></i> Manage Users
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.users.create') }}" class="btn btn-success w-100">
                                <i class="fas fa-user-plus"></i> Add New User
                            </a>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-info w-100">
                                <i class="fas fa-chart-line"></i> View Analytics
                            </button>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-warning w-100">
                                <i class="fas fa-cog"></i> Settings
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Users -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-list"></i> Recent Users
                </div>
                <div class="card-body">
                    @if($userCount > 0)
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Joined Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(\App\Models\User::latest()->limit(5)->get() as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>
                                            <strong>{{ $user->name }}</strong>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->created_at->format('d M, Y') }}</td>
                                        <td>
                                            <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-view">
                                                <i class="fas fa-eye"></i> View
                                            </a>
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
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-info" role="alert">
                            <i class="fas fa-info-circle"></i> No users found. <a href="{{ route('admin.users.create') }}">Create one now</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Admin Info Card -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-user-shield"></i> Admin Information
                </div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ Auth::guard('admin')->user()->name }}</p>
                    <p><strong>Email:</strong> {{ Auth::guard('admin')->user()->email }}</p>
                    <p><strong>Role:</strong> <span class="badge" style="background-color: #e74c3c; color: white;">Administrator</span></p>
                    <p><strong>Member Since:</strong> {{ Auth::guard('admin')->user()->created_at->format('d M, Y') }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-chart-pie"></i> System Status
                </div>
                <div class="card-body">
                    <p><strong>Database:</strong> <span class="badge" style="background-color: #27ae60; color: white;">Connected</span></p>
                    <p><strong>Server:</strong> <span class="badge" style="background-color: #27ae60; color: white;">Online</span></p>
                    <p><strong>Applications:</strong> <span class="badge" style="background-color: #27ae60; color: white;">Running</span></p>
                    <p><strong>Last Update:</strong> {{ now()->format('d M, Y H:i A') }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
