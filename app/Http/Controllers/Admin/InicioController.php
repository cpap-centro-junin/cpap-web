<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BannerSlide;
use App\Models\ConfiguracionInicio;
use App\Models\Noticia;
use App\Models\Evento;
use Illuminate\Http\Request;

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
    
    public function slidesIndex(Request $request)
    {
        // Manejar parámetro de items per page
        if ($request->has('perpage')) {
            $perpage = (int) $request->get('perpage');
            if (in_array($perpage, [10, 20, 50, 100])) {
                session(['pagination_perpage' => $perpage]);
            }
        }
        
        $perpage = session('pagination_perpage', 20);
        
        $query = BannerSlide::with(['noticia', 'evento']);

        // Search by title or tipo
        if ($request->filled('q')) {
            $buscar = $request->q;
            $query->where(function ($q) use ($buscar) {
                $q->where('titulo', 'like', "%{$buscar}%")
                  ->orWhere('subtitulo', 'like', "%{$buscar}%");
            });
        }

        // Filter by slide type
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        // Filter by active status
        if ($request->filled('estado')) {
            $query->where('activo', $request->estado === 'activo');
        }

        $slides = $query->orderBy('orden')->paginate($perpage)->withQueryString();
        
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
            'imagen'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480',
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
            $file = $request->file('imagen');
            $dir = public_path('images/inicio');
            if (!file_exists($dir)) mkdir($dir, 0755, true);
            $nombre = uniqid('slide_') . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $nombre);
            $data['imagen'] = 'public/images/inicio/' . $nombre;
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
            'imagen'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480',
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
            $file = $request->file('imagen');
            $dir = public_path('images/inicio');
            if (!file_exists($dir)) mkdir($dir, 0755, true);
            $nombre = uniqid('slide_') . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $nombre);
            $data['imagen'] = 'public/images/inicio/' . $nombre;
        }

        $slide->update($data);

        return redirect()->route('admin.inicio.slides.index')
            ->with('success', 'Slide actualizado correctamente.');
    }

    public function slidesDestroy(BannerSlide $slide)
    {
        $slide->delete();
        return back()->with('success', 'Slide eliminado correctamente.');
    }

    public function slidesBulkToggle(Request $request)
    {
        $data = $request->validate([
            'ids'    => 'required|array|min:1',
            'ids.*'  => 'integer|exists:banner_slides,id',
            'action' => 'required|in:activar,desactivar,eliminar',
        ]);

        try {
            $ids = $data['ids'];
            $action = $data['action'];
            $count = count($ids);

            switch ($action) {
                case 'activar':
                    BannerSlide::whereIn('id', $ids)->update(['activo' => true]);
                    $message = "{$count} slide(s) activado(s) correctamente.";
                    break;

                case 'desactivar':
                    BannerSlide::whereIn('id', $ids)->update(['activo' => false]);
                    $message = "{$count} slide(s) desactivado(s) correctamente.";
                    break;

                case 'eliminar':
                    // Obtener slides para eliminar sus imágenes
                    $slides = BannerSlide::whereIn('id', $ids)->get();
                    foreach ($slides as $slide) {
                        if ($slide->imagen && !str_starts_with($slide->imagen, 'http') && \Storage::disk('public')->exists($slide->imagen)) {
                            \Storage::disk('public')->delete($slide->imagen);
                        }
                    }
                    BannerSlide::whereIn('id', $ids)->delete();
                    $message = "{$count} slide(s) eliminado(s) correctamente.";
                    break;
            }

            return response()->json([
                'success' => true,
                'message' => $message,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
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
            'hero_imagen'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480',
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
            $file = $request->file('hero_imagen');
            $dir = public_path('images/inicio');
            if (!file_exists($dir)) mkdir($dir, 0755, true);
            $nombre = uniqid('hero_') . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $nombre);
            $data['hero_imagen'] = 'public/images/inicio/' . $nombre;
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
