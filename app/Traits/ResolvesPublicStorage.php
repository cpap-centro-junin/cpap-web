<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

/**
 * Trait para resolver URLs de archivos en disk 'public'.
 * Maneja rutas heredadas con prefijos 'storage/' y 'public/'.
 */
trait ResolvesPublicStorage
{
    /**
     * Resuelve URL de archivo público con fallback si falta el symlink.
     * 
     * @param  string|null $path
     * @return string|null
     */
    protected function resolvePublicStorageUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        // URLs externas y data URIs pasan sin cambios
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') ||
            str_starts_with($path, 'data:')) {
            return $path;
        }

        // Normalizar: convertir backslashes a forward slashes, remover inicio /
        $normalized = ltrim(str_replace('\\', '/', $path), '/');

        // Remover prefijos heredados
        if (str_starts_with($normalized, 'storage/')) {
            $normalized = substr($normalized, 8);
        }
        if (str_starts_with($normalized, 'public/')) {
            $normalized = substr($normalized, 7);
        }

        $normalized = ltrim($normalized, '/');

        // Si existe en Storage::disk('public') O en public/storage directamente → usar asset()
        if (Storage::disk('public')->exists($normalized) || is_file(public_path('storage/' . $normalized))) {
            return asset('storage/' . $normalized);
        }

        // Fallback: servir desde /media/public/{path} (usa PublicMediaController)
        return route('media.public', ['path' => $normalized]);
    }
}
