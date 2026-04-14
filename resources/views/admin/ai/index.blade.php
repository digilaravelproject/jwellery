@extends('layouts.admin')

@section('title', 'AI Management - Admin Panel')
@section('page-title', 'AI Management Dashboard')

@section('content')
    <div class="container-fluid">
        <!-- Statistics -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-key"></i>
                    </div>
                    <div class="stat-number">{{ $providers->sum(fn($p) => $p->credentials->count()) }}</div>
                    <div class="stat-label">API Credentials</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="stat-card" style="border-left-color: #27ae60;">
                    <div class="stat-icon" style="color: #27ae60;">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-number">{{ $providers->map(fn($p) => $p->credentials->where('status', 'active')->count())->sum() }}</div>
                    <div class="stat-label">Active Credentials</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="stat-card" style="border-left-color: #3498db;">
                    <div class="stat-icon" style="color: #3498db;">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <div class="stat-number">{{ $selections->where('is_active', true)->count() }}</div>
                    <div class="stat-label">Active Agents</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="stat-card" style="border-left-color: #f39c12;">
                    <div class="stat-icon" style="color: #f39c12;">
                        <i class="fas fa-robot"></i>
                    </div>
                    <div class="stat-number">{{ $providers->count() }}</div>
                    <div class="stat-label">AI Providers</div>
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
                            <div class="col-md-3">
                                <a href="{{ route('admin.ai.credentials') }}" class="btn btn-primary w-100">
                                    <i class="fas fa-key"></i> Manage Credentials
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('admin.ai.agents') }}" class="btn btn-success w-100">
                                    <i class="fas fa-cogs"></i> Configure Agents
                                </a>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-info w-100" onclick="testAllCredentials()">
                                    <i class="fas fa-flask"></i> Test All Keys
                                </button>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-warning w-100" onclick="refreshStatus()">
                                    <i class="fas fa-sync"></i> Refresh Status
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Providers Overview -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-server"></i> AI Providers
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @forelse($providers as $provider)
                                <div class="col-md-6 mb-4">
                                    <div class="provider-card">
                                        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 15px;">
                                            <div>
                                                <h5 style="margin: 0; color: var(--primary-color);">
                                                    <i class="fas {{ $provider->name === 'openai' ? 'fa-brain' : 'fa-route' }}"></i>
                                                    {{ $provider->display_name }}
                                                </h5>
                                                <small class="text-muted">{{ $provider->description }}</small>
                                            </div>
                                            @if($provider->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </div>

                                        <div class="mb-3">
                                            <strong>Credentials:</strong>
                                            <p>
                                                {{ $provider->credentials->count() }} total
                                                ({{ $provider->credentials->where('status', 'active')->count() }} active)
                                            </p>
                                        </div>

                                        <div class="mb-3">
                                            <strong>Supported Models:</strong>
                                            <div class="model-list">
                                                @forelse($provider->supported_models as $model)
                                                    <span class="badge bg-light text-dark">{{ $model }}</span>
                                                @empty
                                                    <span class="text-muted">No specific models listed</span>
                                                @endforelse
                                            </div>
                                        </div>

                                        <div class="alert alert-info p-2 mb-0">
                                            <small>
                                                @switch($provider->name)
                                                    @case('openai')
                                                        <i class="fas fa-info-circle"></i> Get API key from <a href="https://platform.openai.com/api-keys" target="_blank">OpenAI Platform</a>
                                                        @break
                                                    @case('openrouter')
                                                        <i class="fas fa-info-circle"></i> Get API key from <a href="https://openrouter.ai" target="_blank">Open Router</a>
                                                        @break
                                                @endswitch
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-md-12">
                                    <p class="text-muted text-center">No AI providers configured</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Selections -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-list"></i> Active Agent Selections
                    </div>
                    <div class="card-body">
                        @if($selections->where('is_active', true)->count() > 0)
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Feature</th>
                                        <th>Provider</th>
                                        <th>Vision Model</th>
                                        <th>Image Model</th>
                                        <th>Text Model</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($selections->where('is_active', true) as $selection)
                                        <tr>
                                            <td>
                                                <strong>{{ ucwords(str_replace('_', ' ', $selection->feature)) }}</strong>
                                            </td>
                                            <td>
                                                <i class="fas {{ $selection->credential->provider->name === 'openai' ? 'fa-brain' : 'fa-route' }}"></i>
                                                {{ $selection->credential->provider->display_name }}
                                            </td>
                                            <td>
                                                @if($selection->vision_model)
                                                    <span class="badge bg-primary">{{ $selection->vision_model }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($selection->image_model)
                                                    <span class="badge bg-info">{{ $selection->image_model }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($selection->text_model)
                                                    <span class="badge bg-secondary">{{ $selection->text_model }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-success">Active</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-muted text-center">No active agent selections configured</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        function testAllCredentials() {
            alert('Testing all credentials... Please wait.');
            // This would be an advanced feature to test all credentials at once
        }

        function refreshStatus() {
            location.reload();
        }
    </script>

    <style>
        .provider-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            transition: all 0.3s;
        }

        .provider-card:hover {
            border-color: var(--accent-color);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .model-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 8px;
        }

        .model-list .badge {
            margin: 0;
        }

        .alert-info {
            background-color: #d1ecf1;
            color: #0c5460;
            border: none;
        }
    </style>
@endsection
