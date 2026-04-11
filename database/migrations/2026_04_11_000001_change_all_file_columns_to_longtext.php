<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Cambiar todas las columnas que almacenan archivos base64 de string a longText
     */
    public function up(): void
    {
        // Normativa: archivo_pdf
        Schema::table('normativa_documentos', function (Blueprint $table) {
            $table->longText('archivo_pdf')->nullable()->change();
        });

        // Biblioteca: archivo_pdf e imagen_portada
        Schema::table('biblioteca', function (Blueprint $table) {
            $table->longText('archivo_pdf')->nullable()->change();
            $table->longText('imagen_portada')->nullable()->change();
        });

        // Galería: imagen
        Schema::table('galeria_imagenes', function (Blueprint $table) {
            $table->longText('imagen')->nullable()->change();
        });

        // Colegiados: cv_path y foto (si aún no lo son)
        if (Schema::hasTable('colegiados')) {
            Schema::table('colegiados', function (Blueprint $table) {
                // Cambiar foto solo si no fue cambiada en migración anterior
                try {
                    $table->longText('foto')->nullable()->change();
                } catch (\Exception $e) {
                    // La columna ya podría ser longText de una migración anterior
                }
                
                // Cambiar cv_path
                try {
                    $table->longText('cv_path')->nullable()->change();
                } catch (\Exception $e) {
                    // Manejo de error silencioso
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('normativa_documentos', function (Blueprint $table) {
            $table->string('archivo_pdf')->nullable()->change();
        });

        Schema::table('biblioteca', function (Blueprint $table) {
            $table->string('archivo_pdf')->nullable()->change();
            $table->string('imagen_portada')->nullable()->change();
        });

        Schema::table('galeria_imagenes', function (Blueprint $table) {
            $table->string('imagen')->nullable()->change();
        });

        if (Schema::hasTable('colegiados')) {
            Schema::table('colegiados', function (Blueprint $table) {
                $table->string('foto')->nullable()->change();
                $table->string('cv_path')->nullable()->change();
            });
        }
    }
};
