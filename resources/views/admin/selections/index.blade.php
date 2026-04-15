@extends('layouts.admin')

@section('title', 'Manage Selections - Admin Dashboard')
@section('page-title', 'Manage Design Selections')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-layer-group"></i> Design Selections
                </h5>
                <a href="{{ route('admin.selections.create') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-plus"></i> Add New Selection
                </a>
            </div>
            <div class="card-body">
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

                @if($selections->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="30%">Title</th>
                                    <th width="40%">Values</th>
                                    <th width="15%">Status</th>
                                    <th width="15%" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($selections as $selection)
                                    <tr>
                                        <td>
                                            <strong>{{ $selection->title }}</strong>
                                        </td>
                                        <td>
                                            <div style="max-height: 60px; overflow-y: auto;">
                                                @foreach($selection->values as $value)
                                                    <span class="badge bg-info" style="margin-right: 5px; margin-bottom: 3px;">{{ $value }}</span>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td>
                                            @if($selection->is_active)
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check-circle"></i> Active
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">
                                                    <i class="fas fa-times-circle"></i> Inactive
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.selections.edit', $selection->id) }}" class="btn btn-edit btn-action" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.selections.destroy', $selection->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this selection?');">
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
                @else
                    <div class="alert alert-info" role="alert">
                        <i class="fas fa-info-circle"></i> No selections found. 
                        <a href="{{ route('admin.selections.create') }}">Create your first selection</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
