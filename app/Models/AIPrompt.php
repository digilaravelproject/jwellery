<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AIPrompt extends Model
{
    protected $table = 'ai_prompts';

    protected $fillable = [
        'title',
        'prompt_text',
        'is_active',
    ];
}
