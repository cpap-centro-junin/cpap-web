<?php

namespace App\Models;

use App\Traits\ResolvesPublicStorage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class BannerSlide extends Model
{
    use HasFactory, ResolvesPublicStorage;

    protected $fillable = [
        'tipo',
        'noticia_id',
        'evento_id',
        'tag',
        'titulo',
        'descripcion',
        'imagen',
        'boton_texto',
        'boton_url',
        'orden',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'orden' => 'integer',
        'noticia_id' => 'string',
        'evento_id' => 'string',
    ];

    /**
     * Normaliza IDs foráneos para evitar valores inválidos heredados.
     */
    private function normalizeForeignId($value): ?string
    {
        if ($value === null) {
            return null;
        }

        $normalized = trim((string) $value);
        if ($normalized === '' || !preg_match('/^\d+$/', $normalized)) {
            return null;
        }

        return $normalized;
    }

    public function getNoticiaIdAttribute($value): ?string
    {
        return $this->normalizeForeignId($value);
    }

    public function getEventoIdAttribute($value): ?string
    {
        return $this->normalizeForeignId($value);
    }

    /**
     * Scope para obtener solo slides activos ordenados
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true)->orderBy('orden');
    }

    /**
     * Relación con Noticia (si el slide es de tipo 'noticia')
     */
    public function noticia(): BelongsTo
    {
        return $this->belongsTo(Noticia::class);
    }

    /**
     * Relación con Evento (si el slide es de tipo 'evento')
     */
    public function evento(): BelongsTo
    {
        return $this->belongsTo(Evento::class);
    }

    /**
     * Obtener el título del slide (desde la noticia/evento o custom)
     */
    public function getTituloFinalAttribute(): string
    {
        $noticia = $this->relationLoaded('noticia') ? $this->getRelation('noticia') : null;
        $evento  = $this->relationLoaded('evento') ? $this->getRelation('evento') : null;

        if ($this->tipo === 'noticia' && $noticia) {
            return $this->titulo ?? $noticia->titulo;
        }
        
        if ($this->tipo === 'evento' && $evento) {
            return $this->titulo ?? $evento->titulo;
        }
        
        return $this->titulo ?? '';
    }

    /**
     * Obtener la descripción del slide (desde la noticia/evento o custom)
     */
    public function getDescripcionFinalAttribute(): ?string
    {
        $noticia = $this->relationLoaded('noticia') ? $this->getRelation('noticia') : null;
        $evento  = $this->relationLoaded('evento') ? $this->getRelation('evento') : null;

        if ($this->tipo === 'noticia' && $noticia) {
            return $this->descripcion ?? $noticia->resumen;
        }
        
        if ($this->tipo === 'evento' && $evento) {
            return $this->descripcion ?? $evento->descripcion;
        }
        
        return $this->descripcion;
    }

    /**
     * Obtener la imagen del slide (desde la noticia/evento o custom)
     */
    public function getImagenFinalAttribute(): ?string
    {
        $noticia = $this->relationLoaded('noticia') ? $this->getRelation('noticia') : null;
        $evento  = $this->relationLoaded('evento') ? $this->getRelation('evento') : null;

        if ($this->tipo === 'noticia' && $noticia && !$this->imagen) {
            return $noticia->imagen;
        }
        
        if ($this->tipo === 'evento' && $evento && !$this->imagen) {
            return $evento->imagen_portada;
        }
        
        // Si la imagen es una ruta de storage, convertirla a URL pública
        if ($this->imagen && !str_starts_with($this->imagen, 'http') && !str_starts_with($this->imagen, 'data:')) {
            return $this->resolvePublicStorageUrl($this->imagen);
        }

        if ($this->imagen) {
            return $this->imagen;
        }

        return asset('images/banners/banner-colegiatura.png');
    }

    /**
     * Obtener la URL del botón (desde la noticia/evento o custom)
     */
    public function getBotonUrlFinalAttribute(): string
    {
        $noticia = $this->relationLoaded('noticia') ? $this->getRelation('noticia') : null;
        $evento  = $this->relationLoaded('evento') ? $this->getRelation('evento') : null;

        // Para slides vinculados a noticia/evento, SIEMPRE usar la ruta generada
        if ($this->tipo === 'noticia' && $noticia) {
            return route('noticias.show', $noticia->id);
        }
        
        if ($this->tipo === 'evento' && $evento) {
            return route('eventos.show', $evento->id);
        }
        
        // Para slides personalizados o sin vinculación válida, usar boton_url
        return $this->boton_url ?? '#';
    }
}
