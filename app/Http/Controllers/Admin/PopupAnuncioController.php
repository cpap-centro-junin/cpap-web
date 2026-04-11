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
            'imagen' => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:20480',
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
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:20480',
        ]);

        $data['activo'] = $request->boolean('activo');

        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $data['imagen'] = 'data:' . $file->getMimeType() . ';base64,' . base64_encode(file_get_contents($file->getRealPath()));
        }

        $anuncio->update($data);

        return redirect()->route('admin.inicio.anuncios.index')
            ->with('success', 'Anuncio actualizado correctamente.');
    }

    public function destroy(PopupAnuncio $anuncio)
    {
        $anuncio->delete();

        return back()->with('success', 'Anuncio eliminado.');
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
