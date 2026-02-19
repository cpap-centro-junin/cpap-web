<?php

use Illuminate\Support\Facades\Route;


// Dashboard
Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

// Directivos
Route::resource('directivos', \App\Http\Controllers\Admin\DirectivoController::class)->names([
    'index'   => 'admin.directivos.index',
    'create'  => 'admin.directivos.create',
    'store'   => 'admin.directivos.store',
    'show'    => 'admin.directivos.show',
    'edit'    => 'admin.directivos.edit',
    'update'  => 'admin.directivos.update',
    'destroy' => 'admin.directivos.destroy',
]);

// Invitaciones
Route::get('/invitaciones', function () {
    return view('admin.invitaciones.index');
})->name('admin.invitaciones');

// Usuarios
Route::get('/usuarios', function () {
    return view('admin.usuarios.index');
})->name('admin.usuarios');

// Contenido
Route::get('/contenido', function () {
    return view('admin.contenido.index');
})->name('admin.contenido');

// Eventos - gestionado por resource route en web.php (admin.eventos.*)
// Route removida para evitar conflicto con Route::resource('eventos', ...)

// Documentos
Route::get('/documentos', function () {
    return view('admin.documentos.index');
})->name('admin.documentos');

// Invitaciones - Controlador

Route::get('/invitaciones', [App\Http\Controllers\Admin\InvitacionController::class, 'index'])
    ->name('admin.invitaciones');

Route::post('/invitaciones/enviar', [App\Http\Controllers\Admin\InvitacionController::class, 'enviar'])
    ->name('admin.invitaciones.enviar');


use App\Http\Controllers\Admin\ColegiadoController;
use App\Http\Controllers\Admin\HabilitacionController;

// Noticias - gestionado por resource route en web.php (admin.noticias.*)

// ============================================
// RUTAS DE COLEGIADOS (CPAP)
// ============================================

// CRUD de Colegiados
Route::resource('colegiados', ColegiadoController::class)->names([
    'index' => 'admin.colegiados.index',
    'create' => 'admin.colegiados.create',
    'store' => 'admin.colegiados.store',
    'show' => 'admin.colegiados.show',
    'edit' => 'admin.colegiados.edit',
    'update' => 'admin.colegiados.update',
    'destroy' => 'admin.colegiados.destroy',
]);

// Toggle estado (activo/inactivo)
Route::patch('/colegiados/{colegiado}/toggle-estado', [ColegiadoController::class, 'toggleEstado'])
    ->name('admin.colegiados.toggle-estado');

// Descargar CV de un colegiado
Route::get('/colegiados/{colegiado}/descargar-cv', [ColegiadoController::class, 'descargarCV'])
    ->name('admin.colegiados.descargar-cv');

// ============================================
// RUTAS DE HABILITACIONES
// ============================================

// Crear nueva habilitación
Route::get('/colegiados/{colegiado}/habilitaciones/create', [HabilitacionController::class, 'create'])
    ->name('admin.habilitaciones.create');

Route::post('/colegiados/{colegiado}/habilitaciones', [HabilitacionController::class, 'store'])
    ->name('admin.habilitaciones.store');

// Descargar documento de habilitación
Route::get('/habilitaciones/{habilitacion}/descargar', [HabilitacionController::class, 'descargar'])
    ->name('admin.habilitaciones.descargar');

// Descargar QR Code
Route::get('/habilitaciones/{habilitacion}/descargar-qr', [HabilitacionController::class, 'descargarQR'])
    ->name('admin.habilitaciones.descargar-qr');

// Revocar/Reactivar
Route::patch('/habilitaciones/{habilitacion}/revocar', [HabilitacionController::class, 'revocar'])
    ->name('admin.habilitaciones.revocar');

Route::patch('/habilitaciones/{habilitacion}/reactivar', [HabilitacionController::class, 'reactivar'])
    ->name('admin.habilitaciones.reactivar');

// Eliminar habilitación
Route::delete('/habilitaciones/{habilitacion}', [HabilitacionController::class, 'destroy'])
    ->name('admin.habilitaciones.destroy');

// ============================================
// POPUP ANUNCIOS EMERGENTES
// ============================================

Route::resource('anuncios', \App\Http\Controllers\Admin\PopupAnuncioController::class)->names([
    'index'   => 'admin.anuncios.index',
    'create'  => 'admin.anuncios.create',
    'store'   => 'admin.anuncios.store',
    'show'    => 'admin.anuncios.show',
    'edit'    => 'admin.anuncios.edit',
    'update'  => 'admin.anuncios.update',
    'destroy' => 'admin.anuncios.destroy',
]);

Route::patch('/anuncios/{anuncio}/toggle', [\App\Http\Controllers\Admin\PopupAnuncioController::class, 'toggleActivo'])
    ->name('admin.anuncios.toggle');

    use App\Http\Controllers\Admin\ContactMessageController;

//MENSAJES

Route::get('/mensajes', [ContactMessageController::class, 'index'])
    ->name('admin.mensajes.index');

Route::get('/mensajes/{message}', [ContactMessageController::class, 'show'])
    ->name('admin.mensajes.show');

Route::post('/mensajes/{message}/responder', [ContactMessageController::class, 'responder'])
    ->name('admin.mensajes.responder');

Route::delete('/mensajes/{message}', 
    [ContactMessageController::class, 'destroy'])
    ->name('admin.mensajes.destroy');
