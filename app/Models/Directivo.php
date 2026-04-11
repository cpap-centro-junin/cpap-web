<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Directivo extends Model
{
    protected $fillable = [
        'cargo',
        'nombre',
        'foto',
        'periodo',
        'orden',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'orden'  => 'integer',
    ];

    /**
     * Icono Font Awesome según el cargo.
     * Cubre las variantes masculinas y femeninas de cada dirección.
     */
    public function getIconAttribute(): string
    {
        $c = strtolower($this->cargo);

        return match (true) {
            str_contains($c, 'vice')                                                              => 'fa-award',
            (str_contains($c, 'decano') || str_contains($c, 'decana')) && !str_contains($c, 'vice') => 'fa-star',
            str_contains($c, 'secretari')                                                         => 'fa-pen-nib',
            str_contains($c, 'econom')                                                            => 'fa-coins',
            str_contains($c, 'actividades')                                                       => 'fa-flask',
            str_contains($c, 'seguridad')                                                         => 'fa-shield-alt',
            str_contains($c, 'biblioteca')                                                        => 'fa-book',
            str_contains($c, 'defensa')                                                           => 'fa-handshake',
            str_contains($c, 'relaciones')                                                        => 'fa-bullhorn',
            default                                                                               => 'fa-user-tie',
        };
    }

    public function getFotoAttribute($value): ?string
    {
        if (!$value) return null;
        if (str_starts_with($value, 'http')) return $value;

        return asset($value);
    }
}
