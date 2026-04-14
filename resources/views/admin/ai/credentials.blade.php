@extends('layouts.admin')

@section('title', 'AI Credentials Management - Admin Panel')
@section('page-title', 'AI Credentials Management')

@section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <h3><i class="fas fa-key"></i> API Credentials</h3>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCredentialModal">
                        <i class="fas fa-plus"></i> Add API Key
                    </button>
                </div>
            </div>
        </div>

        <!-- AI Credentials List -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @if($credentials->count() > 0)
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Provider</th>
                                        <th>Status</th>
                                        <th>Last Tested</th>
                                        <th>Default</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($credentials as $credential)
                                        <tr>
                                            <td>
                                                <i class="fas {{ $credential->provider->name === 'openai' ? 'fa-brain' : 'fa-route' }}"></i>
                                                {{ $credential->provider->display_name }}
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $credential->status === 'active' ? 'success' : ($credential->status === 'error' ? 'danger' : 'warning') }}">
                                                    {{ ucfirst($credential->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($credential->last_tested_at)
                                                    {{ \Carbon\Carbon::parse($credential->last_tested_at)->diffForHumans() }}
                                                @else
                                                    <span class="text-muted">Never</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($credential->is_default)
                                                    <i class="fas fa-star text-warning"></i> Yes
                                                @else
                                                    <span class="text-muted">No</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-info" onclick="testCredential({{ $credential->id }})">
                                                    <i class="fas fa-flask"></i> Test
                                                </button>
                                                <button class="btn btn-sm btn-warning" onclick="editCredential({{ $credential->id }})">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>
                                                <button class="btn btn-sm btn-danger" onclick="deleteCredential({{ $credential->id }})">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-inbox" style="font-size: 48px; color: #ccc; margin-bottom: 20px;"></i>
                                <p class="text-muted">No API credentials added yet</p>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCredentialModal">
                                    <i class="fas fa-plus"></i> Add Your First API Key
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Add/Edit Credential Modal -->
        <div class="modal fade" id="addCredentialModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-key"></i> Add API Credential
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form id="credentialForm" onsubmit="submitCredentialForm(event)">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="ai_provider_id" class="form-label">AI Provider</label>
                                <select class="form-control" id="ai_provider_id" name="ai_provider_id" required>
                                    <option value="">-- Select Provider --</option>
                                    @foreach($providers as $provider)
                                        <option value="{{ $provider->id }}">{{ $provider->display_name }}</option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Select the AI provider you want to add credentials for</small>
                            </div>

                            <div class="mb-3">
                                <label for="api_key" class="form-label">API Key</label>
                                <input type="password" class="form-control" id="api_key" name="api_key" required placeholder="Enter your API key">
                                <small class="form-text text-muted">Your API key will be encrypted and stored securely</small>
                            </div>

                            <!-- Provider Info -->
                            <div id="providerInfo" class="alert alert-info d-none">
                                <p id="providerInfoText"></p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Credential
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        const providerInfo = {
            'openai': '<strong>OpenAI API Key:</strong> Get your API key from <a href="https://platform.openai.com/api-keys" target="_blank">OpenAI Platform</a>',
            'openrouter': '<strong>Open Router API Key:</strong> Get your API key from <a href="https://openrouter.ai" target="_blank">Open Router</a>'
        };

        document.getElementById('ai_provider_id').addEventListener('change', function() {
            const providerId = this.value;
            const selectedOption = this.options[this.selectedIndex];
            const providerName = selectedOption.text.toLowerCase().includes('openai') ? 'openai' : 'openrouter';

            const infoDiv = document.getElementById('providerInfo');
            const infoText = document.getElementById('providerInfoText');

            if (providerInfo[providerName]) {
                infoText.innerHTML = providerInfo[providerName];
                infoDiv.classList.remove('d-none');
            } else {
                infoDiv.classList.add('d-none');
            }
        });

        function submitCredentialForm(event) {
            event.preventDefault();

            const formData = new FormData(document.getElementById('credentialForm'));

            axios.post('{{ route("admin.ai.credentials.store") }}', formData)
                .then(response => {
                    if (response.data.success) {
                        alert('API Credential added successfully!');
                        document.getElementById('credentialForm').reset();
                        const modal = bootstrap.Modal.getInstance(document.getElementById('addCredentialModal'));
                        modal.hide();
                        location.reload();
                    }
                })
                .catch(error => {
                    let message = 'Error adding credential';
                    if (error.response && error.response.data && error.response.data.message) {
                        message = error.response.data.message;
                    }
                    alert(message);
                });
        }

        function testCredential(credentialId) {
            if (confirm('Test this API credential?')) {
                axios.post(`{{ url('/admin/ai/credentials') }}/${credentialId}/test`)
                    .then(response => {
                        if (response.data.success) {
                            alert('✓ API Key is valid and working!');
                            location.reload();
                        } else {
                            alert('✗ API Key test failed: ' + response.data.message);
                        }
                    })
                    .catch(error => {
                        alert('Error testing credential: ' + (error.response?.data?.message || 'Unknown error'));
                    });
            }
        }

        function editCredential(credentialId) {
            const apiKey = prompt('Enter new API key (leave empty to keep current):');
            if (apiKey !== null && apiKey !== '') {
                axios.put(`{{ url('/admin/ai/credentials') }}/${credentialId}`, {
                    api_key: apiKey
                })
                    .then(response => {
                        if (response.data.success) {
                            alert('Credential updated successfully!');
                            location.reload();
                        }
                    })
                    .catch(error => {
                        alert('Error updating credential: ' + (error.response?.data?.message || 'Unknown error'));
                    });
            }
        }

        function deleteCredential(credentialId) {
            if (confirm('Are you sure you want to delete this credential?')) {
                axios.delete(`{{ url('/admin/ai/credentials') }}/${credentialId}`)
                    .then(response => {
                        if (response.data.success) {
                            alert('Credential deleted successfully!');
                            location.reload();
                        }
                    })
                    .catch(error => {
                        alert('Error deleting credential: ' + (error.response?.data?.message || 'Unknown error'));
                    });
            }
        }
    </script>

    <style>
        .modal-content {
            border-radius: 8px;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            background-color: var(--primary-color);
            color: white;
            border: none;
        }

        .btn-info {
            background-color: #17a2b8;
            color: white;
            border: none;
        }

        .btn-info:hover {
            background-color: #138496;
            color: white;
        }
    </style>
@endsection
