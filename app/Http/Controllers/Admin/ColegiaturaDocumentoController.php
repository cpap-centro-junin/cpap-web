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
            'slug' => 'proceso-colegiacion',
        ],
        'proceso_habilitacion' => [
            'title' => 'Guia de Habilitacion',
            'description' => 'Documento usado en la seccion de Proceso de Habilitacion.',
            'filename' => 'proceso-habilitacion.pdf',
            'slug' => 'proceso-habilitacion',
        ],
        'reglamento_habilitaciones' => [
            'title' => 'Reglamento de Habilitaciones',
            'description' => 'Documento usado en la seccion de Reglamento Interno.',
            'filename' => 'reglamento-habilitaciones.pdf',
            'slug' => 'reglamento-habilitaciones',
        ],
    ];

    /**
     * Mostrar formulario para reemplazar documentos fijos de colegiatura.
     */
    public function edit()
    {
        $documents = [];

        foreach (self::DOCUMENTS as $key => $doc) {
            $absolutePath = $this->resolveDocumentAbsolutePath($doc['filename']);
            $exists = $absolutePath !== null;

            $documents[$key] = [
                'key' => $key,
                'title' => $doc['title'],
                'description' => $doc['description'],
                'filename' => $doc['filename'],
                'url' => route('colegiatura.documento', $doc['slug']),
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

        $legacyTargetDir = public_path('assets/documents');
        if (!is_dir($legacyTargetDir)) {
            mkdir($legacyTargetDir, 0755, true);
        }

        $updated = [];

        foreach (self::DOCUMENTS as $field => $doc) {
            if (!isset($validated[$field]) || !$validated[$field]) {
                continue;
            }

            $file = $validated[$field];

            // Ruta principal (sin symlink): public/storage/colegiatura-documentos/{archivo}
            $file->storeAs('colegiatura-documentos', $doc['filename'], 'public');

            // Compatibilidad con enlaces legacy existentes
            $storageAbsolutePath = public_path('storage/colegiatura-documentos/' . $doc['filename']);
            $legacyAbsolutePath = $legacyTargetDir . DIRECTORY_SEPARATOR . $doc['filename'];

            if (is_file($storageAbsolutePath)) {
                @copy($storageAbsolutePath, $legacyAbsolutePath);
            }

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

    /**
     * Resuelve la ruta absoluta del PDF buscando en ubicaciones actuales y legacy.
     */
    private function resolveDocumentAbsolutePath(string $filename): ?string
    {
        foreach ($this->getCandidatePaths($filename) as $path) {
            if (is_file($path)) {
                return $path;
            }
        }

        return null;
    }

    /**
     * Ubicaciones candidatas para compatibilidad con distintos despliegues.
     */
    private function getCandidatePaths(string $filename): array
    {
        return [
            public_path('storage/colegiatura-documentos/' . $filename),
            public_path('assets/documents/' . $filename),
            public_path('pdf/' . $filename),
            public_path('public/assets/documents/' . $filename),
        ];
    }
}
