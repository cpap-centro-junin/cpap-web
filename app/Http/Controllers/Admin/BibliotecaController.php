<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RecursoBiblioteca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BibliotecaController extends Controller
{
    /* -------------------------------------------------------
     * INDEX
     * ----------------------------------------------------- */
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
        
        $query = RecursoBiblioteca::query();

        // Filtros
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('titulo', 'like', "%{$search}%")
                  ->orWhere('autor', 'like', "%{$search}%")
                  ->orWhere('editorial', 'like', "%{$search}%")
                  ->orWhere('isbn_issn', 'like', "%{$search}%");
            });
        }

        if ($request->filled('tipo')) {
            $query->porTipo($request->tipo);
        }

        if ($request->filled('estado')) {
            if ($request->estado === 'publicado') {
                $query->where('activo', true);
            } elseif ($request->estado === 'oculto') {
                $query->where('activo', false);
            }
        }

        if ($request->filled('formato')) {
            $query->porFormato($request->formato);
        }

        $recursos = $query->orderBy('created_at', 'desc')->paginate($perpage)->withQueryString();

        return view('admin.biblioteca.index', compact('recursos'));
    }

    /* -------------------------------------------------------
     * CREATE
     * ----------------------------------------------------- */
    public function create()
    {
        return view('admin.biblioteca.create');
    }

    /* -------------------------------------------------------
     * STORE
     * ----------------------------------------------------- */
    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo'              => 'required|string|max:255',
            'autor'               => 'required|string|max:255',
            'tipo'                => 'required|in:libro,articulo,tesis,documento,revista,multimedia',
            'formato'             => 'required|in:fisico,digital',
            'area_tematica'       => 'required|string|max:255',
            'descripcion'         => 'required|string',
            'editorial'           => 'nullable|string|max:255',
            'anio_publicacion'    => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'isbn_issn'           => 'nullable|string|max:50',
            'paginas'             => 'nullable|integer|min:1',
            'idioma'              => 'nullable|string|max:80',
            'enlace_externo'      => 'nullable|url|max:500',
            'archivo_pdf'         => 'nullable|file|mimes:pdf|max:204800',     // 200 MB
            'imagen_portada'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480', // 20 MB
            'copyright_titular'   => 'nullable|string|max:255',
            'copyright_anio'      => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'licencia_tipo'       => 'required|in:copyright,creative_commons_by,cc_by_sa,cc_by_nc,cc_by_nc_sa,cc_by_nd,cc_by_nc_nd,dominio_publico,licencia_cpap',
            'notas_legales'       => 'nullable|string|max:1000',
            'descarga_permitida'  => 'boolean',
            'solo_colegiados'     => 'boolean',
            'activo'              => 'boolean',
            'destacado'           => 'boolean',
        ]);

        // Archivo PDF
        if ($request->hasFile('archivo_pdf')) {
            $file = $request->file('archivo_pdf');
            $dir = public_path('pdf/biblioteca');
            if (!file_exists($dir)) mkdir($dir, 0755, true);
            $nombre = uniqid('biblioteca_') . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $nombre);
            $data['archivo_pdf'] = 'public/pdf/biblioteca/' . $nombre;
        }

        // Imagen de portada
        if ($request->hasFile('imagen_portada')) {
            $file = $request->file('imagen_portada');
            $dir = public_path('images/biblioteca');
            if (!file_exists($dir)) mkdir($dir, 0755, true);
            $nombre = uniqid('portada_') . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $nombre);
            $data['imagen_portada'] = 'public/images/biblioteca/' . $nombre;
        }

        // Booleans
        $data['activo']              = $request->has('activo') ? (bool) $request->activo : true;
        $data['destacado']           = $request->has('destacado') ? (bool) $request->destacado : false;
        $data['descarga_permitida']  = $request->has('descarga_permitida') ? (bool) $request->descarga_permitida : false;
        $data['solo_colegiados']     = $request->has('solo_colegiados') ? (bool) $request->solo_colegiados : false;

        RecursoBiblioteca::create($data);

        return redirect()->route('admin.biblioteca.index')
                         ->with('success', 'Recurso bibliográfico creado correctamente.');
    }

    /* -------------------------------------------------------
     * SHOW (detalle rápido — opcional)
     * ----------------------------------------------------- */
    public function show(RecursoBiblioteca $biblioteca)
    {
        return view('admin.biblioteca.show', ['recurso' => $biblioteca]);
    }

    /* -------------------------------------------------------
     * EDIT
     * ----------------------------------------------------- */
    public function edit(RecursoBiblioteca $biblioteca)
    {
        return view('admin.biblioteca.edit', ['recurso' => $biblioteca]);
    }

    /* -------------------------------------------------------
     * UPDATE
     * ----------------------------------------------------- */
    public function update(Request $request, RecursoBiblioteca $biblioteca)
    {
        $data = $request->validate([
            'titulo'              => 'required|string|max:255',
            'autor'               => 'required|string|max:255',
            'tipo'                => 'required|in:libro,articulo,tesis,documento,revista,multimedia',
            'formato'             => 'required|in:fisico,digital',
            'area_tematica'       => 'required|string|max:255',
            'descripcion'         => 'required|string',
            'editorial'           => 'nullable|string|max:255',
            'anio_publicacion'    => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'isbn_issn'           => 'nullable|string|max:50',
            'paginas'             => 'nullable|integer|min:1',
            'idioma'              => 'nullable|string|max:80',
            'enlace_externo'      => 'nullable|url|max:500',
            'archivo_pdf'         => 'nullable|file|mimes:pdf|max:204800',      // 200 MB
            'imagen_portada'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480',
            'copyright_titular'   => 'nullable|string|max:255',
            'copyright_anio'      => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'licencia_tipo'       => 'required|in:copyright,creative_commons_by,cc_by_sa,cc_by_nc,cc_by_nc_sa,cc_by_nd,cc_by_nc_nd,dominio_publico,licencia_cpap',
            'notas_legales'       => 'nullable|string|max:1000',
            'descarga_permitida'  => 'boolean',
            'solo_colegiados'     => 'boolean',
            'activo'              => 'boolean',
            'destacado'           => 'boolean',
        ]);

        // Eliminar PDF si se solicita
        if ($request->boolean('pdf_clear')) {
            if ($biblioteca->archivo_pdf) {
                $ruta = $biblioteca->archivo_pdf;
                if (str_starts_with($ruta, 'public/')) {
                    $ruta = substr($ruta, 7);
                }
                $pdfPath = public_path($ruta);
                if (file_exists($pdfPath)) {
                    @unlink($pdfPath);
                }
            }
            $data['archivo_pdf'] = null;
        }
        // Archivo PDF (si se sube uno nuevo)
        elseif ($request->hasFile('archivo_pdf')) {
            // Eliminar anterior si existe
            if ($biblioteca->archivo_pdf) {
                $ruta = $biblioteca->archivo_pdf;
                if (str_starts_with($ruta, 'public/')) {
                    $ruta = substr($ruta, 7);
                }
                $pdfPath = public_path($ruta);
                if (file_exists($pdfPath)) {
                    @unlink($pdfPath);
                }
            }
            $file = $request->file('archivo_pdf');
            $dir = public_path('pdf/biblioteca');
            if (!file_exists($dir)) mkdir($dir, 0755, true);
            $nombre = uniqid('biblioteca_') . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $nombre);
            $data['archivo_pdf'] = 'public/pdf/biblioteca/' . $nombre;
        }

        // Eliminar imagen si se solicita
        if ($request->boolean('imagen_clear')) {
            if ($biblioteca->imagen_portada) {
                $ruta = $biblioteca->imagen_portada;
                if (str_starts_with($ruta, 'public/')) {
                    $ruta = substr($ruta, 7);
                }
                $imagenPath = public_path($ruta);
                if (file_exists($imagenPath)) {
                    @unlink($imagenPath);
                }
            }
            $data['imagen_portada'] = null;
        }
        // Imagen de portada (si se sube una nueva)
        elseif ($request->hasFile('imagen_portada')) {
            // Eliminar anterior si existe
            if ($biblioteca->imagen_portada) {
                $ruta = $biblioteca->imagen_portada;
                if (str_starts_with($ruta, 'public/')) {
                    $ruta = substr($ruta, 7);
                }
                $imagenPath = public_path($ruta);
                if (file_exists($imagenPath)) {
                    @unlink($imagenPath);
                }
            }
            $file = $request->file('imagen_portada');
            $dir = public_path('images/biblioteca');
            if (!file_exists($dir)) mkdir($dir, 0755, true);
            $nombre = uniqid('portada_') . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $nombre);
            $data['imagen_portada'] = 'public/images/biblioteca/' . $nombre;
        }

        // Booleans
        $data['activo']              = $request->has('activo') ? (bool) $request->activo : false;
        $data['destacado']           = $request->has('destacado') ? (bool) $request->destacado : false;
        $data['descarga_permitida']  = $request->has('descarga_permitida') ? (bool) $request->descarga_permitida : false;
        $data['solo_colegiados']     = $request->has('solo_colegiados') ? (bool) $request->solo_colegiados : false;

        $biblioteca->update($data);

        return redirect()->route('admin.biblioteca.index')
                         ->with('success', 'Recurso actualizado correctamente.');
    }

    /* -------------------------------------------------------
     * DESTROY
     * ----------------------------------------------------- */
    public function destroy(RecursoBiblioteca $biblioteca)
    {
        $biblioteca->delete();

        return redirect()->route('admin.biblioteca.index')
                         ->with('success', 'Recurso eliminado correctamente.');
    }

    public function bulkToggle(Request $request)
    {
        try {
            $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'integer|exists:biblioteca,id',
                'action' => 'required|in:fisico,virtual,activar,desactivar,destacar,no-destacar,eliminar'
            ]);

            $ids = $request->ids;
            $action = $request->action;
            $count = count($ids);

            switch($action) {
                case 'fisico':
                    RecursoBiblioteca::whereIn('id', $ids)->update(['formato' => 'fisico']);
                    $message = "{$count} recurso(s) marcado(s) como físico correctamente.";
                    break;
                case 'virtual':
                    RecursoBiblioteca::whereIn('id', $ids)->update(['formato' => 'digital']);
                    $message = "{$count} recurso(s) marcado(s) como virtual correctamente.";
                    break;
                case 'activar':
                    RecursoBiblioteca::whereIn('id', $ids)->update(['activo' => true]);
                    $message = "{$count} recurso(s) publicado(s) correctamente.";
                    break;
                case 'desactivar':
                    RecursoBiblioteca::whereIn('id', $ids)->update(['activo' => false]);
                    $message = "{$count} recurso(s) ocultado(s) correctamente.";
                    break;
                case 'destacar':
                    RecursoBiblioteca::whereIn('id', $ids)->update(['destacado' => true]);
                    $message = "{$count} recurso(s) destacado(s) correctamente.";
                    break;
                case 'no-destacar':
                    RecursoBiblioteca::whereIn('id', $ids)->update(['destacado' => false]);
                    $message = "{$count} recurso(s) sin destaque correctamente.";
                    break;
                case 'eliminar':
                    $recursos = RecursoBiblioteca::whereIn('id', $ids)->get();
                    $eliminados = 0;
                    
                    foreach ($recursos as $recurso) {
                        try {
                            // Eliminar PDF
                            if ($recurso->archivo_pdf) {
                                $ruta = $recurso->archivo_pdf;
                                if (str_starts_with($ruta, 'public/')) {
                                    $ruta = substr($ruta, 7);
                                }
                                $pdfPath = public_path($ruta);
                                if (file_exists($pdfPath)) {
                                    @unlink($pdfPath);
                                }
                            }
                            
                            // Eliminar Imagen
                            if ($recurso->imagen_portada) {
                                $ruta = $recurso->imagen_portada;
                                if (str_starts_with($ruta, 'public/')) {
                                    $ruta = substr($ruta, 7);
                                }
                                $imagenPath = public_path($ruta);
                                if (file_exists($imagenPath)) {
                                    @unlink($imagenPath);
                                }
                            }
                            
                            // Eliminamos el registro
                            $recurso->delete();
                            $eliminados++;
                        } catch (\Exception $e) {
                            \Log::error("Error eliminando recurso {$recurso->id}: " . $e->getMessage());
                        }
                    }
                    
                    if ($eliminados > 0) {
                        if ($eliminados === 1) {
                            $message = "Se eliminó 1 recurso correctamente con sus archivos adjuntos (PDF e imagen).";
                        } else {
                            $message = "Se eliminaron {$eliminados} recursos correctamente con sus archivos adjuntos.";
                        }
                    } else {
                        $message = "No se pudieron eliminar los recursos.";
                    }
                    break;
            }

            return response()->json(['success' => true, 'message' => $message]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /* -------------------------------------------------------
     * DESCARGAR PDF (Admin)
     * ----------------------------------------------------- */
    public function descargarPdf(RecursoBiblioteca $biblioteca)
    {
        if (!$biblioteca->archivo_pdf) {
            abort(404, 'El PDF no está disponible.');
        }

        $nombre = $biblioteca->titulo . '.pdf';

        // Stripear public/ prefix de la ruta en BD antes de usar public_path()
        $ruta = $biblioteca->archivo_pdf;
        if (str_starts_with($ruta, 'public/')) {
            $ruta = substr($ruta, 7);
        }
        
        $pdfPath = public_path($ruta);
        
        if (file_exists($pdfPath)) {
            return response()->file(
                $pdfPath,
                [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="' . $nombre . '"',
                ]
            );
        }

        // Fallback: si es URL externa
        if (str_starts_with($biblioteca->archivo_pdf, 'http')) {
            return redirect($biblioteca->archivo_pdf);
        }

        abort(404, 'El archivo no se encontró.');
    }
}
