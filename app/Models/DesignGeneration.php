<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DesignGeneration extends Model
{
    protected $table = 'design_generations';

    protected $fillable = [
        'user_id',
        'sketch_path',
        'prompt',
        'generated_design_path',
        'design_specification',
        'design_type',
        'ai_provider',
    ];

    /**
     * Get the user that owns this design generation
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
