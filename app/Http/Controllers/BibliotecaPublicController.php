<?php

namespace App\Http\Controllers;

use App\Models\RecursoBiblioteca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BibliotecaPublicController extends Controller
{
    /**
     * Listado público de la biblioteca con búsqueda y filtros.
     */
    public function index(Request $request)
    {
        $query = RecursoBiblioteca::activos();

        // Búsqueda por texto
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('titulo', 'like', "%{$search}%")
                  ->orWhere('autor', 'like', "%{$search}%")
                  ->orWhere('editorial', 'like', "%{$search}%")
                  ->orWhere('descripcion', 'like', "%{$search}%");
            });
        }

        // Filtro por tipo
        if ($request->filled('tipo')) {
            $query->porTipo($request->tipo);
        }

        // Filtro por área
        if ($request->filled('area')) {
            $query->porArea($request->area);
        }

        // Filtro por año
        if ($request->filled('anio')) {
            switch ($request->anio) {
                case '2024':
                    $query->whereBetween('anio_publicacion', [2024, 2026]);
                    break;
                case '2020':
                    $query->whereBetween('anio_publicacion', [2020, 2023]);
                    break;
                case '2015':
                    $query->whereBetween('anio_publicacion', [2015, 2019]);
                    break;
                case 'older':
                    $query->where('anio_publicacion', '<', 2015);
                    break;
            }
        }

        $recursos = $query->orderBy('created_at', 'desc')->paginate(12)->withQueryString();

        // Destacados (para la sección hero)
        $destacados = RecursoBiblioteca::activos()->destacados()
            ->orderBy('created_at', 'desc')->take(3)->get();

        // Conteos por categoría
        $conteos = [
            'libro'      => RecursoBiblioteca::activos()->porTipo('libro')->count(),
            'articulo'   => RecursoBiblioteca::activos()->porTipo('articulo')->count(),
            'tesis'      => RecursoBiblioteca::activos()->porTipo('tesis')->count(),
            'documento'  => RecursoBiblioteca::activos()->porTipo('documento')->count(),
            'revista'    => RecursoBiblioteca::activos()->porTipo('revista')->count(),
            'multimedia' => RecursoBiblioteca::activos()->porTipo('multimedia')->count(),
        ];

        $totalRecursos = RecursoBiblioteca::activos()->count();

        return view('biblioteca.index', compact('recursos', 'destacados', 'conteos', 'totalRecursos'));
    }

    /**
     * Detalle de un recurso (incrementa vistas).
     */
    public function show(RecursoBiblioteca $recurso)
    {
        if (! $recurso->activo) {
            abort(404);
        }

        $recurso->increment('vistas_count');

        // Recursos relacionados (misma área temática)
        $relacionados = RecursoBiblioteca::activos()
            ->where('id', '!=', $recurso->id)
            ->porArea($recurso->area_tematica)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('biblioteca.show', compact('recurso', 'relacionados'));
    }

    /**
     * Descarga de archivo PDF (si está permitido).
     */
    public function descargar(RecursoBiblioteca $recurso)
    {
        if (! $recurso->activo || ! $recurso->descarga_permitida || ! $recurso->archivo_pdf) {
            abort(403, 'La descarga no está disponible para este recurso.');
        }

        $recurso->increment('descargas_count');

        $filename = \Illuminate\Support\Str::slug($recurso->titulo) . '.pdf';

        return Storage::disk('public')->download($recurso->archivo_pdf, $filename);
    }
}
