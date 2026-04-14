<?php

namespace App\Services;

use setasign\Fpdi\Fpdi;
use Exception;

class PDFService
{
    /**
     * Embeber QR Code y código de verificación en el PDF
     *
     * @param string $pdfTempPath Path temporal del PDF subido
     * @param string $qrImagePath Path de la imagen QR
     * @param string $codigoVerificacion Código único
     * @param string $urlVerificacion URL corta
     * @return string Path del PDF modificado temporal
     * @throws Exception Si el PDF no se puede procesar
     */
    public function embederQREnPDFTemporal(
        string $pdfTempPath,
        string $qrImagePath,
        string $codigoVerificacion,
        string $urlVerificacion
    ): string {
        try {
            // Crear instancia FPDI
            $pdf = new Fpdi();

            // Configurar fuente predeterminada
            $pdf->SetFont('Arial', '', 12);

            // Obtener número de páginas del PDF original
            $pageCount = $pdf->setSourceFile($pdfTempPath);

            // Procesar cada página
            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                // Importar página original
                $templateId = $pdf->importPage($pageNo);
                $size = $pdf->getTemplateSize($templateId);

                // Agregar página respetando orientación original
                $orientation = ($size['orientation'] ?? 'P') === 'L' ? 'L' : 'P';
                $pdf->AddPage($orientation, [$size['width'], $size['height']]);

                // Usar la plantilla (contenido original)
                $pdf->useTemplate($templateId);

                // Solo en la primera página agregamos el QR y metadata
                if ($pageNo === 1) {
                    $this->agregarQRYMetadata(
                        $pdf,
                        $size,
                        $qrImagePath,
                        $codigoVerificacion,
                        $urlVerificacion
                    );
                }
            }

            // Crear path para PDF modificado temporal
            $pdfModificadoPath = sys_get_temp_dir() . '/' . uniqid('cpap_', true) . '.pdf';

            // Guardar PDF
            $pdf->Output('F', $pdfModificadoPath);

            return $pdfModificadoPath;

        } catch (Exception $e) {
            throw new Exception("Error al procesar PDF: " . $e->getMessage());
        }
    }

    /**
     * Agregar QR Code y metadata al PDF
     *
     * @param Fpdi $pdf Instancia de FPDI
     * @param array $size Dimensiones de la página
     * @param string $qrImagePath Path de la imagen QR
     * @param string $codigoVerificacion Código único
     * @param string $urlVerificacion URL de verificación
     * @return void
     */
    private function agregarQRYMetadata(
        Fpdi $pdf,
        array $size,
        string $qrImagePath,
        string $codigoVerificacion,
        string $urlVerificacion
    ): void {
        // Desactivar salto de página automático para evitar páginas extra
        // cuando el texto del código/URL queda cerca del borde inferior
        $pdf->SetAutoPageBreak(false);

        // Configuración del QR
        $qrSize = 35;  // Tamaño en mm
        $margenDerecho  = 15;
        $margenInferior = 15;
        $espacioTexto   = 42; // mm para código + URL + watermark debajo del QR

        // Posición del QR (esquina inferior derecha, suficientemente arriba)
        $qrX = $size['width']  - $qrSize - $margenDerecho;
        $qrY = $size['height'] - $qrSize - $espacioTexto - $margenInferior;

        // Insertar imagen QR
        // Si empieza con "public/", remover ese prefijo para public_path()
        $ruta = $qrImagePath;
        if (str_starts_with($ruta, 'public/')) {
            $ruta = substr($ruta, 7); // Remover "public/"
        }
        $qrFullPath = public_path($ruta);
        if (file_exists($qrFullPath)) {
            $pdf->Image($qrFullPath, $qrX, $qrY, $qrSize, $qrSize, 'PNG');
        }

        // Código de verificación (debajo del QR, en una línea)
        $pdf->SetFont('Arial', 'B', 6.5);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY($qrX - 30, $qrY + $qrSize + 2);
        $pdf->MultiCell($qrSize + 60, 2.5, "Codigo: {$codigoVerificacion}", 0, 'C');

        // URL de verificación (debajo del código, en línea separada)
        $pdf->SetFont('Arial', '', 4.5);
        $pdf->SetXY($qrX - 30, $qrY + $qrSize + 7);
        $pdf->MultiCell($qrSize + 60, 2, $urlVerificacion, 0, 'C');

        // Marca de agua "Documento Verificable"
        $pdf->SetFont('Arial', 'I', 8);
        $pdf->SetTextColor(139, 21, 56); // Color vino CPAP
        $pdf->SetXY($qrX - 30, $qrY + $qrSize + 12);
        $pdf->MultiCell($qrSize + 60, 3, "Documento Verificable", 0, 'C');
    }
}
