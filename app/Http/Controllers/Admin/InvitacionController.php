<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invitaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class InvitacionController extends Controller
{
    public function index()
    {
        $invitaciones = Invitaciones::latest()->get();
        return view('admin.invitaciones.index', compact('invitaciones'));
    }

    public function enviar(Request $request)
{
    $request->validate([
        'email' => 'required|email'
    ]);

    // Buscar si ya existe una invitación
    $inv = Invitaciones::where('email', $request->email)->first();

    // Si existe y ya fue usada → no permitir otra invitación
    if ($inv && $inv->usado) {
        return back()->withErrors(['email' => 'Este correo ya se registró anteriormente.']);
    }

    // Si existe pero NO ha sido usada → regenerar token
    if ($inv && !$inv->usado) {
        $inv->token = Str::random(40);
        $inv->save();
    }

    // Si no existe → crear nueva invitación
    if (!$inv) {
        $inv = Invitaciones::create([
            'email' => $request->email,
            'token' => Str::random(40)
        ]);
    }

    // Enviar correo
    $link = url('/register?token=' . $inv->token);

    Mail::raw("Has sido invitado a registrarte. Ingresa aquí: $link", function ($m) use ($request) {
        $m->to($request->email)->subject('Invitación para registro');
    });

    return back()->with('success', 'Invitación enviada correctamente.');
}

}
