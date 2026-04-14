@extends('layouts.admin')

@section('title', 'AI Agents Selection - Admin Panel')
@section('page-title', 'AI Agents Selection')

@section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-md-12">
                <h3><i class="fas fa-cogs"></i> AI Agent Configuration</h3>
                <p class="text-muted">Select which AI provider to use for different features in your application</p>
            </div>
        </div>

        <!-- Jewelry Design Feature -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-ring"></i> Jewelry Design Generation
                    </div>
                    <div class="card-body">
                        <!-- Feature Support Info -->
                        <div class="alert alert-info" role="alert">
                            <i class="fas fa-info-circle"></i>
                            <strong>Feature Support:</strong>
                            <ul class="mb-0 mt-2">
                                <li><strong>OpenAI:</strong> ✅ Full support (Sketch analysis + Image generation)</li>
                                <li><strong>Open Router:</strong> ⚠️ Partial support (Sketch analysis only - for image generation, you need OpenAI)</li>
                            </ul>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Select AI Provider</label>
                                <select class="form-control" id="design_provider" onchange="loadModels('design_generation')">
                                    <option value="">-- Select Provider --</option>
                                    @foreach($activeCredentials as $credential)
                                        <option value="{{ $credential->id }}" 
                                            {{ $selections->where('feature', 'design_generation')->first()?->ai_credential_id == $credential->id ? 'selected' : '' }}
                                            data-provider="{{ $credential->provider->name }}">
                                            {{ $credential->provider->display_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Store current model values as data -->
                        @php
                            $currentSelection = $selections->where('feature', 'design_generation')->first();
                        @endphp
                        <div id="current_models" 
                            data-vision="{{ $currentSelection?->vision_model }}"
                            data-image="{{ $currentSelection?->image_model }}"
                            data-text="{{ $currentSelection?->text_model }}"
                            style="display: none;"></div>

                        <div id="design_models" class="row" style="display: none;">
                            <div class="col-md-12 mb-3">
                                <div id="provider_warning" class="alert alert-warning d-none" role="alert">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <strong>Note:</strong> <span id="warning_text"></span>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="design_vision_model" class="form-label">Vision Model (for analyzing sketches)</label>
                                <input type="text" class="form-control" id="design_vision_model" placeholder="e.g., gpt-4o">
                                <small class="form-text text-muted">Model used to analyze your jewelry sketches</small>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="design_image_model" class="form-label">Image Model (for generating designs)</label>
                                <input type="text" class="form-control" id="design_image_model" placeholder="e.g., dall-e-3">
                                <small class="form-text text-muted">Model used to generate final jewelry images</small>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="design_text_model" class="form-label">Text Model (for descriptions)</label>
                                <input type="text" class="form-control" id="design_text_model" placeholder="e.g., gpt-4o">
                                <small class="form-text text-muted">Model used to generate text descriptions</small>
                            </div>
                        </div>

                        <button class="btn btn-success" onclick="saveAgentSelection('design_generation')">
                            <i class="fas fa-save"></i> Save Configuration
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Feature Placeholder -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-star" style="font-size: 36px; color: #ffc107; margin-bottom: 15px;"></i>
                        <h5>More Features Coming Soon</h5>
                        <p class="text-muted">Additional AI-powered features will be available in future updates</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Current Configuration -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-info-circle"></i> Current Configuration
                    </div>
                    <div class="card-body">
                        @if($selections->count() > 0)
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Feature</th>
                                        <th>Provider</th>
                                        <th>Models</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($selections as $selection)
                                        <tr>
                                            <td>
                                                <strong>{{ ucwords(str_replace('_', ' ', $selection->feature)) }}</strong>
                                            </td>
                                            <td>
                                                <i class="fas {{ $selection->credential->provider->name === 'openai' ? 'fa-brain' : 'fa-route' }}"></i>
                                                {{ $selection->credential->provider->display_name }}
                                            </td>
                                            <td>
                                                <small>
                                                    @if($selection->vision_model)
                                                        <span class="badge bg-primary">Vision: {{ $selection->vision_model }}</span>
                                                    @endif
                                                    @if($selection->image_model)
                                                        <span class="badge bg-info">Image: {{ $selection->image_model }}</span>
                                                    @endif
                                                    @if($selection->text_model)
                                                        <span class="badge bg-secondary">Text: {{ $selection->text_model }}</span>
                                                    @endif
                                                </small>
                                            </td>
                                            <td>
                                                @if($selection->is_active)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-secondary">Inactive</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-muted">No AI agents configured yet. Please configure above.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        // Model presets for different providers
        const modelPresets = {
            'openai': {
                vision_model: 'gpt-4o',
                image_model: 'dall-e-3',
                text_model: 'gpt-4o'
            },
            'openrouter': {
                vision_model: 'google/gemma-4-31b-it:free',
                image_model: 'N/A (Use OpenAI for image generation)',
                text_model: 'mistral/mistral-7b-instruct'
            }
        };

        // Get provider name from id
        function getProviderName(credentialId) {
            if (!credentialId) return null;
            
            // First try to get from data attribute
            const option = document.querySelector(`#design_provider option[value="${credentialId}"]`);
            if (option && option.dataset.provider) {
                return option.dataset.provider;
            }
            
            // Fallback to loop
            @foreach($activeCredentials as $credential)
                if ({{ $credential->id }} === parseInt(credentialId)) {
                    return '{{ $credential->provider->name }}';
                }
            @endforeach
            return null;
        }

        function loadModels(feature) {
            const selectId = feature === 'design_generation' ? 'design_provider' : null;
            
            if (!selectId) return;

            const select = document.getElementById(selectId);
            const credentialId = select.value;

            if (!credentialId) {
                document.getElementById('design_models').style.display = 'none';
                return;
            }

            const providerName = getProviderName(credentialId);
            const models = modelPresets[providerName] || {};

            // Show provider-specific warnings
            const warningDiv = document.getElementById('provider_warning');
            const warningText = document.getElementById('warning_text');
            
            if (providerName === 'openrouter') {
                warningText.innerHTML = 'Open Router is selected for sketch analysis and text. Image generation models should be set to a valid service (N/A indicates you need another provider for image generation).';
                warningDiv.classList.remove('d-none');
            } else {
                warningDiv.classList.add('d-none');
            }

            if (feature === 'design_generation') {
                // Always use presets when loading, not stored values
                document.getElementById('design_vision_model').value = models.vision_model || '';
                document.getElementById('design_image_model').value = models.image_model || '';
                document.getElementById('design_text_model').value = models.text_model || '';
                document.getElementById('design_models').style.display = 'block';
            }
        }

        function saveAgentSelection(feature) {
            const selectId = feature === 'design_generation' ? 'design_provider' : null;
            
            if (!selectId) {
                alert('Invalid feature');
                return;
            }

            const credentialId = document.getElementById(selectId).value;
            const visionModel = document.getElementById('design_vision_model').value;
            const imageModel = document.getElementById('design_image_model').value;
            const textModel = document.getElementById('design_text_model').value;

            // Validation
            if (!credentialId) {
                alert('❌ Please select an AI provider');
                return;
            }

            if (!visionModel || !imageModel || !textModel) {
                alert('❌ Please fill in all model fields:\n- Vision Model: ' + (visionModel || 'MISSING') + '\n- Image Model: ' + (imageModel || 'MISSING') + '\n- Text Model: ' + (textModel || 'MISSING'));
                return;
            }

            const data = {
                feature: feature,
                ai_credential_id: credentialId,
                vision_model: visionModel,
                image_model: imageModel,
                text_model: textModel,
            };

            // Log what we're sending
            console.log('📤 Sending agent selection data:', data);

            axios.post('{{ route("admin.ai.agents.select") }}', data)
                .then(response => {
                    console.log('✅ Server response:', response.data);
                    if (response.data.success) {
                        alert('✓ SAVED!\n\nProvider: Open Router\nVision: ' + visionModel + '\nImage: ' + imageModel + '\nText: ' + textModel + '\n\nPlease close this and test the design generation.');
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        alert('⚠️ Unexpected response: ' + response.data.message);
                    }
                })
                .catch(error => {
                    console.error('❌ Request failed:', error);
                    console.error('Status:', error.response?.status);
                    console.error('Data:', error.response?.data);
                    
                    let errorMsg = 'Unknown error occurred';
                    if (error.response?.data?.message) {
                        errorMsg = error.response.data.message;
                    } else if (error.message) {
                        errorMsg = error.message;
                    }
                    
                    alert('❌ Error saving configuration:\n\n' + errorMsg);
                });
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            // If there's a currently selected provider, load its models
            const designProvider = document.getElementById('design_provider');
            if (designProvider && designProvider.value) {
                loadModels('design_generation');
            }
        });
    </script>

    <style>
        .card-header {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 15px 20px;
            font-weight: 600;
        }

        .badge {
            margin-right: 5px;
            margin-bottom: 5px;
        }
    </style>
@endsection
