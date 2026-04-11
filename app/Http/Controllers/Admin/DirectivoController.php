<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Directivo;
use Illuminate\Http\Request;

class DirectivoController extends Controller
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
        
        $query = Directivo::query();

        // Search by name or position
        if ($request->filled('q')) {
            $buscar = $request->q;
            $query->where(function ($q) use ($buscar) {
                $q->where('nombre', 'like', "%{$buscar}%")
                  ->orWhere('cargo', 'like', "%{$buscar}%");
            });
        }

        // Filter by active status
        if ($request->filled('estado')) {
            $query->where('activo', $request->estado === 'activo');
        }

        $directivos = $query->orderBy('orden')->orderBy('id')->paginate($perpage)->withQueryString();
        
        return view('admin.directivos.index', compact('directivos'));
    }

    public function create()
    {
        return view('admin.directivos.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cargo'   => 'required|string|max:100',
            'nombre'  => 'required|string|max:200',
            'periodo' => 'nullable|string|max:50',
            'orden'   => 'nullable|integer|min:0',
            'foto'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data['activo'] = $request->boolean('activo');
        $data['orden']  = $data['orden'] ?? 0;
        $data['periodo'] = $data['periodo'] ?? '2024-2026';

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = $file->move(public_path('images/directivos'), uniqid('directivo_') . '.' . $file->getClientOriginalExtension());
            $data['foto'] = 'images/directivos/' . basename($filename);
        }

        Directivo::create($data);

        return redirect()->route('admin.directivos.index')
            ->with('success', 'Directivo creado correctamente.');
    }

    public function edit(Directivo $directivo)
    {
        return view('admin.directivos.edit', compact('directivo'));
    }

    public function update(Request $request, Directivo $directivo)
    {
        $data = $request->validate([
            'cargo'   => 'required|string|max:100',
            'nombre'  => 'required|string|max:200',
            'periodo' => 'nullable|string|max:50',
            'orden'   => 'nullable|integer|min:0',
            'foto'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data['activo'] = $request->boolean('activo');
        $data['orden']  = $data['orden'] ?? $directivo->orden;

        if ($request->hasFile('foto')) {
            $rawFoto = $directivo->getOriginal('foto');
            if ($rawFoto && !str_starts_with($rawFoto, 'data:')) {
                @unlink(public_path($rawFoto));
            }
            $file = $request->file('foto');
            $filename = $file->move(public_path('images/directivos'), uniqid('directivo_') . '.' . $file->getClientOriginalExtension());
            $data['foto'] = 'images/directivos/' . basename($filename);
        }

        $directivo->update($data);

        return redirect()->route('admin.directivos.index')
            ->with('success', 'Directivo actualizado correctamente.');
    }

    public function destroy(Directivo $directivo)
    {
        $rawFoto = $directivo->getOriginal('foto');
        if ($rawFoto && !str_starts_with($rawFoto, 'data:')) {
            @unlink(public_path($rawFoto));
        }
        $directivo->delete();

        return back()->with('success', 'Directivo eliminado.');
    }
}
