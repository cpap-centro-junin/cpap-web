<?php

namespace App\Http\Controllers;

class ColegiaturaController extends Controller
{
    private const DOCUMENTS = [
        'proceso-colegiacion' => 'proceso-colegiacion.pdf',
        'proceso-habilitacion' => 'proceso-habilitacion.pdf',
        'reglamento-habilitaciones' => 'reglamento-habilitaciones.pdf',
    ];

    public function index()
    {
        return view('colegiatura.index');
    }

    /**
     * Descarga/visualiza documentos fijos de colegiatura.
     */
    public function descargarDocumento(string $documento)
    {
        if (!array_key_exists($documento, self::DOCUMENTS)) {
            abort(404, 'Documento no válido.');
        }

        $filename = self::DOCUMENTS[$documento];
        $absolutePath = $this->resolveDocumentAbsolutePath($filename);

        if (!$absolutePath) {
            abort(404, 'El documento no se encontró.');
        }

        return response()->file($absolutePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }

    private function resolveDocumentAbsolutePath(string $filename): ?string
    {
        $candidates = [
            public_path('storage/colegiatura-documentos/' . $filename),
            public_path('assets/documents/' . $filename),
            public_path('pdf/' . $filename),
            public_path('public/assets/documents/' . $filename),
        ];

        foreach ($candidates as $path) {
            if (is_file($path)) {
                return $path;
            }
        }

        return null;
    }
}
