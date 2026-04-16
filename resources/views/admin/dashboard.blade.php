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
                    <i class="fas fa-robot"></i>
                </div>
                <div class="stat-number">{{ \App\Models\AICredential::count() }}</div>
                <div class="stat-label">AI Credentials</div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="stat-card" style="border-left-color: #3498db;">
                <div class="stat-icon" style="color: #3498db;">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-number">{{ \App\Models\AISelection::active()->count() }}</div>
                <div class="stat-label">Active Selections</div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="stat-card" style="border-left-color: #FFD966;">
                <div class="stat-icon" style="color: #FFD966;">
                    <i class="fas fa-list-check"></i>
                </div>
                <div class="stat-number">{{ \App\Models\AIPrompt::count() }}</div>
                <div class="stat-label">AI Prompts</div>
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
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('admin.users.index') }}" class="btn w-100" style="background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); color: white; border-radius: 20px; font-weight: 600; padding: 12px 20px;">
                                <i class="fas fa-users"></i> Manage Users
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('admin.ai.credentials') }}" class="btn w-100" style="background: linear-gradient(135deg, #27ae60 0%, #229954 100%); color: white; border-radius: 20px; font-weight: 600; padding: 12px 20px;">
                                <i class="fas fa-key"></i> AI Credentials
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('admin.analytics.index') }}" class="btn w-100" style="background: linear-gradient(135deg, #FFD966 0%, #f2cc5b 100%); color: #2D2D2D; border-radius: 20px; font-weight: 600; padding: 12px 20px;">
                                <i class="fas fa-chart-line"></i> View Analytics
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('admin.selections.index') }}" class="btn w-100" style="background: linear-gradient(135deg, #9b59b6 0%, #8e44ad 100%); color: white; border-radius: 20px; font-weight: 600; padding: 12px 20px;">
                                <i class="fas fa-layer-group"></i> Selections
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Users -->
    <div class="row mb-4">
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
                                        <td><strong>#{{ $user->id }}</strong></td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->created_at->format('d M, Y') }}</td>
                                        <td>
                                            <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-view" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-edit" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline; margin: 0;" 
                                                  onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-delete" title="Delete">
                                                    <i class="fas fa-trash"></i>
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

    <!-- Admin Information -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-user-shield"></i> Admin Information
                </div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ Auth::guard('admin')->user()->name }}</p>
                    <p><strong>Email:</strong> {{ Auth::guard('admin')->user()->email }}</p>
                    <p><strong>Role:</strong> <span class="badge" style="background-color: #FFD966; color: #2D2D2D; font-weight: 600;">Administrator</span></p>
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
