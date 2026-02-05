<?php

use Illuminate\Support\Facades\Route;

// Dashboard
Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

// Directivos
Route::get('/directivos', function () {
    return view('admin.directivos.index');
})->name('admin.directivos');

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

// Eventos
Route::get('/eventos', function () {
    return view('admin.eventos.index');
})->name('admin.eventos');

// Documentos
Route::get('/documentos', function () {
    return view('admin.documentos.index');
})->name('admin.documentos');

// Invitaciones - Controlador

Route::get('/invitaciones', [App\Http\Controllers\Admin\InvitacionController::class, 'index'])
    ->name('admin.invitaciones');

Route::post('/invitaciones/enviar', [App\Http\Controllers\Admin\InvitacionController::class, 'enviar'])
    ->name('admin.invitaciones.enviar');
