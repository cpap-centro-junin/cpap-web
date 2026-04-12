<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'resumen',
        'lugar',
        'fecha_inicio',
        'fecha_fin',
        'hora_inicio',
        'imagen_portada',
        'categoria',
        'activo',
        'destacado',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin'    => 'date',
        'activo'       => 'boolean',
        'destacado'    => 'boolean',
    ];

    /** Devuelve si el evento aún no terminó */
    public function getEsProximoAttribute(): bool
    {
        $fin = $this->fecha_fin ?? $this->fecha_inicio;
        return $fin->greaterThanOrEqualTo(now()->startOfDay());
    }

    public function getImagenPortadaAttribute($value): ?string
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
