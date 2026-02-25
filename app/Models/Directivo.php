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
     */
    public function getIconAttribute(): string
    {
        return match (true) {
            str_contains(strtolower($this->cargo), 'decano') && !str_contains(strtolower($this->cargo), 'vice') => 'fa-star',
            str_contains(strtolower($this->cargo), 'vice') => 'fa-award',
            str_contains(strtolower($this->cargo), 'secretari') => 'fa-pen-nib',
            str_contains(strtolower($this->cargo), 'tesorer') => 'fa-coins',
            str_contains(strtolower($this->cargo), 'fiscal') => 'fa-balance-scale',
            default => 'fa-handshake',
        };
    }

    public function getFotoAttribute($value): ?string
    {
        if (!$value) return null;
        if (str_starts_with($value, 'data:')) return $value;
        return asset('storage/' . $value);
    }
}
