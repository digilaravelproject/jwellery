@extends('layouts.admin')

@section('title', 'View Design - Admin Dashboard')
@section('page-title', 'View Design Generation #' . $design->id)

@section('content')
<div class="row">
    <div class="col-md-12">
        <a href="{{ route('admin.analytics.index') }}" class="btn btn-sm mb-3" style="background: #999; color: white; border-radius: 15px;">
            <i class="fas fa-arrow-left"></i> Back to Records
        </a>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-gem"></i> Design Generation Details - Record #{{ $design->id }}
                </h5>
            </div>
            <div class="card-body">
                <!-- User Information -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 style="color: var(--primary-color); font-weight: bold; margin-bottom: 15px;">
                            <i class="fas fa-user"></i> User Information
                        </h6>
                        <table class="table table-sm" style="border: none;">
                            <tr>
                                <td style="border: none;"><strong>Name:</strong></td>
                                <td style="border: none;">{{ $design->user->name }}</td>
                            </tr>
                            <tr>
                                <td style="border: none;"><strong>Email:</strong></td>
                                <td style="border: none;">{{ $design->user->email }}</td>
                            </tr>
                            <tr>
                                <td style="border: none;"><strong>User ID:</strong></td>
                                <td style="border: none;">#{{ $design->user->id }}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-6">
                        <h6 style="color: var(--primary-yellow); font-weight: bold; margin-bottom: 15px;">
                            <i class="fas fa-info-circle"></i> Design Information
                        </h6>
                        <table class="table table-sm" style="border: none;">
                            <tr>
                                <td style="border: none;"><strong>Record ID:</strong></td>
                                <td style="border: none;">#{{ $design->id }}</td>
                            </tr>
                            <tr>
                                <td style="border: none;"><strong>Design Type:</strong></td>
                                <td style="border: none;">
                                    @if($design->design_type === 'image')
                                        <span class="badge" style="background-color: #3498db; color: white;"><i class="fas fa-image"></i> Image</span>
                                    @else
                                        <span class="badge" style="background-color: #9b59b6; color: white;"><i class="fas fa-file-alt"></i> Specification</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td style="border: none;"><strong>AI Provider:</strong></td>
                                <td style="border: none;"><span class="badge" style="background-color: #FFD966; color: #2D2D2D; font-weight: 600;">{{ ucfirst($design->ai_provider ?? 'Unknown') }}</span></td>
                            </tr>
                            <tr>
                                <td style="border: none;"><strong>Generated:</strong></td>
                                <td style="border: none;">{{ $design->created_at->format('d M Y, H:i:s') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <hr>

                <!-- Sketch Image -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 style="color: var(--primary-color); font-weight: bold; margin-bottom: 15px;">
                            <i class="fas fa-image"></i> Uploaded Sketch
                        </h6>
                        @if(!empty($design->sketch_path))
                            <img src="{{ asset('storage/app/public/' . $design->sketch_path) }}"
                            alt="Sketch" style="max-width: 100%; height: auto; border-radius: 8px; border: 1px solid #ddd;">
                            <p class="mt-2 text-muted"><small>Path: {{ $design->sketch_path }}</small></p>
                        @else
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i> Sketch file not available
                            </div>
                        @endif
                    </div>

                    <!-- Generated Design -->
                    <div class="col-md-6">
                        <h6 style="color: var(--primary-yellow); font-weight: bold; margin-bottom: 15px;">
                            <i class="fas fa-wand-magic-sparkles"></i> Generated Design
                        </h6>
                        @if($design->design_type === 'image' && !empty($design->generated_design_path))
                            <img src="{{ asset('storage/app/public/' . $design->generated_design_path) }}" alt="Generated Design" style="max-width: 100%; height: auto; border-radius: 8px; border: 1px solid #ddd;">
                            <p class="mt-2 text-muted"><small>Path: {{ $design->generated_design_path }}</small></p>
                        @else
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> This record contains a design specification instead of an image
                            </div>
                        @endif
                    </div>
                </div>

                <hr>

                <!-- Prompt -->
                <div class="mb-4">
                    <h6 style="color: var(--primary-yellow); font-weight: bold; margin-bottom: 15px;">
                        <i class="fas fa-file-alt"></i> Generation Prompt
                    </h6>
                    <div style="background-color: #f0f0f0; border: 2px solid #FFD966; border-radius: 20px; padding: 15px; max-height: 300px; overflow-y: auto;">
                        <p style="font-size: 13px; color: #666; margin: 0; white-space: pre-wrap; word-wrap: break-word;">
                            {{ $design->prompt }}
                        </p>
                    </div>
                </div>

                <!-- Design Specification -->
                <div class="mb-4">
                    <h6 style="color: var(--primary-yellow); font-weight: bold; margin-bottom: 15px;">
                        <i class="fas fa-description"></i> Design Specification/Description
                    </h6>
                    <div style="background-color: #f0f0f0; border: 2px solid #FFD966; border-radius: 20px; padding: 15px; max-height: 300px; overflow-y: auto;">
                        <p style="font-size: 13px; color: #666; margin: 0; white-space: pre-wrap; word-wrap: break-word;">
                            {{ $design->design_specification }}
                        </p>
                    </div>
                </div>

                <hr>

                <!-- Actions -->
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.analytics.index') }}" class="btn" style="background: #999; color: white; border-radius: 20px; font-weight: 600;">
                        <i class="fas fa-arrow-left"></i> Back to Records
                    </a>
                    <form action="{{ route('admin.analytics.destroy', $design->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure? This will delete the record and associated files.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn" style="background: #dc3545; color: white; border-radius: 20px; font-weight: 600;">
                            <i class="fas fa-trash"></i> Delete Record
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
