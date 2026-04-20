<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BolsaTrabajo;
use Illuminate\Http\Request;

class SolicitudOfertaController extends Controller
{
    /**
     * Listado tipo bandeja de entrada de solicitudes de ofertas laborales.
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
        
        $perpage = session('pagination_perpage', 10);
        
        $query = BolsaTrabajo::solicitudes();

        // Search by applicant name or email
        if ($request->filled('q')) {
            $buscar = $request->q;
            $query->where(function ($q) use ($buscar) {
                $q->where('nombre_contacto', 'like', "%{$buscar}%")
                  ->orWhere('email_contacto', 'like', "%{$buscar}%");
            });
        }

        // Filter by review status
        if ($request->filled('estado')) {
            $query->where('revisado', $request->estado === 'revisado');
        }

        $solicitudes = $query->latest()->paginate($perpage)->withQueryString();

        return view('admin.solicitudes.index', compact('solicitudes'));
    }

    /**
     * Detalle de una solicitud. Marca como revisada al abrir.
     */
    public function show(BolsaTrabajo $solicitud)
    {
        if (! $solicitud->revisado) {
            $solicitud->update(['revisado' => true]);
        }

        return view('admin.solicitudes.show', compact('solicitud'));
    }

    /**
     * Aprobar solicitud: activa la oferta y establece fecha de publicación.
     */
    public function aprobar(BolsaTrabajo $solicitud)
    {
        $solicitud->update([
            'activo'            => true,
            'revisado'          => true,
            'fecha_publicacion' => now(),
        ]);

        return redirect()
            ->route('admin.solicitudes.index')
            ->with('success', 'Solicitud aprobada. La oferta ya es visible en el sitio web.');
    }

    /**
     * Rechazar y eliminar la solicitud.
     */
    public function rechazar(BolsaTrabajo $solicitud)
    {
        $solicitud->delete();

        return redirect()
            ->route('admin.solicitudes.index')
            ->with('success', 'Solicitud rechazada y eliminada.');
    }

    /**
     * Acciones en masa para solicitudes
     */
    public function bulkToggle(Request $request)
    {
        try {
            $validated = $request->validate([
                'ids'    => 'required|array',
                'ids.*'  => 'integer|exists:bolsa_trabajo,id',
                'action' => 'required|in:eliminar',
            ]);

            $ids = $validated['ids'];
            $action = $validated['action'];

            $count = 0;

            switch ($action) {
                case 'eliminar':
                    $count = BolsaTrabajo::whereIn('id', $ids)->delete();
                    $message = $count . ($count === 1 ? ' solicitud eliminada.' : ' solicitudes eliminadas.');
                    break;

                default:
                    return response()->json(['success' => false, 'message' => 'Acción no válida'], 400);
            }

            return response()->json([
                'success' => true,
                'message' => $message,
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}
