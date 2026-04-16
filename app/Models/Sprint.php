<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sprint extends Model
{
    use HasFactory;

    protected $fillable = [
        'proyecto_id',
        'nombre',
        'objetivo',
        'fecha_inicio',
        'fecha_fin',
        'estado',
    ];

    protected function casts(): array
    {
        return [
            'fecha_inicio' => 'date',
            'fecha_fin'    => 'date',
        ];
    }

    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class);
    }
}
