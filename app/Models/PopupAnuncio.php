<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PopupAnuncio extends Model
{
    protected $fillable = [
        'titulo',
        'imagen',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function scopeActivo($query)
    {
        return $query->where('activo', true);
    }

    public function getImagenAttribute($value): ?string
    {
        if (!$value) return null;
        if (str_starts_with($value, 'http')) return $value;

        // Retornar la ruta tal como está en BD (con public/)
        return asset($value);
    }
}
