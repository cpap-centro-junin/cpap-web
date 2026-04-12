<?php

namespace App\Http\Controllers;

use App\Models\Habilitacion;
use App\Models\VerificacionLog;
use Illuminate\Http\Request;

class VerificacionController extends Controller
{
    /**
     * URL corta de verificación (redirige a la completa)
     * Ejemplo: /v/HC-a3f4e8d9-4c2a-41f6-9b8e-3fa2c8d1e7f6
     */
    public function verificarCorto(Request $request, string $codigo)
    {
        return redirect()->route('verificacion.show', $codigo);
    }

    /**
     * Vista completa de verificación pública
     * Ejemplo: /verificar/HC-a3f4e8d9-4c2a-41f6-9b8e-3fa2c8d1e7f6
     */
    public function verificar(Request $request, string $codigo)
    {
        // Buscar habilitación por código
        $habilitacion = Habilitacion::with('colegiado')
            ->where('codigo_verificacion', $codigo)
            ->first();

        // Registrar intento de verificación
        $resultado = $this->registrarVerificacion($request, $codigo, $habilitacion);

        // Si no existe el código
        if (!$habilitacion) {
            return view('verificacion.invalido', [
                'codigo' => $codigo,
                'mensaje' => 'Código de verificación no encontrado'
            ]);
        }

        // Si el documento está revocado/inactivo
        if (!$habilitacion->activo) {
            return view('verificacion.invalido', [
                'codigo' => $codigo,
                'mensaje' => 'Este documento de habilitación ha sido revocado',
                'habilitacion' => $habilitacion
            ]);
        }

        // Mostrar vista de verificación exitosa
        return view('verificacion.show', [
            'habilitacion' => $habilitacion,
            'colegiado' => $habilitacion->colegiado
        ]);
    }

    /**
     * Descargar documento verificado (desde la vista pública)
     */
    public function descargar(string $codigo)
    {
        $habilitacion = Habilitacion::with('colegiado')
            ->where('codigo_verificacion', $codigo)
            ->where('activo', true)
            ->firstOrFail();

        // Stripear public/ prefix de la ruta en BD antes de usar public_path()
        $ruta = $habilitacion->documento_path;
        if (str_starts_with($ruta, 'public/')) {
            $ruta = substr($ruta, 7);
        }
        $pdfPath = public_path($ruta);
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
     * Registrar verificación en la tabla de logs (anti-fraude)
     */
    private function registrarVerificacion(Request $request, string $codigo, $habilitacion = null): string
    {
        // Determinar el resultado
        if (!$habilitacion) {
            $resultado = 'codigo_invalido';
        } elseif (!$habilitacion->activo) {
            $resultado = 'documento_inactivo';
        } else {
            $resultado = 'exitoso';
        }

        // Guardar en log
        VerificacionLog::create([
            'codigo_verificacion' => $codigo,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'resultado' => $resultado,
        ]);

        return $resultado;
    }
}
