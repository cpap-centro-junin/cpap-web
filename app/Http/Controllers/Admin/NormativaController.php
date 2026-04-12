<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NormativaDocumento;
use Illuminate\Http\Request;

class NormativaController extends Controller
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
        
        $query = NormativaDocumento::query();

        // Search by title
        if ($request->filled('q')) {
            $buscar = $request->q;
            $query->where(function ($q) use ($buscar) {
                $q->where('titulo', 'like', "%{$buscar}%")
                  ->orWhere('descripcion', 'like', "%{$buscar}%");
            });
        }

        // Filter by active status
        if ($request->filled('estado')) {
            $query->where('activo', $request->estado === 'activo');
        }

        $documentos = $query->orderBy('orden')->orderBy('id')->paginate($perpage)->withQueryString();
        
        return view('admin.normativa.index', compact('documentos'));
    }

    public function create()
    {
        $iconos = NormativaDocumento::iconosDisponibles();
        return view('admin.normativa.create', compact('iconos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo'      => 'required|string|max:200',
            'descripcion' => 'nullable|string|max:500',
            'icono'       => 'required|string|max:50',
            'archivo_pdf' => 'nullable|file|mimes:pdf|max:204800',
            'orden'       => 'nullable|integer|min:0',
        ]);

        $data['activo'] = $request->boolean('activo');
        $data['orden']  = $data['orden'] ?? 0;

        if ($request->hasFile('archivo_pdf')) {
            $file = $request->file('archivo_pdf');
            $dir = public_path('pdf');
            if (!file_exists($dir)) mkdir($dir, 0755, true);
            $nombre = uniqid('normativa_') . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $nombre);
            $data['archivo_nombre'] = $file->getClientOriginalName();
            $data['archivo_pdf'] = 'public/pdf/' . $nombre;
        }

        NormativaDocumento::create($data);

        return redirect()->route('admin.normativa.index')
            ->with('success', 'Documento normativo creado correctamente.');
    }

    public function edit(NormativaDocumento $normativa)
    {
        $iconos = NormativaDocumento::iconosDisponibles();
        return view('admin.normativa.edit', compact('normativa', 'iconos'));
    }

    public function update(Request $request, NormativaDocumento $normativa)
    {
        $data = $request->validate([
            'titulo'      => 'required|string|max:200',
            'descripcion' => 'nullable|string|max:500',
            'icono'       => 'required|string|max:50',
            'archivo_pdf' => 'nullable|file|mimes:pdf|max:204800',
            'orden'       => 'nullable|integer|min:0',
        ]);

        $data['activo'] = $request->boolean('activo');
        $data['orden']  = $data['orden'] ?? $normativa->orden;

        if ($request->hasFile('archivo_pdf')) {
            $file = $request->file('archivo_pdf');
            $dir = public_path('pdf');
            if (!file_exists($dir)) mkdir($dir, 0755, true);
            $nombre = uniqid('normativa_') . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $nombre);
            $data['archivo_nombre'] = $file->getClientOriginalName();
            $data['archivo_pdf'] = 'public/pdf/' . $nombre;
        }

        if ($request->boolean('eliminar_pdf') && !$request->hasFile('archivo_pdf')) {
            $data['archivo_pdf'] = null;
            $data['archivo_nombre'] = null;
        }

        $normativa->update($data);

        return redirect()->route('admin.normativa.index')
            ->with('success', 'Documento normativo actualizado correctamente.');
    }

    public function destroy(NormativaDocumento $normativa)
    {
        $normativa->delete();

        return redirect()->route('admin.normativa.index')
            ->with('success', 'Documento normativo eliminado correctamente.');
    }

    public function bulkToggle(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:normativa_documentos,id',
            'action' => 'required|in:activar,desactivar,eliminar'
        ]);

        $ids = $request->ids;
        $action = $request->action;
        $count = count($ids);

        switch($action) {
            case 'activar':
                NormativaDocumento::whereIn('id', $ids)->update(['activo' => true]);
                $message = "{$count} documento(s) activado(s) correctamente.";
                break;
            case 'desactivar':
                NormativaDocumento::whereIn('id', $ids)->update(['activo' => false]);
                $message = "{$count} documento(s) desactivado(s) correctamente.";
                break;
            case 'eliminar':
                $documentos = NormativaDocumento::whereIn('id', $ids)->get();
                foreach ($documentos as $doc) {
                    if ($doc->archivo_pdf) {
                        Storage::disk('public')->delete($doc->archivo_pdf);
                    }
                    $doc->delete();
                }
                $message = "{$count} documento(s) eliminado(s) correctamente.";
                break;
        }

        return response()->json(['success' => true, 'message' => $message]);
    }
    /**
     * Descargar PDF (ruta pública).
     */
    public function descargar(NormativaDocumento $documento)
    {
        if (!$documento->archivo_pdf) {
            abort(404, 'El documento no está disponible.');
        }

        $nombre = $documento->archivo_nombre ?? $documento->titulo . '.pdf';

        // Stripear public/ prefix de la ruta en BD antes de usar public_path()
        $ruta = $documento->archivo_pdf;
        if (str_starts_with($ruta, 'public/')) {
            $ruta = substr($ruta, 7);
        }
        $pdfPath = public_path($ruta);
        if (file_exists($pdfPath)) {
            return response()->download($pdfPath, $nombre, [
                'Content-Type' => 'application/pdf'
            ]);
        }

        // Fallback: si es URL externa
        if (str_starts_with($documento->archivo_pdf, 'http')) {
            return redirect($documento->archivo_pdf);
        }

        abort(404, 'El archivo no se encontró.');
    }
}