<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'proyecto_id',
        'task_status_id',
        'user_story_id',
        'sprint_id',
        'titulo',
        'descripcion',
        'fecha_limite',
    ];

    protected function casts(): array
    {
        return [
            'fecha_limite' => 'date',
        ];
    }

    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(TaskStatus::class, 'task_status_id');
    }

    public function userStory(): BelongsTo
    {
        return $this->belongsTo(UserStory::class);
    }

    public function sprint(): BelongsTo
    {
        return $this->belongsTo(Sprint::class);
    }
}
