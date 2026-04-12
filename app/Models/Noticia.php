<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'resumen',
        'contenido',
        'imagen',
        'autor',
        'categoria',
        'activo',
        'destacado',
    ];

    protected $casts = [
        'activo'    => 'boolean',
        'destacado' => 'boolean',
    ];

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
