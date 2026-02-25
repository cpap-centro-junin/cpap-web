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
        
        // Si la imagen es una ruta de storage, convertirla a URL pública
        if ($this->imagen && !str_starts_with($this->imagen, 'http')) {
            return asset('storage/' . $this->imagen);
        }
        
        return $this->imagen;
    }

    /**
     * Obtener la URL del botón (desde la noticia/evento o custom)
     */
    public function getBotonUrlFinalAttribute(): string
    {
        if ($this->tipo === 'noticia' && $this->noticia && !$this->boton_url) {
            return route('noticia.show', $this->noticia->slug);
        }
        
        if ($this->tipo === 'evento' && $this->evento && !$this->boton_url) {
            return route('evento.show', $this->evento->slug);
        }
        
        return $this->boton_url;
    }
}
