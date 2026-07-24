<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectFile extends Model
{
    // Laragear/Vite/Laravel usually matches table name using snake_case, but the migration created the "files" table.
    // Let's specify table name explicitly since the migration is 'files' and the model name is 'ProjectFile'.
    protected $table = 'files';

    protected $fillable = [
        'project_id',
        'name',
        'type',
        'path',
        'mime_type',
        'size_bytes',
    ];

    protected $casts = [
        'size_bytes' => 'integer',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
