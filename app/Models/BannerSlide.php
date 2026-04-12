<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BannerSlide extends Model
{
    use HasFactory;

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
    ];

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
        if ($this->tipo === 'noticia' && $this->noticia) {
            return $this->titulo ?? $this->noticia->titulo;
        }
        
        if ($this->tipo === 'evento' && $this->evento) {
            return $this->titulo ?? $this->evento->titulo;
        }
        
        return $this->titulo;
    }

    /**
     * Obtener la descripción del slide (desde la noticia/evento o custom)
     */
    public function getDescripcionFinalAttribute(): ?string
    {
        if ($this->tipo === 'noticia' && $this->noticia) {
            return $this->descripcion ?? $this->noticia->extracto;
        }
        
        if ($this->tipo === 'evento' && $this->evento) {
            return $this->descripcion ?? $this->evento->descripcion;
        }
        
        return $this->descripcion;
    }

    /**
     * Obtener la imagen del slide (desde la noticia/evento o custom)
     */
    public function getImagenFinalAttribute(): ?string
    {
        if ($this->tipo === 'noticia' && $this->noticia && !$this->imagen) {
            return $this->noticia->imagen;
        }
        
        if ($this->tipo === 'evento' && $this->evento && !$this->imagen) {
            return $this->evento->imagen;
        }
        
        if (!$this->imagen) {
            return null;
        }

        // URL externa
        if (str_starts_with($this->imagen, 'http')) {
            return $this->imagen;
        }

        // Ruta en public/
        return asset($this->imagen);
    }

    /**
     * Mutador para manejar imagen (base64, URL externa o storage)
     */
    public function getImagenAttribute($value): ?string
    {
        if (!$value) return null;
        if (str_starts_with($value, 'http')) return $value;
        
        // Retornar la ruta tal como está en BD (con public/)
        return asset($value);
    }

    /**
     * Obtener la URL del botón (desde la noticia/evento o custom)
     */
    public function getBotonUrlFinalAttribute(): string
    {
        // Para slides vinculados a noticia/evento, SIEMPRE usar la ruta generada
        if ($this->tipo === 'noticia' && $this->noticia) {
            return route('noticias.show', $this->noticia->id);
        }
        
        if ($this->tipo === 'evento' && $this->evento) {
            return route('eventos.show', $this->evento->id);
        }
        
        // Para slides personalizados o sin vinculación válida, usar boton_url
        return $this->boton_url ?? '#';
    }
}
