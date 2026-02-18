<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Colegiado;
use App\Models\Habilitacion;
use App\Services\QRCodeService;
use App\Services\PDFService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        $rutaTempRelativa = null;
        $pdfModificadoTempPath = null;

        try {
            // 1. Generar código y QR
            $codigoVerificacion = $this->qrService->generarCodigoUnicoGarantizado();
            $qrPath = $this->qrService->generarQR($codigoVerificacion, $colegiado->nombre_completo);

            // 2. Guardar PDF temporalmente
            $documento = $request->file('documento');
            $rutaTempRelativa = 'habilitaciones/temp/' . $codigoVerificacion . '_original.pdf';
            Storage::put($rutaTempRelativa, file_get_contents($documento));

            // 3. Embeber QR y código dentro del PDF
            $urlVerificacion = url("/v/{$codigoVerificacion}");
            $pdfModificadoTempPath = $this->pdfService->embederQREnPDFTemporal(
                Storage::path($rutaTempRelativa),
                $qrPath,
                $codigoVerificacion,
                $urlVerificacion
            );

            // 4. Guardar PDF definitivo
            $nombreFinal = $codigoVerificacion . '.pdf';
            $documentoPath = 'habilitaciones/' . $nombreFinal;
            Storage::put($documentoPath, file_get_contents($pdfModificadoTempPath));

            // 5. Limpiar temporales
            Storage::delete($rutaTempRelativa);
            if (file_exists($pdfModificadoTempPath)) {
                @unlink($pdfModificadoTempPath);
            }

            // 6. Eliminar habilitación anterior si existe (reemplazo)
            $this->eliminarHabilitacionAnterior($colegiado);

            // 7. Crear nueva habilitación en BD
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
            if ($rutaTempRelativa) {
                Storage::delete($rutaTempRelativa);
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
     * Descargar documento de habilitación
     */
    public function descargar(Habilitacion $habilitacion)
    {
        if (!Storage::exists($habilitacion->documento_path)) {
            abort(404, 'Documento no encontrado');
        }

        $nombre = 'Habilitacion_' . $habilitacion->colegiado->codigo_cpap . '.pdf';

        return response()->file(Storage::path($habilitacion->documento_path), [
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

        // Eliminar PDF del storage
        if (Storage::exists($habilitacion->documento_path)) {
            Storage::delete($habilitacion->documento_path);
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
        if (Storage::exists($anterior->documento_path)) {
            Storage::delete($anterior->documento_path);
        }

        // Eliminar QR
        $this->qrService->eliminarQR($anterior->qr_path);

        // Eliminar registro BD
        $anterior->delete();
    }
}
