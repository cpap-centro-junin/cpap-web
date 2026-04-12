<?php

namespace App\Helpers;

class PublicPathHelper
{
    /**
     * Retorna la URL correcta para un archivo en la carpeta public.
     * Detecta automáticamente si está en hosting compartido o ambiente local.
     * 
     * @param string $path Ruta relativa comenzando con / (ej: /images/noticias/file.jpg)
     * @return string URL completa accesible desde el navegador
     */
    public static function getPublicUrl($path): string
    {
        if (!$path) {
            return '';
        }

        // Si es URL externa, retornarla tal cual
        if (str_starts_with($path, 'http')) {
            return $path;
        }

        // Si comienza con /, usar asset() directamente
        // (Asume que DocumentRoot está en public/)
        if (str_starts_with($path, '/')) {
            return asset($path);
        }

        // Si no comienza con /, agregar /
        return asset('/' . $path);
    }

    /**
     * Obtiene la ruta relativa correcta para guardar en la BD
     * Usa / para ser compatible con asset()
     * 
     * @param string $directory Directorio (ej: 'images/noticias')
     * @param string $filename Nombre del archivo
     * @return string Ruta para guardar en BD
     */
    public static function getStoragePath($directory, $filename): string
    {
        return '/' . trim($directory, '/') . '/' . $filename;
    }
}
