<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AISelection extends Model
{
    use HasFactory;

    protected $table = 'ai_selections';

    protected $fillable = [
        'ai_credential_id',
        'feature',
        'vision_model',
        'image_model',
        'text_model',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the credential for this selection
     */
    public function credential(): BelongsTo
    {
        return $this->belongsTo(AICredential::class, 'ai_credential_id');
    }

    /**
     * Scope to get only active selections
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get selection by feature
     */
    public function scopeByFeature($query, $feature)
    {
        return $query->where('feature', $feature);
    }
}
