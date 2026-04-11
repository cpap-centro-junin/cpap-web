<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GaleriaImagen;
use Illuminate\Http\Request;

class GaleriaController extends Controller
{
    /**
     * Listado con filtros y paginación.
     */
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
        
        $query = GaleriaImagen::query();

        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }

        if ($request->filled('estado')) {
            $query->where('activo', $request->estado === 'activo');
        }

        if ($request->filled('q')) {
            $buscar = $request->q;
            $query->where(function ($q) use ($buscar) {
                $q->where('titulo', 'like', "%{$buscar}%")
                  ->orWhere('descripcion', 'like', "%{$buscar}%");
            });
        }

        $imagenes = $query->orderByDesc('destacado')
                          ->orderBy('orden')
                          ->orderByDesc('created_at')
                          ->paginate($perpage)
                          ->withQueryString();

        $categorias = GaleriaImagen::categoriasDisponibles();

        return view('admin.galeria.index', compact('imagenes', 'categorias'));
    }

    /**
     * Formulario de creación.
     */
    public function create()
    {
        $categorias = GaleriaImagen::categoriasDisponibles();
        return view('admin.galeria.create', compact('categorias'));
    }

    /**
     * Guardar nueva imagen.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo'      => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
            'imagen'      => 'required|image|mimes:jpg,jpeg,png,webp|max:20480',
            'categoria'   => 'nullable|string|max:100',
            'fecha'       => 'nullable|date',
            'destacado'   => 'nullable|boolean',
            'activo'      => 'nullable|boolean',
        ]);

        $file = $request->file('imagen');
        $filename = $file->move(public_path('images/galeria'), uniqid('galeria_') . '.' . $file->getClientOriginalExtension());
        $data['imagen'] = 'images/galeria/' . basename($filename);
        $data['destacado'] = $request->boolean('destacado');
        $data['activo']    = $request->boolean('activo', true);
        $data['orden']     = GaleriaImagen::max('orden') + 1;

        GaleriaImagen::create($data);

        return redirect()->route('admin.galeria.index')
                         ->with('success', 'Imagen agregada a la galería exitosamente.');
    }

    /**
     * Subida masiva de imágenes — Paso 1: sube archivos y redirige a edición.
     */
    public function storeMasivo(Request $request)
    {
        $request->validate([
            'imagenes'   => 'required|array|min:1|max:20',
            'imagenes.*' => 'image|mimes:jpg,jpeg,png,webp|max:20480',
        ]);

        $orden = GaleriaImagen::max('orden') + 1;
        $ids   = [];

        foreach ($request->file('imagenes') as $file) {
            $filename = $file->move(public_path('images/galeria'), uniqid('galeria_') . '.' . $file->getClientOriginalExtension());
            $imagenPath = 'images/galeria/' . basename($filename);
            $nombre = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

            $img = GaleriaImagen::create([
                'titulo'    => str_replace(['-', '_'], ' ', $nombre),
                'imagen'    => $imagenPath,
                'activo'    => true,
                'destacado' => false,
                'orden'     => $orden++,
            ]);

            $ids[] = $img->id;
        }

        // Redirigir al paso 2: edición masiva
        return redirect()->route('admin.galeria.edit-masivo', ['ids' => implode(',', $ids)])
                         ->with('success', count($ids) . ' imágenes subidas. Ahora puedes editar los detalles de cada una.');
    }

    /**
     * Edición masiva — Paso 2: formulario para editar todas las imágenes subidas.
     */
    public function editMasivo(Request $request)
    {
        $ids = collect(explode(',', $request->query('ids', '')))
                ->filter()
                ->map(fn($id) => (int) $id);

        $imagenes   = GaleriaImagen::whereIn('id', $ids)->orderBy('orden')->get();
        $categorias = GaleriaImagen::categoriasDisponibles();

        if ($imagenes->isEmpty()) {
            return redirect()->route('admin.galeria.index')
                             ->with('success', 'No se encontraron imágenes para editar.');
        }

        return view('admin.galeria.edit-masivo', compact('imagenes', 'categorias'));
    }

    /**
     * Actualización masiva — guarda cambios de todas las imágenes.
     */
    public function updateMasivo(Request $request)
    {
        $request->validate([
            'imagenes'               => 'required|array',
            'imagenes.*.id'          => 'required|exists:galeria_imagenes,id',
            'imagenes.*.titulo'      => 'required|string|max:255',
            'imagenes.*.descripcion' => 'nullable|string|max:1000',
            'imagenes.*.categoria'   => 'nullable|string|max:100',
            'imagenes.*.fecha'       => 'nullable|date',
        ]);

        $count = 0;

        foreach ($request->imagenes as $data) {
            $img = GaleriaImagen::find($data['id']);
            if (!$img) continue;

            $img->update([
                'titulo'      => $data['titulo'],
                'descripcion' => $data['descripcion'] ?? null,
                'categoria'   => $data['categoria'] ?? null,
                'fecha'       => $data['fecha'] ?? null,
                'destacado'   => isset($data['destacado']),
                'activo'      => isset($data['activo']),
            ]);

            $count++;
        }

        return redirect()->route('admin.galeria.index')
                         ->with('success', "{$count} imágenes actualizadas exitosamente.");
    }

    /**
     * Formulario de edición.
     */
    public function edit(GaleriaImagen $galeria)
    {
        $categorias = GaleriaImagen::categoriasDisponibles();
        return view('admin.galeria.edit', compact('galeria', 'categorias'));
    }

    /**
     * Actualizar imagen.
     */
    public function update(Request $request, GaleriaImagen $galeria)
    {
        $data = $request->validate([
            'titulo'      => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
            'imagen'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480',
            'categoria'   => 'nullable|string|max:100',
            'fecha'       => 'nullable|date',
            'destacado'   => 'nullable|boolean',
            'activo'      => 'nullable|boolean',
        ]);

        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $filename = $file->move(public_path('images/galeria'), uniqid('galeria_') . '.' . $file->getClientOriginalExtension());
            $data['imagen'] = 'images/galeria/' . basename($filename);
        } else {
            unset($data['imagen']);
        }

        $data['destacado'] = $request->boolean('destacado');
        $data['activo']    = $request->boolean('activo', true);

        $galeria->update($data);

        return redirect()->route('admin.galeria.index')
                         ->with('success', 'Imagen actualizada exitosamente.');
    }

    /**
     * Toggle destacado vía AJAX o redirect.
     */
    public function toggleDestacado(GaleriaImagen $galeria)
    {
        $galeria->update(['destacado' => !$galeria->destacado]);

        return redirect()->route('admin.galeria.index')
                         ->with('success', $galeria->destacado
                             ? "'{$galeria->titulo}' marcada como destacada."
                             : "'{$galeria->titulo}' ya no es destacada.");
    }

    /**
     * Toggle activo.
     */
    public function toggleActivo(GaleriaImagen $galeria)
    {
        $galeria->update(['activo' => !$galeria->activo]);

        return redirect()->route('admin.galeria.index')
                         ->with('success', $galeria->activo
                             ? "'{$galeria->titulo}' activada."
                             : "'{$galeria->titulo}' ocultada.");
    }

    /**
     * Eliminar imagen.
     */
    public function destroy(GaleriaImagen $galeria)
    {
        $galeria->delete();

        return redirect()->route('admin.galeria.index')
                         ->with('success', 'Imagen eliminada de la galería.');
    }
}
