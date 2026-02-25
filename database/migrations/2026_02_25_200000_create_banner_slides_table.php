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
        Schema::create('banner_slides', function (Blueprint $table) {
            $table->id();
            
            // Tipo de slide: noticia, evento, personalizado
            $table->enum('tipo', ['noticia', 'evento', 'personalizado'])->default('personalizado');
            
            // Referencias opcionales a noticias o eventos
            $table->foreignId('noticia_id')->nullable()->constrained('noticias')->nullOnDelete();
            $table->foreignId('evento_id')->nullable()->constrained('eventos')->nullOnDelete();
            
            // Contenido del slide
            $table->string('tag', 50)->nullable()->comment('Etiqueta superior del slide');
            $table->string('titulo', 200)->comment('Título principal del slide');
            $table->text('descripcion')->nullable()->comment('Texto descriptivo del slide');
            $table->string('imagen', 500)->nullable()->comment('URL de la imagen de fondo');
            
            // Botón de acción
            $table->string('boton_texto', 50)->default('Ver Más');
            $table->string('boton_url', 500)->comment('URL a donde redirige el botón');
            
            // Control
            $table->integer('orden')->default(0)->comment('Orden de aparición (menor = primero)');
            $table->boolean('activo')->default(true)->comment('Si el slide está activo');
            
            $table->timestamps();
            
            // Índices
            $table->index(['activo', 'orden']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banner_slides');
    }
};
