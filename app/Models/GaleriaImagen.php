<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GaleriaImagen extends Model
{
    protected $table = 'galeria_imagenes';

    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'categoria',
        'fecha',
        'destacado',
        'activo',
        'orden',
    ];

    protected $casts = [
        'fecha'     => 'date',
        'destacado' => 'boolean',
        'activo'    => 'boolean',
        'orden'     => 'integer',
    ];

    /* ── Scopes ────────────────────────────── */

    public function scopeActivos($query)
    {
        return $query->where('activo', true)->orderBy('orden')->orderByDesc('fecha')->orderByDesc('id');
    }

    public function scopeDestacados($query)
    {
        return $query->where('activo', true)->where('destacado', true)->orderBy('orden')->orderByDesc('fecha');
    }

    public function scopePorCategoria($query, string $categoria)
    {
        return $query->where('categoria', $categoria);
    }

    /* ── Accessors ─────────────────────────── */

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

    /* ── Helpers estáticos ─────────────────── */

    public static function categoriasDisponibles(): array
    {
        return [
            'Ceremonias'    => 'Ceremonias',
            'Eventos'       => 'Eventos Académicos',
            'Institucional' => 'Institucional',
            'Congresos'     => 'Congresos y Conferencias',
            'Actividades'   => 'Actividades Sociales',
            'Otros'         => 'Otros',
        ];
    }
}
