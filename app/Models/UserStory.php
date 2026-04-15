<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserStory extends Model
{
    use HasFactory;

    protected $fillable = [
        'requirement_id',
        'titulo',
        'como_usuario',
        'quiero',
        'para_poder',
        'criterios_aceptacion',
        'prioridad',
    ];

    public function requirement(): BelongsTo
    {
        return $this->belongsTo(Requirement::class);
    }
}
