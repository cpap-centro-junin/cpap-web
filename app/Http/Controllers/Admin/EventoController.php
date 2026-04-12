<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventoController extends Controller
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
        
        $query = Evento::query();
        
        // Búsqueda
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('titulo', 'like', "%{$search}%")
                  ->orWhere('descripcion', 'like', "%{$search}%");
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
        
        $eventos = $query->latest('fecha_inicio')->paginate($perpage)->withQueryString();
        
        return view('admin.eventos.index', compact('eventos'));
    }

    public function create()
    {
        return view('admin.eventos.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo'        => 'required|string|max:255',
            'descripcion'   => 'required|string',
            'resumen'       => 'nullable|string|max:400',
            'lugar'         => 'nullable|string|max:255',
            'fecha_inicio'  => 'required|date',
            'fecha_fin'     => 'nullable|date|after_or_equal:fecha_inicio',
            'hora_inicio'   => 'nullable',
            'imagen_portada'=> 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'categoria'     => 'required|string',
        ]);

        $data['activo']    = $request->boolean('activo');
        $data['destacado'] = $request->boolean('destacado');

        if ($request->hasFile('imagen_portada')) {
            $file = $request->file('imagen_portada');
            $data['imagen_portada'] = 'data:' . $file->getMimeType() . ';base64,' . base64_encode(file_get_contents($file->getRealPath()));
        }

        Evento::create($data);

        return redirect()->route('admin.eventos.index')
            ->with('success', 'Evento creado correctamente.');
    }

    public function edit(Evento $evento)
    {
        return view('admin.eventos.edit', compact('evento'));
    }

    public function update(Request $request, Evento $evento)
    {
        $data = $request->validate([
            'titulo'        => 'required|string|max:255',
            'descripcion'   => 'required|string',
            'resumen'       => 'nullable|string|max:400',
            'lugar'         => 'nullable|string|max:255',
            'fecha_inicio'  => 'required|date',
            'fecha_fin'     => 'nullable|date|after_or_equal:fecha_inicio',
            'hora_inicio'   => 'nullable',
            'imagen_portada'=> 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'categoria'     => 'required|string',
        ]);

        $data['activo']    = $request->boolean('activo');
        $data['destacado'] = $request->boolean('destacado');

        if ($request->hasFile('imagen_portada')) {
            $rawImagen = $evento->getOriginal('imagen_portada');
            if ($rawImagen && !str_starts_with($rawImagen, 'data:')) {
                Storage::disk('public')->delete($rawImagen);
            }
            $file = $request->file('imagen_portada');
            $data['imagen_portada'] = 'data:' . $file->getMimeType() . ';base64,' . base64_encode(file_get_contents($file->getRealPath()));
        }

        $evento->update($data);

        return redirect()->route('admin.eventos.index')
            ->with('success', 'Evento actualizado correctamente.');
    }

    public function destroy(Evento $evento)
    {
        $rawImagen = $evento->getOriginal('imagen_portada');
        if ($rawImagen && !str_starts_with($rawImagen, 'data:')) {
            Storage::disk('public')->delete($rawImagen);
        }
        $evento->delete();

        return back()->with('success', 'Evento eliminado.');
    }

    public function bulkToggle(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:eventos,id',
            'action' => 'required|in:activar,desactivar,destacar,no-destacar,eliminar'
        ]);

        $ids = $request->ids;
        $action = $request->action;
        $count = count($ids);

        switch($action) {
            case 'activar':
                Evento::whereIn('id', $ids)->update(['activo' => true]);
                $message = "{$count} evento(s) publicado(s) correctamente.";
                break;
            case 'desactivar':
                Evento::whereIn('id', $ids)->update(['activo' => false]);
                $message = "{$count} evento(s) guardado(s) como borrador correctamente.";
                break;
            case 'destacar':
                Evento::whereIn('id', $ids)->update(['destacado' => true]);
                $message = "{$count} evento(s) destacado(s) correctamente.";
                break;
            case 'no-destacar':
                Evento::whereIn('id', $ids)->update(['destacado' => false]);
                $message = "{$count} evento(s) sin destaque correctamente.";
                break;
            case 'eliminar':
                $eventos = Evento::whereIn('id', $ids)->get();
                foreach ($eventos as $evento) {
                    $rawImagen = $evento->getOriginal('imagen_portada');
                    if ($rawImagen && !str_starts_with($rawImagen, 'data:')) {
                        Storage::disk('public')->delete($rawImagen);
                    }
                    $evento->delete();
                }
                $message = "{$count} evento(s) eliminado(s) correctamente.";
                break;
        }

        return response()->json(['success' => true, 'message' => $message]);
    }
}
