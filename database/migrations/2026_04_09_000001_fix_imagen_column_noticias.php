<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Si doctrine/dbal no funciona, recreamos la tabla
        Schema::table('noticias', function (Blueprint $table) {
            // Primero, eliminamos la columna actual y la recreamos como longText
            if (Schema::hasColumn('noticias', 'imagen')) {
                DB::statement('ALTER TABLE noticias MODIFY imagen LONGTEXT NULL');
            }
        });
    }

    public function down(): void
    {
        // Revertir a string
    }
};
