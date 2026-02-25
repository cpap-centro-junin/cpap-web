<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('configuracion_inicio', function (Blueprint $table) {
            $table->id();
            
            // ============================================
            // HERO SECTION
            // ============================================
            $table->string('hero_badge', 50)->nullable();
            $table->text('hero_titulo')->nullable();
            $table->text('hero_subtitulo')->nullable();
            
            // Botón 1 (primario)
            $table->string('hero_btn1_texto', 50)->nullable();
            $table->string('hero_btn1_url', 500)->nullable();
            $table->string('hero_btn1_icono', 50)->nullable();
            
            // Botón 2 (secundario)
            $table->string('hero_btn2_texto', 50)->nullable();
            $table->string('hero_btn2_url', 500)->nullable();
            $table->string('hero_btn2_icono', 50)->nullable();
            
            // ============================================
            // ESTADÍSTICAS
            // ============================================
            $table->integer('stat_colegiados')->default(1250)->comment('Número de colegiados');
            $table->integer('stat_eventos')->default(150)->comment('Eventos anuales');
            $table->integer('stat_años')->default(39)->comment('Años de servicio');
            $table->integer('stat_publicaciones')->default(500)->comment('Publicaciones');
            
            // ============================================
            // OPCIONES GENERALES
            // ============================================
            $table->boolean('mostrar_orientaciones')->default(true)->comment('Mostrar sección "Orientaciones de la Antropología"');
            
            $table->timestamps();
        });
        
        // Insertar registro por defecto (singleton)
        DB::table('configuracion_inicio')->insert([
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
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configuracion_inicio');
    }
};
