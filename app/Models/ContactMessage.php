<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
    'nombre',
    'email',
    'telefono',
    'asunto',
    'mensaje',
    'respuesta',
    'archivo_respuesta',
    'leido'
];

    /* ── Accessors ────────────────────────────────────────── */

    public function getArchivoRespuestaUrlAttribute(): ?string
    {
        if (!$this->archivo_respuesta) {
            return null;
        }

        // URL externa
        if (str_starts_with($this->archivo_respuesta, 'http')) {
            return $this->archivo_respuesta;
        }

        // Si empieza con "public/", convertir a URL
        if (str_starts_with($this->archivo_respuesta, 'public/')) {
            $ruta = substr($this->archivo_respuesta, 7); // Remover "public/"
            return asset($ruta);
        }

        // Ruta en public/
        return asset($this->archivo_respuesta);
    }
}
