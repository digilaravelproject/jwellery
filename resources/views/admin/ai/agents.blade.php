@extends('layouts.admin')

@section('title', 'AI Agents Selection - Admin Panel')
@section('page-title', 'AI Agents Selection')

@section('content')
    <style>
        .agent-config-container {
            background: white;
            border-radius: 25px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-bottom: 25px;
        }

        .agent-config-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .agent-config-title i {
            color: var(--primary-yellow);
            font-size: 24px;
        }

        .agent-config-subtitle {
            color: #666;
            font-size: 14px;
            margin-bottom: 0;
        }

        .model-section {
            background: linear-gradient(135deg, #F9F7F2 0%, #FFFBF0 100%);
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 20px;
            border: 2px solid rgba(255, 217, 102, 0.2);
        }

        .model-field {
            margin-bottom: 20px;
        }

        .model-field label {
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .model-field input {
            border-radius: 20px;
            border: 2px solid #ddd;
            padding: 12px 16px;
            font-size: 14px;
            width: 100%;
            transition: all 0.3s ease;
            background-color: white;
        }

        .model-field input:focus {
            outline: none;
            border-color: var(--primary-yellow);
            box-shadow: 0 0 0 0.2rem rgba(255, 217, 102, 0.3);
            background-color: white;
        }

        .model-hint {
            font-size: 13px;
            color: #666;
            margin-top: 6px;
            font-style: italic;
        }

        .btn-save-config {
            background: linear-gradient(135deg, var(--primary-yellow) 0%, #f2cc5b 100%);
            border: none;
            color: var(--text-main);
            font-weight: 600;
            border-radius: 20px;
            padding: 12px 28px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-save-config:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 217, 102, 0.4);
            color: var(--text-main);
        }

        .alert-custom {
            background: rgba(255, 217, 102, 0.15);
            border: 2px solid rgba(255, 217, 102, 0.3);
            border-radius: 20px;
            padding: 18px 20px;
            color: #666;
            margin-bottom: 25px;
        }

        .alert-custom i {
            color: var(--primary-yellow);
            margin-right: 10px;
            font-weight: 600;
        }

        .alert-custom strong {
            color: var(--text-main);
        }

        .alert-custom ul {
            margin: 10px 0 0 20px;
        }

        .alert-custom li {
            margin-bottom: 5px;
            color: #555;
        }

        .provider-select {
            border-radius: 20px;
            border: 2px solid #ddd;
            padding: 12px 16px;
            max-width: 400px;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .provider-select:focus {
            outline: none;
            border-color: var(--primary-yellow);
            box-shadow: 0 0 0 0.2rem rgba(255, 217, 102, 0.3);
        }
    </style>

    <div class="container-fluid">
        <!-- Header -->
        <div class="agent-config-container">
            <div class="agent-config-title">
                <i class="fas fa-cogs"></i> AI Agent Configuration
            </div>
            <p class="agent-config-subtitle">Select which AI provider to use for different features in your application</p>
        </div>

        <!-- Jewelry Design Feature -->
        <div class="agent-config-container">
            <div class="agent-config-title">
                <i class="fas fa-ring"></i> Jewelry Design Generation
            </div>

            <!-- Feature Support Info -->
            <div class="alert-custom">
                <i class="fas fa-info-circle"></i>
                <strong>Feature Support:</strong>
                <ul class="mb-0 mt-2">
                    <li><strong>OpenAI:</strong> ✅ Full support (Sketch analysis + Image generation)</li>
                    <li><strong>Open Router:</strong> ⚠️ Partial support (Sketch analysis only - for image generation, you need OpenAI)</li>
                </ul>
            </div>

            <div style="margin-bottom: 25px;">
                <label style="font-weight: 600; color: var(--text-main); display: block; margin-bottom: 10px;">Select AI Provider</label>
                <select class="provider-select" id="design_provider" onchange="loadModels('design_generation')">
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

            <!-- Store current model values as data -->
            @php
                $currentSelection = $selections->where('feature', 'design_generation')->first();
            @endphp
            <div id="current_models" 
                data-vision="{{ $currentSelection?->vision_model }}"
                data-image="{{ $currentSelection?->image_model }}"
                data-text="{{ $currentSelection?->text_model }}"
                style="display: none;"></div>

            <div id="design_models" style="display: none;">
                <div id="provider_warning" class="alert-custom" style="display: none; margin-bottom: 20px;">
                    <i class="fas fa-exclamation-circle"></i>
                    <strong>Note:</strong> <span id="warning_text"></span>
                </div>

                <div class="model-section">
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
                        <div class="model-field">
                            <label for="design_vision_model"><i class="fas fa-eye" style="color: var(--primary-yellow);\"></i>Vision Model (for analyzing sketches)</label>
                            <input type="text" id="design_vision_model" placeholder="e.g., gpt-4o">
                            <div class="model-hint">Model used to analyze your jewelry sketches</div>
                        </div>

                        <div class="model-field">
                            <label for="design_image_model"><i class="fas fa-image" style="color: var(--primary-yellow);\"></i>Image Model (for generating designs)</label>
                            <input type="text" id="design_image_model" placeholder="e.g., dall-e-3">
                            <div class="model-hint">Model used to generate final jewelry images</div>
                        </div>

                        <div class="model-field">
                            <label for="design_text_model"><i class="fas fa-pen" style="color: var(--primary-yellow);\"></i>Text Model (for descriptions)</label>
                            <input type="text" id="design_text_model" placeholder="e.g., gpt-4o">
                            <div class="model-hint">Model used to generate text descriptions</div>
                        </div>
                    </div>
                </div>

                <button class="btn-save-config" onclick="saveAgentSelection('design_generation')">
                    <i class="fas fa-save"></i> Save Configuration
                </button>
            </div>
        </div>

        <!-- Additional Feature Placeholder -->
        <div class="agent-config-container">
            <div style="text-align: center; padding: 30px 0;">
                <i class="fas fa-star" style="font-size: 48px; color: var(--primary-yellow); margin-bottom: 15px; display: block;\"></i>
                <h5 style="color: var(--text-main); font-weight: 700; margin: 15px 0;\">More Features Coming Soon</h5>
                <p style="color: #666; margin: 0;\">Additional AI-powered features will be available in future updates</p>
            </div>
        </div>

        <!-- Current Configuration -->
        <div class="agent-config-container">
            <div class="agent-config-title">
                <i class="fas fa-info-circle"></i> Current Configuration
            </div>

            @if($selections->count() > 0)
                <div style="overflow-x: auto;">
                    <table class="table" style="margin: 0;">
                        <thead>
                            <tr>
                                <th style="font-weight: 700; padding: 15px 20px; border-bottom: 2px solid #ddd;">Feature</th>
                                <th style="font-weight: 700; padding: 15px 20px; border-bottom: 2px solid #ddd;">Provider</th>
                                <th style="font-weight: 700; padding: 15px 20px; border-bottom: 2px solid #ddd;">Models</th>
                                <th style="font-weight: 700; padding: 15px 20px; border-bottom: 2px solid #ddd;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($selections as $selection)
                                <tr style="border-bottom: 1px solid #eee;">
                                    <td style="padding: 15px 20px; color: var(--text-main);">
                                        <strong>{{ ucwords(str_replace('_', ' ', $selection->feature)) }}</strong>
                                    </td>
                                    <td style="padding: 15px 20px; color: #666;">
                                        <i class="fas {{ $selection->credential->provider->name === 'openai' ? 'fa-brain' : 'fa-route' }}" style="color: var(--primary-yellow); margin-right: 8px;\"></i>
                                        {{ $selection->credential->provider->display_name }}
                                    </td>
                                    <td style="padding: 15px 20px;">
                                        <small style="display: flex; gap: 6px; flex-wrap: wrap;">
                                            @if($selection->vision_model)
                                                <span style="background-color: var(--primary-yellow); color: var(--text-main); padding: 4px 10px; border-radius: 15px; font-weight: 500; font-size: 12px;">Vision: {{ $selection->vision_model }}</span>
                                            @endif
                                            @if($selection->image_model)
                                                <span style="background-color: #3498db; color: white; padding: 4px 10px; border-radius: 15px; font-weight: 500; font-size: 12px;">Image: {{ $selection->image_model }}</span>
                                            @endif
                                            @if($selection->text_model)
                                                <span style="background-color: #666; color: white; padding: 4px 10px; border-radius: 15px; font-weight: 500; font-size: 12px;">Text: {{ $selection->text_model }}</span>
                                            @endif
                                        </small>
                                    </td>
                                    <td style="padding: 15px 20px;">
                                        @if($selection->is_active)
                                            <span style="background-color: #27ae60; color: white; padding: 4px 12px; border-radius: 15px; font-weight: 500; font-size: 12px;\">Active</span>
                                        @else
                                            <span style="background-color: #999; color: white; padding: 4px 12px; border-radius: 15px; font-weight: 500; font-size: 12px;\">Inactive</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p style="color: #666; font-size: 14px; margin: 0;\">No AI agents configured yet. Please configure above.</p>
            @endif
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
