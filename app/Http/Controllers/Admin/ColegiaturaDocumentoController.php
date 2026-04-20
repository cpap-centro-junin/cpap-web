<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ColegiaturaDocumentoController extends Controller
{
    private const DOCUMENTS = [
        'proceso_colegiacion' => [
            'title' => 'Guia de Colegiacion',
            'description' => 'Documento usado en la seccion de Proceso de Colegiacion y en el boton "Descargar Guia Completa" del home.',
            'filename' => 'proceso-colegiacion.pdf',
        ],
        'proceso_habilitacion' => [
            'title' => 'Guia de Habilitacion',
            'description' => 'Documento usado en la seccion de Proceso de Habilitacion.',
            'filename' => 'proceso-habilitacion.pdf',
        ],
        'reglamento_habilitaciones' => [
            'title' => 'Reglamento de Habilitaciones',
            'description' => 'Documento usado en la seccion de Reglamento Interno.',
            'filename' => 'reglamento-habilitaciones.pdf',
        ],
    ];

    /**
     * Mostrar formulario para reemplazar documentos fijos de colegiatura.
     */
    public function edit()
    {
        $documents = [];

        foreach (self::DOCUMENTS as $key => $doc) {
            $absolutePath = public_path('assets/documents/' . $doc['filename']);
            $exists = file_exists($absolutePath);

            $documents[$key] = [
                'key' => $key,
                'title' => $doc['title'],
                'description' => $doc['description'],
                'filename' => $doc['filename'],
                'url' => asset('assets/documents/' . $doc['filename']),
                'exists' => $exists,
                'size_kb' => $exists ? round(filesize($absolutePath) / 1024, 2) : null,
                'updated_at' => $exists ? date('d/m/Y H:i', filemtime($absolutePath)) : null,
            ];
        }

        return view('admin.colegiatura-documentos.edit', compact('documents'));
    }

    /**
     * Reemplazar uno o varios documentos fijos.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'proceso_colegiacion' => 'nullable|file|mimes:pdf|max:20480',
            'proceso_habilitacion' => 'nullable|file|mimes:pdf|max:20480',
            'reglamento_habilitaciones' => 'nullable|file|mimes:pdf|max:20480',
        ]);

        $targetDir = public_path('assets/documents');
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $updated = [];

        foreach (self::DOCUMENTS as $field => $doc) {
            if (!isset($validated[$field]) || !$validated[$field]) {
                continue;
            }

            $file = $validated[$field];
            $file->move($targetDir, $doc['filename']);
            $updated[] = $doc['title'];
        }

        if (empty($updated)) {
            return redirect()
                ->back()
                ->with('error', 'No seleccionaste ningun PDF para actualizar.');
        }

        return redirect()
            ->back()
            ->with('success', 'Documentos actualizados correctamente: ' . implode(', ', $updated) . '.');
    }
}
