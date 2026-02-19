<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NoticiaController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\VerificacionController;
use App\Http\Controllers\ColegiadoPublicoController;
use App\Http\Controllers\Admin\NoticiaController as AdminNoticiaController;
use App\Http\Controllers\Admin\EventoController  as AdminEventoController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

// ============================================
// PÁGINA PRINCIPAL
// ============================================
Route::get('/', function () {
    $anuncio = \App\Models\PopupAnuncio::where('activo', true)->latest()->first();
    return view('home', compact('anuncio'));
})->name('home');

// ============================================
// SERVICIOS PÚBLICOS
// ============================================
Route::get('/bolsa-trabajo', function () {
    return view('bolsa-trabajo');
})->name('bolsa-trabajo');

Route::get('/biblioteca', function () {
    return view('biblioteca');
})->name('biblioteca');

// ============================================
// NOSOTROS
// ============================================
Route::get('/nosotros/mision-vision', function () {
    return view('nosotros.mision-vision');
})->name('nosotros.mision-vision');

Route::get('/nosotros/historia', function () {
    return view('nosotros.historia');
})->name('nosotros.historia');

Route::get('/nosotros/consejo-directivo', function () {
    $consejo = \App\Models\Directivo::where('activo', true)->orderBy('orden')->orderBy('id')->get();
    return view('nosotros.consejo-directivo', compact('consejo'));
})->name('nosotros.consejo-directivo');

// ============================================
// ACTUALIDAD: NOTICIAS Y EVENTOS (PÚBLICO)
// ============================================
Route::get('/noticias', [NoticiaController::class, 'index'])->name('noticias.index');
Route::get('/noticias/{noticia}', [NoticiaController::class, 'show'])->name('noticias.show');

Route::get('/eventos', [EventoController::class, 'index'])->name('eventos.index');
Route::get('/eventos/{evento}', [EventoController::class, 'show'])->name('eventos.show');

// ============================================
// COLEGIADOS PÚBLICO
// ============================================
Route::get('/colegiados', [ColegiadoPublicoController::class, 'index'])
    ->name('colegiados.index');

Route::get('/colegiados/{colegiado:codigo_cpap}', [ColegiadoPublicoController::class, 'show'])
    ->name('colegiados.show');

Route::get('/colegiados/{colegiado:codigo_cpap}/cv', [ColegiadoPublicoController::class, 'descargarCV'])
    ->name('colegiados.descargar-cv');

// ============================================
// VERIFICACIÓN PÚBLICA
// ============================================
Route::get('/v/{codigo}', [VerificacionController::class, 'verificarCorto'])
    ->name('verificacion.corto');

Route::get('/verificar/{codigo}', [VerificacionController::class, 'verificar'])
    ->name('verificacion.show');

Route::get('/verificar/{codigo}/descargar', [VerificacionController::class, 'descargar'])
    ->name('verificacion.descargar');

// ============================================
// AUTENTICACIÓN
// ============================================

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister']);
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/forgot-password', [AuthController::class, 'showForgot'])
        ->name('forgot-password');

    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])
        ->name('password.email');

    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])
        ->name('password.reset');

    Route::post('/reset-password', [AuthController::class, 'resetPassword'])
        ->name('password.update');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::prefix('admin')->group(base_path('routes/admin.php'));
});



// ============================================
// ADMIN: NOTICIAS Y EVENTOS (CRUD)
// ============================================
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('noticias', AdminNoticiaController::class);
    Route::resource('eventos', AdminEventoController::class);
});
