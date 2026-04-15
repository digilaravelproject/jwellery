@extends('layouts.admin')

@section('title', 'Design Analytics - Admin Dashboard')
@section('page-title', 'Design Generation Analytics')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-chart-bar"></i> Design Generation Records
                </h5>
                <small class="text-muted">Total: {{ $designGenerations->total() }} records</small>
            </div>
            <div class="card-body">
                @if($designGenerations->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Design Type</th>
                                    <th>AI Provider</th>
                                    <th>Prompt (Preview)</th>
                                    <th>Generated</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($designGenerations as $design)
                                    <tr>
                                        <td><strong>#{{ $design->id }}</strong></td>
                                        <td>
                                            <i class="fas fa-user-circle"></i>
                                            {{ $design->user->name ?? 'N/A' }}<br>
                                            <small class="text-muted">{{ $design->user->email ?? 'N/A' }}</small>
                                        </td>
                                        <td>
                                            @if($design->design_type === 'image')
                                                <span class="badge bg-primary">
                                                    <i class="fas fa-image"></i> Image
                                                </span>
                                            @else
                                                <span class="badge bg-info">
                                                    <i class="fas fa-file-alt"></i> Specification
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">{{ ucfirst($design->ai_provider ?? 'Unknown') }}</span>
                                        </td>
                                        <td>
                                            <small style="max-width: 250px; display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                {{ substr($design->prompt, 0, 100) }}...
                                            </small>
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ $design->created_at->format('d M Y H:i') }}</small>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.analytics.show', $design->id) }}" class="btn btn-view btn-action" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <form action="{{ route('admin.analytics.destroy', $design->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this record? This will also delete the associated files.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-delete btn-action" title="Delete">
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
                    <div class="d-flex justify-content-center mt-4">
                        {{ $designGenerations->links() }}
                    </div>
                @else
                    <div class="alert alert-info" role="alert">
                        <i class="fas fa-info-circle"></i> No design generation records found yet.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
