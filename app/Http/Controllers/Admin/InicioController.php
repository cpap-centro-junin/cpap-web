<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BannerSlide;
use App\Models\ConfiguracionInicio;
use App\Models\Noticia;
use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InicioController extends Controller
{
    // =====================================
    // Dashboard de Gestión de Inicio
    // =====================================
    
    public function index()
    {
        $slides = BannerSlide::orderBy('orden')->get();
        $config = ConfiguracionInicio::obtener();
        
        return view('admin.inicio.index', compact('slides', 'config'));
    }

    // =====================================
    // BANNER SLIDES - CRUD
    // =====================================
    
    public function slidesIndex()
    {
        $slides = BannerSlide::with(['noticia', 'evento'])->orderBy('orden')->get();
        return view('admin.inicio.slides.index', compact('slides'));
    }

    public function slidesCreate()
    {
        $noticias = Noticia::where('activo', true)
                           ->orderBy('created_at', 'desc')
                           ->limit(50)
                           ->get();
        
        $eventos = Evento::where('activo', true)
                        ->orderBy('fecha_inicio', 'desc')
                        ->limit(50)
                        ->get();
                        
        return view('admin.inicio.slides.create', compact('noticias', 'eventos'));
    }

    public function slidesStore(Request $request)
    {
        $data = $request->validate([
            'tipo'          => 'required|in:noticia,evento,personalizado',
            'noticia_id'    => 'nullable|exists:noticias,id',
            'evento_id'     => 'nullable|exists:eventos,id',
            'tag'           => 'nullable|string|max:50',
            'titulo'        => 'required|string|max:200',
            'descripcion'   => 'nullable|string',
            'imagen'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'boton_texto'   => 'nullable|string|max:50',
            'boton_url'     => 'required|string|max:500',
            'orden'         => 'nullable|integer|min:0',
        ]);

        $data['activo'] = $request->boolean('activo');
        $data['orden'] = $data['orden'] ?? BannerSlide::max('orden') + 1;
        $data['boton_texto'] = $data['boton_texto'] ?? 'Ver Más';

        // Si el tipo es noticia o evento, limpiar el ID del otro
        if ($data['tipo'] === 'noticia') {
            $data['evento_id'] = null;
        } elseif ($data['tipo'] === 'evento') {
            $data['noticia_id'] = null;
        } else {
            $data['noticia_id'] = null;
            $data['evento_id'] = null;
        }

        // Procesar imagen
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = 'slide_' . time() . '_' . uniqid() . '.' . $imagen->getClientOriginalExtension();
            $imagen->storeAs('banner-slides', $nombreImagen, 'public');
            $data['imagen'] = 'banner-slides/' . $nombreImagen;
        }

        BannerSlide::create($data);

        return redirect()->route('admin.inicio.slides.index')
            ->with('success', 'Slide creado correctamente.');
    }

    public function slidesEdit(BannerSlide $slide)
    {
        $noticias = Noticia::where('activo', true)
                           ->orderBy('created_at', 'desc')
                           ->limit(50)
                           ->get();
        
        $eventos = Evento::where('activo', true)
                        ->orderBy('fecha_inicio', 'desc')
                        ->limit(50)
                        ->get();
                        
        return view('admin.inicio.slides.edit', compact('slide', 'noticias', 'eventos'));
    }

    public function slidesUpdate(Request $request, BannerSlide $slide)
    {
        $data = $request->validate([
            'tipo'          => 'required|in:noticia,evento,personalizado',
            'noticia_id'    => 'nullable|exists:noticias,id',
            'evento_id'     => 'nullable|exists:eventos,id',
            'tag'           => 'nullable|string|max:50',
            'titulo'        => 'required|string|max:200',
            'descripcion'   => 'nullable|string',
            'imagen'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'boton_texto'   => 'nullable|string|max:50',
            'boton_url'     => 'required|string|max:500',
            'orden'         => 'nullable|integer|min:0',
        ]);

        $data['activo'] = $request->boolean('activo');
        $data['boton_texto'] = $data['boton_texto'] ?? 'Ver Más';

        // Si el tipo es noticia o evento, limpiar el ID del otro
        if ($data['tipo'] === 'noticia') {
            $data['evento_id'] = null;
        } elseif ($data['tipo'] === 'evento') {
            $data['noticia_id'] = null;
        } else {
            $data['noticia_id'] = null;
            $data['evento_id'] = null;
        }

        // Procesar imagen
        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior si existe
            if ($slide->imagen && !str_starts_with($slide->imagen, 'http') && \Storage::disk('public')->exists($slide->imagen)) {
                \Storage::disk('public')->delete($slide->imagen);
            }
            
            $imagen = $request->file('imagen');
            $nombreImagen = 'slide_' . time() . '_' . uniqid() . '.' . $imagen->getClientOriginalExtension();
            $imagen->storeAs('banner-slides', $nombreImagen, 'public');
            $data['imagen'] = 'banner-slides/' . $nombreImagen;
        }

        $slide->update($data);

        return redirect()->route('admin.inicio.slides.index')
            ->with('success', 'Slide actualizado correctamente.');
    }

    public function slidesDestroy(BannerSlide $slide)
    {
        // Eliminar imagen si existe
        if ($slide->imagen && !str_starts_with($slide->imagen, 'http') && \Storage::disk('public')->exists($slide->imagen)) {
            \Storage::disk('public')->delete($slide->imagen);
        }
        
        $slide->delete();
        return back()->with('success', 'Slide eliminado correctamente.');
    }

    // =====================================
    // HERO SECTION
    // =====================================
    
    public function heroEdit()
    {
        $config = ConfiguracionInicio::obtener();
        return view('admin.inicio.hero.edit', compact('config'));
    }

    public function heroUpdate(Request $request)
    {
        $data = $request->validate([
            'hero_badge'       => 'nullable|string|max:50',
            'hero_titulo'      => 'nullable|string',
            'hero_subtitulo'   => 'nullable|string',
            'hero_imagen'      => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'hero_btn1_texto'  => 'nullable|string|max:50',
            'hero_btn1_url'    => 'nullable|string|max:500',
            'hero_btn1_icono'  => 'nullable|string|max:50',
            'hero_btn2_texto'  => 'nullable|string|max:50',
            'hero_btn2_url'    => 'nullable|string|max:500',
            'hero_btn2_icono'  => 'nullable|string|max:50',
        ]);

        $config = ConfiguracionInicio::obtener();

        // Procesar imagen si se sube una nueva
        if ($request->hasFile('hero_imagen')) {
            // Eliminar imagen anterior si existe
            if ($config->hero_imagen && Storage::disk('public')->exists($config->hero_imagen)) {
                Storage::disk('public')->delete($config->hero_imagen);
            }
            
            $imagen = $request->file('hero_imagen');
            $nombreImagen = 'hero_' . time() . '.' . $imagen->getClientOriginalExtension();
            $imagen->storeAs('hero', $nombreImagen, 'public');
            $data['hero_imagen'] = 'hero/' . $nombreImagen;
        }

        $config->update($data);

        return redirect()->route('admin.inicio.index')
            ->with('success', 'Hero Section actualizado correctamente.');
    }

    // =====================================
    // ESTADÍSTICAS
    // =====================================
    
    public function estadisticasEdit()
    {
        $config = ConfiguracionInicio::obtener();
        return view('admin.inicio.estadisticas.edit', compact('config'));
    }

    public function estadisticasUpdate(Request $request)
    {
        $data = $request->validate([
            'stat_colegiados'    => 'required|integer|min:0',
            'stat_eventos'       => 'required|integer|min:0',
            'stat_años'          => 'required|integer|min:0',
            'stat_publicaciones' => 'required|integer|min:0',
        ]);

        $config = ConfiguracionInicio::obtener();
        $config->update($data);

        return redirect()->route('admin.inicio.index')
            ->with('success', 'Estadísticas actualizadas correctamente.');
    }
}
