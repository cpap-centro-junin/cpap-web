<?php

namespace App\Models;

use App\Traits\ResolvesPublicStorage;
use Illuminate\Database\Eloquent\Model;

class NormativaDocumento extends Model
{
    use ResolvesPublicStorage;
    protected $table = 'normativa_documentos';

    protected $fillable = [
        'titulo',
        'descripcion',
        'icono',
        'archivo_pdf',
        'archivo_nombre',
        'orden',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'orden'  => 'integer',
    ];

    public function scopeActivos($query)
    {
        return $query->where('activo', true)->orderBy('orden')->orderBy('id');
    }

    public function getPdfUrlAttribute(): ?string
    {
        return $this->resolvePublicStorageUrl($this->archivo_pdf);
    }

    public static function iconosDisponibles(): array
    {
        return [
            'fas fa-scroll'         => 'Pergamino (Estatuto)',
            'fas fa-book'           => 'Libro (Reglamento)',
            'fas fa-balance-scale'  => 'Balanza (Ética)',
            'fas fa-landmark'       => 'Edificio (Ley)',
            'fas fa-vote-yea'       => 'Voto (Elecciones)',
            'fas fa-gavel'          => 'Mazo (Legal)',
            'fas fa-file-contract'  => 'Contrato',
            'fas fa-file-alt'       => 'Documento',
            'fas fa-file-pdf'       => 'PDF',
            'fas fa-folder-open'    => 'Carpeta',
            'fas fa-university'     => 'Universidad',
            'fas fa-shield-alt'     => 'Escudo',
        ];
    }
}
