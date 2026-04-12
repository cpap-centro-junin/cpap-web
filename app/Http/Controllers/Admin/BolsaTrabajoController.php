<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BolsaTrabajo;
use Illuminate\Http\Request;

class BolsaTrabajoController extends Controller
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
        
        $perpage = session('pagination_perpage', 10);
        
        $query = BolsaTrabajo::query();
        
        // Búsqueda
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('titulo', 'like', "%{$search}%")
                  ->orWhere('empresa', 'like', "%{$search}%")
                  ->orWhere('descripcion', 'like', "%{$search}%");
            });
        }
        
        // Filtro por tipo
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }
        
        // Filtro por área
        if ($request->filled('area')) {
            $query->where('area', $request->area);
        }
        
        // Filtro por estado
        if ($request->filled('estado')) {
            $query->where('activo', $request->estado === 'activo');
        }
        
        $ofertas = $query->orderBy('fecha_publicacion', 'desc')->paginate($perpage)->withQueryString();
        
        return view('admin.bolsa.index', compact('ofertas'));
    }

    public function create()
    {
        return view('admin.bolsa.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo'              => 'required|string|max:255',
            'empresa'             => 'required|string|max:255',
            'ubicacion'           => 'required|string|max:255',
            'tipo'                => 'required|in:fulltime,parttime,freelance,consultoria',
            'area'                => 'required|in:investigacion,docencia,consultoria,gestion',
            'descripcion'         => 'required|string',
            'salario'             => 'nullable|string|max:255',
            'enlace_postulacion'  => 'nullable|url|max:500',
            'fecha_publicacion'   => 'required|date',
            'fecha_vencimiento'   => 'nullable|date|after_or_equal:fecha_publicacion',
            'activo'              => 'boolean',
        ]);

        $data['activo'] = $request->has('activo') ? (bool) $request->activo : true;

        BolsaTrabajo::create($data);

        return redirect()->route('admin.bolsa.index')
                         ->with('success', 'Oferta de trabajo creada correctamente.');
    }

    public function edit(BolsaTrabajo $bolsa)
    {
        return view('admin.bolsa.edit', ['oferta' => $bolsa]);
    }

    public function update(Request $request, BolsaTrabajo $bolsa)
    {
        $data = $request->validate([
            'titulo'              => 'required|string|max:255',
            'empresa'             => 'required|string|max:255',
            'ubicacion'           => 'required|string|max:255',
            'tipo'                => 'required|in:fulltime,parttime,freelance,consultoria',
            'area'                => 'required|in:investigacion,docencia,consultoria,gestion',
            'descripcion'         => 'required|string',
            'salario'             => 'nullable|string|max:255',
            'enlace_postulacion'  => 'nullable|url|max:500',
            'fecha_publicacion'   => 'required|date',
            'fecha_vencimiento'   => 'nullable|date|after_or_equal:fecha_publicacion',
            'activo'              => 'boolean',
        ]);

        $data['activo'] = $request->has('activo') ? (bool) $request->activo : false;

        $bolsa->update($data);

        return redirect()->route('admin.bolsa.index')
                         ->with('success', 'Oferta actualizada correctamente.');
    }

    public function destroy(BolsaTrabajo $bolsa)
    {
        $bolsa->delete();

        return redirect()->route('admin.bolsa.index')
                         ->with('success', 'Oferta eliminada correctamente.');
    }

    public function bulkToggle(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:bolsa_trabajo,id',
            'action' => 'required|in:activar,desactivar,eliminar'
        ]);

        $ids = $request->ids;
        $action = $request->action;
        $count = count($ids);

        switch($action) {
            case 'activar':
                BolsaTrabajo::whereIn('id', $ids)->update(['activo' => true]);
                $message = "{$count} oferta(s) activada(s) correctamente.";
                break;
            case 'desactivar':
                BolsaTrabajo::whereIn('id', $ids)->update(['activo' => false]);
                $message = "{$count} oferta(s) desactivada(s) correctamente.";
                break;
            case 'eliminar':
                BolsaTrabajo::whereIn('id', $ids)->delete();
                $message = "{$count} oferta(s) eliminada(s) correctamente.";
                break;
        }

        return response()->json(['success' => true, 'message' => $message]);
    }
}
