<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\RespuestaMensajeMail;

class ContactMessageController extends Controller
{
    public function index(Request $request)
    {
        // Manejar parámetro de items per page
        if ($request->has('perpage')) {
            $perpage = (int) $request->get('perpage');
            if (in_array($perpage, [10, 20, 50, 100])) {
                session(['pagination_perpage' => $perpage]);
            }
        }
        
        $perpage = session('pagination_perpage', 10);
        
        $query = ContactMessage::query();

        // Search by subject or message
        if ($request->filled('q')) {
            $buscar = $request->q;
            $query->where(function ($q) use ($buscar) {
                $q->where('asunto', 'like', "%{$buscar}%")
                  ->orWhere('mensaje', 'like', "%{$buscar}%")
                  ->orWhere('email', 'like', "%{$buscar}%");
            });
        }

        // Filter by read status
        if ($request->filled('estado')) {
            $query->where('leido', $request->estado === 'leido');
        }

        $messages = $query->latest()->paginate($perpage)->withQueryString();

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
        if ($message->archivo_respuesta && \Illuminate\Support\Facades\Storage::disk('public')->exists($message->archivo_respuesta)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($message->archivo_respuesta);
        }

        $message->delete();

        return back()->with('success', 'Mensaje eliminado correctamente.');
    }

}
