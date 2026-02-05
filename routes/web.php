<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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



Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    });

    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Aquí jalamos las rutas del panel admin
    Route::prefix('admin')->group(base_path('routes/admin.php'));
});
