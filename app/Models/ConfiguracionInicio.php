<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfiguracionInicio extends Model
{
    use HasFactory;

    protected $table = 'configuracion_inicio';

    protected $fillable = [
        // Hero Section
        'hero_badge',
        'hero_titulo',
        'hero_subtitulo',
        'hero_btn1_texto',
        'hero_btn1_url',
        'hero_btn1_icono',
        'hero_btn2_texto',
        'hero_btn2_url',
        'hero_btn2_icono',
        
        // Estadísticas
        'stat_colegiados',
        'stat_eventos',
        'stat_años',
        'stat_publicaciones',
        
        // Opciones
        'mostrar_orientaciones',
    ];

    protected $casts = [
        'stat_colegiados' => 'integer',
        'stat_eventos' => 'integer',
        'stat_años' => 'integer',
        'stat_publicaciones' => 'integer',
        'mostrar_orientaciones' => 'boolean',
    ];

    /**
     * Obtener la instancia singleton de la configuración
     */
    public static function obtener()
    {
        $config = self::first();
        
        // Si no existe ningún registro, crear uno con valores por defecto
        if (!$config) {
            $config = self::create([
                'hero_badge' => 'Bienvenidos',
                'hero_titulo' => 'Colegio Profesional de<br><span class="gradient-text">Antropólogos del Perú</span>',
                'hero_subtitulo' => 'Región Centro - Promoviendo la excelencia profesional y la investigación antropológica desde 1985',
                'hero_btn1_texto' => 'Quiero Colegiarme',
                'hero_btn1_url' => '#colegiatura',
                'hero_btn1_icono' => 'fas fa-user-plus',
                'hero_btn2_texto' => 'Conocer Más',
                'hero_btn2_url' => '#nosotros',
                'hero_btn2_icono' => 'fas fa-info-circle',
                'stat_colegiados' => 1250,
                'stat_eventos' => 150,
                'stat_años' => 39,
                'stat_publicaciones' => 500,
                'mostrar_orientaciones' => true,
            ]);
        }
        
        return $config;
    }
}
