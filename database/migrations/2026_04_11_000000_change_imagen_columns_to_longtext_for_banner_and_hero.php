<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Cambiar columna imagen en banner_slides de string(500) a longText
        Schema::table('banner_slides', function (Blueprint $table) {
            $table->longText('imagen')->nullable()->change();
        });

        // Cambiar columna hero_imagen en configuracion_inicio de string a longText
        Schema::table('configuracion_inicio', function (Blueprint $table) {
            $table->longText('hero_imagen')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('banner_slides', function (Blueprint $table) {
            $table->string('imagen', 500)->nullable()->change();
        });

        Schema::table('configuracion_inicio', function (Blueprint $table) {
            $table->string('hero_imagen')->nullable()->change();
        });
    }
};
