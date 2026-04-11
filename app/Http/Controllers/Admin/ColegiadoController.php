<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Colegiado;
use App\Models\Habilitacion;
use App\Services\QRCodeService;
use App\Services\PDFService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ColegiadoController extends Controller
{
    public function __construct(
        protected QRCodeService $qrService,
        protected PDFService    $pdfService
    ) {}

    /**
     * Reglas de validación compartidas entre store y update.
     * $forCreate = true agrega la validación del documento de habilitación (obligatorio).
     */
    private function validationRules(int $excludeId = 0, bool $forCreate = false): array
    {
        $rules = [
            'codigo_cpap'        => "required|string|max:50|unique:colegiados,codigo_cpap,{$excludeId}",
            'dni'                => "required|string|size:8|unique:colegiados,dni,{$excludeId}",
            'nombres'            => 'required|string|max:100',
            'apellidos'          => 'required|string|max:100',
            'email'              => "nullable|email|max:100|unique:colegiados,email,{$excludeId}",
            'telefono'           => 'nullable|string|max:15',
            'fecha_nacimiento'   => 'nullable|date',
            'foto'               => 'nullable|image|mimes:jpg,jpeg,png|max:20480',
            'especialidad'       => 'nullable|string|max:150',
            'orientacion'        => 'nullable|string|max:150',
            'universidad'        => 'nullable|string|max:200',
            'anio_graduacion'    => 'nullable|integer|min:1950|max:' . date('Y'),
            'descripcion'        => 'nullable|string',
            'cv'                 => 'nullable|file|mimes:pdf|max:204800',
            'estado'             => 'required|in:activo,inactivo',
            'fecha_colegiatura'  => 'required|date',
        ];

        if ($forCreate) {
            $rules['documento'] = 'required|file|mimes:pdf|max:204800';
        }

        return $rules;
    }

    /**
     * Procesa campos booleanos de visibilidad desde checkboxes HTML.
     */
    private function resolveVisibilityFields(Request $request): array
    {
        return [
            'perfil_oculto'             => $request->boolean('perfil_oculto'),
            'ocultar_email'             => $request->boolean('ocultar_email'),
            'ocultar_telefono'          => $request->boolean('ocultar_telefono'),
            'ocultar_descripcion'       => $request->boolean('ocultar_descripcion'),
            'ocultar_especialidad'      => $request->boolean('ocultar_especialidad'),
            'ocultar_orientacion'       => $request->boolean('ocultar_orientacion'),
            'ocultar_universidad'       => $request->boolean('ocultar_universidad'),
            'ocultar_anio_graduacion'   => $request->boolean('ocultar_anio_graduacion'),
            'ocultar_fecha_colegiatura' => $request->boolean('ocultar_fecha_colegiatura'),
            'ocultar_foto'              => $request->boolean('ocultar_foto'),
            'ocultar_cv'                => $request->boolean('ocultar_cv'),
        ];
    }

    /**
     * Genera y guarda el documento de habilitación para un colegiado.
     * Misma lógica que HabilitacionController::store().
     * Lanza excepción en caso de error (para rollback de transacción).
     */
    private function crearHabilitacion(Colegiado $colegiado, $archivo): void
    {
        $qrPath = null;
        $pdfTempPath = null;
        $pdfModificadoTempPath = null;

        $codigoVerificacion = $this->qrService->generarCodigoUnicoGarantizado();
        $qrPath = $this->qrService->generarQR($codigoVerificacion, $colegiado->nombre_completo);

        // Guardar PDF temporalmente
        $pdfTempPath = tempnam(sys_get_temp_dir(), 'hab_');
        file_put_contents($pdfTempPath, file_get_contents($archivo));

        $urlVerificacion = url("/v/{$codigoVerificacion}");
        $pdfModificadoTempPath = $this->pdfService->embederQREnPDFTemporal(
            $pdfTempPath,
            $qrPath,
            $codigoVerificacion,
            $urlVerificacion
        );

        // Guardar PDF definitivo en public/pdf/
        $nombreFinal = $codigoVerificacion . '.pdf';
        $pdfDir = public_path('pdf');
        if (!file_exists($pdfDir)) {
            mkdir($pdfDir, 0755, true);
        }
        $pdfPath = $pdfDir . '/' . $nombreFinal;
        file_put_contents($pdfPath, file_get_contents($pdfModificadoTempPath));

        // Limpiar temporales
        if (file_exists($pdfTempPath)) {
            @unlink($pdfTempPath);
        }
        if (file_exists($pdfModificadoTempPath)) {
            @unlink($pdfModificadoTempPath);
        }

        $documentoPath = 'pdf/' . $nombreFinal;
        Habilitacion::create([
            'colegiado_id'        => $colegiado->id,
            'codigo_verificacion' => $codigoVerificacion,
            'documento_path'      => $documentoPath,
            'qr_path'             => $qrPath,
            'generado_por'        => Auth::id(),
            'activo'              => true,
        ]);

        // El colegiado queda activo al tener un documento vigente
        $colegiado->update(['estado' => 'activo']);
    }

    /**
     * Listar todos los colegiados con paginación, búsqueda y filtros.
     */
    public function index(Request $request)
    {
        // Manejar parámetro de items per page
        if ($request->has('perpage')) {
            $perpage = (int) $request->get('perpage');
            if (in_array($perpage, [10, 20, 50, 100])) {
                session(['pagination_perpage' => $perpage]);
            }
        }
        
        $perpage = session('pagination_perpage', 10);
        
        $query = Colegiado::query();

        // Support both 'q' (new) and 'buscar' (legacy) parameters
        $search = $request->filled('q') ? $request->q : $request->buscar;
        if ($search) {
            $query->buscar($search);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('visibilidad')) {
            if ($request->visibilidad === 'oculto') {
                $query->where('perfil_oculto', true);
            } elseif ($request->visibilidad === 'visible') {
                $query->where('perfil_oculto', false);
            }
        }

        $sortableColumns = ['codigo_cpap', 'dni', 'nombres', 'apellidos', 'especialidad', 'estado', 'fecha_colegiatura', 'created_at'];
        $sort  = in_array($request->get('sort', 'created_at'), $sortableColumns)
            ? $request->get('sort', 'created_at')
            : 'created_at';
        $order = in_array(strtolower($request->get('order', 'desc')), ['asc', 'desc'])
            ? strtolower($request->get('order', 'desc'))
            : 'desc';

        $colegiados = $query->orderBy($sort, $order)->paginate($perpage)->withQueryString();

        return view('admin.colegiados.index', compact('colegiados', 'sort', 'order'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        return view('admin.colegiados.create');
    }

    /**
     * Guardar nuevo colegiado junto con su documento de habilitación (obligatorio).
     * Si el procesamiento del documento falla, se hace rollback completo.
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->validationRules(0, true));
        $validated = array_merge($validated, $this->resolveVisibilityFields($request));

        // Procesar foto
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $ext = strtolower($foto->getClientOriginalExtension());
            
            // Crear directorio si no existe
            $fotoDir = public_path('images/colegiados');
            if (!file_exists($fotoDir)) {
                mkdir($fotoDir, 0755, true);
            }
            
            // Redimensionar si excede 800×800
            $tempPath = $foto->getRealPath();
            $src = match($ext) {
                'jpg', 'jpeg' => @imagecreatefromjpeg($tempPath),
                'png'         => @imagecreatefrompng($tempPath),
                default       => null,
            };
            
            $contenidoFoto = file_get_contents($tempPath);
            
            if ($src) {
                $w = imagesx($src); $h = imagesy($src);
                if ($w > 800 || $h > 800) {
                    $ratio = min(800 / $w, 800 / $h);
                    $nw = (int)($w * $ratio); $nh = (int)($h * $ratio);
                    $dst = imagecreatetruecolor($nw, $nh);
                    if ($ext === 'png') { imagealphablending($dst, false); imagesavealpha($dst, true); }
                    imagecopyresampled($dst, $src, 0, 0, 0, 0, $nw, $nh, $w, $h);
                    
                    // Guardar en temporal
                    $tempResized = tempnam(sys_get_temp_dir(), 'foto');
                    $ext === 'png' ? imagepng($dst, $tempResized) : imagejpeg($dst, $tempResized, 85);
                    $contenidoFoto = file_get_contents($tempResized);
                    unlink($tempResized);
                    
                    imagedestroy($dst);
                }
                imagedestroy($src);
            }
            
            // Guardar foto en public/images/colegiados/
            $nombreFoto = uniqid('foto_') . '.' . $ext;
            file_put_contents($fotoDir . '/' . $nombreFoto, $contenidoFoto);
            $validated['foto'] = 'images/colegiados/' . $nombreFoto;
        }

        // Procesar CV
        if ($request->hasFile('cv')) {
            $cv = $request->file('cv');
            
            // Crear directorio si no existe
            $cvDir = public_path('pdf/colegiados');
            if (!file_exists($cvDir)) {
                mkdir($cvDir, 0755, true);
            }
            
            // Guardar CV en public/pdf/colegiados/
            $nombreCV = uniqid('cv_') . '.pdf';
            $cv->move($cvDir, $nombreCV);
            $validated['cv_path'] = 'pdf/colegiados/' . $nombreCV;
        }

        $colegiado = null;

        try {
            DB::transaction(function () use ($validated, $request, &$colegiado) {
                $colegiado = Colegiado::create($validated);
                $this->crearHabilitacion($colegiado, $request->file('documento'));
            });
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['documento' => 'Error al procesar el documento de habilitación: ' . $e->getMessage()]);
        }

        return redirect()->route('admin.colegiados.show', $colegiado)
            ->with('success', 'Colegiado registrado con habilitación exitosamente.');
    }

    /**
     * Mostrar detalle del colegiado (admin)
     */
    public function show(Colegiado $colegiado)
    {
        $colegiado->load('habilitaciones');
        $tieneAlgunaHabilitacion = $colegiado->habilitaciones->count() > 0;
        $tieneHabilitacionActiva = $colegiado->habilitaciones->where('activo', true)->count() > 0;

        return view('admin.colegiados.show', compact('colegiado', 'tieneAlgunaHabilitacion', 'tieneHabilitacionActiva'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Colegiado $colegiado)
    {
        return view('admin.colegiados.edit', compact('colegiado'));
    }

    /**
     * Actualizar colegiado
     */
    public function update(Request $request, Colegiado $colegiado)
    {
        $validated = $request->validate($this->validationRules($colegiado->id));
        $validated = array_merge($validated, $this->resolveVisibilityFields($request));

        // Procesar foto
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $ext = strtolower($foto->getClientOriginalExtension());
            
            // Eliminar foto anterior si existe
            if ($colegiado->foto && !str_starts_with($colegiado->foto, 'data:')) {
                $fotoAntPath = public_path($colegiado->foto);
                if (file_exists($fotoAntPath)) {
                    @unlink($fotoAntPath);
                }
            }
            
            // Crear directorio si no existe
            $fotoDir = public_path('images/colegiados');
            if (!file_exists($fotoDir)) {
                mkdir($fotoDir, 0755, true);
            }
            
            // Redimensionar si excede 800×800
            $tempPath = $foto->getRealPath();
            $src = match($ext) {
                'jpg', 'jpeg' => @imagecreatefromjpeg($tempPath),
                'png'         => @imagecreatefrompng($tempPath),
                default       => null,
            };
            
            $contenidoFoto = file_get_contents($tempPath);
            
            if ($src) {
                $w = imagesx($src); $h = imagesy($src);
                if ($w > 800 || $h > 800) {
                    $ratio = min(800 / $w, 800 / $h);
                    $nw = (int)($w * $ratio); $nh = (int)($h * $ratio);
                    $dst = imagecreatetruecolor($nw, $nh);
                    if ($ext === 'png') { imagealphablending($dst, false); imagesavealpha($dst, true); }
                    imagecopyresampled($dst, $src, 0, 0, 0, 0, $nw, $nh, $w, $h);
                    
                    // Guardar en temporal
                    $tempResized = tempnam(sys_get_temp_dir(), 'foto');
                    $ext === 'png' ? imagepng($dst, $tempResized) : imagejpeg($dst, $tempResized, 85);
                    $contenidoFoto = file_get_contents($tempResized);
                    unlink($tempResized);
                    
                    imagedestroy($dst);
                }
                imagedestroy($src);
            }
            
            // Guardar foto en public/images/colegiados/
            $nombreFoto = uniqid('foto_') . '.' . $ext;
            file_put_contents($fotoDir . '/' . $nombreFoto, $contenidoFoto);
            $validated['foto'] = 'images/colegiados/' . $nombreFoto;
        }

        // Procesar CV
        if ($request->hasFile('cv')) {
            $cv = $request->file('cv');
            
            // Eliminar CV anterior si existe
            if ($colegiado->cv_path && !str_starts_with($colegiado->cv_path, 'data:')) {
                $cvAntPath = public_path($colegiado->cv_path);
                if (file_exists($cvAntPath)) {
                    @unlink($cvAntPath);
                }
            }
            
            // Crear directorio si no existe
            $cvDir = public_path('pdf/colegiados');
            if (!file_exists($cvDir)) {
                mkdir($cvDir, 0755, true);
            }
            
            // Guardar CV en public/pdf/colegiados/
            $nombreCV = uniqid('cv_') . '.pdf';
            $cv->move($cvDir, $nombreCV);
            $validated['cv_path'] = 'pdf/colegiados/' . $nombreCV;
        }

        $colegiado->update($validated);

        Habilitacion::where('colegiado_id', $colegiado->id)
            ->update(['activo' => $validated['estado'] === 'activo']);

        return redirect()->route('admin.colegiados.show', $colegiado)
            ->with('success', 'Colegiado actualizado exitosamente.');
    }

    /**
     * Eliminar colegiado y sus archivos asociados
     */
    public function destroy(Colegiado $colegiado)
    {
        $colegiado->delete();

        return redirect()->route('admin.colegiados.index')
            ->with('success', 'Colegiado eliminado exitosamente.');
    }

    /**
     * Descargar CV del colegiado (inline PDF)
     */
    public function descargarCV(Colegiado $colegiado)
    {
        if (!$colegiado->cv_path) {
            abort(404, 'CV no disponible');
        }

        $filename = 'CV_' . $colegiado->codigo_cpap . '.pdf';

        // Si es ruta en public/pdf/colegiados/
        $cvPath = public_path($colegiado->cv_path);
        if (file_exists($cvPath)) {
            return response()->file($cvPath, [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $filename . '"',
            ]);
        }

        // Si es URL externa
        if (str_starts_with($colegiado->cv_path, 'http')) {
            return redirect($colegiado->cv_path);
        }

        abort(404, 'CV no disponible');
    }

    /**
     * Toggle estado activo/inactivo. Sincroniza habilitaciones.
     */
    public function toggleEstado(Colegiado $colegiado)
    {
        $nuevoEstado = $colegiado->estado === 'activo' ? 'inactivo' : 'activo';
        $colegiado->update(['estado' => $nuevoEstado]);

        Habilitacion::where('colegiado_id', $colegiado->id)
            ->update(['activo' => $nuevoEstado === 'activo']);

        $mensaje = $nuevoEstado === 'activo'
            ? 'Colegiado activado. Su documento de habilitación fue reactivado.'
            : 'Colegiado desactivado. Su documento de habilitación fue revocado.';

        return redirect()->back()->with('success', $mensaje);
    }

    /**
     * Toggle visibilidad del perfil en el directorio público.
     */
    public function togglePerfilOculto(Colegiado $colegiado)
    {
        $nuevoEstado = !$colegiado->perfil_oculto;
        $colegiado->update(['perfil_oculto' => $nuevoEstado]);

        $mensaje = $nuevoEstado
            ? 'Perfil ocultado del directorio público.'
            : 'Perfil ahora visible en el directorio público.';

        return redirect()->back()->with('success', $mensaje);
    }
}
