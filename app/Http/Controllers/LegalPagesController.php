<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use App\Models\Evento;
use App\Models\Colegiado;
use App\Models\RecursoBiblioteca;

class LegalPagesController extends Controller
{
    /**
     * Mostrar página de Política de Privacidad
     */
    public function privacidad()
    {
        return view('legal.privacidad');
    }

    /**
     * Mostrar página de Términos y Condiciones
     */
    public function terminos()
    {
        return view('legal.terminos');
    }

    /**
     * Mostrar Mapa del Sitio
     */
    public function mapa()
    {
        $noticias = Noticia::where('activo', true)->latest()->get();
        $eventos = Evento::where('activo', true)->orderBy('fecha_inicio')->get();
        $recursos = RecursoBiblioteca::where('activo', true)->latest()->get();
        $colegiados = Colegiado::where('estado', 'activo')->latest()->get();

        return view('legal.mapa-sitio', compact('noticias', 'eventos', 'recursos', 'colegiados'));
    }
}
