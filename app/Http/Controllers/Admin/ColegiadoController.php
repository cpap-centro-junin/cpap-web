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
use Illuminate\Support\Facades\Storage;

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
            'foto'               => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'especialidad'       => 'nullable|string|max:150',
            'orientacion'        => 'nullable|string|max:150',
            'universidad'        => 'nullable|string|max:200',
            'anio_graduacion'    => 'nullable|integer|min:1950|max:' . date('Y'),
            'descripcion'        => 'nullable|string',
            'cv'                 => 'nullable|file|mimes:pdf|max:5120',
            'estado'             => 'required|in:activo,inactivo',
            'fecha_colegiatura'  => 'required|date',
        ];

        if ($forCreate) {
            $rules['documento'] = 'required|file|mimes:pdf|max:10240';
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
        $qrPath               = null;
        $rutaTempRelativa     = null;
        $pdfModificadoTempPath = null;

        $codigoVerificacion = $this->qrService->generarCodigoUnicoGarantizado();
        $qrPath             = $this->qrService->generarQR($codigoVerificacion, $colegiado->nombre_completo);

        $rutaTempRelativa = 'habilitaciones/temp/' . $codigoVerificacion . '_original.pdf';
        Storage::disk('public')->put($rutaTempRelativa, file_get_contents($archivo));

        $urlVerificacion       = url("/v/{$codigoVerificacion}");
        $pdfModificadoTempPath = $this->pdfService->embederQREnPDFTemporal(
            Storage::disk('public')->path($rutaTempRelativa),
            $qrPath,
            $codigoVerificacion,
            $urlVerificacion
        );

        $documentoPath = 'habilitaciones/' . $codigoVerificacion . '.pdf';
        Storage::disk('public')->put($documentoPath, file_get_contents($pdfModificadoTempPath));

        Storage::disk('public')->delete($rutaTempRelativa);
        if (file_exists($pdfModificadoTempPath)) {
            @unlink($pdfModificadoTempPath);
        }

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

        // Procesar foto y CV antes de la transacción (son operaciones de disco simples)
        if ($request->hasFile('foto')) {
            $foto       = $request->file('foto');
            $ext        = strtolower($foto->getClientOriginalExtension());
            $nombreFoto = $validated['dni'] . '.' . $ext;

            Storage::disk('public')->putFileAs('colegiados', $foto, $nombreFoto);
            $ruta = Storage::disk('public')->path('colegiados/' . $nombreFoto);

            // Redimensionar si excede 800×800 (GD)
            $src = match($ext) {
                'jpg', 'jpeg' => @imagecreatefromjpeg($ruta),
                'png'         => @imagecreatefrompng($ruta),
                default       => null,
            };
            if ($src) {
                $w = imagesx($src); $h = imagesy($src);
                if ($w > 800 || $h > 800) {
                    $ratio = min(800 / $w, 800 / $h);
                    $nw = (int)($w * $ratio); $nh = (int)($h * $ratio);
                    $dst = imagecreatetruecolor($nw, $nh);
                    if ($ext === 'png') { imagealphablending($dst, false); imagesavealpha($dst, true); }
                    imagecopyresampled($dst, $src, 0, 0, 0, 0, $nw, $nh, $w, $h);
                    $ext === 'png' ? imagepng($dst, $ruta) : imagejpeg($dst, $ruta, 85);
                    imagedestroy($dst);
                }
                imagedestroy($src);
            }

            $validated['foto'] = 'colegiados/' . $nombreFoto;
        }

        if ($request->hasFile('cv')) {
            $cv       = $request->file('cv');
            $nombreCV = $validated['dni'] . '_cv.pdf';
            $cv->storeAs('colegiados', $nombreCV, 'public');
            $validated['cv_path'] = 'colegiados/' . $nombreCV;
        }

        $colegiado = null;

        try {
            DB::transaction(function () use ($validated, $request, &$colegiado) {
                $colegiado = Colegiado::create($validated);
                $this->crearHabilitacion($colegiado, $request->file('documento'));
            });
        } catch (\Exception $e) {
            // Limpiar archivos subidos si la transacción falló
            if (isset($validated['foto']) && Storage::disk('public')->exists($validated['foto'])) {
                Storage::disk('public')->delete($validated['foto']);
            }
            if (isset($validated['cv_path']) && Storage::exists($validated['cv_path'])) {
                Storage::delete($validated['cv_path']);
            }

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

        if ($request->hasFile('foto')) {
            if ($colegiado->foto && Storage::disk('public')->exists($colegiado->foto)) {
                Storage::disk('public')->delete($colegiado->foto);
            }
            $foto       = $request->file('foto');
            $ext        = strtolower($foto->getClientOriginalExtension());
            $nombreFoto = $validated['dni'] . '.' . $ext;

            Storage::disk('public')->putFileAs('colegiados', $foto, $nombreFoto);
            $ruta = Storage::disk('public')->path('colegiados/' . $nombreFoto);

            // Redimensionar si excede 800×800 (GD)
            $src = match($ext) {
                'jpg', 'jpeg' => @imagecreatefromjpeg($ruta),
                'png'         => @imagecreatefrompng($ruta),
                default       => null,
            };
            if ($src) {
                $w = imagesx($src); $h = imagesy($src);
                if ($w > 800 || $h > 800) {
                    $ratio = min(800 / $w, 800 / $h);
                    $nw = (int)($w * $ratio); $nh = (int)($h * $ratio);
                    $dst = imagecreatetruecolor($nw, $nh);
                    if ($ext === 'png') { imagealphablending($dst, false); imagesavealpha($dst, true); }
                    imagecopyresampled($dst, $src, 0, 0, 0, 0, $nw, $nh, $w, $h);
                    $ext === 'png' ? imagepng($dst, $ruta) : imagejpeg($dst, $ruta, 85);
                    imagedestroy($dst);
                }
                imagedestroy($src);
            }

            $validated['foto'] = 'colegiados/' . $nombreFoto;
        }

        if ($request->hasFile('cv')) {
            if ($colegiado->cv_path && Storage::disk('public')->exists($colegiado->cv_path)) {
                Storage::disk('public')->delete($colegiado->cv_path);
            }
            $cv       = $request->file('cv');
            $nombreCV = $validated['dni'] . '_cv.pdf';
            $cv->storeAs('colegiados', $nombreCV, 'public');
            $validated['cv_path'] = 'colegiados/' . $nombreCV;
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
        if ($colegiado->foto && Storage::disk('public')->exists($colegiado->foto)) {
            Storage::disk('public')->delete($colegiado->foto);
        }
        if ($colegiado->cv_path && Storage::exists($colegiado->cv_path)) {
            Storage::delete($colegiado->cv_path);
        }

        $colegiado->delete();

        return redirect()->route('admin.colegiados.index')
            ->with('success', 'Colegiado eliminado exitosamente.');
    }

    /**
     * Descargar CV del colegiado (inline PDF)
     */
    public function descargarCV(Colegiado $colegiado)
    {
        if (!$colegiado->cv_path || !Storage::exists($colegiado->cv_path)) {
            abort(404, 'CV no disponible');
        }

        return response()->file(Storage::disk('public')->path($colegiado->cv_path), [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="CV_' . $colegiado->codigo_cpap . '.pdf"',
        ]);
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

    /**
     * Acciones en masa para colegiados: activar, desactivar, ocultar, mostrar, eliminar
     */
    public function bulkToggle(Request $request)
    {
        $data = $request->validate([
            'ids'    => 'required|array|min:1',
            'ids.*'  => 'integer|exists:colegiados,id',
            'action' => 'required|in:activar,desactivar,ocultar,mostrar,eliminar',
        ]);

        try {
            $ids = $data['ids'];
            $action = $data['action'];
            $count = count($ids);

            switch ($action) {
                case 'activar':
                    Colegiado::whereIn('id', $ids)->update(['estado' => 'activo']);
                    // Sincronizar habilitaciones
                    Habilitacion::whereIn('colegiado_id', $ids)->update(['activo' => true]);
                    $message = "{$count} colegiado(s) activado(s) correctamente.";
                    break;

                case 'desactivar':
                    Colegiado::whereIn('id', $ids)->update(['estado' => 'inactivo']);
                    // Sincronizar habilitaciones
                    Habilitacion::whereIn('colegiado_id', $ids)->update(['activo' => false]);
                    $message = "{$count} colegiado(s) desactivado(s) correctamente.";
                    break;

                case 'ocultar':
                    Colegiado::whereIn('id', $ids)->update(['perfil_oculto' => true]);
                    $message = "{$count} perfil(es) ocultado(s) del directorio público.";
                    break;

                case 'mostrar':
                    Colegiado::whereIn('id', $ids)->update(['perfil_oculto' => false]);
                    $message = "{$count} perfil(es) ahora visible(s) en el directorio público.";
                    break;

                case 'eliminar':
                    // Obtener colegiados para eliminar sus archivos
                    $colegiados = Colegiado::whereIn('id', $ids)->get();
                    foreach ($colegiados as $colegiado) {
                        if ($colegiado->foto && Storage::disk('public')->exists($colegiado->foto)) {
                            Storage::disk('public')->delete($colegiado->foto);
                        }
                        if ($colegiado->cv_path && Storage::exists($colegiado->cv_path)) {
                            Storage::delete($colegiado->cv_path);
                        }
                    }
                    Colegiado::whereIn('id', $ids)->delete();
                    $message = "{$count} colegiado(s) eliminado(s) correctamente.";
                    break;
            }

            return response()->json([
                'success' => true,
                'message' => $message,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }
}
