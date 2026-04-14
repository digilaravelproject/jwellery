<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Encryption\Encrypter;

class AICredential extends Model
{
    use HasFactory;

    protected $table = 'ai_credentials';

    protected $fillable = [
        'ai_provider_id',
        'api_key',
        'additional_config',
        'status',
        'last_error',
        'last_tested_at',
        'is_default',
    ];

    protected $casts = [
        'additional_config' => 'json',
        'is_default' => 'boolean',
        'last_tested_at' => 'datetime',
    ];

    protected $hidden = [
        'api_key',
    ];

    /**
     * Get the provider for this credential
     */
    public function provider(): BelongsTo
    {
        return $this->belongsTo(AIProvider::class, 'ai_provider_id');
    }

    /**
     * Get the selections for this credential
     */
    public function selections(): HasMany
    {
        return $this->hasMany(AISelection::class, 'ai_credential_id');
    }

    /**
     * Get the decrypted API key
     */
    public function getDecryptedApiKey()
    {
        try {
            return decrypt($this->api_key);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Set the API key with encryption
     */
    public function setApiKeyAttribute($value)
    {
        $this->attributes['api_key'] = encrypt($value);
    }
}
