<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use App\Models\Evento;
use App\Models\Colegiado;
use App\Models\RecursoBiblioteca;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';

        // Página principal - Máxima prioridad
        $sitemap .= $this->url('/', '1.0', 'daily', now(), [
            ['loc' => asset('images/logos/cpap-logo.jpg'), 'title' => 'Logo Colegio de Antropólogos del Perú - Región Centro']
        ]);

        // Páginas estáticas - Nosotros
        $sitemap .= $this->url('/nosotros/mision-vision', '0.8', 'monthly');
        $sitemap .= $this->url('/nosotros/historia', '0.8', 'monthly');
        $sitemap .= $this->url('/nosotros/consejo-directivo', '0.8', 'weekly');
        $sitemap .= $this->url('/nosotros/normativa-legal', '0.7', 'monthly');
        $sitemap .= $this->url('/nosotros/plan-2026', '0.7', 'monthly');

        // Colegiatura - Muy importante para SEO
        $sitemap .= $this->url('/colegiatura', '0.95', 'weekly');

        // Directorio de Colegiados - Importante
        $sitemap .= $this->url('/colegiados', '0.9', 'daily');

        // Contacto
        $sitemap .= $this->url('/contacto', '0.8', 'monthly');

        // Noticias - Listado
        $sitemap .= $this->url('/noticias', '0.9', 'daily');

        // Noticias - Individuales con imágenes
        $noticias = Noticia::where('activo', true)->latest()->get();
        foreach ($noticias as $noticia) {
            $images = [];
            if ($noticia->imagen) {
                $images[] = ['loc' => $noticia->imagen, 'title' => $noticia->titulo];
            }
            $sitemap .= $this->url(
                '/noticias/' . $noticia->id,
                '0.7',
                'weekly',
                $noticia->updated_at,
                $images
            );
        }

        // Eventos - Listado
        $sitemap .= $this->url('/eventos', '0.9', 'daily');

        // Eventos - Individuales con imágenes
        $eventos = Evento::where('activo', true)->get();
        foreach ($eventos as $evento) {
            $images = [];
            if ($evento->imagen_portada) {
                $images[] = ['loc' => $evento->imagen_portada, 'title' => $evento->titulo];
            }
            $sitemap .= $this->url(
                '/eventos/' . $evento->id,
                '0.7',
                'weekly',
                $evento->updated_at,
                $images
            );
        }

        // Colegiados - Perfiles públicos (limitado para rendimiento)
        $colegiados = Colegiado::where('estado', 'activo')
            ->where('perfil_oculto', false)
            ->latest()
            ->take(100)
            ->get();
        foreach ($colegiados as $colegiado) {
            $sitemap .= $this->url(
                '/colegiados/' . $colegiado->codigo_cpap,
                '0.6',
                'monthly',
                $colegiado->updated_at
            );
        }

        // Biblioteca
        $sitemap .= $this->url('/biblioteca', '0.8', 'weekly');

        $recursos = RecursoBiblioteca::where('activo', true)->get();
        foreach ($recursos as $recurso) {
            $sitemap .= $this->url(
                '/biblioteca/' . $recurso->id,
                '0.6',
                'monthly',
                $recurso->updated_at
            );
        }

        // Bolsa de Trabajo
        $sitemap .= $this->url('/bolsa-trabajo', '0.85', 'daily');

        // Galería
        $sitemap .= $this->url('/galeria', '0.7', 'weekly');

        $sitemap .= '</urlset>';

        return response($sitemap, 200)
            ->header('Content-Type', 'application/xml');
    }

    private function url(string $loc, string $priority, string $changefreq, $lastmod = null, array $images = []): string
    {
        $url = '<url>';
        $url .= '<loc>' . htmlspecialchars(url($loc), ENT_XML1) . '</loc>';

        if ($lastmod) {
            $url .= '<lastmod>' . $lastmod->toAtomString() . '</lastmod>';
        }

        $url .= '<changefreq>' . $changefreq . '</changefreq>';
        $url .= '<priority>' . $priority . '</priority>';

        // Agregar imágenes al sitemap (Google Image Sitemap Extension)
        foreach ($images as $image) {
            $url .= '<image:image>';
            $url .= '<image:loc>' . htmlspecialchars($image['loc'], ENT_XML1) . '</image:loc>';
            if (!empty($image['title'])) {
                $url .= '<image:title>' . htmlspecialchars($image['title'], ENT_XML1) . '</image:title>';
            }
            $url .= '</image:image>';
        }

        $url .= '</url>';

        return $url;
    }
}
