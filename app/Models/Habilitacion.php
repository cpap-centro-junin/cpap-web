<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Habilitacion extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla
     */
    protected $table = 'habilitaciones';

    /**
     * Campos asignables masivamente
     */
    protected $fillable = [
        'colegiado_id',
        'codigo_verificacion',
        'documento_path',
        'qr_path',
        'generado_por',
        'fecha_subida',
        'activo',
    ];

    /**
     * Casteo de atributos
     */
    protected $casts = [
        'fecha_subida' => 'datetime',
        'activo' => 'boolean',
    ];

    /**
     * Relación: Una habilitación pertenece a un colegiado
     */
    public function colegiado(): BelongsTo
    {
        return $this->belongsTo(Colegiado::class);
    }

    /**
     * Relación: Usuario que generó la habilitación
     */
    public function generadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'generado_por');
    }

    /**
     * Scope: Habilitaciones activas
     */
    public function scopeActivas($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Scope: Habilitaciones inactivas/revocadas
     */
    public function scopeInactivas($query)
    {
        return $query->where('activo', false);
    }

    /**
     * Accessor: URL del documento de habilitación
     */
    public function getDocumentoUrlAttribute(): ?string
    {
        if (!$this->documento_path) {
            return null;
        }

        // URL externa
        if (str_starts_with($this->documento_path, 'http')) {
            return $this->documento_path;
        }

        // Retornar la ruta tal como está en BD (con public/)
        return asset($this->documento_path);
    }

    /**
     * Accessor: URL del código QR
     */
    public function getQrUrlAttribute(): ?string
    {
        if (!$this->qr_path) {
            return null;
        }

        // URL externa
        if (str_starts_with($this->qr_path, 'http')) {
            return $this->qr_path;
        }

        // Retornar la ruta tal como está en BD (con public/)
        return asset($this->qr_path);
    }

    /**
     * Accessor: URL de verificación pública
     */
    public function getUrlVerificacionAttribute(): string
    {
        return url("/verificar/{$this->codigo_verificacion}");
    }

    /**
     * Accessor: URL corta de verificación
     */
    public function getUrlCortaAttribute(): string
    {
        return url("/v/{$this->codigo_verificacion}");
    }
}
