<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Actualizar noticias - imagen
        DB::statement(<<<SQL
            UPDATE noticias 
            SET imagen = CONCAT('public/', imagen) 
            WHERE imagen IS NOT NULL 
            AND imagen != '' 
            AND NOT imagen LIKE 'public/%'
            AND NOT imagen LIKE 'http%'
            AND NOT imagen LIKE 'data:%'
        SQL);

        // Actualizar eventos - imagen_portada
        DB::statement(<<<SQL
            UPDATE eventos 
            SET imagen_portada = CONCAT('public/', imagen_portada) 
            WHERE imagen_portada IS NOT NULL 
            AND imagen_portada != '' 
            AND NOT imagen_portada LIKE 'public/%'
            AND NOT imagen_portada LIKE 'http%'
            AND NOT imagen_portada LIKE 'data:%'
        SQL);

        // Actualizar directivos - foto
        DB::statement(<<<SQL
            UPDATE directivos 
            SET foto = CONCAT('public/', foto) 
            WHERE foto IS NOT NULL 
            AND foto != '' 
            AND NOT foto LIKE 'public/%'
            AND NOT foto LIKE 'http%'
            AND NOT foto LIKE 'data:%'
        SQL);

        // Actualizar galeria_imagenes - imagen
        DB::statement(<<<SQL
            UPDATE galeria_imagenes 
            SET imagen = CONCAT('public/', imagen) 
            WHERE imagen IS NOT NULL 
            AND imagen != '' 
            AND NOT imagen LIKE 'public/%'
            AND NOT imagen LIKE 'http%'
            AND NOT imagen LIKE 'data:%'
        SQL);

        // Actualizar popup_anuncios - imagen
        DB::statement(<<<SQL
            UPDATE popup_anuncios 
            SET imagen = CONCAT('public/', imagen) 
            WHERE imagen IS NOT NULL 
            AND imagen != '' 
            AND NOT imagen LIKE 'public/%'
            AND NOT imagen LIKE 'http%'
            AND NOT imagen LIKE 'data:%'
        SQL);

        // Actualizar banner_slides - imagen
        DB::statement(<<<SQL
            UPDATE banner_slides 
            SET imagen = CONCAT('public/', imagen) 
            WHERE imagen IS NOT NULL 
            AND imagen != '' 
            AND NOT imagen LIKE 'public/%'
            AND NOT imagen LIKE 'http%'
            AND NOT imagen LIKE 'data:%'
        SQL);

        // Actualizar configuracion_inicio - hero_imagen (si existe el campo)
        if (Schema::hasColumn('configuracion_inicio', 'hero_imagen')) {
            DB::statement(<<<SQL
                UPDATE configuracion_inicio 
                SET hero_imagen = CONCAT('public/', hero_imagen) 
                WHERE hero_imagen IS NOT NULL 
                AND hero_imagen != '' 
                AND NOT hero_imagen LIKE 'public/%'
                AND NOT hero_imagen LIKE 'http%'
                AND NOT hero_imagen LIKE 'data:%'
            SQL);
        }

        // Actualizar normativa_documentos - archivo_pdf
        DB::statement(<<<SQL
            UPDATE normativa_documentos 
            SET archivo_pdf = CONCAT('public/', archivo_pdf) 
            WHERE archivo_pdf IS NOT NULL 
            AND archivo_pdf != '' 
            AND NOT archivo_pdf LIKE 'public/%'
            AND NOT archivo_pdf LIKE 'http%'
            AND NOT archivo_pdf LIKE 'data:%'
        SQL);

        // Actualizar biblioteca - archivo_pdf
        DB::statement(<<<SQL
            UPDATE biblioteca 
            SET archivo_pdf = CONCAT('public/', archivo_pdf) 
            WHERE archivo_pdf IS NOT NULL 
            AND archivo_pdf != '' 
            AND NOT archivo_pdf LIKE 'public/%'
            AND NOT archivo_pdf LIKE 'http%'
            AND NOT archivo_pdf LIKE 'data:%'
        SQL);

        // Actualizar biblioteca - imagen_portada
        DB::statement(<<<SQL
            UPDATE biblioteca 
            SET imagen_portada = CONCAT('public/', imagen_portada) 
            WHERE imagen_portada IS NOT NULL 
            AND imagen_portada != '' 
            AND NOT imagen_portada LIKE 'public/%'
            AND NOT imagen_portada LIKE 'http%'
            AND NOT imagen_portada LIKE 'data:%'
        SQL);

        // Actualizar colegiados - foto
        DB::statement(<<<SQL
            UPDATE colegiados 
            SET foto = CONCAT('public/', foto) 
            WHERE foto IS NOT NULL 
            AND foto != '' 
            AND NOT foto LIKE 'public/%'
            AND NOT foto LIKE 'http%'
            AND NOT foto LIKE 'data:%'
        SQL);

        // Actualizar colegiados - cv_path
        DB::statement(<<<SQL
            UPDATE colegiados 
            SET cv_path = CONCAT('public/', cv_path) 
            WHERE cv_path IS NOT NULL 
            AND cv_path != '' 
            AND NOT cv_path LIKE 'public/%'
            AND NOT cv_path LIKE 'http%'
            AND NOT cv_path LIKE 'data:%'
        SQL);

        // Actualizar habilitaciones - documento_path
        DB::statement(<<<SQL
            UPDATE habilitaciones 
            SET documento_path = CONCAT('public/', documento_path) 
            WHERE documento_path IS NOT NULL 
            AND documento_path != '' 
            AND NOT documento_path LIKE 'public/%'
            AND NOT documento_path LIKE 'http%'
            AND NOT documento_path LIKE 'data:%'
        SQL);

        // Actualizar habilitaciones - qr_path
        DB::statement(<<<SQL
            UPDATE habilitaciones 
            SET qr_path = CONCAT('public/', qr_path) 
            WHERE qr_path IS NOT NULL 
            AND qr_path != '' 
            AND NOT qr_path LIKE 'public/%'
            AND NOT qr_path LIKE 'http%'
            AND NOT qr_path LIKE 'data:%'
        SQL);

        // Actualizar contact_messages - imagen (si existe el campo)
        if (Schema::hasColumn('contact_messages', 'imagen')) {
            DB::statement(<<<SQL
                UPDATE contact_messages 
                SET imagen = CONCAT('public/', imagen) 
                WHERE imagen IS NOT NULL 
                AND imagen != '' 
                AND NOT imagen LIKE 'public/%'
                AND NOT imagen LIKE 'http%'
                AND NOT imagen LIKE 'data:%'
            SQL);
        }

        // Actualizar contact_messages - archivo_respuesta (si existe el campo)
        if (Schema::hasColumn('contact_messages', 'archivo_respuesta')) {
            DB::statement(<<<SQL
                UPDATE contact_messages 
                SET archivo_respuesta = CONCAT('public/', archivo_respuesta) 
                WHERE archivo_respuesta IS NOT NULL 
                AND archivo_respuesta != '' 
                AND NOT archivo_respuesta LIKE 'public/%'
                AND NOT archivo_respuesta LIKE 'http%'
                AND NOT archivo_respuesta LIKE 'data:%'
            SQL);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Para revertir, simplemente quitamos el prefijo 'public/'
        
        // Revertir noticias - imagen
        DB::statement("UPDATE noticias SET imagen = SUBSTRING(imagen, 8) WHERE imagen LIKE 'public/%'");

        // Revertir eventos - imagen_portada
        DB::statement("UPDATE eventos SET imagen_portada = SUBSTRING(imagen_portada, 8) WHERE imagen_portada LIKE 'public/%'");

        // Revertir directivos - foto
        DB::statement("UPDATE directivos SET foto = SUBSTRING(foto, 8) WHERE foto LIKE 'public/%'");

        // Revertir galeria_imagenes - imagen
        DB::statement("UPDATE galeria_imagenes SET imagen = SUBSTRING(imagen, 8) WHERE imagen LIKE 'public/%'");

        // Revertir popup_anuncios - imagen
        DB::statement("UPDATE popup_anuncios SET imagen = SUBSTRING(imagen, 8) WHERE imagen LIKE 'public/%'");

        // Revertir banner_slides - imagen
        DB::statement("UPDATE banner_slides SET imagen = SUBSTRING(imagen, 8) WHERE imagen LIKE 'public/%'");

        // Revertir configuracion_inicio - hero_imagen
        if (Schema::hasColumn('configuracion_inicio', 'hero_imagen')) {
            DB::statement("UPDATE configuracion_inicio SET hero_imagen = SUBSTRING(hero_imagen, 8) WHERE hero_imagen LIKE 'public/%'");
        }

        // Revertir normativa_documentos - archivo_pdf
        DB::statement("UPDATE normativa_documentos SET archivo_pdf = SUBSTRING(archivo_pdf, 8) WHERE archivo_pdf LIKE 'public/%'");

        // Revertir biblioteca - archivo_pdf
        DB::statement("UPDATE biblioteca SET archivo_pdf = SUBSTRING(archivo_pdf, 8) WHERE archivo_pdf LIKE 'public/%'");

        // Revertir biblioteca - imagen_portada
        DB::statement("UPDATE biblioteca SET imagen_portada = SUBSTRING(imagen_portada, 8) WHERE imagen_portada LIKE 'public/%'");

        // Revertir colegiados - foto
        DB::statement("UPDATE colegiados SET foto = SUBSTRING(foto, 8) WHERE foto LIKE 'public/%'");

        // Revertir colegiados - cv_path
        DB::statement("UPDATE colegiados SET cv_path = SUBSTRING(cv_path, 8) WHERE cv_path LIKE 'public/%'");

        // Revertir habilitaciones - documento_path
        DB::statement("UPDATE habilitaciones SET documento_path = SUBSTRING(documento_path, 8) WHERE documento_path LIKE 'public/%'");

        // Revertir habilitaciones - qr_path
        DB::statement("UPDATE habilitaciones SET qr_path = SUBSTRING(qr_path, 8) WHERE qr_path LIKE 'public/%'");

        // Revertir contact_messages - imagen
        if (Schema::hasColumn('contact_messages', 'imagen')) {
            DB::statement("UPDATE contact_messages SET imagen = SUBSTRING(imagen, 8) WHERE imagen LIKE 'public/%'");
        }

        // Revertir contact_messages - archivo_respuesta
        if (Schema::hasColumn('contact_messages', 'archivo_respuesta')) {
            DB::statement("UPDATE contact_messages SET archivo_respuesta = SUBSTRING(archivo_respuesta, 8) WHERE archivo_respuesta LIKE 'public/%'");
        }
    }
};
