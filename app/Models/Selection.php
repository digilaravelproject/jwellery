<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Selection extends Model
{
    protected $table = 'design_selections';

    protected $fillable = [
        'title',
        'values',
        'prompt_template',
        'is_active',
    ];

    protected $casts = [
        'values' => 'array',
        'is_active' => 'boolean',
    ];
}
