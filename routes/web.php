<?php

use Illuminate\Support\Facades\Route;

// Página principal
Route::get('/', function () {
    return view('home');
})->name('home');

// Bolsa de Trabajo
Route::get('/bolsa-trabajo', function () {
    return view('bolsa-trabajo');
})->name('bolsa-trabajo');

// Biblioteca Virtual
Route::get('/biblioteca', function () {
    return view('biblioteca');
})->name('biblioteca');

// Nosotros - Misión y Visión
Route::get('/nosotros/mision-vision', function () {
    return view('nosotros.mision-vision');
})->name('nosotros.mision-vision');

//historia
Route::get('/nosotros/historia', function () {
    return view('nosotros.historia');
})->name('nosotros.historia');

//consejo directivo
Route::get('/nosotros/consejo-directivo', function () {
    return view('nosotros.consejo-directivo');
})->name('nosotros.consejo-directivo');

