@extends('layouts.admin')

@section('page-title', 'Manage AI Prompts')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-comment-dots"></i> AI Prompts</h5>
        <?php /*<button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#addPromptModal" style="color: var(--primary-color); font-weight: bold;">
            <i class="fas fa-plus"></i> Add New Prompt
        </button>*/ ?>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th width="20%">Title</th>
                        <th width="45%">Prompt Text</th>
                        <th width="15%">Status</th>
                        <th width="15%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($prompts as $prompt)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong>{{ $prompt->title }}</strong></td>
                        <td>{{ Str::limit($prompt->prompt_text, 100) }}</td>
                        <td>
                            @if($prompt->is_active)
                                <span class="badge bg-success"><i class="fas fa-check-circle"></i> Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td>
                            @if(!$prompt->is_active)
                            <form action="{{ route('admin.ai.prompts.activate', $prompt->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success" title="Set Active" style="padding: 5px 10px; font-size: 12px; margin-right: 5px;">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            @endif

                            <button type="button" class="btn btn-sm btn-edit" title="Edit" data-bs-toggle="modal" data-bs-target="#editPromptModal{{ $prompt->id }}" style="padding: 5px 10px; font-size: 12px; margin-right: 5px;">
                                <i class="fas fa-edit"></i>
                            </button>
                            
                            <!-- <form action="{{ route('admin.ai.prompts.delete', $prompt->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this prompt?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-delete" title="Delete" style="padding: 5px 10px; font-size: 12px;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form> -->
                        </td>
                    </tr>

                    <!-- Edit Prompt Modal -->
                    <div class="modal fade" id="editPromptModal{{ $prompt->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit AI Prompt</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('admin.ai.prompts.update', $prompt->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Title</label>
                                            <input type="text" name="title" class="form-control" value="{{ $prompt->title }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Prompt Text</label>
                                            <textarea name="prompt_text" class="form-control" rows="8" required>{{ $prompt->prompt_text }}</textarea>
                                            <small class="text-muted">This prompt will be used to instruct the AI algorithm when generating jewelry images.</small>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary" style="background-color: var(--primary-color);">Update Prompt</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            <i class="fas fa-comment-dots" style="font-size: 24px; color: #ccc;"></i><br>
                            No AI prompts found. Add one to get started!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Prompt Modal -->
<div class="modal fade" id="addPromptModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New AI Prompt</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.ai.prompts.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" placeholder="e.g. Default Jewelry Settings" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Prompt Text</label>
                        <textarea name="prompt_text" class="form-control" rows="8" placeholder="Enter instructions for the AI like: You are a jewelry designer..." required>You are a jewelry designer. Analyze this hand-drawn jewelry sketch and create a detailed, descriptive specification for a professional, luxury jewelry design. Include: jewelry type, style details, materials (gold, silver, diamonds, gems, etc.), design elements, dimensions, estimated craftsmanship time, and overall aesthetic. Format as a clear, professional jewelry design specification.</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="background-color: var(--primary-color);">Save Prompt</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
