<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ColegiaturaController extends Controller
{
    public function index()
    {
        return view('colegiatura.index');
    }
}
