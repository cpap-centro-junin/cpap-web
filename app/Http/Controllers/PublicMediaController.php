<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class PublicMediaController extends Controller
{
    /**
     * Sirve archivos del disco public con validación básica de ruta.
     */
    public function show(string $path)
    {
        $safePath = ltrim(str_replace('\\', '/', $path), '/');

        if (str_starts_with($safePath, 'storage/')) {
            $safePath = substr($safePath, 8);
        }

        if (str_starts_with($safePath, 'public/')) {
            $safePath = substr($safePath, 7);
        }

        $safePath = ltrim($safePath, '/');

        if ($safePath === '' || str_contains($safePath, '..')) {
            abort(Response::HTTP_NOT_FOUND);
        }

        // Verificar si existe en Storage::disk('public') O en public/storage/
        $fileExists = Storage::disk('public')->exists($safePath) || is_file(public_path('storage/' . $safePath));
        if (!$fileExists) {
            abort(Response::HTTP_NOT_FOUND);
        }

        $stream = Storage::disk('public')->readStream($safePath);
        if ($stream === false) {
            abort(Response::HTTP_NOT_FOUND);
        }

        $mimeType = Storage::disk('public')->mimeType($safePath) ?: 'application/octet-stream';

        return response()->stream(function () use ($stream) {
            fpassthru($stream);
            if (is_resource($stream)) {
                fclose($stream);
            }
        }, Response::HTTP_OK, [
            'Content-Type' => $mimeType,
            'Cache-Control' => 'public, max-age=604800',
            'Content-Disposition' => 'inline; filename="' . basename($safePath) . '"',
        ]);
    }
}
