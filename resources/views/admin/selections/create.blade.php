@extends('layouts.admin')

@section('title', 'Add New Selection - Admin Dashboard')
@section('page-title', 'Add New Selection')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-plus-circle"></i> Create New Design Selection
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> <strong>Validation Errors:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('admin.selections.store') }}" method="POST">
                    @csrf

                    <!-- Title -->
                    <div class="form-group mb-4">
                        <label for="title" class="form-label">
                            <i class="fas fa-heading"></i> Selection Title
                        </label>
                        <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" 
                               placeholder="e.g., Metal Type, Stone Type, Design Style" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">This title will be displayed to users</small>
                    </div>

                    <!-- Prompt Template -->
                    <div class="form-group mb-4">
                        <label for="prompt_template" class="form-label">
                            <i class="fas fa-file-alt"></i> Prompt Template
                        </label>
                        <input type="text" id="prompt_template" name="prompt_template" class="form-control @error('prompt_template') is-invalid @enderror" 
                               placeholder="e.g., The jewelry should be made of {value}" value="{{ old('prompt_template', 'Incorporate {value}') }}">
                        @error('prompt_template')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Use {value} as placeholder for the selected option</small>
                    </div>

                    <!-- Values -->
                    <div class="form-group mb-4">
                        <label class="form-label">
                            <i class="fas fa-list"></i> Selection Values
                        </label>
                        <div id="valuesContainer">
                            @if(old('values'))
                                @foreach(old('values') as $index => $value)
                                    <div class="input-group mb-3 value-item">
                                        <input type="text" name="values[]" class="form-control" 
                                               placeholder="Enter value (e.g., Gold, Silver)" value="{{ $value }}" required>
                                        <button type="button" class="btn btn-outline-danger" onclick="removeValue(this)">
                                            <i class="fas fa-times"></i> Remove
                                        </button>
                                    </div>
                                @endforeach
                            @else
                                <div class="input-group mb-3 value-item">
                                    <input type="text" name="values[]" class="form-control" 
                                           placeholder="Enter value (e.g., Gold, Silver)" required>
                                    <button type="button" class="btn btn-outline-danger" onclick="removeValue(this)">
                                        <i class="fas fa-times"></i> Remove
                                    </button>
                                </div>
                                <div class="input-group mb-3 value-item">
                                    <input type="text" name="values[]" class="form-control" 
                                           placeholder="Enter value (e.g., Gold, Silver)">
                                    <button type="button" class="btn btn-outline-danger" onclick="removeValue(this)">
                                        <i class="fas fa-times"></i> Remove
                                    </button>
                                </div>
                            @endif
                        </div>
                        <button type="button" class="btn btn-sm mt-2" style="background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); color: white; border-radius: 15px;" onclick="addValue()">
                            <i class="fas fa-plus"></i> Add Another Value
                        </button>
                        @error('values')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Active Status -->
                    <div class="form-group mb-4">
                        <div class="form-check">
                            <input type="checkbox" id="is_active" name="is_active" class="form-check-input" value="1" 
                                   {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                <i class="fas fa-eye"></i> Active (Display to Users)
                            </label>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="form-group">
                        <button type="submit" class="btn" style="background: linear-gradient(135deg, #27ae60 0%, #229954 100%); color: white; border-radius: 20px; font-weight: 600; padding: 10px 25px;">
                            <i class="fas fa-save"></i> Create Selection
                        </button>
                        <a href="{{ route('admin.selections.index') }}" class="btn" style="background: #999; color: white; border-radius: 20px; font-weight: 600; padding: 10px 25px;">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function addValue() {
        const container = document.getElementById('valuesContainer');
        const template = `<div class="input-group mb-3 value-item">
                            <input type="text" name="values[]" class="form-control" 
                                   placeholder="Enter value (e.g., Gold, Silver)">
                            <button type="button" class="btn btn-outline-danger" onclick="removeValue(this)">
                                <i class="fas fa-times"></i> Remove
                            </button>
                        </div>`;
        container.insertAdjacentHTML('beforeend', template);
    }

    function removeValue(button) {
        const items = document.querySelectorAll('.value-item');
        if (items.length > 1) {
            button.closest('.value-item').remove();
        } else {
            alert('You must have at least one value!');
        }
    }
</script>
@endsection
