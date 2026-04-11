<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Colegiado;
use App\Models\Habilitacion;
use App\Services\QRCodeService;
use App\Services\PDFService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HabilitacionController extends Controller
{
    protected $qrService;
    protected $pdfService;

    public function __construct(QRCodeService $qrService, PDFService $pdfService)
    {
        $this->qrService = $qrService;
        $this->pdfService = $pdfService;
    }

    /**
     * Mostrar formulario para subir documento de habilitación
     */
    public function create(Colegiado $colegiado)
    {
        $habilitacionActual = $colegiado->habilitaciones()->first();

        return view('admin.habilitaciones.create', compact('colegiado', 'habilitacionActual'));
    }

    /**
     * Guardar documento de habilitación (reemplaza si ya existe uno)
     *
     * Regla: Un colegiado tiene EXACTAMENTE 1 documento de habilitación.
     * Al subir uno nuevo, el anterior se elimina completamente (archivos + BD).
     * El colegiado pasa a ACTIVO automáticamente al tener un nuevo documento.
     */
    public function store(Request $request, Colegiado $colegiado)
    {
        $request->validate([
            'documento' => 'required|file|mimes:pdf|max:10240',
        ]);

        $qrPath = null;
        $pdfTempPath = null;
        $pdfModificadoTempPath = null;

        try {
            // 1. Generar código y QR
            $codigoVerificacion = $this->qrService->generarCodigoUnicoGarantizado();
            $qrPath = $this->qrService->generarQR($codigoVerificacion, $colegiado->nombre_completo);

            // 2. Guardar PDF temporalmente en temp del sistema
            $documento = $request->file('documento');
            $pdfTempPath = tempnam(sys_get_temp_dir(), 'hab_');
            file_put_contents($pdfTempPath, file_get_contents($documento));

            // 3. Embeber QR y código dentro del PDF
            $urlVerificacion = url("/v/{$codigoVerificacion}");
            $pdfModificadoTempPath = $this->pdfService->embederQREnPDFTemporal(
                $pdfTempPath,
                $qrPath,
                $codigoVerificacion,
                $urlVerificacion
            );

            // 4. Guardar PDF definitivo en public/pdf/
            $nombreFinal = $codigoVerificacion . '.pdf';
            $pdfDir = public_path('pdf');
            if (!file_exists($pdfDir)) {
                mkdir($pdfDir, 0755, true);
            }
            $pdfPath = $pdfDir . '/' . $nombreFinal;
            file_put_contents($pdfPath, file_get_contents($pdfModificadoTempPath));

            // 5. Limpiar temporales
            if (file_exists($pdfTempPath)) {
                @unlink($pdfTempPath);
            }
            if (file_exists($pdfModificadoTempPath)) {
                @unlink($pdfModificadoTempPath);
            }

            // 6. Eliminar habilitación anterior si existe (reemplazo)
            $this->eliminarHabilitacionAnterior($colegiado);

            // 7. Crear nueva habilitación en BD (guardar ruta relativa)
            $documentoPath = 'public/pdf/' . $nombreFinal;
            $habilitacion = Habilitacion::create([
                'colegiado_id'       => $colegiado->id,
                'codigo_verificacion' => $codigoVerificacion,
                'documento_path'     => $documentoPath,
                'qr_path'            => $qrPath,
                'generado_por'       => Auth::id(),
                'activo'             => true,
            ]);

            // 8. El colegiado pasa a ACTIVO al tener un documento vigente
            $colegiado->update(['estado' => 'activo']);

            return redirect()->route('admin.colegiados.show', $colegiado)
                ->with('success', 'Documento de habilitación generado exitosamente.')
                ->with('codigo_generado', $codigoVerificacion)
                ->with('url_verificacion', $habilitacion->url_corta);

        } catch (\Exception $e) {
            // Limpiar archivos generados en caso de error
            if ($qrPath) {
                $this->qrService->eliminarQR($qrPath);
            }
            if ($pdfTempPath && file_exists($pdfTempPath)) {
                @unlink($pdfTempPath);
            }
            if ($pdfModificadoTempPath && file_exists($pdfModificadoTempPath)) {
                @unlink($pdfModificadoTempPath);
            }

            return redirect()->back()
                ->withInput()
                ->withErrors(['documento' => 'Error al procesar el documento: ' . $e->getMessage()]);
        }
    }

    /**
     * Ver/servir el documento de habilitación usando el código de verificación como URL.
     * Ej: /admin/habilitaciones/HC-xxxx-xxxx/documento
     */
    public function documento(string $codigo)
    {
        $habilitacion = Habilitacion::where('codigo_verificacion', $codigo)->firstOrFail();

        $pdfPath = public_path($habilitacion->documento_path);
        
        if (!file_exists($pdfPath)) {
            abort(404, 'Documento no encontrado');
        }

        $nombre = 'Habilitacion_' . $habilitacion->colegiado->codigo_cpap . '.pdf';

        return response()->file($pdfPath, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $nombre . '"',
        ]);
    }

    /**
     * Descargar QR Code
     */
    public function descargarQR(Habilitacion $habilitacion)
    {
        $qrPathCompleto = public_path($habilitacion->qr_path);

        if (!file_exists($qrPathCompleto)) {
            abort(404, 'QR Code no encontrado');
        }

        return response()->download(
            $qrPathCompleto,
            'QR_' . $habilitacion->colegiado->codigo_cpap . '.png'
        );
    }

    /**
     * Revocar documento → Colegiado pasa a INACTIVO
     *
     * La habilitación revocada significa que el colegiado no está habilitado.
     * Por eso el estado del colegiado también cambia a inactivo.
     */
    public function revocar(Habilitacion $habilitacion)
    {
        $habilitacion->update(['activo' => false]);
        $habilitacion->colegiado->update(['estado' => 'inactivo']);

        return redirect()->back()
            ->with('success', 'Documento revocado. El colegiado fue marcado como INACTIVO.');
    }

    /**
     * Reactivar documento → Colegiado pasa a ACTIVO
     *
     * Al reactivar el documento de habilitación, el colegiado también se activa.
     */
    public function reactivar(Habilitacion $habilitacion)
    {
        $habilitacion->update(['activo' => true]);
        $habilitacion->colegiado->update(['estado' => 'activo']);

        return redirect()->back()
            ->with('success', 'Documento reactivado. El colegiado fue marcado como ACTIVO.');
    }

    /**
     * Eliminar permanentemente una habilitación (PDF + QR + BD)
     *
     * Si era la única habilitación activa del colegiado,
     * el colegiado pasa a INACTIVO automáticamente.
     */
    public function destroy(Habilitacion $habilitacion)
    {
        $colegiado = $habilitacion->colegiado;

        // Eliminar PDF del public/pdf/
        $pdfPath = public_path($habilitacion->documento_path);
        if (file_exists($pdfPath)) {
            @unlink($pdfPath);
        }

        // Eliminar QR de public
        $this->qrService->eliminarQR($habilitacion->qr_path);

        // Eliminar registro de BD
        $habilitacion->delete();

        // Si el colegiado ya no tiene habilitaciones activas → pasa a INACTIVO
        if ($colegiado->habilitaciones()->where('activo', true)->count() === 0) {
            $colegiado->update(['estado' => 'inactivo']);
        }

        return redirect()->route('admin.colegiados.show', $colegiado)
            ->with('success', 'Documento de habilitación eliminado permanentemente.');
    }

    /**
     * Eliminar completamente la habilitación anterior de un colegiado (archivos + BD)
     */
    private function eliminarHabilitacionAnterior(Colegiado $colegiado): void
    {
        $anterior = $colegiado->habilitaciones()->first();

        if (!$anterior) {
            return;
        }

        // Eliminar PDF
        $pdfPath = public_path($anterior->documento_path);
        if (file_exists($pdfPath)) {
            @unlink($pdfPath);
        }

        // Eliminar QR
        $this->qrService->eliminarQR($anterior->qr_path);

        // Eliminar registro BD
        $anterior->delete();
    }
}
