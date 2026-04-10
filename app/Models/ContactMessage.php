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

        // Ruta de storage (convierte a URL pública)
        return \Illuminate\Support\Facades\Storage::url($this->archivo_respuesta);
    }
}
