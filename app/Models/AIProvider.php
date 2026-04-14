<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AIProvider extends Model
{
    use HasFactory;

    protected $table = 'ai_providers';

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'api_url',
        'supported_models',
        'is_active',
    ];

    protected $casts = [
        'supported_models' => 'json',
        'is_active' => 'boolean',
    ];

    /**
     * Get the credentials for this provider
     */
    public function credentials(): HasMany
    {
        return $this->hasMany(AICredential::class, 'ai_provider_id');
    }

    /**
     * Get the active credential for this provider
     */
    public function activeCredential()
    {
        return $this->credentials()->where('status', 'active')->where('is_default', true)->first();
    }
}
