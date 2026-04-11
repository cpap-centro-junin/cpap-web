<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Noticia;
use Illuminate\Http\Request;

class NoticiaController extends Controller
{
    public function index(Request $request)
    {
        // Manejar parámetro de items per page
        if ($request->has('perpage')) {
            $perpage = (int) $request->get('perpage');
            if (in_array($perpage, [10, 20, 50, 100])) {
                session(['pagination_perpage' => $perpage]);
            }
        }
        
        $perpage = session('pagination_perpage', 20);
        
        $query = Noticia::query();
        
        // Búsqueda
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('titulo', 'like', "%{$search}%")
                  ->orWhere('resumen', 'like', "%{$search}%")
                  ->orWhere('autor', 'like', "%{$search}%");
            });
        }
        
        // Filtro por categoría
        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }
        
        // Filtro por estado
        if ($request->filled('estado')) {
            $query->where('activo', $request->estado === 'activo');
        }
        
        // Filtro por destacado
        if ($request->filled('destacado')) {
            $query->where('destacado', $request->destacado === 'si');
        }
        
        $noticias = $query->latest()->paginate($perpage)->withQueryString();
        
        return view('admin.noticias.index', compact('noticias'));
    }

    public function create()
    {
        return view('admin.noticias.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo'    => 'required|string|max:255',
            'resumen'   => 'nullable|string|max:400',
            'contenido' => 'required|string',
            'autor'     => 'nullable|string|max:150',
            'categoria' => 'required|string',
            'imagen'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        $data['activo']    = $request->boolean('activo');
        $data['destacado'] = $request->boolean('destacado');
        $data['autor']     = $data['autor'] ?? 'Redacción CPAP';

        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $imagenDir = public_path('images/noticias');
            if (!file_exists($imagenDir)) {
                mkdir($imagenDir, 0755, true);
            }
            $nombreImagen = uniqid('noticia_') . '.' . $file->getClientOriginalExtension();
            $file->move($imagenDir, $nombreImagen);
            $data['imagen'] = 'images/noticias/' . $nombreImagen;
        }

        Noticia::create($data);

        return redirect()->route('admin.noticias.index')
            ->with('success', 'Noticia creada correctamente.');
    }

    public function edit(Noticia $noticia)
    {
        return view('admin.noticias.edit', compact('noticia'));
    }

    public function update(Request $request, Noticia $noticia)
    {
        $data = $request->validate([
            'titulo'    => 'required|string|max:255',
            'resumen'   => 'nullable|string|max:400',
            'contenido' => 'required|string',
            'autor'     => 'nullable|string|max:150',
            'categoria' => 'required|string',
            'imagen'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        $data['activo']    = $request->boolean('activo');
        $data['destacado'] = $request->boolean('destacado');
        $data['autor']     = $data['autor'] ?? 'Redacción CPAP';

        if ($request->hasFile('imagen')) {
            // Eliminar imagen antigua si existe
            $imagenAntigua = $noticia->getOriginal('imagen');
            if ($imagenAntigua && !str_starts_with($imagenAntigua, 'data:') && !str_starts_with($imagenAntigua, 'http')) {
                $rutaRela = $imagenAntigua;
                if (str_starts_with($rutaRela, 'public/')) {
                    $rutaRela = substr($rutaRela, 7); // Remover "public/"
                }
                $rutaAntigua = public_path($rutaRela);
                if (file_exists($rutaAntigua)) {
                    @unlink($rutaAntigua);
                }
            }
            
            // Guardar nueva imagen
            $file = $request->file('imagen');
            $imagenDir = public_path('images/noticias');
            if (!file_exists($imagenDir)) {
                mkdir($imagenDir, 0755, true);
            }
            $nombreImagen = uniqid('noticia_') . '.' . $file->getClientOriginalExtension();
            $file->move($imagenDir, $nombreImagen);
            $data['imagen'] = 'public/images/noticias/' . $nombreImagen;
        }

        $noticia->update($data);

        return redirect()->route('admin.noticias.index')
            ->with('success', 'Noticia actualizada correctamente.');
    }

    public function destroy(Noticia $noticia)
    {
        $rawImagen = $noticia->getOriginal('imagen');
        if ($rawImagen && !str_starts_with($rawImagen, 'data:') && !str_starts_with($rawImagen, 'http')) {
            $rutaRela = $rawImagen;
            if (str_starts_with($rutaRela, 'public/')) {
                $rutaRela = substr($rutaRela, 7); // Remover "public/"
            }
            $rutaImagen = public_path($rutaRela);
            if (file_exists($rutaImagen)) {
                @unlink($rutaImagen);
            }
        }
        $noticia->delete();
        return back()->with('success', 'Noticia eliminada.');
    }

    public function show(Noticia $noticia)
    {
        return view('noticias.show', compact('noticia'));
    }
}
