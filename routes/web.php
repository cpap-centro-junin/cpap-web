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
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\ColegiaturaController;


// ============================================
// PÁGINA PRINCIPAL
// ============================================
Route::get('/', function () {
    $anuncio = \App\Models\PopupAnuncio::where('activo', true)->latest()->first();
    $slides = \App\Models\BannerSlide::activos()->get();
    $config = \App\Models\ConfiguracionInicio::obtener();
    
    return view('home', compact('anuncio', 'slides', 'config'));
})->name('home');

// ============================================
// SERVICIOS PÚBLICOS
// ============================================
Route::get('/bolsa-trabajo', function (\Illuminate\Http\Request $request) {
    $query = \App\Models\BolsaTrabajo::vigentes();

    // Filtro por búsqueda de texto
    if ($request->filled('q')) {
        $buscar = $request->q;
        $query->where(function ($q) use ($buscar) {
            $q->where('titulo', 'like', "%{$buscar}%")
              ->orWhere('empresa', 'like', "%{$buscar}%")
              ->orWhere('ubicacion', 'like', "%{$buscar}%")
              ->orWhere('descripcion', 'like', "%{$buscar}%");
        });
    }

    // Filtro por tipo
    if ($request->filled('tipo')) {
        $query->where('tipo', $request->tipo);
    }

    // Filtro por área
    if ($request->filled('area')) {
        $query->where('area', $request->area);
    }

    $ofertas = $query->orderBy('fecha_publicacion', 'desc')->paginate(12)->withQueryString();

    return view('bolsa-trabajo', compact('ofertas'));
})->name('bolsa-trabajo');

Route::post('/bolsa-trabajo/solicitar', function (\Illuminate\Http\Request $request) {
    $data = $request->validate([
        'nombre_contacto'    => 'required|string|max:100',
        'email_contacto'     => 'required|email|max:255',
        'titulo'             => 'required|string|max:255',
        'empresa'            => 'required|string|max:255',
        'ubicacion'          => 'required|string|max:255',
        'tipo'               => 'required|in:fulltime,parttime,freelance,consultoria',
        'area'               => 'required|in:investigacion,docencia,consultoria,gestion',
        'descripcion'        => 'required|string|min:20',
        'salario'            => 'nullable|string|max:255',
    ]);

    $oferta = \App\Models\BolsaTrabajo::create([
        'titulo'             => $data['titulo'],
        'empresa'            => $data['empresa'],
        'ubicacion'          => $data['ubicacion'],
        'tipo'               => $data['tipo'],
        'area'               => $data['area'],
        'descripcion'        => $data['descripcion'],
        'salario'            => $data['salario'] ?? null,
        'email_contacto'     => $data['email_contacto'],
        'fecha_publicacion'  => now()->toDateString(),
        'activo'             => false,
    ]);

    \Illuminate\Support\Facades\Mail::to('juancarloschmm@gmail.com')
        ->send(new \App\Mail\SolicitudOfertaLaboralMail($oferta));

    return response()->json(['success' => true, 'message' => 'Solicitud enviada correctamente.']);
})->name('bolsa-trabajo.solicitar');

Route::get('/biblioteca', [\App\Http\Controllers\BibliotecaPublicController::class, 'index'])->name('biblioteca');
Route::get('/biblioteca/{recurso}', [\App\Http\Controllers\BibliotecaPublicController::class, 'show'])->name('biblioteca.show');
Route::get('/biblioteca/{recurso}/descargar', [\App\Http\Controllers\BibliotecaPublicController::class, 'descargar'])->name('biblioteca.descargar');

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

Route::get('/nosotros/normativa-legal', function () {
    $documentos = \App\Models\NormativaDocumento::activos()->orderBy('orden')->get();
    return view('nosotros.normativa-legal', compact('documentos'));
})->name('nosotros.normativa-legal');

Route::get('/nosotros/normativa-legal/{documento}/descargar', [\App\Http\Controllers\Admin\NormativaController::class, 'descargar'])
    ->name('nosotros.normativa.descargar');

// CONTACTO PUBLICO
Route::get('/contacto', [ContactoController::class, 'index'])
    ->name('contacto.index');

Route::post('/contacto', [ContactoController::class, 'send'])
    ->name('contact.send');


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

//COLEGIATURA

Route::get('/colegiatura', [ColegiaturaController::class, 'index'])
    ->name('colegiatura.index');



// ============================================
// ADMIN: NOTICIAS Y EVENTOS (CRUD)
// ============================================
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('noticias', AdminNoticiaController::class);
    Route::resource('eventos', AdminEventoController::class);
});
