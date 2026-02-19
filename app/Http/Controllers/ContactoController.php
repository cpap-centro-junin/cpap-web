<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMessageMail;

class ContactoController extends Controller
{
    public function index()
    {
        return view('contacto.index');
    }

    public function send(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'email' => 'required|email',
            'asunto' => 'required|string|max:150',
            'mensaje' => 'required|string',
        ]);

        $message = ContactMessage::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'asunto' => $request->asunto,
            'mensaje' => $request->mensaje,
        ]);

        // Enviar correo real
        Mail::to('juancarloschmm@gmail.com')
            ->send(new ContactMessageMail($message));

        return response()->json([
            'success' => true,
            'message' => 'Mensaje enviado correctamente.'
        ]);
    }
}
?>