<?php

namespace App\Models;

use App\Traits\ResolvesPublicStorage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    use HasFactory, ResolvesPublicStorage;

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
        return $this->resolvePublicStorageUrl($value);
    }
}
