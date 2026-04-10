<?php

namespace App\Models;

use App\Traits\ResolvesPublicStorage;
use Illuminate\Database\Eloquent\Model;

class PopupAnuncio extends Model
{
    use ResolvesPublicStorage;
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
        return $this->resolvePublicStorageUrl($value);
    }
}
