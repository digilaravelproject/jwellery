@extends('layouts.admin')

@section('title', 'Manage Users - Admin Dashboard')
@section('page-title', 'Manage Users')

@section('content')
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Manage Users</li>
        </ol>
    </nav>

    <!-- Action Buttons -->
    <div class="mb-4">
        <a href="{{ route('admin.users.create') }}" class="btn btn-success">
            <i class="fas fa-user-plus"></i> Add New User
        </a>
        <button class="btn btn-secondary" onclick="location.reload()">
            <i class="fas fa-sync"></i> Refresh
        </button>
    </div>

    <!-- Users Table -->
    <div class="card">
        <div class="card-header">
            <i class="fas fa-table"></i> Users List ({{ $users->total() }} Total)
        </div>
        <div class="card-body">
            @if($users->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Joined Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td><strong>#{{ $user->id }}</strong></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #2c3e50, #34495e); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; margin-right: 10px;">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                            <span>{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at->format('d M, Y') }}</td>
                                    <td>
                                        <span class="badge" style="background-color: #27ae60; color: white;">
                                            <i class="fas fa-check-circle"></i> Active
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-view" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-edit" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline;" 
                                              onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
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
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $users->links() }}
                </div>
            @else
                <div class="alert alert-info text-center py-5" role="alert">
                    <i class="fas fa-inbox" style="font-size: 48px; color: #17a2b8; margin-bottom: 15px;"></i>
                    <h5>No Users Found</h5>
                    <p class="mb-0">There are no users in the system yet.</p>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-user-plus"></i> Create First User
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Stats Card -->
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-number">{{ $users->total() }}</div>
                <div class="stat-label">Total Users</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card" style="border-left-color: #27ae60;">
                <div class="stat-icon" style="color: #27ae60;">
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="stat-number">{{ $users->total() }}</div>
                <div class="stat-label">Active Users</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card" style="border-left-color: #3498db;">
                <div class="stat-icon" style="color: #3498db;">
                    <i class="fas fa-user-clock"></i>
                </div>
                <div class="stat-number">0</div>
                <div class="stat-label">New This Month</div>
            </div>
        </div>
    </div>
@endsection
