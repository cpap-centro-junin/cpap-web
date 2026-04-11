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
            $data['archivo_nombre'] = $file->getClientOriginalName();
            $data['archivo_pdf'] = 'data:' . $file->getMimeType() . ';base64,' . base64_encode(file_get_contents($file->getRealPath()));
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
            $data['archivo_nombre'] = $file->getClientOriginalName();
            $data['archivo_pdf'] = 'data:' . $file->getMimeType() . ';base64,' . base64_encode(file_get_contents($file->getRealPath()));
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

    /**
     * Descargar PDF (ruta pública).
     */
    public function descargar(NormativaDocumento $documento)
    {
        if (!$documento->archivo_pdf) {
            abort(404, 'El documento no está disponible.');
        }

        $nombre = $documento->archivo_nombre ?? $documento->titulo . '.pdf';

        // Si es base64, decodificar y descargar
        if (str_starts_with($documento->archivo_pdf, 'data:')) {
            $parts = explode(';base64,', $documento->archivo_pdf);
            if (count($parts) === 2) {
                $contenido = base64_decode($parts[1]);
                return response()->download(
                    response()->streamDownload(function () use ($contenido) {
                        echo $contenido;
                    }, $nombre, ['Content-Type' => 'application/pdf'])
                );
            }
        }

        // Fallback: si es URL externa
        if (str_starts_with($documento->archivo_pdf, 'http')) {
            return redirect($documento->archivo_pdf);
        }

        // Si es ruta de storage (por compatibilidad con datos legacy)
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($documento->archivo_pdf)) {
            return \Illuminate\Support\Facades\Storage::disk('public')->download($documento->archivo_pdf, $nombre);
        }

        abort(404, 'El documento no está disponible.');
    }
}
