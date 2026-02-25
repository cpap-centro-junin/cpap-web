<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BannerSlide;

class BannerSlidesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpiar tabla (opcional, comentar si no deseas eliminar slides existentes)
        // BannerSlide::truncate();

        // Slide 1: Colegiatura 2026 (Personalizado)
        BannerSlide::create([
            'tipo' => 'personalizado',
            'tag' => 'Proceso de Colegiatura',
            'titulo' => '¡Proceso de Colegiatura<br>2026 Abierto!',
            'descripcion' => 'Únete a nuestra comunidad profesional. Requisitos y formularios disponibles para nuevos colegiados.',
            'imagen' => asset('images/banners/banner-colegiatura.png'),
            'boton_texto' => 'Ver Más',
            'boton_url' => '/#colegiatura',
            'orden' => 1,
            'activo' => true,
        ]);

        // Slide 2: 39 Aniversario (Personalizado)
        BannerSlide::create([
            'tipo' => 'personalizado',
            'tag' => 'Aniversario Institucional',
            'titulo' => 'Celebramos 39 Años<br>de Trayectoria',
            'descripcion' => 'Cuatro décadas promoviendo la excelencia en la antropología peruana y la investigación social.',
            'imagen' => asset('images/noticias/39-Aniversario.jpg'),
            'boton_texto' => 'Leer Más',
            'boton_url' => '/#noticias',
            'orden' => 2,
            'activo' => true,
        ]);

        // Slide 3: Juramentación (Personalizado)
        BannerSlide::create([
            'tipo' => 'personalizado',
            'tag' => 'Ceremonia Especial',
            'titulo' => 'Juramentación de<br>Nuevos Colegiados',
            'descripcion' => 'Damos la bienvenida a los nuevos profesionales que se unen a nuestra institución.',
            'imagen' => asset('images/noticias/Ceremonia-juramentacion.png'),
            'boton_texto' => 'Ver Galería',
            'boton_url' => '/#eventos',
            'orden' => 3,
            'activo' => true,
        ]);

        $this->command->info('✅ 3 slides del banner creados exitosamente.');
    }
}
