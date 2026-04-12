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

        // Si empieza con "public/", remover ese prefijo para asset()
        if (str_starts_with($value, 'public/')) {
            $ruta = substr($value, 7); // Remover "public/"
            return asset($ruta);
        }
        
        return asset($value);
    }
}
