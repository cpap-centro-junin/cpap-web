<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Colegiado extends Model
{
    use HasFactory;

    protected $table = 'colegiados';

    protected $fillable = [
        'codigo_cpap',
        'dni',
        'nombres',
        'apellidos',
        'email',
        'telefono',
        'fecha_nacimiento',
        'foto',
        'especialidad',
        'grado_academico',
        'especializacion_detalle',
        'diplomados',
        'experiencia_anos',
        'experiencia_sector',
        'orientacion',
        'universidad',
        'anio_graduacion',
        'descripcion',
        'cv_path',
        'estado',
        'fecha_colegiatura',
        // Visibilidad
        'perfil_oculto',
        'ocultar_email',
        'ocultar_telefono',
        'ocultar_descripcion',
        'ocultar_especialidad',
        'ocultar_grado_academico',
        'ocultar_especializacion_detalle',
        'ocultar_diplomados',
        'ocultar_experiencia',
        'ocultar_orientacion',
        'ocultar_universidad',
        'ocultar_anio_graduacion',
        'ocultar_fecha_colegiatura',
        'ocultar_foto',
        'ocultar_cv',
    ];

    protected $casts = [
        'fecha_nacimiento'   => 'date',
        'fecha_colegiatura'  => 'date',
        'anio_graduacion'    => 'integer',
        'experiencia_anos'   => 'integer',
        'perfil_oculto'                  => 'boolean',
        'ocultar_email'                  => 'boolean',
        'ocultar_telefono'               => 'boolean',
        'ocultar_descripcion'            => 'boolean',
        'ocultar_especialidad'           => 'boolean',
        'ocultar_grado_academico'        => 'boolean',
        'ocultar_especializacion_detalle'=> 'boolean',
        'ocultar_diplomados'             => 'boolean',
        'ocultar_experiencia'            => 'boolean',
        'ocultar_orientacion'            => 'boolean',
        'ocultar_universidad'            => 'boolean',
        'ocultar_anio_graduacion'        => 'boolean',
        'ocultar_fecha_colegiatura'      => 'boolean',
        'ocultar_foto'                   => 'boolean',
        'ocultar_cv'                     => 'boolean',
    ];

    // ─── Relaciones ──────────────────────────────────────────────

    public function habilitaciones(): HasMany
    {
        return $this->hasMany(Habilitacion::class);
    }

    public function habilitacionActiva()
    {
        return $this->hasOne(Habilitacion::class)
            ->where('activo', true)
            ->latest('fecha_subida');
    }

    // ─── Accessors ───────────────────────────────────────────────

    public function getNombreCompletoAttribute(): string
    {
        return "{$this->nombres} {$this->apellidos}";
    }

    public function getEstadoBadgeAttribute(): string
    {
        return $this->estado === 'activo'
            ? '<span class="badge badge-success">ACTIVO</span>'
            : '<span class="badge badge-danger">INACTIVO</span>';
    }

    /**
     * Verifica si el perfil puede mostrarse en el directorio público:
     * - No debe estar oculto (perfil_oculto = false)
     * - Debe tener al menos una habilitación activa
     */
    public function getEsVisiblePublicoAttribute(): bool
    {
        if ($this->perfil_oculto) {
            return false;
        }
        return $this->habilitaciones()->where('activo', true)->exists();
    }

    /** URL de la foto del colegiado. */
    public function getFotoUrlAttribute(): ?string
    {
        if (!$this->foto) {
            return null;
        }

        // Data URI (foto base64) - datos legacy
        if (str_starts_with($this->foto, 'data:')) {
            return $this->foto;
        }

        // URL externa
        if (str_starts_with($this->foto, 'http')) {
            return $this->foto;
        }

        // Si empieza con "public/", convertir a URL
        if (str_starts_with($this->foto, 'public/')) {
            $ruta = substr($this->foto, 7); // Remover "public/"
            return asset($ruta);
        }

        // Ruta en public/ - convertir a URL
        return asset($this->foto);
    }

    /** URL del CV (archivo PDF). */
    public function getCvUrlAttribute(): ?string
    {
        if (!$this->cv_path) {
            return null;
        }

        // Data URI (base64) - datos legacy
        if (str_starts_with($this->cv_path, 'data:')) {
            return $this->cv_path;
        }

        // URL externa
        if (str_starts_with($this->cv_path, 'http')) {
            return $this->cv_path;
        }

        // Si empieza con "public/", convertir a URL
        if (str_starts_with($this->cv_path, 'public/')) {
            $ruta = substr($this->cv_path, 7); // Remover "public/"
            return asset($ruta);
        }

        // Ruta en public/ - convertir a URL
        return asset($this->cv_path);
    }

    // ─── Scopes ──────────────────────────────────────────────────

    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }

    public function scopeInactivos($query)
    {
        return $query->where('estado', 'inactivo');
    }

    /**
     * Scope para el directorio público:
     * - No oculto manualmente
     * - Tiene al menos una habilitación registrada (activa o revocada)
     *   → Sin ningún documento = perfil incompleto, invisible en público
     *   → Con documento revocado = aparece como "No Habilitado" (transparencia)
     */
    public function scopeVisiblesPublico($query)
    {
        return $query
            ->where('perfil_oculto', false)
            ->whereHas('habilitaciones');
    }

    /**
     * Búsqueda por DNI, código, nombre o especialidad/orientación.
     */
    public function scopeBuscar($query, $termino)
    {
        $termino = trim($termino);

        return $query->where(function ($q) use ($termino) {
            $q->where('dni', 'like', "%{$termino}%")
              ->orWhere('codigo_cpap', 'like', "%{$termino}%");

            $q->orWhereRaw("CONCAT(nombres, ' ', apellidos) LIKE ?", ["%{$termino}%"]);
            $q->orWhereRaw("CONCAT(apellidos, ' ', nombres) LIKE ?", ["%{$termino}%"]);

            $palabras = array_filter(
                preg_split('/\s+/', $termino),
                fn($p) => mb_strlen($p) >= 3
            );
            if (!empty($palabras)) {
                $boolQuery = implode(' ', array_map(fn($p) => "+{$p}*", $palabras));
                $q->orWhereRaw(
                    "MATCH(nombres, apellidos, especialidad, orientacion) AGAINST(? IN BOOLEAN MODE)",
                    [$boolQuery]
                );
            }
        });
    }
}
