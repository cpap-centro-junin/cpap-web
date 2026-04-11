<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecursoBiblioteca extends Model
{
    protected $table = 'biblioteca';

    protected $fillable = [
        'titulo',
        'autor',
        'tipo',
        'formato',
        'area_tematica',
        'descripcion',
        'editorial',
        'anio_publicacion',
        'isbn_issn',
        'paginas',
        'idioma',
        'archivo_pdf',
        'imagen_portada',
        'enlace_externo',
        'copyright_titular',
        'copyright_anio',
        'licencia_tipo',
        'notas_legales',
        'descarga_permitida',
        'solo_colegiados',
        'activo',
        'destacado',
        'descargas_count',
        'vistas_count',
    ];

    protected $casts = [
        'descarga_permitida' => 'boolean',
        'solo_colegiados'    => 'boolean',
        'activo'             => 'boolean',
        'destacado'          => 'boolean',
        'descargas_count'    => 'integer',
        'vistas_count'       => 'integer',
    ];

    /* -------------------------------------------------------
     * SCOPES
     * ----------------------------------------------------- */

    /** Recursos publicados (activos). */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    /** Filtrar por tipo de recurso. */
    public function scopePorTipo($query, string $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    /** Filtrar por formato (fisico / digital). */
    public function scopePorFormato($query, string $formato)
    {
        return $query->where('formato', $formato);
    }

    /** Filtrar por área temática. */
    public function scopePorArea($query, string $area)
    {
        return $query->where('area_tematica', $area);
    }

    /** Solo recursos destacados. */
    public function scopeDestacados($query)
    {
        return $query->where('destacado', true);
    }

    /** Acceso público (no restringidos a colegiados). */
    public function scopePublicos($query)
    {
        return $query->where('solo_colegiados', false);
    }

    /* -------------------------------------------------------
     * ACCESSORS
     * ----------------------------------------------------- */

    /** Label legible del formato. */
    public function getFormatoLabelAttribute(): string
    {
        // Si es documento, no mostrar "Libro"
        if ($this->tipo === 'documento') {
            return match ($this->formato) {
                'fisico'  => 'Físico',
                'digital' => 'Digital',
                default   => $this->formato,
            };
        }

        // Para libros, usar "Libro Físico/Virtual"
        if ($this->tipo === 'libro') {
            return match ($this->formato) {
                'fisico'  => 'Libro Físico',
                'digital' => 'Libro Virtual',
                default   => $this->formato,
            };
        }

        // Para otros tipos (tesis, artículos, etc.)
        return match ($this->formato) {
            'fisico'  => 'Físico',
            'digital' => 'Digital',
            default   => $this->formato,
        };
    }

    /** Icono FontAwesome según formato. */
    public function getFormatoIconAttribute(): string
    {
        return match ($this->formato) {
            'fisico'  => 'fa-book',
            'digital' => 'fa-laptop',
            default   => 'fa-file',
        };
    }

    /** Label legible del tipo. */
    public function getTipoLabelAttribute(): string
    {
        return match ($this->tipo) {
            'libro'      => 'Libro',
            'articulo'   => 'Artículo',
            'tesis'      => 'Tesis',
            'documento'  => 'Documento CPAP',
            'revista'    => 'Revista',
            'multimedia' => 'Multimedia',
            default      => $this->tipo,
        };
    }

    /** Icono FontAwesome según tipo. */
    public function getTipoIconAttribute(): string
    {
        return match ($this->tipo) {
            'libro'      => 'fa-book-open',
            'articulo'   => 'fa-newspaper',
            'tesis'      => 'fa-graduation-cap',
            'documento'  => 'fa-file-pdf',
            'revista'    => 'fa-globe-americas',
            'multimedia' => 'fa-video',
            default      => 'fa-file',
        };
    }

    /** Label del área temática. */
    public function getAreaLabelAttribute(): string
    {
        return match ($this->area_tematica) {
            'cultural'    => 'Antropología Cultural',
            'social'      => 'Antropología Social',
            'arqueologia' => 'Arqueología',
            'linguistica' => 'Lingüística',
            'biologica'   => 'Antropología Biológica',
            default       => $this->area_tematica,
        };
    }

    /** Label de la licencia. */
    public function getLicenciaLabelAttribute(): string
    {
        return match ($this->licencia_tipo) {
            'copyright'       => '© Todos los derechos reservados',
            'creative_commons_by'   => 'CC BY — Atribución',
            'cc_by_sa'        => 'CC BY-SA — Atribución-CompartirIgual',
            'cc_by_nc'        => 'CC BY-NC — Atribución-NoComercial',
            'cc_by_nc_sa'     => 'CC BY-NC-SA — Atrib-NoCom-CompartirIgual',
            'cc_by_nd'        => 'CC BY-ND — Atribución-SinDerivadas',
            'cc_by_nc_nd'     => 'CC BY-NC-ND — Atrib-NoCom-SinDerivadas',
            'dominio_publico' => 'Dominio Público',
            'licencia_cpap'   => 'Licencia CPAP — Uso institucional',
            default           => $this->licencia_tipo,
        };
    }

    /** Label corta de licencia (para badges). */
    public function getLicenciaBadgeAttribute(): string
    {
        return match ($this->licencia_tipo) {
            'copyright'             => '© Copyright',
            'creative_commons_by'   => 'CC BY',
            'cc_by_sa'              => 'CC BY-SA',
            'cc_by_nc'              => 'CC BY-NC',
            'cc_by_nc_sa'           => 'CC BY-NC-SA',
            'cc_by_nd'              => 'CC BY-ND',
            'cc_by_nc_nd'           => 'CC BY-NC-ND',
            'dominio_publico'       => 'Dominio Público',
            'licencia_cpap'         => 'CPAP',
            default                 => $this->licencia_tipo,
        };
    }

    /** Texto completo del copyright. */
    public function getCopyrightTextoAttribute(): string
    {
        $parts = [];
        if ($this->copyright_titular) {
            $year = $this->copyright_anio ?? ($this->anio_publicacion ?? '');
            $parts[] = "© {$year} {$this->copyright_titular}";
        }
        $parts[] = $this->licencia_label;

        if ($this->notas_legales) {
            $parts[] = $this->notas_legales;
        }

        return implode(' · ', $parts);
    }

    /** ¿Se puede descargar? */
    public function getPuedeDescargarAttribute(): bool
    {
        if (! $this->descarga_permitida) {
            return false;
        }
        return (bool) ($this->archivo_pdf || $this->enlace_externo);
    }

    /** URL del archivo PDF para descarga. */
    public function getArchivoPdfUrlAttribute(): ?string
    {
        if (!$this->archivo_pdf) {
            return null;
        }

        // URL externa
        if (str_starts_with($this->archivo_pdf, 'http')) {
            return $this->archivo_pdf;
        }

        // Ruta en public/
        return asset($this->archivo_pdf);
    }

    /** URL de la imagen de portada. */
    public function getImagenPortadaUrlAttribute(): ?string
    {
        if (!$this->imagen_portada) {
            return null;
        }

        // URL externa
        if (str_starts_with($this->imagen_portada, 'http')) {
            return $this->imagen_portada;
        }

        // Ruta en public/
        return asset($this->imagen_portada);
    }
}
