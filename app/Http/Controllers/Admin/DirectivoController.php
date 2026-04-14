<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Directivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            $data['foto'] = 'public/images/directivos/' . basename($filename);
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

        // Procesar nueva foto si se sube
        if ($request->hasFile('foto')) {
            $rawFoto = $directivo->getOriginal('foto');
            if ($rawFoto && !str_starts_with($rawFoto, 'data:')) {
                $rutaFoto = $rawFoto;                
                if (str_starts_with($rutaFoto, 'public/')) {
                    $rutaFoto = substr($rutaFoto, 7); // Remover "public/"
                }                
                $fotoPath = public_path($rutaFoto);
                if (file_exists($fotoPath)) {
                    @unlink($fotoPath);
                }
            }
            $file = $request->file('foto');
            $filename = $file->move(public_path('images/directivos'), uniqid('directivo_') . '.' . $file->getClientOriginalExtension());
            $data['foto'] = 'public/images/directivos/' . basename($filename);
        }
        // Eliminar foto si se solicita (solo si no hay foto nueva)
        elseif ($request->boolean('foto_clear')) {
            $rawFoto = $directivo->getOriginal('foto');
            if ($rawFoto && !str_starts_with($rawFoto, 'data:')) {
                $rutaFoto = $rawFoto;
                if (str_starts_with($rutaFoto, 'public/')) {
                    $rutaFoto = substr($rutaFoto, 7);
                }
                $fotoPath = public_path($rutaFoto);
                if (file_exists($fotoPath)) {
                    @unlink($fotoPath);
                }
            }
            $data['foto'] = null;
        }

        $directivo->update($data);

        return redirect()->route('admin.directivos.index')
            ->with('success', 'Directivo actualizado correctamente.');
    }

    public function destroy(Directivo $directivo)
    {
        $rawFoto = $directivo->getOriginal('foto');
        if ($rawFoto && !str_starts_with($rawFoto, 'data:')) {
            $rutaFoto = $rawFoto;
            if (str_starts_with($rutaFoto, 'public/')) {
                $rutaFoto = substr($rutaFoto, 7); // Remover "public/"
            }
            @unlink(public_path($rutaFoto));
        }
        $directivo->delete();

        return back()->with('success', 'Directivo eliminado.');
    }

    public function bulkToggle(Request $request)
    {
        $data = $request->validate([
            'ids'    => 'required|array|min:1',
            'ids.*'  => 'integer|exists:directivos,id',
            'action' => 'required|in:activar,desactivar,eliminar',
        ]);

        try {
            $ids = $data['ids'];
            $action = $data['action'];
            $count = count($ids);

            switch ($action) {
                case 'activar':
                    Directivo::whereIn('id', $ids)->update(['activo' => true]);
                    $message = "{$count} directivo(s) activado(s) correctamente.";
                    break;

                case 'desactivar':
                    Directivo::whereIn('id', $ids)->update(['activo' => false]);
                    $message = "{$count} directivo(s) desactivado(s) correctamente.";
                    break;

                case 'eliminar':
                    // Obtener directivos para eliminar sus fotos
                    $directivos = Directivo::whereIn('id', $ids)->get();
                    foreach ($directivos as $directivo) {
                        $rawFoto = $directivo->getOriginal('foto');
                        if ($rawFoto && !str_starts_with($rawFoto, 'data:')) {
                            try {
                                Storage::disk('public')->delete($rawFoto);
                            } catch (\Exception $fe) {
                                // Ignorar errores de eliminación de archivos
                            }
                        }
                    }
                    Directivo::whereIn('id', $ids)->delete();
                    $message = "{$count} directivo(s) eliminado(s) correctamente.";
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
}
