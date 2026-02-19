<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\RespuestaMensajeMail;

class ContactMessageController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::latest()->paginate(10);

        return view('admin.mensajes.index', compact('messages'));
    }

    public function show(ContactMessage $message)
    {
        $message->update(['leido' => true]);

        return view('admin.mensajes.show', compact('message'));
    }

    public function responder(Request $request, ContactMessage $message)
    {
        $request->validate([
            'respuesta' => 'required',
            'archivo' => 'nullable|file|max:2048'
        ]);

        $filePath = null;

        if ($request->hasFile('archivo')) {
            $filePath = $request->file('archivo')->store('respuestas', 'public');
        }

        $message->update([
            'respuesta' => $request->respuesta,
            'archivo_respuesta' => $filePath
        ]);

        Mail::to($message->email)
            ->send(new RespuestaMensajeMail($message));

        return back()->with('success', 'Respuesta enviada correctamente.');
    }
    public function destroy(ContactMessage $message)
    {
        $message->delete();

        return back()->with('success', 'Mensaje eliminado correctamente.');
    }

}
