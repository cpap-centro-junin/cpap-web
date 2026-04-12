<?php

namespace App\Http\Controllers;

use App\Models\Colegiado;
use Illuminate\Http\Request;


class ColegiadoPublicoController extends Controller
{
    /**
     * Buscador público de colegiados.
     * Solo muestra perfiles NO ocultos con habilitación activa.
     */
    public function index(Request $request)
    {
        // Solo columnas necesarias para las cards
        $query = Colegiado::select(
            'id', 'codigo_cpap', 'nombres', 'apellidos',
            'foto', 'especialidad', 'orientacion', 'estado',
            'perfil_oculto',
            'ocultar_foto', 'ocultar_especialidad', 'ocultar_orientacion'
        )
        ->visiblesPublico();

        if ($request->filled('buscar')) {
            $query->buscar($request->buscar);
        }

        if ($request->filled('estado') && in_array($request->estado, ['activo', 'inactivo'])) {
            $query->where('estado', $request->estado);
        }

        $colegiados = $query->orderBy('apellidos')->paginate(12)->withQueryString();

        // Petición AJAX (búsqueda en tiempo real): devuelve solo el grid en JSON.
        // Comprueba tanto X-Requested-With como Accept: application/json para evitar
        // que navegaciones normales del navegador reciban JSON accidentalmente.
        if ($request->ajax() && $request->wantsJson()) {
            return response()->json([
                'html'  => view('colegiados._grid', [
                    'colegiados' => $colegiados,
                    'buscar'     => trim($request->buscar ?? ''),
                ])->render(),
                'total' => $colegiados->total(),
            ])->header('Cache-Control', 'no-store, no-cache, must-revalidate');
        }

        return view('colegiados.index', [
            'colegiados' => $colegiados,
            'buscar'     => $request->buscar ?? '',
            'estado'     => $request->estado ?? '',
        ]);
    }

    /**
     * Perfil público del colegiado.
     * Aborta 404 solo si el perfil está oculto manualmente.
     */
    public function show(Colegiado $colegiado)
    {
        if ($colegiado->perfil_oculto) {
            abort(404);
        }

        // Traemos la habilitación más reciente (activa O revocada).
        // null = nunca tuvo documento → "Sin habilitación"
        // activo=false → "Revocado"
        // activo=true  → "Vigente"
        $habilitacion = $colegiado->habilitaciones()
            ->latest('fecha_subida')
            ->first();

        return view('colegiados.show', compact('colegiado', 'habilitacion'));
    }

    /**
     * Descarga pública del CV del colegiado.
     */
    public function descargarCV(Colegiado $colegiado)
    {
        if ($colegiado->perfil_oculto) {
            abort(404);
        }

        if (!$colegiado->cv_path) {
            abort(404, 'CV no disponible');
        }

        $filename = 'CV_' . $colegiado->codigo_cpap . '.pdf';

        // Stripear public/ prefix de la ruta en BD antes de usar public_path()
        $ruta = $colegiado->cv_path;
        if (str_starts_with($ruta, 'public/')) {
            $ruta = substr($ruta, 7);
        }
        // Si es ruta en public/ (archivos nuevos)
        $cvPath = public_path($ruta);
        if (file_exists($cvPath)) {
            return response()->file($cvPath, [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $filename . '"',
            ]);
        }

        // Fallback: si es URL externa
        if (str_starts_with($colegiado->cv_path, 'http')) {
            return redirect($colegiado->cv_path);
        }

        abort(404, 'CV no disponible');
    }
}
