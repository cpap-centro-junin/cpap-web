<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PopupAnuncio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PopupAnuncioController extends Controller
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
        
        $query = PopupAnuncio::query();

        // Search by title
        if ($request->filled('q')) {
            $buscar = $request->q;
            $query->where('titulo', 'like', "%{$buscar}%");
        }

        // Filter by active status
        if ($request->filled('estado')) {
            $query->where('activo', $request->estado === 'activo');
        }

        $anuncios = $query->latest()->paginate($perpage)->withQueryString();
        
        return view('admin.inicio.anuncios.index', compact('anuncios'));
    }

    public function create()
    {
        return view('admin.inicio.anuncios.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:200',
            'imagen' => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:4096',
        ]);

        $data['activo'] = $request->boolean('activo');

        $file = $request->file('imagen');
        $data['imagen'] = 'data:' . $file->getMimeType() . ';base64,' . base64_encode(file_get_contents($file->getRealPath()));

        PopupAnuncio::create($data);

        return redirect()->route('admin.inicio.anuncios.index')
            ->with('success', 'Anuncio creado correctamente.');
    }

    public function edit(PopupAnuncio $anuncio)
    {
        return view('admin.inicio.anuncios.edit', compact('anuncio'));
    }

    public function update(Request $request, PopupAnuncio $anuncio)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:200',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:4096',
        ]);

        $data['activo'] = $request->boolean('activo');

        if ($request->hasFile('imagen')) {
            $rawImagen = $anuncio->getOriginal('imagen');
            if ($rawImagen && !str_starts_with($rawImagen, 'data:')) {
                Storage::disk('public')->delete($rawImagen);
            }
            $file = $request->file('imagen');
            $data['imagen'] = 'data:' . $file->getMimeType() . ';base64,' . base64_encode(file_get_contents($file->getRealPath()));
        }

        $anuncio->update($data);

        return redirect()->route('admin.inicio.anuncios.index')
            ->with('success', 'Anuncio actualizado correctamente.');
    }

    public function destroy(PopupAnuncio $anuncio)
    {
        $rawImagen = $anuncio->getOriginal('imagen');
        if ($rawImagen && !str_starts_with($rawImagen, 'data:')) {
            Storage::disk('public')->delete($rawImagen);
        }
        $anuncio->delete();

        return back()->with('success', 'Anuncio eliminado.');
    }

    public function bulkToggle(Request $request)
    {
        $data = $request->validate([
            'ids'    => 'required|array|min:1',
            'ids.*'  => 'integer|exists:popup_anuncios,id',
            'action' => 'required|in:activar,desactivar,eliminar',
        ]);

        try {
            $ids = $data['ids'];
            $action = $data['action'];
            $count = count($ids);

            switch ($action) {
                case 'activar':
                    PopupAnuncio::whereIn('id', $ids)->update(['activo' => true]);
                    $message = "{$count} anuncio(s) activado(s) correctamente.";
                    break;

                case 'desactivar':
                    PopupAnuncio::whereIn('id', $ids)->update(['activo' => false]);
                    $message = "{$count} anuncio(s) desactivado(s) correctamente.";
                    break;

                case 'eliminar':
                    // Obtener anuncios para eliminar sus imágenes
                    $anuncios = PopupAnuncio::whereIn('id', $ids)->get();
                    foreach ($anuncios as $anuncio) {
                        $rawImagen = $anuncio->getOriginal('imagen');
                        if ($rawImagen && !str_starts_with($rawImagen, 'data:')) {
                            Storage::disk('public')->delete($rawImagen);
                        }
                    }
                    PopupAnuncio::whereIn('id', $ids)->delete();
                    $message = "{$count} anuncio(s) eliminado(s) correctamente.";
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

    public function toggleActivo(PopupAnuncio $anuncio)
    {
        $anuncio->update(['activo' => !$anuncio->activo]);
        $msg = $anuncio->activo
            ? 'Anuncio activado. Aparecerá en la página de inicio.'
            : 'Anuncio desactivado.';

        return back()->with('success', $msg);
    }
}
