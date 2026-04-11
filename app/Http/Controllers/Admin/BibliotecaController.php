<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RecursoBiblioteca;
use Illuminate\Http\Request;

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
        
        $perpage = session('pagination_perpage', 15);
        
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
            'area_tematica'       => 'required|in:cultural,social,arqueologia,linguistica,biologica',
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
            $dir = public_path('pdf');
            if (!file_exists($dir)) mkdir($dir, 0755, true);
            $nombre = uniqid('biblioteca_') . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $nombre);
            $data['archivo_pdf'] = 'public/pdf/' . $nombre;
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

        // Archivo PDF
        if ($request->hasFile('archivo_pdf')) {
            $file = $request->file('archivo_pdf');
            $dir = public_path('pdf');
            if (!file_exists($dir)) mkdir($dir, 0755, true);
            $nombre = uniqid('biblioteca_') . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $nombre);
            $data['archivo_pdf'] = 'public/pdf/' . $nombre;
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

    /* -------------------------------------------------------
     * DESCARGAR PDF (Admin)
     * ----------------------------------------------------- */
    public function descargarPdf(RecursoBiblioteca $biblioteca)
    {
        if (!$biblioteca->archivo_pdf) {
            abort(404, 'El PDF no está disponible.');
        }

        $nombre = $biblioteca->titulo . '.pdf';

        // Si es ruta en public/ (archivos guardados)
        $pdfPath = public_path($biblioteca->archivo_pdf);
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
