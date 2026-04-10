<?php

namespace App\Models;

use App\Traits\ResolvesPublicStorage;
use Illuminate\Database\Eloquent\Model;

class Directivo extends Model
{
    use ResolvesPublicStorage;
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
        return $this->resolvePublicStorageUrl($value);
    }
}
