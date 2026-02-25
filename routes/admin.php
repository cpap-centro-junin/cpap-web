<?php

use Illuminate\Support\Facades\Route;


// Dashboard
Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

// ============================================
// GESTIÓN DE INICIO (HOME PÚBLICO)
// ============================================
use App\Http\Controllers\Admin\InicioController;

// Dashboard principal de Gestión de Inicio
Route::get('/inicio', [InicioController::class, 'index'])->name('admin.inicio.index');

// Banner Slides - CRUD
Route::prefix('inicio/slides')->name('admin.inicio.slides.')->group(function () {
    Route::get('/', [InicioController::class, 'slidesIndex'])->name('index');
    Route::get('/create', [InicioController::class, 'slidesCreate'])->name('create');
    Route::post('/', [InicioController::class, 'slidesStore'])->name('store');
    Route::get('/{slide}/edit', [InicioController::class, 'slidesEdit'])->name('edit');
    Route::put('/{slide}', [InicioController::class, 'slidesUpdate'])->name('update');
    Route::delete('/{slide}', [InicioController::class, 'slidesDestroy'])->name('destroy');
});

// Hero Section
Route::get('/inicio/hero/edit', [InicioController::class, 'heroEdit'])->name('admin.inicio.hero.edit');
Route::put('/inicio/hero', [InicioController::class, 'heroUpdate'])->name('admin.inicio.hero.update');

// Estadísticas
Route::get('/inicio/estadisticas/edit', [InicioController::class, 'estadisticasEdit'])->name('admin.inicio.estadisticas.edit');
Route::put('/inicio/estadisticas', [InicioController::class, 'estadisticasUpdate'])->name('admin.inicio.estadisticas.update');

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
Route::get('/invitaciones', [App\Http\Controllers\Admin\InvitacionController::class, 'index'])
    ->name('admin.invitaciones');

Route::post('/invitaciones/enviar', [App\Http\Controllers\Admin\InvitacionController::class, 'enviar'])
    ->name('admin.invitaciones.enviar');

// ============================================
// NOTA: Las siguientes rutas fueron removidas por no tener funcionalidad:
// - /usuarios (sin implementar)
// - /documentos (sin implementar)
// - /contenido (sin usar)
// - Solicitudes está integrada en Bolsa de Trabajo (ver admin.bolsa.index)
// ============================================

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

// Toggle visibilidad del perfil en el directorio público
Route::patch('/colegiados/{colegiado}/toggle-perfil-oculto', [ColegiadoController::class, 'togglePerfilOculto'])
    ->name('admin.colegiados.toggle-perfil-oculto');

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

// Ver documento de habilitación (URL usa código de verificación)
Route::get('/habilitaciones/{codigo}/documento', [HabilitacionController::class, 'documento'])
    ->name('admin.habilitaciones.documento');

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

// NORMATIVA LEGAL
Route::resource('normativa', \App\Http\Controllers\Admin\NormativaController::class)->names([
    'index'   => 'admin.normativa.index',
    'create'  => 'admin.normativa.create',
    'store'   => 'admin.normativa.store',
    'edit'    => 'admin.normativa.edit',
    'update'  => 'admin.normativa.update',
    'destroy' => 'admin.normativa.destroy',
]);

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

// ============================================
// BOLSA DE TRABAJO
// ============================================

Route::resource('bolsa', \App\Http\Controllers\Admin\BolsaTrabajoController::class)->names([
    'index'   => 'admin.bolsa.index',
    'create'  => 'admin.bolsa.create',
    'store'   => 'admin.bolsa.store',
    'edit'    => 'admin.bolsa.edit',
    'update'  => 'admin.bolsa.update',
    'destroy' => 'admin.bolsa.destroy',
])->except(['show']);

// ============================================
// SOLICITUDES DE OFERTAS LABORALES
// ============================================

use App\Http\Controllers\Admin\SolicitudOfertaController;
use App\Models\BolsaTrabajo;

Route::model('solicitud', BolsaTrabajo::class);

Route::get('/solicitudes-oferta', [SolicitudOfertaController::class, 'index'])
    ->name('admin.solicitudes.index');

Route::get('/solicitudes-oferta/{solicitud}', [SolicitudOfertaController::class, 'show'])
    ->name('admin.solicitudes.show');

Route::patch('/solicitudes-oferta/{solicitud}/aprobar', [SolicitudOfertaController::class, 'aprobar'])
    ->name('admin.solicitudes.aprobar');

Route::delete('/solicitudes-oferta/{solicitud}/rechazar', [SolicitudOfertaController::class, 'rechazar'])
    ->name('admin.solicitudes.rechazar');

// ============================================
// BIBLIOTECA VIRTUAL
// ============================================

Route::resource('biblioteca', \App\Http\Controllers\Admin\BibliotecaController::class)->names([
    'index'   => 'admin.biblioteca.index',
    'create'  => 'admin.biblioteca.create',
    'store'   => 'admin.biblioteca.store',
    'show'    => 'admin.biblioteca.show',
    'edit'    => 'admin.biblioteca.edit',
    'update'  => 'admin.biblioteca.update',
    'destroy' => 'admin.biblioteca.destroy',
]);
