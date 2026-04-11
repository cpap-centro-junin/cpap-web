<?php

namespace App\Services;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Label\Font\OpenSans;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\Habilitacion;

class QRCodeService
{
    /**
     * Generar código UUID único para habilitación
     *
     * @return string Ejemplo: HC-a3f4e8d9-4c2a-41f6-9b8e-3fa2c8d1e7f6
     */
    public function generarCodigoUnico(): string
    {
        return 'HC-' . Str::uuid()->toString();
    }

    /**
     * Generar imagen QR Code
     *
     * @param string $codigoVerificacion Código único de la habilitación
     * @param string|null $nombreColegiado Nombre del colegiado (opcional)
     * @return string Path donde se guardó el QR
     */
    public function generarQR(string $codigoVerificacion, string $nombreColegiado = null): string
    {
        // URL de verificación
        $url = url("/v/{$codigoVerificacion}");

        // Directorio público para QR codes
        $directorioQR = public_path('images/qr');

        // Crear directorio si no existe
        if (!File::exists($directorioQR)) {
            File::makeDirectory($directorioQR, 0755, true);
        }

        // Nombre y path del archivo
        $nombreArchivo = "{$codigoVerificacion}.png";
        $pathCompleto = $directorioQR . '/' . $nombreArchivo;

        // Crear Builder con los parámetros necesarios (v6.0.9)
        // En esta versión, Builder es readonly y se pasan parámetros al constructor
        $label = !empty($nombreColegiado)
            ? 'CPAP - ' . Str::limit($nombreColegiado, 30)
            : '';

        $builder = new Builder(
            writer: new PngWriter(),
            data: $url,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            size: 350,
            margin: 10,
            foregroundColor: new Color(0, 0, 0),
            backgroundColor: new Color(255, 255, 255),
            labelText: $label,
            labelFont: new OpenSans(13),
        );

        // Construir el QR
        $result = $builder->build();

        // Guardar imagen
        file_put_contents($pathCompleto, $result->getString());

        // Retornar path relativo con prefijo public/ (para BD)
        return 'public/images/qr/' . $nombreArchivo;
    }

    /**
     * Eliminar QR code
     *
     * @param string $qrPath Path del QR en la base de datos
     * @return bool
     */
    public function eliminarQR(string $qrPath): bool
    {
        // Si empieza con "public/", remover ese prefijo para public_path()
        $ruta = $qrPath;
        if (str_starts_with($ruta, 'public/')) {
            $ruta = substr($ruta, 7); // Remover "public/"
        }

        $pathCompleto = public_path($ruta);

        if (File::exists($pathCompleto)) {
            return File::delete($pathCompleto);
        }

        return false;
    }

    /**
     * Validar si un código de verificación existe
     *
     * @param string $codigoVerificacion
     * @return bool
     */
    public function codigoExiste(string $codigoVerificacion): bool
    {
        return Habilitacion::where('codigo_verificacion', $codigoVerificacion)->exists();
    }

    /**
     * Generar código único asegurando que no exista en la BD
     *
     * @return string
     */
    public function generarCodigoUnicoGarantizado(): string
    {
        do {
            $codigo = $this->generarCodigoUnico();
        } while ($this->codigoExiste($codigo));

        return $codigo;
    }
}