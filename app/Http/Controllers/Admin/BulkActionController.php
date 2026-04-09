<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BulkActionController extends Controller
{
    /**
     * Procesar acción en lote genérica
     */
    public function bulkAction(Request $request)
    {
        $action = $request->input('action');
        $table = $request->input('table');
        $ids = $request->input('ids', []);

        if (empty($ids) || !is_array($ids)) {
            return response()->json([
                'success' => false,
                'message' => 'No hay elementos seleccionados'
            ], 400);
        }

        try {
            $result = match($action) {
                'delete' => $this->deleteAction($table, $ids),
                'activate' => $this->activateAction($table, $ids),
                'deactivate' => $this->deactivateAction($table, $ids),
                'highlight' => $this->highlightAction($table, $ids),
                'unhighlight' => $this->unhighlightAction($table, $ids),
                'hide' => $this->hideAction($table, $ids),
                'show' => $this->showAction($table, $ids),
                default => throw new \Exception('Acción no soportada')
            };

            return response()->json([
                'success' => true,
                'message' => $result['message']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    // ============================================================
    // ACCIONES GENÉRICAS
    // ============================================================

    private function deleteAction($table, $ids)
    {
        match($table) {
            'noticias' => \App\Models\Noticia::whereIn('id', $ids)->delete(),
            'eventos' => \App\Models\Evento::whereIn('id', $ids)->delete(),
            'bolsa' => \App\Models\BolsaTrabajo::whereIn('id', $ids)->delete(),
            'galeria' => \App\Models\GaleriaImagen::whereIn('id', $ids)->delete(),
            'mensajes' => \App\Models\ContactMessage::whereIn('id', $ids)->delete(),
            'solicitudes' => \App\Models\BolsaTrabajo::whereIn('id', $ids)->delete(),
            'directivos' => \App\Models\Directivo::whereIn('id', $ids)->delete(),
            'normativa' => \App\Models\NormativaDocumento::whereIn('id', $ids)->delete(),
            'invitaciones' => \App\Models\Invitacion::whereIn('id', $ids)->delete(),
            'slides' => \App\Models\BannerSlide::whereIn('id', $ids)->delete(),
            'anuncios' => \App\Models\PopupAnuncio::whereIn('id', $ids)->delete(),
            'colegiados' => \App\Models\Colegiado::whereIn('id', $ids)->delete(),
            'biblioteca' => \App\Models\RecursoBiblioteca::whereIn('id', $ids)->delete(),
            default => throw new \Exception('Tabla no soportada'),
        };

        return ['message' => count($ids) . ' elemento(s) eliminado(s) correctamente'];
    }

    private function activateAction($table, $ids)
    {
        match($table) {
            'noticias' => \App\Models\Noticia::whereIn('id', $ids)->update(['activo' => true]),
            'eventos' => \App\Models\Evento::whereIn('id', $ids)->update(['activo' => true]),
            'bolsa' => \App\Models\BolsaTrabajo::whereIn('id', $ids)->update(['activo' => true]),
            'galeria' => \App\Models\GaleriaImagen::whereIn('id', $ids)->update(['activo' => true]),
            'mensajes' => \App\Models\ContactMessage::whereIn('id', $ids)->update(['revisado' => true]),
            'solicitudes' => \App\Models\BolsaTrabajo::whereIn('id', $ids)->update(['revisado' => true]),
            'directivos' => \App\Models\Directivo::whereIn('id', $ids)->update(['activo' => true]),
            'normativa' => \App\Models\NormativaDocumento::whereIn('id', $ids)->update(['activo' => true]),
            'invitaciones' => \App\Models\Invitacion::whereIn('id', $ids)->update(['activo' => true]),
            'slides' => \App\Models\BannerSlide::whereIn('id', $ids)->update(['activo' => true]),
            'anuncios' => \App\Models\PopupAnuncio::whereIn('id', $ids)->update(['activo' => true]),
            'colegiados' => \App\Models\Colegiado::whereIn('id', $ids)->update(['estado' => 'activo']),
            'biblioteca' => \App\Models\RecursoBiblioteca::whereIn('id', $ids)->update(['activo' => true]),
            default => throw new \Exception('Tabla no soportada'),
        };

        return ['message' => 'Elemento(s) activado(s) correctamente'];
    }

    private function deactivateAction($table, $ids)
    {
        match($table) {
            'noticias' => \App\Models\Noticia::whereIn('id', $ids)->update(['activo' => false]),
            'eventos' => \App\Models\Evento::whereIn('id', $ids)->update(['activo' => false]),
            'bolsa' => \App\Models\BolsaTrabajo::whereIn('id', $ids)->update(['activo' => false]),
            'galeria' => \App\Models\GaleriaImagen::whereIn('id', $ids)->update(['activo' => false]),
            'mensajes' => \App\Models\ContactMessage::whereIn('id', $ids)->update(['revisado' => false]),
            'solicitudes' => \App\Models\BolsaTrabajo::whereIn('id', $ids)->update(['revisado' => false]),
            'directivos' => \App\Models\Directivo::whereIn('id', $ids)->update(['activo' => false]),
            'normativa' => \App\Models\NormativaDocumento::whereIn('id', $ids)->update(['activo' => false]),
            'invitaciones' => \App\Models\Invitacion::whereIn('id', $ids)->update(['activo' => false]),
            'slides' => \App\Models\BannerSlide::whereIn('id', $ids)->update(['activo' => false]),
            'anuncios' => \App\Models\PopupAnuncio::whereIn('id', $ids)->update(['activo' => false]),
            'colegiados' => \App\Models\Colegiado::whereIn('id', $ids)->update(['estado' => 'inactivo']),
            'biblioteca' => \App\Models\RecursoBiblioteca::whereIn('id', $ids)->update(['activo' => false]),
            default => throw new \Exception('Tabla no soportada'),
        };

        return ['message' => 'Elemento(s) desactivado(s) correctamente'];
    }

    private function highlightAction($table, $ids)
    {
        match($table) {
            'noticias' => \App\Models\Noticia::whereIn('id', $ids)->update(['destacado' => true]),
            'eventos' => \App\Models\Evento::whereIn('id', $ids)->update(['destacado' => true]),
            'biblioteca' => \App\Models\RecursoBiblioteca::whereIn('id', $ids)->update(['destacado' => true]),
            default => throw new \Exception('Esta tabla no soporta destaque'),
        };

        return ['message' => 'Elemento(s) destacado(s) correctamente'];
    }

    private function unhighlightAction($table, $ids)
    {
        match($table) {
            'noticias' => \App\Models\Noticia::whereIn('id', $ids)->update(['destacado' => false]),
            'eventos' => \App\Models\Evento::whereIn('id', $ids)->update(['destacado' => false]),
            'biblioteca' => \App\Models\RecursoBiblioteca::whereIn('id', $ids)->update(['destacado' => false]),
            default => throw new \Exception('Esta tabla no soporta destaque'),
        };

        return ['message' => 'Destaque removido correctamente'];
    }

    private function hideAction($table, $ids)
    {
        match($table) {
            'colegiados' => \App\Models\Colegiado::whereIn('id', $ids)->update(['perfil_oculto' => true]),
            default => throw new \Exception('Esta tabla no soporta ocultar'),
        };

        return ['message' => 'Elemento(s) oculto(s) correctamente'];
    }

    private function showAction($table, $ids)
    {
        match($table) {
            'colegiados' => \App\Models\Colegiado::whereIn('id', $ids)->update(['perfil_oculto' => false]),
            default => throw new \Exception('Esta tabla no soporta mostrar'),
        };

        return ['message' => 'Elemento(s) mostrado(s) correctamente'];
    }
}

